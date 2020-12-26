<?php


namespace App\Http\Controllers\Api;


use App\Book;
use App\Tariff;
use App\TariffPriceList;
use App\Transaction;
use App\UserBook;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function tariffs()
    {
        $tariffs = [];

        if(Auth::user()->isInviteToVip()){
            $res = Tariff::query();
        }else{
            $res = Tariff::query()->whereIn('slug',['premium', 'standard']);
        }
        $res->each(function ($tariff) use (&$tariffs){
            $tariffs[] = [
                "id"=> $tariff->id,
                "title"=> $tariff->title,
                "description"=> $tariff->description,
                "image_url"=> ($tariff->image_url) ? url($tariff->image_url) : null,
                "price_list" => $tariff->tariffPriceLists
            ];
        });
        return $this->sendResponse([
            'tariffs' =>$tariffs
        ], '');
    }

    public function create($type, $object_id)
    {
        if(in_array($type, Transaction::geTypes())){
            $transaction_data = [];
            $user = Auth::user();
            switch ($type){
                case Transaction::TRANSACTION_TYPE_TARIFF:
                    $tariff_price_list = TariffPriceList::query()->find($object_id);
                    if($tariff_price_list){
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
                    if($book){
                        if($my_book = UserBook::query()->where(['book_id' => $book->id, 'user_id' => $user->id])->first()){
                            return $this->sendError('Forbidden','Вы ранее уже купили эту книгу', 403);
                        }
                        $user = Auth::user();
                        if($user->tariff_id && time() < strtotime($user->tariff_end_date)){
                            return $this->sendError('Forbidden','У вас уже имеется подписка', 403);
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
            if(!empty($transaction_data)){
                $transaction = new Transaction();
                $transaction->setRawAttributes($transaction_data);
                if($transaction->save()){
                    if(env('PAYBOX_SECRET_KEY') && env('PAYBOX_MERCHANT_ID')){
                        $request = [
                            'pg_merchant_id'=> env('PAYBOX_MERCHANT_ID'),
                            'pg_amount' => $transaction_data['amount'],
                            'pg_salt' => Str::random(),
                            'pg_order_id'=>$transaction->transaction_id,
                            'pg_description' => $transaction_data['description'],
                            'pg_result_url' => url('api/payment/result'),
                            'pg_user_contact_email' => Auth::user()->email,
                            'pg_success_url' => url('payment/success?transaction_id='.$transaction->transaction_id),
                            'pg_failure_url' => url('payment/failure?transaction_id='.$transaction->transaction_id),
                        ];

                        if(Auth::user()->phone){
                            $request['pg_user_phone'] = Auth::user()->phone;
                        }
                        $request['client_name'] = Auth::user()->name;
                        if(env('APP_DEBUG')){
                            $request['pg_testing_mode'] = 1; //add this parameter to request for testing payments
                        }


                        ksort($request); //sort alphabetically
                        array_unshift($request, 'payment.php');
                        array_push($request, env('PAYBOX_SECRET_KEY')); //add your secret key (you can take it in your personal cabinet on paybox system)

                        $request['pg_sig'] = md5(implode(';', $request));

                        unset($request[0], $request[1]);
                        $query = http_build_query($request);
                        $payment_url = 'https://api.paybox.money/payment.php?'.$query;
                        $transaction->request = $payment_url;
                        $transaction->save();
                        return $this->sendResponse([
                            'payment_url' =>$payment_url,
                            'success_url' => $request['pg_success_url'],
                            'failure_url' => $request['pg_failure_url']
                        ], 'Заказ успешно создан! Осталось оплатить');
                    }
                }
            }

        }
        return $this->sendError('Ресус не найден!','Ресус не найден');
    }
}