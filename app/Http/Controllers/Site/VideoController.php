<?php
/**
 * Created by PhpStorm.
 * User: eduard
 * Date: 10/7/20
 * Time: 01:14
 */

namespace App\Http\Controllers\Site;


use App\Category;
use App\Comment;
use App\Facades\ShareFacade;
use App\Http\Controllers\Controller;
use App\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Подборка видео';
        $breadcrumb[] = [
            'title' => $title,
            'route' => route('articles'),
            'active' => true
        ];
        $videos = Video::query()->where('for_vip', 0);
        if(Auth::user()){
            if(Auth::user()->have_active_tariff()){
                if(Auth::user()->tariff->slug == 'vip'){
                    $videos = Video::query();
                }
            }
        }
        if($request->get('category')){
            $category = $request->get('category');
            $videos->whereHas('categories',function ($query) use ($category){
                return $query->where('name', 'like', "%$category%");
            });
        }
        $videos = $videos->orderBy('created_at','desc')->orderBy('updated_at', 'desc')->paginate(9);
        $recentVideos = Video::recents();
        $categories = (Category::query()->where('slug','video')->first()) ? Category::query()->where('slug','video')->first()->childs : [];
        return view('site.videos',[
            'videos' => $videos,
            'recentVideos' => $recentVideos,
            'categories' => $categories,
            'title' => $title,
            'breadcrumb' => $breadcrumb
        ]);
    }

    public function single($id)
    {
        $video = Video::find($id);

        if ($video) {
            Video::where('id', $id)->increment('show_counter');
            $author = $video->author;
            $similar_videos = Video::query()->orWhere('author','like', "%{$author}%")->limit(5)->get();
        }

        $comments = Comment::where('object_id', '=', $id)->where('object_type', '=', 'ARTICLE')->get();

        if ($comments->count() == 0) {
            $comments = [];
        }

        $breadcrumb[] = [
            'title' => 'Видео',
            'route' => route('videos'),
            'active' => false,
        ];
        $title = $video->name;
        $breadcrumb[] = [
            'title' => $title,
            'active' => true
        ];
        $video->setAsRecent();
        $share_links = ShareFacade::page(url('video/'.$id), $video->name)
            ->facebook()
            ->vk()
            ->twitter()
            ->whatsapp()
            ->telegram()
            ->getRawLinks();

        return view('site.video', [
            'video' => $video,
            'similar_videos' => $similar_videos,
            'comments' => $comments,
            'title' => $title,
            'breadcrumb' => $breadcrumb,
            'share_links' => $share_links,
        ]);
    }
}