<?php


namespace App\Http\Controllers\Api;


use Akaunting\Money\Money;
use App\Book;
use App\BookShelf;
use App\BookShelfLink;
use App\Helpers\DateHelper;
use App\Helpers\PhoneHelper;
use App\Tariff;
use App\User;
use App\UserBuyedBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function my_books()
    {

        $books = [];
        Auth::user()->books()->each(function ($book) use (&$books){
            if($book->type == Book::BOOK_TYPE){
                $books[] = [
                    "id"=> $book->id,
                    "name"=> $book->name,
                    "rating"=> $book->rate,
                    "forum_message_count"=> ($book->comments) ? $book->comments->count() : 0,
                    "show_counter"=> $book->show_counter,
                    "image_url"=> ($book->image_link) ? url($book->image_link) : null
                ];
            }
        });
        return $this->sendResponse($books, '');
    }

    public function my_audio_books()
    {
        $audio_books = [];
        Auth::user()->books()->each(function ($audio_book) use (&$audio_books){
            if($audio_book->type == Book::AUDIO_BOOK_TYPE){
                $audio_books[] = [
                    "id"=> $audio_book->id,
                    "name"=> $audio_book->name,
                    "rating"=> $audio_book->rate,
                    "forum_message_count"=> ($audio_book->comments) ? $audio_book->comments->count() : 0,
                    "show_counter"=> $audio_book->show_counter,
                    "image_url"=> ($audio_book->image_link) ? url($audio_book->image_link) : null
                ];
            }
        });
        return $this->sendResponse($audio_books, '');
    }

    public function my_tariff()
    {
        $user = Auth::user();
        /**
         * @var Tariff $tariff
         */
        $tariff = $user->tariff;
        $tariff_price_list = $user->tariff_price_list;

        if($tariff && $tariff_price_list){
            $tariff = array_merge($tariff->attributesToArray(), $tariff_price_list->attributesToArray());
            $tariff['formatted_duration'] = "{$tariff['duration']} месяц";
            $tariff['formatted_price'] = Money::KZT($tariff['price'])->format();
            $tariff['image_url'] = url($tariff['image_url']);
            $tariff['begin_date'] = $user->tariff_begin_date;
            $tariff['end_date'] = $user->tariff_end_date;
            unset($tariff['created_at']);
            unset($tariff['updated_at']);

            return $this->sendResponse($tariff, 'Ваша подписка');
        }
        return $this->sendError('Not Found','Вы еще не приобрели подписку');
    }

    public function update(Request $request){
        $user = Auth::user();
        $data  = [];
        if($request->email && filter_var($request->email,FILTER_VALIDATE_EMAIL) && !User::query()->where('email' , $request->email)->exists()){
            $user->email = $request->email;
            $data['email'] = $user->email;
        }
        if($request->name){
            $user->name = $request->name;
            $data['name'] = $user->name;
        }
        if($request->phone && PhoneHelper::isCorrectFormat($request->phone) && !PhoneHelper::isBusy($request->phone)){
            $user->phone = PhoneHelper::toNumeric($request->phone);
            $data['phone'] = PhoneHelper::formatFromNumeric($user->phone);
        }

        if($request->date_of_birth && DateHelper::validateDate($request->date_of_birth)){
            $user->date_of_birth = DateHelper::changeDateFormat($request->date_of_birth, 'Y-m-d');
            $data['date_of_birth'] = $request->date_of_birth;
        }
//dd($request->allFiles());
        if($request->file('photo')){
            $file = $request->file('photo')->storeAs('profile/'.$user->id, Str::random(5).'.'.$request->file('photo')->extension(), 'public');
            $user->profile_photo_path = $file;
            $data['profile_photo_path'] = url('uploads/'.$file);
        }

        $user->save();

        return $this->sendResponse($data, 'Профиль успешно обнавлен!');

    }

    public function book_shelfs(){
        $book_shelfs = [];
        Auth::user()->book_shelfs()->each(function ($book_shelf) use (&$book_shelfs){
            $book_shelfs[] = [
                "id"=> $book_shelf->id,
                "title"=> $book_shelf->title,
                "description"=> $book_shelf->description,
                "image"=> $book_shelf->image_url ? url('uploads/'.$book_shelf->image_url) :
                    (($book_shelf->books->first()) ? url($book_shelf->books->first()->image_link) : null),
                "books_count"=> ($book_shelf->books) ? $book_shelf->books->count() : 0,
            ];
        });
        return $this->sendResponse($book_shelfs, '');
    }

    public function book_shelfs_view($id){
        if($book_shelf = BookShelf::query()->where(['id' => $id, 'user_id' => Auth::id()])->first()){
            $data = [
                "id"=> $book_shelf->id,
                "title"=> $book_shelf->title,
                "description"=> $book_shelf->description,
                "image"=> ($book_shelf->image_url) ? url('uploads/'.$book_shelf->image_url) :
                    (($book_shelf->books) ? url($book_shelf->books->first()->image_link) : null),
                "books_count"=> ($book_shelf->books) ? $book_shelf->books->count() : 0,
            ];
            if($book_shelf->books){
                foreach ($book_shelf->books as $book){
                    $data['books'][] = [
                        "id"=> $book->id,
                        "name"=> $book->name,
                        "rating"=> $book->rate,
                        "type"=> $book->type,
                        "is_free"=> $book->is_free ? true :false,
                        "price"=> $book->price,
                        "formatted_price"=> Money::KZT($book->price)->format(),
                        "forum_message_count"=> ($book->comments) ? $book->comments->count() : 0,
                        "show_counter"=> $book->show_counter,
                        "image_url"=> ($book->image_link) ? url($book->image_link) : null
                    ];
                }
            }
            return $this->sendResponse($data, '');
        }
        return $this->sendError('Not Found','Ресус не найден');
    }

    public function book_shelfs_add(){
        $request = Request::createFromGlobals();
        $data = $request->all();
        $data['user_id'] = Auth::id();
        $book_shelf= BookShelf::create($data);
        return $this->sendResponse($book_shelf, $book_shelf ? 'Полка успешно добавлена!' : 'Ошибка при обнавление!',
            $book_shelf ? 200 : 400);
    }

    public function book_shelfs_update($id){
        $request = Request::createFromGlobals();
        $data = $request->all();
        $image_link = $request->file('image_url');
        if (null !== $image_link) {
            $file = $request->file('image_url')->storeAs('book_shelfs/'.$id, Str::random(32).'.'.$request->file('image_url')->extension(), 'public');
            $data['image_url'] = $file;
        }
        $book_shelf= BookShelf::where(['id'=>$id, 'user_id' => Auth::id()])->update($data);
        return $this->sendResponse($book_shelf, $book_shelf ? 'Полка успешно обнавлена!' : 'Ошибка при обнавление!',
            $book_shelf ? 200 : 400);
    }

    public function book_shelfs_remove($id){
        $book_shelf= BookShelf::where(['id'=>$id, 'user_id' => Auth::id()])->delete();
        BookShelfLink::where(['shelf_id'=>$id])->delete();
        return $this->sendResponse($book_shelf, $book_shelf ? 'Полка успешно удалена!' : 'Ошибка при удаление!',
            $book_shelf ? 200 : 400);
    }

    public function add_to_book_shelf($id){
        if($book_shelf = BookShelf::query()->where(['id' => $id, 'user_id' => Auth::id()])->first()){
            $book_id = $this->getParsedBody('book_id');
            if((Auth::user()->have_active_tariff() ||UserBuyedBook::query()->where('book_id', $book_id)->exists())
                && !BookShelfLink::query()->where(['book_id' => $book_id, 'shelf_id' => $id])->exists()){
                $data = [
                    'book_id' => $book_id,
                    'shelf_id' => $id
                ];
                BookShelfLink::create($data);
                return $this->sendResponse($data, 'Успешно добавлен!');
            }
        }
        return $this->sendError('Not Found','Ресус не найден');
    }

    public function remove_in_book_shelf($id){
        if($book_shelf = BookShelf::query()->where(['id' => $id, 'user_id' => Auth::id()])->first()){
            $book_id = $this->getParsedBody('book_id');
            if($book_shelf_link = BookShelfLink::query()->where(['book_id' => $book_id, 'shelf_id' => $id])){
                $book_shelf_link->delete();
                return $this->sendResponse([], 'Успешно удален из полки!');
            }
        }
        return $this->sendError('Not Found','Ресус не найден');
    }
}