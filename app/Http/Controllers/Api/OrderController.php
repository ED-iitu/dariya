<?php


namespace App\Http\Controllers\Api;


use App\Book;
use App\Tariff;
use App\TariffPriceList;
use App\Transaction;
use App\UserBuyedBook;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function tariffs()
    {
        $tariffs = [];
        $res = Tariff::query();
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
                            'amount' => $tariff_price_list->price
                        ];
                    }
                    break;
                case Transaction::TRANSACTION_TYPE_PRODUCT:
                    $book = Book::query()->find($object_id);
                    if($book){
                        if($my_book = UserBuyedBook::query()->where(['book_id' => $book->id, 'user_id' => $user->id])->first()){
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
                            'amount' => $book->price
                        ];
                    }
                    break;
                default:
            }
            if(!empty($transaction_data)){
                $transaction = new Transaction();
                $transaction->setRawAttributes($transaction_data);
                if($transaction->save()){
                    $payment_url = url("payment_plug/{$transaction->transaction_id}");
                    return $this->sendResponse([
                        'payment_url' =>$payment_url
                    ], 'Заказ успешно создан! Осталось оплатить');
                }
            }

        }
        return $this->sendError('Not Found','Ресус не найден');
    }
}