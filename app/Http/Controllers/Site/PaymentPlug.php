<?php


namespace App\Http\Controllers\Site;


use App\TariffPriceList;
use App\Transaction;
use App\User;
use App\UserBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PaymentPlug
{
    public function index($transaction_id)
    {

        $success_pay = false;

        $transaction = Transaction::query()->find($transaction_id);
        if($transaction->transaction_type == Transaction::TRANSACTION_TYPE_TARIFF && !$transaction->status){

            if($tariff_price_list = TariffPriceList::query()->find($transaction->object_id)){
                $user_tariff_begin_date = date('Y-m-d H:i:s', time());
                $user_tariff_end_date = date('Y-m-d H:i:s', strtotime("+{$tariff_price_list->duration} month"));

                if($user = User::query()->find($transaction->user_id)){
                    $transaction->status = 1;
                    $transaction->processor_transaction_id = Str::random(255);
                    if($transaction->save()){
                        $success_pay = true;
                        $user->tariff_id = $tariff_price_list->tariff_id;
                        $user->tariff_price_list_id = $tariff_price_list->id;
                        $user->tariff_begin_date = $user_tariff_begin_date;
                        $user->tariff_end_date = $user_tariff_end_date;
                        $user->save();
                    }
                }
            }
        }

        if($transaction->transaction_type == Transaction::TRANSACTION_TYPE_PRODUCT && !$transaction->status){

            if($user = User::query()->find($transaction->user_id)){
                $transaction->status = 1;
                $transaction->processor_transaction_id = Str::random(255);
                if($transaction->save()){
                    $success_pay = true;
                    if(!($my_book = UserBook::query()->where(['book_id'=> $transaction->object_id, 'user_id' => Auth::id()])->first())){
                        UserBook::query()->create([
                            'user_id' => $user->id,
                            'book_id' => $transaction->object_id
                        ]);
                    }
                }
            }
        }

        return view('site.payment_plug', ['success_pay' => $success_pay]);
    }
}