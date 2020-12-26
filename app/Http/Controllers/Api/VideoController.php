<?php


namespace App\Http\Controllers\Api;


use App\Rating;
use App\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VideoController extends Controller
{
    public function index(Request $request){
        $page = $request->get('page') ? $request->get('page') : 1;
        $pageSize = $request->get('pageSize') ? $request->get('pageSize') : 5;
        $videos = [];

        $res = Video::query()->where('for_vip', 0);
        if(Auth::user()){
            if(Auth::user()->have_active_tariff()){
                if(Auth::user()->tariff->slug == 'vip'){
                    $res = Video::query();
                }
            }
        }

        $res = $res->orderBy('created_at','desc')->orderBy('updated_at', 'desc')->paginate($pageSize,['*'],'page', $page);
        $res->each(function ($video) use (&$videos){
            $videos[] = [
                "id"=> $video->id,
                "name"=> $video->name,
                "rating"=> $video->rate,
                "is_favorite"=> $video->isFavorite(),
                "author"=> $video->author ? $video->author : null,
                "forum_message_count"=> ($video->comments) ? $video->comments->count() : 0,
                "show_counter"=> $video->show_counter,
                "image_url"=> ($video->image_link) ? url($video->image_link) : null,
                "type" => ($video->youtube_video_id) ? "YOUTUBE" : "LOCAL",
                "for_vip" => (bool)$video->for_vip,
                "youtube_video_id" => $video->youtube_video_id,
                "local_video_link" => ($video->local_video_link) ? url($video->local_video_link) : null,
            ];
        });
        return $this->sendResponse([
            'videos' =>$videos, 'count' => $res->count(), 'all_count' => $res->total()
        ], '');
    }

    public function view($id){
        if($video = Video::query()->find($id)){
            $data = [
                "id"=> $video->id,
                "name"=> $video->name,
                "preview_text"=> $video->preview_text,
                "detail_text"=> $video->detail_text,
                "rating"=> $video->rate,
                "is_favorite"=> $video->isFavorite(),
                "user_rating"=> ($video->user_rate()) ? $video->user_rate()->rate : null,
                "author"=> $video->author ? $video->author : null,
                "forum_message_count"=> ($video->comments) ? $video->comments->count() : 0 ,
                "show_counter"=> $video->show_counter,
                "image_url"=> ($video->image_link) ? url($video->image_link) : null,
                "type" => ($video->youtube_video_id) ? "YOUTUBE" : "LOCAL",
                "youtube_video_id" => $video->youtube_video_id,
                "local_video_link" => ($video->local_video_link) ? url($video->local_video_link) : null,
                "share_link"=> route('video', $video->id)
            ];
            if($video->comments){
                foreach ($video->comments()->paginate(5) as $comment){
                    $rating = Rating::query()->where([
                        'author_id' => $comment->author_id,
                        'object_type' => Rating::VIDEO_TYPE,
                        'object_id' => $id
                    ])->first();
                    $comment = [
                        "message"=> $comment->message,
                        "author_id"=> $comment->author_id,
                        "author_name"=> ($comment->author) ? $comment->author->name : '',
                        "personal_photo"=> null,
                        "post_date"=> $comment->created_at
                    ];
                    if($rating){
                        $comment["user_rating"] = $rating->rate;
                    }
                    $data['comments'][] = $comment;
                }
            }
            if($video->categories){
                foreach ($video->categories as $category){
                    $data['categories'][] = [
                        "id"=> $category->id,
                        "category_name"=> $category->name
                    ];
                }
            }
            return $this->sendResponse($data, '');
        }
        return $this->sendError('Видео-материал не найден!','Ресус не найден');
    }
}