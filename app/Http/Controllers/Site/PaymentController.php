<?php


namespace App\Http\Controllers\Site;


use App\Book;
use App\Http\Controllers\Controller;
use App\Transaction;
use App\User;
use App\UserBook;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function buy_book($id){

        if($book = Book::query()->find($id)){
            if(!($transction = Transaction::query()->where([
                'user_id' => Auth::id(),
                'transaction_type' => 'product',
                'object_id' => $id
            ])->first())){
                $transction = new Transaction();
                $transction->setRawAttributes([
                    'user_id' => Auth::id(),
                    'transaction_type' => Transaction::TRANSACTION_TYPE_PRODUCT,
                    'amount' => $book->price,
                    'object_id' => $id
                ]);
                $transction->save();
            }
            if(env('PAYBOX_SECRET_KEY') && env('PAYBOX_MERCHANT_ID')){
                $request = [
                    'pg_merchant_id'=> env('PAYBOX_MERCHANT_ID'),
                    'pg_amount' => $book->price,
                    'pg_salt' => Str::random(),
                    'pg_order_id'=>$transction->transaction_id,
                    'pg_description' => 'Книга: '.$book->name,
                    'pg_result_url' => url('api/payment/result'),
                    'pg_user_contact_email' => Auth::user()->email,
                    'pg_success_url' => url('payment/success?transaction_id='.$transction->transaction_id),
                ];
            }
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

//redirect a customer to payment page
            return redirect('https://api.paybox.money/payment.php?'.$query);
        }
        return response('Not Found',404);
    }

    public function result(Request $request){
        $response = '<?xml version="1.0" encoding="UTF-8"?>
                                <response>
                                  <pg_status>rejected</pg_status>
                                </response>';
        if($request->getContentType() == 'xml' && $request->getContent()){
            $xmlObject = simplexml_load_string($request->getContent());
            $request = [];
            foreach ($xmlObject as $attribute => $value){
                $request[$attribute] = $value->__toString();
            }
        }else{
            $request = $request->all();
        }

        $paybox_sig = $request['pg_sig'];
        unset($request['pg_sig']);
        ksort($request); //sort alphabetically
        array_unshift($request, 'result');
        array_push($request, env('PAYBOX_SECRET_KEY')); //add your secret key (you can take it in your personal cabinet on paybox system)

        $request['pg_sig'] = md5(implode(';', $request));
        unset($request[0], $request[1]);
        if($request['pg_sig'] != $paybox_sig){
            $response = '<?xml version="1.0" encoding="UTF-8"?>
                                <response>
                                  <pg_status>error</pg_status>
                                  <pg_sig>'.$request['pg_sig'].'</pg_sig>
                                </response>';
        }else{
            $transaction_id = $request['pg_order_id'];
            if($transaction = Transaction::query()->find($transaction_id)){
                if($transaction->status == 0){
                    $transaction->processor_transaction_id = $request['pg_payment_id'];
                    $transaction->status = true;
                    if($transaction->save()){

                        if($transaction->transaction_type == Transaction::TRANSACTION_TYPE_PRODUCT){
                            if(!UserBook::query()->where('book_id', $transaction->object_id)->exists()){
                                $user_book = new UserBook();
                                $user_book->setRawAttributes([
                                    'user_id' => $transaction->user_id,
                                    'book_id' => $transaction->object_id,
                                    'type_of_acquisition' => UserBook::USER_BOOK_PURCHASED
                                ]);
                                $user_book->save();
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

    public function success(Request $request){
        $transaction_id = $request->get('transaction_id');
        if($transaction_id){
            return view('site.site.success');
        }
        return response('',404);
    }
}