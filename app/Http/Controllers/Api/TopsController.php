<?php


namespace App\Http\Controllers\Api;

use App\Book;

/**
 * Class TopsController
 * @package App\Http\Controllers\Api
 * ToDo
 */
class TopsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function books($type = false)
    {
        if($type){
            $request = \Illuminate\Http\Request::createFromGlobals();
            $page = $request->get('page') ? $request->get('page') : 1;
            $pageSize = $request->get('pageSize') ? $request->get('pageSize') : 5;
            $books = [];
            $res = Book::query()->where(['type' => Book::BOOK_TYPE, 'status' => 1])->orderBy('created_at','desc')->orderBy('updated_at', 'desc')->paginate($pageSize,['*'],'page', $page);
            $res->each(function ($book) use (&$books){
                $authors = [];
                if($book->author){
                    $author = $book->author->name;
                    if($book->author->surname)
                        $author .= ' '.$book->author->surname;
                    $authors[] = $author;
                }
                $books[] = [
                    "id"=> $book->id,
                    "name"=> $book->name,
                    "rating"=> round($book->rate, 2),
                    "type"=> $book->type,
                    'authors' => $authors,
                    "is_free"=> $book->is_free ? true :false,
                    "is_favorite"=> $book->isFavorite(),
                    "price"=> 0,
                    "formatted_price"=> null,
                    "forum_message_count"=> ($book->comments) ? $book->comments->count() : 0,
                    "show_counter"=> $book->show_counter,
                    "image_url"=> ($book->image_link) ? url($book->image_link) : null
                ];
            });
            return $this->sendResponse([
                'books' =>$books, 'count' => $res->count(), 'all_count' => $res->total()
            ], '');
        }


        /**
         * Books
         */
        $res = Book::query()->where(['type' => 'BOOK', 'status' => 1])->orderBy('created_at','desc')->orderBy('updated_at', 'desc');
        $books  = [];
        $res->each(function($model) use (&$books){

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
                "type"=> $model->type,
                'authors' => $authors,
                'rating' => round($model->rate, 2),
                "is_favorite"=> $model->isFavorite(),
                "price"=> 0,
                "formatted_price"=> null,
                'forum_message_count' => ($model->comments) ? $model->comments->count() : 0,
                'show_counter' => $model->show_counter,
                'image_url' => ($model->image_link) ? url($model->image_link) : null,
            ];
        });
        $all_books = $res->count();


        $data = [
            [
                'type' => 'top',
                'title' => 'TOP популярные книги',
                'content' => $books,
                'count' => count($books),
                'all_count' => $all_books
            ],
            [
                'type' => 'read',
                'title' => 'Что читают',
                'content' => $books,
                'count' => count($books),
                'all_count' => $all_books
            ],
            [
                'type' => 'month',
                'title' => 'Популярно в этом месяце',
                'content' => $books,
                'count' => count($books),
                'all_count' => $all_books
            ],
        ];
        return response($data);
    }

    public function audio_books($type = false)
    {
        if($type){
            $request = \Illuminate\Http\Request::createFromGlobals();
            $page = $request->get('page') ? $request->get('page') : 1;
            $pageSize = $request->get('pageSize') ? $request->get('pageSize') : 5;
            $books = [];
            $res = Book::query()->where(['type' => Book::AUDIO_BOOK_TYPE, 'status' => 1])->orderBy('created_at','desc')->orderBy('updated_at', 'desc')->paginate($pageSize,['*'],'page', $page);
            $res->each(function ($book) use (&$books){
                $authors = [];
                if($book->author){
                    $author = $book->author->name;
                    if($book->author->surname)
                        $author .= ' '.$book->author->surname;
                    $authors[] = $author;
                }
                $books[] = [
                    "id"=> $book->id,
                    "name"=> $book->name,
                    "rating"=> round($book->rate, 2),
                    "type"=> $book->type,
                    'authors' => $authors,
                    "is_free"=> $book->is_free ? true :false,
                    "is_favorite"=> $book->isFavorite(),
                    "price"=> 0,
                    "formatted_price"=> null,
                    "forum_message_count"=> ($book->comments) ? $book->comments->count() : 0,
                    "show_counter"=> $book->show_counter,
                    "image_url"=> ($book->image_link) ? url($book->image_link) : null
                ];
            });
            return $this->sendResponse([
                'books' =>$books, 'count' => $res->count(), 'all_count' => $res->total()
            ], '');
        }


        /**
         * Books
         */
        $res = Book::query()->where(['type' => Book::AUDIO_BOOK_TYPE, 'status' => 1])->orderBy('created_at','desc')->orderBy('updated_at', 'desc');
        $books  = [];
        $res->each(function($model) use (&$books){

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
                "type"=> $model->type,
                'authors' => $authors,
                'rating' => round($model->rate, 2),
                "is_favorite"=> $model->isFavorite(),
                "price"=> 0,
                "formatted_price"=> null,
                'forum_message_count' => ($model->comments) ? $model->comments->count() : 0,
                'show_counter' => $model->show_counter,
                'image_url' => ($model->image_link) ? url($model->image_link) : null,
            ];
        });
        $all_books = $res->count();


        $data = [
            [
                'type' => 'top',
                'title' => 'TOP популярные аудио-книги',
                'content' => $books,
                'count' => count($books),
                'all_count' => $all_books
            ],
            [
                'type' => 'read',
                'title' => 'Что слушают',
                'content' => $books,
                'count' => count($books),
                'all_count' => $all_books
            ],
            [
                'type' => 'month',
                'title' => 'Популярно в этом месяце',
                'content' => $books,
                'count' => count($books),
                'all_count' => $all_books
            ],
        ];
        return response($data);
    }

    public function news($type = false)
    {
        if($type){
            if($type == 'new_book'){
                $type = Book::BOOK_TYPE;
            }else{
                $type = Book::AUDIO_BOOK_TYPE;
            }
            $request = \Illuminate\Http\Request::createFromGlobals();
            $page = $request->get('page') ? $request->get('page') : 1;
            $pageSize = $request->get('pageSize') ? $request->get('pageSize') : 5;
            $books = [];
            $res = Book::query()->where(['type' => $type, 'status' => 1])->orderBy('created_at','desc')->orderBy('updated_at', 'desc')->paginate($pageSize,['*'],'page', $page);
            $res->each(function ($book) use (&$books){
                $authors = [];
                if($book->author){
                    $author = $book->author->name;
                    if($book->author->surname)
                        $author .= ' '.$book->author->surname;
                    $authors[] = $author;
                }
                $books[] = [
                    "id"=> $book->id,
                    "name"=> $book->name,
                    "rating"=> round($book->rate, 2),
                    "type"=> $book->type,
                    "is_free"=> $book->is_free ? true :false,
                    "is_favorite"=> $book->isFavorite(),
                    'authors' => $authors,
                    "price"=> 0,
                    "formatted_price"=> null,
                    "forum_message_count"=> ($book->comments) ? $book->comments->count() : 0,
                    "show_counter"=> $book->show_counter,
                    "image_url"=> ($book->image_link) ? url($book->image_link) : null
                ];
            });
            return $this->sendResponse([
                'books' =>$books, 'count' => $res->count(), 'all_count' => $res->total()
            ], '');
        }


        /**
         * Books
         */
        $res = Book::query()->where(['type' => Book::BOOK_TYPE, 'status' => 1])->orderBy('created_at','desc')->orderBy('updated_at', 'desc');
        $books  = [];
        $res->each(function($model) use (&$books){

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
                "type"=> $model->type,
                'authors' => $authors,
                'rating' => round($model->rate, 2),
                "is_favorite"=> $model->isFavorite(),
                "price"=> 0,
                "formatted_price"=> null,
                'forum_message_count' => ($model->comments) ? $model->comments->count() : 0,
                'show_counter' => $model->show_counter,
                'image_url' => ($model->image_link) ? url($model->image_link) : null,
            ];
        });
        $all_books = $res->count();

        /**
         * Audio-Books
         */
        $res = Book::query()->where(['type' => Book::AUDIO_BOOK_TYPE, 'status' => 1])->orderBy('created_at','desc')->orderBy('updated_at', 'desc');
        $audio_books  = [];
        $res->each(function($model) use (&$audio_books){

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
                "type"=> $model->type,
                'authors' => $authors,
                'rating' => round($model->rate, 2),
                "price"=> 0,
                "formatted_price"=> null,
                'forum_message_count' => ($model->comments) ? $model->comments->count() : 0,
                'show_counter' => $model->show_counter,
                'image_url' => ($model->image_link) ? url($model->image_link) : null,
            ];
        });
        $all_audio_books = $res->count();


        $data = [
            [
                'type' => 'new_book',
                'title' => 'Новые книги',
                'content' => $books,
                'count' => count($books),
                'all_count' => $all_books
            ],
            [
                'type' => 'new_audio_book',
                'title' => 'Новые аудиокниги',
                'content' => $audio_books,
                'count' => count($audio_books),
                'all_count' => $all_audio_books
            ],
        ];
        return response($data);
    }

}