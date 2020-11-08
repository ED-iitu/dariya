<?php


namespace App\Http\Controllers\Api;



use Akaunting\Money\Money;
use App\Book;
use App\Genre;
use Gufy\PdfToHtml\Config;
use Gufy\PdfToHtml\Html;
use Gufy\PdfToHtml\PageGenerator;
use Gufy\PdfToHtml\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPHtmlParser\Dom;


class BookController extends Controller
{
    public function index(Request $request){
        $page = $request->get('page') ? $request->get('page') : 1;
        $pageSize = $request->get('pageSize') ? $request->get('pageSize') : 5;
        $books = [];
        $res = Book::query()->where(['type' => Book::BOOK_TYPE])->orderBy('created_at','desc')->orderBy('updated_at', 'desc')->paginate($pageSize,['*'],'page', $page);
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
        if($book = Book::query()->find($id)){
            $is_access = false;
            if(Auth::user()){
                if(Auth::user()->have_active_tariff()){
                    $is_access = true;
                }else{
                    Auth::user()->books->each(function ($my_book) use (&$is_access, $id){
                        if(!$is_access && $id == $my_book->id){
                            $is_access = true;
                        }
                    });
                }
            }
            $data = [
                "id"=> $book->id,
                "name"=> $book->name,
                "preview_text"=> $book->preview_text,
                "detail_text"=> $book->detail_text,
                "lang"=> $book->lang,
                "lang_label"=> $book->getLangLabel(),
                "publisher"=> ($book->publisher) ? $book->publisher->name : null,
                "rating"=> $book->rate,
                "is_favorite"=> $book->isBookFavorite(),
                "in_my_book"=> $book->inMyBook(),
                "user_rating"=> ($book->user_rate()) ? $book->user_rate()->rate : null,
                "page_count"=> $book->page_count,
                "duration"=> $book->duration,
                "type"=> $book->type,
                "is_free"=> $book->is_free ? true :false,
                "is_access"=> $is_access,
                "price"=> $book->price,
                "formatted_price"=> Money::KZT($book->price)->format(),
                "forum_message_count"=> ($book->comments) ? $book->comments->count() : 0 ,
                "show_counter"=> $book->show_counter,
                "image_url"=> ($book->image_link) ? url($book->image_link) : null,
            ];
            if($book->comments){
                foreach ($book->comments as $comment){
                    $data['comments'][] = [
                        "message"=> $comment->message,
                        "author_id"=> $comment->author_id,
                        "author_name"=> ($comment->author) ? $comment->author->name : '',
                        "personal_photo"=> null,
                        "post_date"=> $comment->created_at
                    ];
                }
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


            return $this->sendResponse($data, '');
        }
        return $this->sendError('Not Found','Ресус не найден');
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


        return $this->sendError('Book Not Found' ,[], 404);
    }

    public function group_by_genre(Request $request){
        $page = $request->get('page') ? $request->get('page') : 1;
        $pageSize = $request->get('pageSize') ? $request->get('pageSize') : 5;
        $books = [];
        $res = Book::query();
        if($request->get('only') == Book::BOOK_TYPE){
            $res = Book::query()->where(['type' => Book::BOOK_TYPE])->paginate($pageSize,['*'],'page', $page);
        }elseif($request->get('only') == Book::AUDIO_BOOK_TYPE){
            $res = Book::query()->where(['type' => Book::AUDIO_BOOK_TYPE])->paginate($pageSize,['*'],'page', $page);
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
}