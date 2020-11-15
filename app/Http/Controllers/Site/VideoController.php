<?php
/**
 * Created by PhpStorm.
 * User: eduard
 * Date: 10/7/20
 * Time: 01:14
 */

namespace App\Http\Controllers\Site;


use App\Book;
use App\Category;
use App\Http\Controllers\Controller;
use App\Video;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    public function index()
    {
        $title = 'Подборка статей';
        $breadcrumb[] = [
            'title' => $title,
            'route' => route('articles'),
            'active' => true
        ];
        $videos = Video::query()->where('for_vip', 0)->orderBy('created_at','desc')->orderBy('updated_at', 'desc')->paginate(9);
        if(Auth::user()){
            if(Auth::user()->have_active_tariff()){
                if(Auth::user()->tariff->slug == 'vip'){
                    $videos = Video::query()->orderBy('created_at','desc')->orderBy('updated_at', 'desc')->paginate(9);
                }
            }
        }
        $recentVideos = Video::where('created_at', '>', date('Y-m-d H:i:s', strtotime('-7days')))->get();
        $categories = (Category::query()->where('slug','video')->first()) ? Category::query()->where('slug','video')->first()->childs : [];
        return view('site.videos',[
            'videos' => $videos,
            'recentVideos' => $recentVideos,
            'categories' => $categories,
            'title' => $title,
            'breadcrumb' => $breadcrumb
        ]);
    }
}