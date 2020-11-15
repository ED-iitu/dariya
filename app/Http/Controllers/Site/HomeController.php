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
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $books = Book::query()->where('type', Book::BOOK_TYPE)
            ->orderBy('created_at','desc')->orderBy('updated_at', 'desc')->paginate(10);
        $audio_books = Book::query()->where('type', Book::AUDIO_BOOK_TYPE)
            ->orderBy('created_at','desc')->orderBy('updated_at', 'desc')->paginate(10);
        $articles = Article::query()
            ->orderBy('created_at','desc')->orderBy('updated_at', 'desc')->paginate(10);
        $videos = Video::query()->where('for_vip', 0)
            ->orderBy('created_at','desc')->orderBy('updated_at', 'desc');
        if(Auth::user()){
            if(Auth::user()->have_active_tariff()){
                if(Auth::user()->tariff->slug == 'vip'){
                    $videos = Video::query()
                        ->orderBy('created_at','desc')->orderBy('updated_at', 'desc');
                }
            }
        }
        $videos = $videos->paginate(10);
        $banners = Banner::query()->where('type', Banner::BANNER_MAIN_TYPE)
            ->orderBy('created_at','desc')->orderBy('updated_at', 'desc')->paginate(10);;
        $tariffs = Tariff::query()->whereIn('slug', ['standard', 'premium'])->get();

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
