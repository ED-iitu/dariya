<?php


namespace App\Http\Controllers\Api;


use Akaunting\Money\Money;
use App\Article;
use App\Book;
use App\BookShelf;
use App\BookShelfLink;
use App\Favorite;
use App\Helpers\DateHelper;
use App\Helpers\PhoneHelper;
use App\PushSetting;
use App\PushSettingsValue;
use App\Tariff;
use App\User;
use App\UserBook;
use App\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function info(Request $request){
        $data = [
            "id"=> null,
            "name"=> 'Анонимный пользователь',
            "email"=> null,
            "date_of_birth"=> null,
            "course_link"=> url('api/courses'),
            "phone"=> null,
            "profile_photo_path"=> null,
            "tariff_id"=> null,
            "have_active_tariff"=> null,
            "tariff_price_list_id"=> null,
            "price_id"=> null,
            "created_at"=> null,
            "updated_at"=> null,
            "tariff_begin_date"=> null,
            "tariff_end_date"=> null
        ];
        if(\Illuminate\Support\Facades\Auth::user()){
            $user = $request->user();
            $course_key = $user->course_key;
            if(!$course_key){
                $course_key = Hash::make($user->password.$user->id);
                $course_key = md5(uniqid($course_key, true));
                $user->course_key = $course_key;
                $user->save();
            }
            $data = [
                "id"=> $user->id,
                "name"=> $user->name,
                "email"=> $user->email,
                "date_of_birth"=> DateHelper::changeDateFormat($user->date_of_birth,'d.m.Y', 'Y-m-d'),
                "phone"=> PhoneHelper::formatFromNumeric($user->phone),
                "profile_photo_path"=> url('uploads/'.$user->profile_photo_path),
                "tariff_id"=> $user->tariff_id,
                "have_active_tariff"=> $user->have_active_tariff(),
                "tariff_price_list_id"=> $user->tariff_price_list_id,
                "price_id"=> ($user->tariff_price_list) ? $user->tariff_price_list->price_id : null,
                "created_at"=> $user->created_at,
                "updated_at"=> $user->updated_at,
                "tariff_begin_date"=> $user->tariff_begin_date,
                "tariff_end_date"=> $user->tariff_end_date,
                "course_link"=> url('api/courses/'.$course_key),
            ];
        }else{
            if($device = \App\ApplePurchaseDevice::query()->where('device_id', $request->header('DeviceUID'))->first()){
                $data['tariff_id'] = $device->tariff_id;
                $data['have_active_tariff'] = true;
                $data['tariff_price_list_id'] = $device->tariff_price_list_id;
                $data['price_id'] = $device->price_id;
                $data['tariff_begin_date'] = $device->tariff_begin_date;
                $data['tariff_end_date'] = $device->tariff_end_date;
            }
        }
        return $this->sendResponse($data,'');
    }

    public function my_books()
    {

        $books = [];
        Auth::user()->books()->each(function ($book) use (&$books){
                $books[] = [
                    "id"=> $book->id,
                    "name"=> $book->name,
                    "rating"=> $book->rate,
                    "type"=> $book->type,
                    "is_free"=> $book->is_free ? true :false,
                    "is_favorite"=> $book->isBookFavorite(),
                    "forum_message_count"=> ($book->comments) ? $book->comments->count() : 0,
                    "show_counter"=> $book->show_counter,
                    "image_url"=> ($book->image_link) ? url($book->image_link) : null
                ];
        });
        return $this->sendResponse($books, '');
    }

    public function add_to_my_books($id)
    {
        if(Book::query()->find($id)){
            if(Auth::user()->have_active_tariff()){
                if(!UserBook::query()->where(['book_id' => $id, 'user_id' => Auth::id()])->exists()){
                    $new_link = new UserBook(['book_id' => $id, 'user_id' => Auth::id(), 'type_of_acquisition' => UserBook::USER_BOOK_SUBSCRIPTION]);
                    if($new_link->save()){
                        return $this->sendResponse(['book_id' => $id],'Книга успешно добавлен в мои книги!');
                    }
                }
                return $this->sendError('Эта книга уже имеется в списке мои книг','Ошибка при добавление' ,409);
            }else{
                return $this->sendError('У вас не имеется подписка. Оформите подписку или купите эту книгу','Ошибка при добавление' ,403);
            }
        }
        return $this->sendError('Книга не найдено','Ошибка при добавление' ,404);
    }

    public function remove_in_my_books($id)
    {
        if(Book::query()->find($id)){
            $bookQuery = UserBook::query()->where(['book_id' => $id, 'user_id' => Auth::id()]);
            if($bookQuery->exists()){
                $book = $bookQuery->first();
                if($book->type_of_acquisition == UserBook::USER_BOOK_PURCHASED){
                    return $this->sendError('Вы купили эту книгу, по этому нельзя удалить из списка мои книг!','Ошибка при удаление' ,409);
                }
                $book->delete();
                return $this->sendResponse(['book_id' => $id],'Книга успешно удален из мои книги!');
            }
        }
        return $this->sendError('Книга не найдено','Ошибка при удаление' ,404);
    }

    public function toggle_favorites($type,$id){
        $favorite = false;
        switch (strtoupper($type)){
            case Favorite::FAVORITE_BOOK_TYPE:
                if(Book::query()->where(['id' => $id, 'type' => Book::BOOK_TYPE])->exists()){
                    $favorite = Auth::user()->favorites_books()->toggle([$id => [
                        'object_type' => Favorite::FAVORITE_BOOK_TYPE,
                    ]]);
                }
                break;
            case Favorite::FAVORITE_AUDIO_BOOK_TYPE:
                if(Book::query()->where(['id' => $id, 'type' => Book::AUDIO_BOOK_TYPE])->exists()) {
                    $favorite = Auth::user()->favorites_audio_books()->toggle([$id => [
                        'object_type' => Favorite::FAVORITE_AUDIO_BOOK_TYPE,
                    ]]);
                }
                break;
            case Favorite::FAVORITE_ARTICLE_TYPE:
                if(Article::query()->find($id)) {
                    $favorite = Auth::user()->favorites_articles()->toggle([$id => [
                        'object_type' => Favorite::FAVORITE_ARTICLE_TYPE,
                    ]]);
                }
                break;
            case Favorite::FAVORITE_VIDEO:
                if(Video::query()->find($id)) {
                    $favorite = Auth::user()->favorites_videos()->toggle([$id => [
                        'object_type' => Favorite::FAVORITE_VIDEO,
                    ]]);
                }
                break;
            default:
        }
        if($favorite){
            return $this->sendResponse($favorite,
                (isset($favorite['detached']) && !empty($favorite['detached'])) ? 'Успешно удален из избранных!' : 'Успешно добавлен в избранное!',
            );
        }
        return $this->sendError('Ощибка при добавление','Ощибка при добавление',400);
    }

    public function favorites()
    {

        /**
         * Articles
         */
        $articles  = [];
        Auth::user()->favorites_articles()->each(function ($article) use (&$articles){
            $articles[] = [
                'id' => $article->id,
                'name' => $article->name,
                'rating' => $article->rate,
                'type' => 'ARTICLE',
                "is_favorite"=> true,
                'author' => $article->author ? $article->author : null,
                'forum_message_count' => $article->comments ? $article->comments->count() : 0,
                'show_counter' => $article->show_counter,
                'image_url' => ($article->image_link) ? url($article->image_link) : null,
            ];
        });
        $all_articles = Auth::user()->favorites_articles()->count();

        /**
         * Books
         */
        $books  = [];
        Auth::user()->favorites_books()->each(function($model) use (&$books){

            $authors = [];
            if($model->author){
                $author = $model->author->name;
                if($model->author->surname)
                    $author .= ' '.$model->author->surname;
                $authors[] = $author;
            }

            $books[] = [
                'id' => $model->id,
                'name' => $model->name,
                'authors' => $authors,
                'rating' => $model->rate,
                'type' => $model->type,
                "is_favorite"=> true,
                "price"=> $model->price,
                "formatted_price"=> Money::KZT($model->price)->format(),
                'forum_message_count' => ($model->comments) ? $model->comments->count() : 0,
                'show_counter' => $model->show_counter,
                'image_url' => ($model->image_link) ? url($model->image_link) : null,
            ];
        });
        $all_books = Auth::user()->count();

        /**
         * Audio-Books
         */
        $audio_books  = [];
        Auth::user()->favorites_audio_books()->each(function($model) use (&$audio_books){

            $authors = [];
            if($model->author){
                $author = $model->author->name;
                if($model->author->surname)
                    $author .= ' '.$model->author->surname;
                $authors[] = $author;
            }

            $audio_books[] = [
                'id' => $model->id,
                'name' => $model->name,
                'authors' => $authors,
                'rating' => $model->rate,
                'type' => $model->type,
                "is_favorite"=> true,
                "price"=> $model->price,
                "formatted_price"=> Money::KZT($model->price)->format(),
                'forum_message_count' => ($model->comments) ? $model->comments->count() : 0,
                'show_counter' => $model->show_counter,
                'image_url' => ($model->image_link) ? url($model->image_link) : null,
            ];
        });
        $all_audio_books = Auth::user()->favorites_audio_books()->count();

        /**
         * Videos
         */
        $videos  = [];
        Auth::user()->favorites_videos()->each(function($model) use (&$videos){
            $videos[] = [
                'id' => $model->id,
                'name' => $model->name,
                'rating' => $model->rate,
                "is_favorite"=> true,
                'authors' => $model->author ? [$model->author] : [],
                'forum_message_count' => $model->comments ? $model->comments->count() : 0,
                'show_counter' => $model->show_counter,
                'image_url' => ($model->image_link) ? url($model->image_link) : null,
                "type" => ($model->youtube_video_id) ? "YOUTUBE" : "LOCAL",
                'youtube_video_id' => $model->youtube_video_id
            ];
        });
        $all_videos = Auth::user()->favorites_videos()->count();

        $data = [
            [
                'type' => 'article',
                'content' => $articles,
                'count' => count($articles),
                'all_count' => $all_articles
            ],
            [
                'type' => 'books',
                'content' => $books,
                'count' => count($books),
                'all_count' => $all_books
            ],
            [
                'type' => 'audio_books',
                'content' => $audio_books,
                'count' => count($audio_books),
                'all_count' => $all_audio_books
            ],
            [
                'type' => 'video',
                'content' => $videos,
                'count' => count($videos),
                'all_count' => $all_videos
            ]
        ];
        return response($data);
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
        return $this->sendError('Вы еще не приобрели подписку','Вы еще не приобрели подписку');
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
            $image_url = null;
            if($book_shelf->image_url){
                $image_url = url('uploads/'.$book_shelf->image_url);
            }else{
                if($book_shelf->books){
                    if($book_shelf->books->first()){
                        $image_url = url($book_shelf->books->first()->image_link);
                    }
                }
            }
            $data = [
                "id"=> $book_shelf->id,
                "title"=> $book_shelf->title,
                "description"=> $book_shelf->description,
                "image"=> $image_url,
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
        return $this->sendError('Полка не существует!','Ресус не найден');
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
            if((Auth::user()->have_active_tariff() ||UserBook::query()->where('book_id', $book_id)->exists())
                && !BookShelfLink::query()->where(['book_id' => $book_id, 'shelf_id' => $id])->exists()){
                $data = [
                    'book_id' => $book_id,
                    'shelf_id' => $id
                ];
                BookShelfLink::create($data);
                return $this->sendResponse($data, 'Успешно добавлен!');
            }
        }
        return $this->sendError('Книга уже добавлена!','Ресус не найден');
    }

    public function remove_in_book_shelf($id){
        if($book_shelf = BookShelf::query()->where(['id' => $id, 'user_id' => Auth::id()])->first()){
            $book_id = $this->getParsedBody('book_id');
            if($book_shelf_link = BookShelfLink::query()->where(['book_id' => $book_id, 'shelf_id' => $id])){
                $book_shelf_link->delete();
                return $this->sendResponse([], 'Успешно удален из полки!');
            }
        }
        return $this->sendError('Книга не найдена в полке!','Ресус не найден');
    }

    public function push_settings(){
        $data = [];
        $user = Auth::user();
        PushSetting::query()->each(function ($setting) use (&$data, $user){
            $data[] = [
                'id' => $setting->id,
                'name' => $setting->name,
                'title' => $setting->title,
                'value' => ($setting->getValue()) ? 'Y' : 'N'
            ];
        });
        return $this->sendResponse($data, 'Успешно добавлен!');
    }

    public function toggle_settings($id){
        $value = $this->getParsedBody('value');
        if(in_array($value,['Y', 'N']) && PushSetting::query()->find($id)){
            $data = [
                'setting_id' => $id,
                'value' => ($value == 'Y') ? 1 : 0,
                'user_id' => Auth::id()
            ];
            PushSettingsValue::query()->where(['user_id' => Auth::id(), 'setting_id' => $id])->delete();
            PushSettingsValue::create($data);
            return $this->sendResponse($data,  'Настройки успешно сохранены!' );
        }
        return $this->sendError('Ошибка при обнавление!','Ошибка при обнавление!',400);
    }

    public function terms_of_use(){
        return view('law.terms_of_use');
    }

    public function privacy_policy(){
        return view('law.privacy_policy');
    }
}