<?php
/**
 * Created by PhpStorm.
 * User: eduard
 * Date: 10/6/20
 * Time: 23:30
 */

namespace App\Http\Controllers\Site;


use App\Book;
use Auth;
use App\Http\Controllers\Controller;

class FavoriteController extends Controller
{
    public function index()
    {
        $title = 'Избранные';
        $breadcrumb[] = [
            'title' => $title,
            'route' => route('favorite'),
            'active' => true
        ];

        $books = Auth::user()->favorites_books()->get();
        $audio_books = Auth::user()->favorites_audio_books;
        $articles = Auth::user()->favorites_articles;
        $videos = Auth::user()->favorites_videos;


        return view('site.favorite', [
            'books' => $books,
            'audio_books' => $audio_books,
            'articles' => $articles,
            'videos' => $videos,
            'title' => $title,
            'breadcrumb' => $breadcrumb,
        ]);
    }
}