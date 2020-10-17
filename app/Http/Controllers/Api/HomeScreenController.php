<?php


namespace App\Http\Controllers\Api;


use Akaunting\Money\Money;
use App\Article;
use App\Banner;
use App\Book;
use App\Video;

class HomeScreenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /**
         *  Banners
         */

        $res  = Banner::query();
        $banners = [];
        $res->paginate(5)->each(function ($banner) use(&$banners){
            $banners[] = [
                "id"=> $banner->id,
                "name"=> $banner->title,
                "image_url"=> ($banner->file_url) ? url($banner->file_url) : null,
                "redirect" => $banner->redirect
            ];
        });
        $all_banners = $res->count();
        /**
         * Articles
         */
        $res = Article::query();
        $articles  = [];
        $res->paginate(5)->each(function ($article) use (&$articles){
            $articles[] = [
                'id' => $article->id,
                'name' => $article->name,
                'rating' => $article->rate,
                'forum_message_count' => $article->comments ? $article->comments->count() : 0,
                'show_counter' => $article->show_counter,
                'image_url' => ($article->image_link) ? url($article->image_link) : null,
            ];
        });
        $all_articles = $res->count();

        /**
         * Books
         */
        $res = Book::query()->where(['type' => 'BOOK']);
        $books  = [];
        $res->each(function($model) use (&$books){

            $authors = [];
            if($model->authors){
                $author = $model->authors->name;
                if($model->authors->surname)
                    $author .= ' '.$model->authors->surname;
                $authors[] = $author;
            }

            $books[] = [
                'id' => $model->id,
                'name' => $model->name,
                'authors' => $authors,
                'rating' => $model->rate,
                "price"=> $model->price,
                "formatted_price"=> Money::KZT($model->price)->format(),
                'forum_message_count' => ($model->comments) ? $model->comments->count() : 0,
                'show_counter' => $model->show_counter,
                'image_url' => ($model->image_link) ? url($model->image_link) : null,
            ];
        });
        $all_books = $res->count();

        /**
         * Audio-Books
         */
        $res = Book::query()->where(['type' => 'AUDIO']);
        $audio_books  = [];
        $res->each(function($model) use (&$audio_books){

            $authors = [];
            if($model->authors){
                $author = $model->authors->name;
                if($model->authors->surname)
                    $author .= ' '.$model->authors->surname;
                $authors[] = $author;
            }

            $audio_books[] = [
                'id' => $model->id,
                'name' => $model->name,
                'authors' => $authors,
                'rating' => $model->rate,
                "price"=> $model->price,
                "formatted_price"=> Money::KZT($model->price)->format(),
                'forum_message_count' => ($model->comments) ? $model->comments->count() : 0,
                'show_counter' => $model->show_counter,
                'image_url' => ($model->image_link) ? url($model->image_link) : null,
            ];
        });
        $all_audio_books = $res->count();

        /**
         * Videos
         */
        $res = Video::query();
        $videos  = [];
        $res->each(function($model) use (&$videos){
            $videos[] = [
                'id' => $model->id,
                'name' => '',
                'youtube_video_id' => $model->youtube_video_id
            ];
        });
        $all_videos = $res->count();

        $data = [
            [
                'type' => 'banner',
                'content' => $banners,
                'count' => count($banners),
                'all_count' => $all_banners
            ],
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
}