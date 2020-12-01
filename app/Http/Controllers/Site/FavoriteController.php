<?php
/**
 * Created by PhpStorm.
 * User: eduard
 * Date: 10/6/20
 * Time: 23:30
 */

namespace App\Http\Controllers\Site;


use App\Favorite;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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

    public function addToFavorite($type, $id)
    {
        if (\Illuminate\Support\Facades\Auth::user() == null) {
            return view('site.createAccount');
        }
        /**
         * @var BelongsToMany $model
         */
        switch ($type){
            case strtolower(Favorite::FAVORITE_ARTICLE_TYPE):
                $model = Auth::user()->favorites_articles();
                break;
            case strtolower(Favorite::FAVORITE_VIDEO):
                $model = Auth::user()->favorites_videos();
                break;
            case strtolower(Favorite::FAVORITE_BOOK_TYPE):
                $model = Auth::user()->favorites_books();
                break;
            case strtolower(Favorite::FAVORITE_AUDIO_BOOK_TYPE):
                $model = Auth::user()->favorites_audio_books();
                break;
        }

        $model->syncWithoutDetaching([$id => ['object_type' => strtoupper($type)]]);

        return redirect()->back()->with('success','Успешно добалена в избранное');
    }

    public function removeInFavorite($type, $id)
    {
        if (\Illuminate\Support\Facades\Auth::user() == null) {
            return view('site.createAccount');
        }
        /**
         * @var BelongsToMany $model
         */
        switch ($type){
            case strtolower(Favorite::FAVORITE_ARTICLE_TYPE):
                $model = Auth::user()->favorites_articles();
                break;
            case strtolower(Favorite::FAVORITE_VIDEO):
                $model = Auth::user()->favorites_videos();
                break;
            case strtolower(Favorite::FAVORITE_BOOK_TYPE):
                $model = Auth::user()->favorites_books();
                break;
            case strtolower(Favorite::FAVORITE_AUDIO_BOOK_TYPE):
                $model = Auth::user()->favorites_audio_books();
                break;
        }

        $model->detach([$id => ['object_type' => strtoupper($type)]]);

        return redirect()->back()->with('success','Успешно удаленна из избранных');
    }
}