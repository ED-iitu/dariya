<?php


namespace App\Http\Controllers\Site;


use App\Book;
use App\Http\Controllers\Controller;
use App\Tariff;
use App\TariffPriceList;
use App\Transaction;
use App\User;
use App\UserBook;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function buy($type, $object_id)
    {
        if (in_array($type, Transaction::geTypes())) {
            $transaction_data = [];
            $user = Auth::user();
            switch ($type) {
                case Transaction::TRANSACTION_TYPE_TARIFF:
                    $request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
                    if ($request->get('object_id')) {
                        $object_id = $request->get('object_id');
                    }
                    $tariff_price_list = TariffPriceList::query()->find($object_id);
                    if ($tariff_price_list) {
                        $transaction_data = [
                            'user_id' => Auth::id(),
                            'transaction_type' => Transaction::TRANSACTION_TYPE_TARIFF,
                            'object_id' => $object_id,
                            'amount' => $tariff_price_list->price,
                            'description' => $tariff_price_list->tariff->title,
                        ];
                    }
                    break;
                case Transaction::TRANSACTION_TYPE_PRODUCT:
                    $book = Book::query()->find($object_id);
                    if ($book) {
                        if ($my_book = UserBook::query()->where(['book_id' => $book->id, 'user_id' => $user->id])->first()) {
                            return $this->sendError('Forbidden', 'Вы ранее уже купили эту книгу', 403);
                        }
                        $user = Auth::user();
                        if ($user->tariff_id && time() < strtotime($user->tariff_end_date)) {
                            return $this->sendError('Forbidden', 'У вас уже имеется подписка', 403);
                        }
                        $transaction_data = [
                            'user_id' => Auth::id(),
                            'transaction_type' => Transaction::TRANSACTION_TYPE_PRODUCT,
                            'object_id' => $object_id,
                            'amount' => $book->price,
                            'description' => 'Книга: '.$book->name,
                        ];
                    }
                    break;
                default:
            }
            if (!empty($transaction_data)) {
                $transaction = new Transaction();
                $transaction->setRawAttributes($transaction_data);
                if ($transaction->save()) {
                    $price = $book->price;
                    $description = '';
                    if($book instanceof Book){
                        $description
                    }
                    if (env('PAYBOX_SECRET_KEY') && env('PAYBOX_MERCHANT_ID')) {
                        $request = [
                            'pg_merchant_id' => env('PAYBOX_MERCHANT_ID'),
                            'pg_amount' => $transaction_data['amount'],
                            'pg_salt' => Str::random(),
                            'pg_order_id' => $transaction->transaction_id,
                            'pg_description' => $transaction_data['description'],
                            'pg_result_url' => url('api/payment/result'),
                            'pg_user_contact_email' => Auth::user()->email,
                            'pg_success_url' => url('payment/success?transaction_id=' . $transaction->transaction_id),
                        ];
                    }
                    if (Auth::user()->phone) {
                        $request['pg_user_phone'] = Auth::user()->phone;
                    }
                    $request['client_name'] = Auth::user()->name;
                    if (env('APP_DEBUG')) {
                        $request['pg_testing_mode'] = 1; //add this parameter to request for testing payments
                    }


                    ksort($request); //sort alphabetically
                    array_unshift($request, 'payment.php');
                    array_push($request, env('PAYBOX_SECRET_KEY')); //add your secret key (you can take it in your personal cabinet on paybox system)

                    $request['pg_sig'] = md5(implode(';', $request));

                    unset($request[0], $request[1]);
                    $query = http_build_query($request);
                    $payment_url = 'https://api.paybox.money/payment.php?' . $query;
                    return redirect($payment_url);
                }
            }

        }
        return $this->sendError('Not Found', 'Ресус не найден');
    }

    public function result(Request $request)
    {
        $response = '<?xml version="1.0" encoding="UTF-8"?>
                                <response>
                                  <pg_status>rejected</pg_status>
                                </response>';
        if ($request->getContentType() == 'xml' && $request->getContent()) {
            $xmlObject = simplexml_load_string($request->getContent());
            $request = [];
            foreach ($xmlObject as $attribute => $value) {
                $request[$attribute] = $value->__toString();
            }
        } else {
            $request = $request->all();
        }

        $paybox_sig = $request['pg_sig'];
        unset($request['pg_sig']);
        ksort($request); //sort alphabetically
        array_unshift($request, 'result');
        array_push($request, env('PAYBOX_SECRET_KEY')); //add your secret key (you can take it in your personal cabinet on paybox system)

        $request['pg_sig'] = md5(implode(';', $request));
        unset($request[0], $request[1]);
        if ($request['pg_sig'] != $paybox_sig) {
            $response = '<?xml version="1.0" encoding="UTF-8"?>
                                <response>
                                  <pg_status>error</pg_status>
                                  <pg_sig>' . $request['pg_sig'] . '</pg_sig>
                                </response>';
        } else {
            $transaction_id = $request['pg_order_id'];
            if ($transaction = Transaction::query()->find($transaction_id)) {
                if ($transaction->status == 0) {
                    $transaction->processor_transaction_id = $request['pg_payment_id'];
                    $transaction->status = true;
                    if ($transaction->save()) {

                        if ($transaction->transaction_type == Transaction::TRANSACTION_TYPE_PRODUCT) {
                            if (!UserBook::query()->where('book_id', $transaction->object_id)->exists()) {
                                $user_book = new UserBook();
                                $user_book->setRawAttributes([
                                    'user_id' => $transaction->user_id,
                                    'book_id' => $transaction->object_id,
                                    'type_of_acquisition' => UserBook::USER_BOOK_PURCHASED
                                ]);
                                $user_book->save();
                            }
                        } elseif ($transaction->transaction_type == Transaction::TRANSACTION_TYPE_TARIFF) {

                            if ($tariff_price_list = TariffPriceList::query()->find($transaction->object_id)) {
                                $user_tariff_begin_date = date('Y-m-d H:i:s', time());
                                $user_tariff_end_date = date('Y-m-d H:i:s', strtotime("+{$tariff_price_list->duration} month"));

                                if ($user = User::query()->find($transaction->user_id)) {

                                    $user->tariff_id = $tariff_price_list->tariff_id;
                                    $user->tariff_price_list_id = $tariff_price_list->id;
                                    $user->tariff_begin_date = $user_tariff_begin_date;
                                    $user->tariff_end_date = $user_tariff_end_date;
                                    $user->save();

                                }
                            }
                        }

                        $response = '<?xml version="1.0" encoding="UTF-8"?>
                                <response>
                                  <pg_status>ok</pg_status>
                                </response>';
                    }
                }
            }

        }
        return response($response, 200, [
            'Content-Type' => 'application/xml'
        ]);
    }

    public function success(Request $request)
    {
        $transaction_id = $request->get('transaction_id');
        if ($transaction_id) {
            if ($transaction = Transaction::query()->find($transaction_id)) {
                if ($transaction->transaction_type == Transaction::TRANSACTION_TYPE_PRODUCT) {
                    $book = Book::query()->find($transaction->object_id);
                    if ($book) {
                        $product_name = $book->name;
                        $image = $book->image_link;
                        $description = $book->preview_text;
                        $text = 'Вы купили электронную книгу. Чтобы читать книгу установите наши бесплатные мобильные приложения на ваш смартфон или планшет на базе iOS или Android';

                        return view('site.payment.success', [
                            'product_name' => $product_name,
                            'image' => $image,
                            'description' => $description,
                            'text' => $text,
                        ]);
                    }

                } else {
                    $price_list = TariffPriceList::query()->find($transaction->object_id);
                    if ($price_list && $price_list->tariff) {
                        $product_name = $price_list->tariff->title;
                        $image = $price_list->tariff->image_url;
                        $description = $price_list->tariff->preview_text;
                        $duration_label = $price_list->getDurationLabels($price_list->duration);
                        $text = 'Вы купили подписку за ' . $duration_label . '. Чтобы читать книгу установите наши бесплатные мобильные приложения на ваш смартфон или планшет на базе iOS или Android';

                        return view('site.payment.success', [
                            'product_name' => $product_name,
                            'image' => $image,
                            'description' => $description,
                            'text' => $text,
                        ]);
                    }
                }

            }
        }
        return response('', 404);
    }

    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];
        return response($response, 200);
    }

    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];
        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }
        return response($response, $code);
    }
}