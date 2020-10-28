<?php

namespace App\Http\Controllers\Site;

use App\Article;
use App\Banner;
use App\Book;
use App\BookToGenre;
use App\Genre;
use App\Http\Controllers\Controller;
use App\Tariff;
use App\Video;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $books = Book::query()->where('type', Book::BOOK_TYPE)->get();
        $audio_books = Book::query()->where('type', Book::AUDIO_BOOK_TYPE)->get();
        $articles = Article::all();
        $videos = Video::all();
        $banners = Banner::query()->where('type', Banner::BANNER_MAIN_TYPE)->get();
        $tariffs = Tariff::all();

        $title = 'Дамыту орталығы';

        return view('site.home', [
            'books' => $books,
            'audio_books' => $audio_books,
            'articles' => $articles,
            'videos' => $videos,
            'banners' => $banners,
            'tariffs' => $tariffs,
            'title' => $title,
        ]);
    }
}
