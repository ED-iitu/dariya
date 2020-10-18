<?php

namespace App\Http\Controllers\Site;

use App\Article;
use App\Banner;
use App\Book;
use App\BookToGenre;
use App\Genre;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $books = Book::all();
        $articles = Article::all();
        $genres = Genre::offset(0)->limit(4)->get();
        $popularBooks = Book::all();
        $banners = Banner::query()->where('type', Banner::BANNER_MAIN_TYPE)->get();


        return view('site.home', [
            'books' => $books,
            'articles' => $articles,
            'genres' => $genres,
            'popularBooks' => $popularBooks,
            'banners' => $banners,
        ]);
    }
}
