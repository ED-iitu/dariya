<?php


namespace App\Http\Controllers\Api;



use Akaunting\Money\Money;
use App\Book;
use App\BookMark;
use App\BookPages;
use App\Genre;
use App\Quote;
use App\Rating;
use App\UserReadBookLink;
use Gufy\PdfToHtml\Config;
use Gufy\PdfToHtml\Html;
use Gufy\PdfToHtml\PageGenerator;
use Gufy\PdfToHtml\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use PHPHtmlParser\Dom;


class BookController extends Controller
{
    public function index(Request $request){
        $page = $request->get('page') ? $request->get('page') : 1;
        $pageSize = $request->get('pageSize') ? $request->get('pageSize') : 5;
        $books = [];
        $res = Book::query()->where(['type' => Book::BOOK_TYPE, 'status' => 1, 'in_list' => true])->orderBy('created_at','desc')->orderBy('updated_at', 'desc')->paginate($pageSize,['*'],'page', $page);
        $res->each(function ($book) use (&$books){
            $books[] = [
                "id"=> $book->id,
                "name"=> $book->name,
                "rating"=> $book->rate,
                "type"=> $book->type,
                "is_free"=> $book->is_free ? true :false,
                "is_favorite"=> $book->isBookFavorite(),
                "price"=> $book->price,
                "formatted_price"=> Money::KZT($book->price)->format(),
                "forum_message_count"=> ($book->comments) ? $book->comments->count() : 0,
                "show_counter"=> $book->show_counter,
                "image_url"=> ($book->image_link) ? url($book->image_link) : null
            ];
        });
        return $this->sendResponse([
            'books' =>$books, 'count' => $res->count(), 'all_count' => $res->total()
        ], '');
    }

