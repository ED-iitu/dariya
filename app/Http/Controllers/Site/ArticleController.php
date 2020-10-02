<?php
namespace App\Http\Controllers\Site;

use App\Article;
use App\Genre;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::all();
        $recentArticles = Article::where('created_at', '>', date('Y-m-d H:i:s', strtotime('-7days')))->get();
        $genres = Genre::all();

        return view('site.articles', [
            'articles' => $articles,
            'recentArticles' => $recentArticles,
            'genres' => $genres
        ]);
    }
    public function singleBook($id)
    {
        $articles = Article::where('id', '=', $id)->get();
        $recentArticles = Article::where('created_at', '>', date('Y-m-d H:i:s', strtotime('-7days')))->get();
        $genres = Genre::all();

        return view('site.article', [
            'articles' => $articles,
            'recentArticles' => $recentArticles,
            'genres' => $genres
        ]);
    }
}