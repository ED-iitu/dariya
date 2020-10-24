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
        $videos = Video::paginate(9);
        $recentVideos = Video::where('created_at', '>', date('Y-m-d H:i:s', strtotime('-7days')))->get();
        $categories = Category::all();
        return view('site.videos',[
            'videos' => $videos,
            'recentVideos' => $recentVideos,
            'categories' => $categories,
            'title' => $title,
            'breadcrumb' => $breadcrumb
        ]);
    }
}