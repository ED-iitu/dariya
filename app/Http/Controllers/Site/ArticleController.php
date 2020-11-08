<?php
namespace App\Http\Controllers\Site;

use App\Article;
use App\Comment;
use App\Category;
use App\Facades\ShareFacade;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $articles = Article::query();

        if($request->get('author')){
            $articles->orWhere('author','like',"%{$request->get('author')}%");
        }
        if($request->get('category')){
            $category = $request->get('category');
            $articles->orWhereHas('categories',function ($query) use ($category){
                return $query->where('name', 'like', "%$category%");
            });
        }
        $articles = $articles->paginate(9);
        $recentArticles = Article::recents();
        $categories = (Category::query()->where('slug','article')->first()) ? Category::query()->where('slug','article')->first()->childs : [];

        $title = 'Подборка статей';
        $breadcrumb[] = [
            'title' => $title,
            'route' => route('articles'),
            'active' => true
        ];

        return view('site.articles', [
            'articles' => $articles,
            'recentArticles' => $recentArticles,
            'categories' => $categories,
            'title' => $title,
            'breadcrumb' => $breadcrumb
        ]);
    }
    
    public function singleBook($id)
    {
        $article = Article::find($id);

        if ($article) {
            Article::where('id', $id)->increment('show_counter');
            $author = $article->author;
            $similar_articles = Article::query()->orWhere('author','like', "%{$author}%")->limit(5)->get();
        }

        $comments = Comment::where('object_id', '=', $id)->where('object_type', '=', 'ARTICLE')->get();

        if ($comments->count() == 0) {
            $comments = [];
        }
        $article->setAsRecent();

        $breadcrumb[] = [
            'title' => 'Подборка статей',
            'route' => route('articles'),
            'active' => false,
        ];
        $title = $article->name;
        $breadcrumb[] = [
            'title' => $title,
            'active' => true
        ];

        $share_links = ShareFacade::page(url('article/'.$id), $article->name)
            ->facebook()
            ->vk()
            ->twitter()
            ->whatsapp()
            ->telegram()
            ->getRawLinks();

        return view('site.article', [
            'article' => $article,
            'similar_articles' => $similar_articles,
            'comments' => $comments,
            'title' => $title,
            'breadcrumb' => $breadcrumb,
            'share_links' => $share_links,
        ]);
    }
}