<?php

namespace App\Http\Controllers\Site;

use App\Article;
use App\Book;
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

        return view('site.home', [
            'books' => $books,
            'articles' => $articles,
            'genres' => $genres,
            'popularBooks' => $popularBooks
        ]);
    }
}