    public function view($id){
        /**
         * @var Book $book
         */
        if($book = Book::query()->find($id)){
            Book::where('id', $id)->increment('show_counter');
            $data = [
                "id"=> $book->id,
                "name"=> $book->name,
                "preview_text"=> $book->preview_text,
                "detail_text"=> $book->detail_text,
                "lang"=> $book->lang,
                "lang_label"=> $book->getLangLabel(),
                "publisher"=> ($book->publisher) ? $book->publisher->name : null,
                "rating"=> $book->rate,
                'label' => $book->is_free ? 'Бесплатно' : 'Стандарт',
                "is_favorite"=> $book->isBookFavorite(),
                "in_my_book"=> $book->inMyBook(),
                "user_rating"=> ($book->user_rate()) ? $book->user_rate()->rate : null,
                "page_count"=> $book->page_count,
                "duration"=> $book->duration,
                "type"=> $book->type,
                "is_free"=> $book->is_free ? true :false,
                "is_access"=> $book->isAccess(),
                "price"=> $book->price,
                "price_id"=> $book->price_id,
                "formatted_price"=> Money::KZT($book->price)->format(),
                "forum_message_count"=> ($book->comments) ? $book->comments->count() : 0 ,
                "show_counter"=> $book->show_counter,
                "image_url"=> ($book->image_link) ? url($book->image_link) : null,
                "share_link" => route('book', $book->id),
                "read_link" => $book->getReadLink()
            ];
            if($book->book_id){
                $data['book_id'] = $book->book_id;
            }
            if($book->comments){
                foreach ($book->comments()->paginate(5) as $comment){
                    $rating = Rating::query()->where([
                        'author_id' => $comment->author_id,
                        'object_type' => Rating::BOOK_TYPE,
                        'object_id' => $id
                    ])->first();
                    $comment = [
                        "message"=> $comment->message,
                        "author_id"=> $comment->author_id,
                        "author_name"=> ($comment->author) ? $comment->author->name : '',
                        "personal_photo"=> null,
                        "post_date"=> $comment->created_at
                    ];
                    if($rating){
                        $comment["user_rating"] = $rating->rate;
                    }
                    $data['comments'][] = $comment;
                }
            }
            if($book->ratings){
                $data['rated_users_count'] = $book->ratings->count();
            }
            if($book->genres){
                foreach ($book->genres as $genre){
                    $data['genres'][] = [
                        "genre_id"=> $genre->id,
                        "name"=> $genre->name,
                    ];
                }
            }
            if($book->author){
                $data['authors'][] = $book->author->getFullName();
            }

            log::info(print_r([$data,\Illuminate\Support\Facades\Request::url(), \Illuminate\Support\Facades\Request::header()], true));
            return $this->sendResponse($data, '');
        }
        return $this->sendError('Книга не существует!','Ресус не найден');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_html($id)
    {

        $book = Book::query()->find($id);
        if($book){
            $data = [];
            foreach ($book->pages as $page){
                if($page->status){
                    $data[] = [
                        'content' => $page->content,
                        'page' => $page->page
                    ];
                }else{
                    $data[] = [
                        'content' => 'Страница в обработке',
                        'page' => $page->page
                    ];
                }
            }
            return response(['data' => $data]);
        }


        return $this->sendError('Книга не существует!' ,[], 404);
    }

    public function get_html_by_paginate($id)
    {

        $book = Book::query()->find($id);
        if($book){
            $data = [];
            foreach ($book->pages()->paginate(10) as $page){
                if($page->status){
                    $data[] = [
                        'content' => $page->content,
                        'page' => $page->page
                    ];
                }else{
                    $data[] = [
                        'content' => 'Страница в обработке',
                        'page' => $page->page
                    ];
                }
            }
            return response(['data' => $data]);
        }


        return $this->sendError('Книга не существует!' ,[], 404);
    }

    public function group_by_genre(Request $request){
        $page = $request->get('page') ? $request->get('page') : 1;
        $pageSize = $request->get('pageSize') ? $request->get('pageSize') : 5;
        $books = [];
        $res = Book::query();
        if($request->get('only') == Book::BOOK_TYPE){
            $res = Book::query()->where(['type' => Book::BOOK_TYPE, 'status' => 1, 'in_list' => true])->paginate($pageSize,['*'],'page', $page);
        }elseif($request->get('only') == Book::AUDIO_BOOK_TYPE){
            $res = Book::query()->where(['type' => Book::AUDIO_BOOK_TYPE, 'in_list' => true])->paginate($pageSize,['*'],'page', $page);
        }else{
            $res = Book::query()->paginate($pageSize,['*'],'page', $page);
        }

        $i = 0;
        $res->each(function ($book) use (&$books, &$i){

            $genres = $book->genres;
            foreach ($genres as $genre){
                if(!isset($books[$genre->id])){
                    $books[$genre->id] = [
                        'name' => $genre->name,
                        'genre_id' => $genre->id,
                    ];
                    $books[$genre->id]['books'][] = [
                        "id"=> $book->id,
                        "name"=> $book->name,
                        "rating"=> $book->rate,
                        "type"=> $book->type,
                        "is_free"=> $book->is_free ? true :false,
                        "is_favorite"=> $book->isBookFavorite(),
                        "price"=> $book->price,
                        "formatted_price"=> Money::KZT($book->price)->format(),
                        "forum_message_count"=> ($book->comments) ? $book->comments->count() : 0,
                        "show_counter"=> $book->show_counter,
                        "image_url"=> ($book->image_link) ? url($book->image_link) : null
                    ];
                }else{
                    $books[$genre->id]['books'][] = [
                        "id"=> $book->id,
                        "name"=> $book->name,
                        "rating"=> $book->rate,
                        "type"=> $book->type,
                        "is_free"=> $book->is_free ? true :false,
                        "is_favorite"=> $book->isBookFavorite(),
                        "price"=> $book->price,
                        "formatted_price"=> Money::KZT($book->price)->format(),
                        "forum_message_count"=> ($book->comments) ? $book->comments->count() : 0,
                        "show_counter"=> $book->show_counter,
                        "image_url"=> ($book->image_link) ? url($book->image_link) : null
                    ];
                }
            }
            $i++;
        });
        return $this->sendResponse([
            'genres' =>array_values($books), 'count' => $res->count(), 'all_count' => $res->total()
        ], '');
    }

    public function relatedBooks($id){
        $books = [];
        if($book = Book::find($id)){
            $res = Book::query()->where('type', $book->type)->whereHas('genres', function($query)use($book){
                return $query->whereIn('genre_id', $book->genres->pluck('id')->toArray());
            })->paginate(5);
            $res->each(function ($book) use (&$books){
                $books[] = [
                    "id"=> $book->id,
                    "name"=> $book->name,
                    "rating"=> $book->rate,
                    "type"=> $book->type,
                    "is_free"=> $book->is_free ? true :false,
                    "is_favorite"=> $book->isBookFavorite(),
                    "price"=> $book->price,
                    "formatted_price"=> Money::KZT($book->price)->format(),
                    "forum_message_count"=> ($book->comments) ? $book->comments->count() : 0,
                    "show_counter"=> $book->show_counter,
                    "image_url"=> ($book->image_link) ? url($book->image_link) : null
                ];
            });
        }
        return $this->sendResponse([
            'related_books' =>array_values($books), 'count' => $res->count(), 'all_count' => $res->total()
        ], '');
    }

    public function genres(){
        $genres = Genre::all();
        return $this->sendResponse([
            'genres' =>$genres, 'count' => $genres->count(), 'all_count' => $genres->count()
        ], '');
    }

    public function quotes($book_id = null){
        $data = [];
        $quotes = Quote::query()->where('user_id', Auth::id());
        if($book_id){
            $quotes->where('book_id', $book_id);
        }
        $quotes->orderBy('created_at', 'desc');
        $quotes->each(function (Quote $quote) use (&$data){
            $data[] = [
                'id' => $quote->id,
                'text' => $quote->text,
                'book' => [
                    'id' => $quote->book->id,
                    'name' => $quote->book->name,
                    'image' => url($quote->book->image_link)
                ],
                'user' => [
                    'id' => $quote->user->id,
                    'name' => $quote->user->name,
                    'image' => url($quote->user->profile_photo_path)
                ],
                'created_at' => $quote->created_at
            ];
            return $data;
        });
        return $this->sendResponse([
            'quotes' =>$data, 'count' => $quotes->count(), 'all_count' => $quotes->count()
        ], '');
    }

    public function remove_quote($id){
        if($quote = Quote::query()->find($id)){
            if($quote->user_id = Auth::id()){
                try {
                    if ($quote->delete()) {
                        return $this->sendResponse([
                            "quote_id" => $quote->id
                        ], 'Цитата успешно удалена');
                    }
                } catch (\Exception $e) {
                    return $this->sendError('Internal server error.',[],500);
                }
            }

        }
        return $this->sendError('Bad request.',[],403);
    }

    public function add_quote(Request $request){
        $request->validate([
            'hash' => 'required',
            'page' => 'required',
            'text' => 'required|string',
        ]);
        if($user_book_read_link = UserReadBookLink::query()->where('hash',$request->hash)->first()){
            if($book = Book::query()->find($user_book_read_link->book_id)){
                if(!Quote::query()->where([
                    'user_id' => $user_book_read_link->user_id,
                    'book_id' => $user_book_read_link->book_id,
                    'page' => $request->page,
                    'text' => $request->text
                ])->exists()){
                    $quote = new Quote();
                    $quote->setRawAttributes([
                        'user_id' => $user_book_read_link->user_id,
                        'book_id' => $user_book_read_link->book_id,
                        'page' => $request->page,
                        'text' => $request->text
                    ]);
                    if($quote->save()){
                        return $this->sendResponse([
                            "quote_id" => $quote->id
                        ],'Цитата успешно добавлена!');
                    }
                }
            }
        }
        return $this->sendError('Bad request.',[],403);
    }

    public function save_book_state(Request $request){
        $request->validate([
            'hash' => 'required',
            'page' => 'required'
        ]);
        if($user_book_read_link = UserReadBookLink::query()->where('hash',$request->hash)->first()){
             $user_data = $request->all();
             $user_book_read_link->user_data = $user_data;
            if($user_book_read_link->save()){
                return $this->sendResponse([
                    "page" => $request->page
                ],'Успешно сохранен!');
            }
        }
        return $this->sendError('Bad request.',[],403);
    }

    public function add_book_marks(Request $request){
        $request->validate([
            'hash' => 'required',
            'page' => 'required|int',
        ]);
        if($user_book_read_link = UserReadBookLink::query()->where('hash',$request->hash)->first()){
            if($book_page = BookPages::query()->where(['book_id'=> $user_book_read_link->book_id, 'page' => $request->page])->first()){
                $page_text = strip_tags($book_page->content);
                if($page_text){
                    $page_text = mb_substr($page_text,0,40) . ' ...';
                    if(!BookMark::query()->where([
                        'user_id' => $user_book_read_link->user_id,
                        'book_id' => $user_book_read_link->book_id,
                        'page' => $request->page
                    ])->exists()){
                        $book_mark = new BookMark();
                        $book_mark->setRawAttributes([
                            'user_id' => $user_book_read_link->user_id,
                            'book_id' => $user_book_read_link->book_id,
                            'page' => $request->page,
                            'name' => $page_text
                        ]);
                        if($book_mark->save()){
                            return $this->sendResponse([
                                "name" => $page_text,
                                "bookmark_id" => $book_mark->id
                            ],'Закладка успешно добавлена');
                        }
                    }else{
                        return $this->sendError('Страница уже добавлена!.',[],403);
                    }
                }
                return $this->sendError('Вы не можете сохранить пустую страницу!.',[],403);
            }
        }
        return $this->sendError('Не известная ошибка!.',[],500);
    }

    public function remove_bookmark($id){
        if($bookmark = BookMark::query()->find($id)){
            if($bookmark->user_id = Auth::id()){
                try {
                    if ($bookmark->delete()) {
                        return $this->sendResponse([
                            "bookmark_id" => $bookmark->id
                        ], 'Закладка успешно удалена');
                    }
                } catch (\Exception $e) {
                    return $this->sendError('Internal server error.',[],500);
                }
            }

        }
        return $this->sendError('Bad request.',[],403);
    }

    public function book_marks($book_id = null){
        $data = [];
        $bookmarks = BookMark::query()->where('user_id', Auth::id());
        if($book_id){
            $bookmarks->where('book_id', $book_id);
        }
        $bookmarks->orderBy('created_at', 'desc');
        $bookmarks->each(function (BookMark $bookmark) use (&$data){
            $data[] = [
                'id' => $bookmark->id,
                'name' => $bookmark->name,
                'book' => [
                    'id' => $bookmark->book->id,
                    'name' => $bookmark->book->name,
                    'image' => url($bookmark->book->image_link)
                ],
                'user' => [
                    'id' => $bookmark->user->id,
                    'name' => $bookmark->user->name,
                    'image' => url($bookmark->user->profile_photo_path)
                ],
                'created_at' => $bookmark->created_at
            ];
            return $data;
        });
        return $this->sendResponse([
            'bookmarks' =>$data, 'count' => $bookmarks->count(), 'all_count' => $bookmarks->count()
        ], '');
    }
}