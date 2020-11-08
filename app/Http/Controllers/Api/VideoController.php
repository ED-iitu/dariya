<?php


namespace App\Http\Controllers\Api;


use App\Article;
use App\Video;
use Illuminate\Http\Request;
use function PHPSTORM_META\type;

class VideoController extends Controller
{
    public function index(Request $request){
        $page = $request->get('page') ? $request->get('page') : 1;
        $pageSize = $request->get('pageSize') ? $request->get('pageSize') : 5;
        $videos = [];
        $res = Video::query()->orderBy('created_at','desc')->orderBy('updated_at', 'desc')->paginate($pageSize,['*'],'page', $page);
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
            ];
            if($video->comments){
                foreach ($video->comments as $comment){
                    $data['comments'][] = [
                        "message"=> $comment->message,
                        "author_id"=> $comment->author_id,
                        "author_name"=> ($comment->author) ? $comment->author->name : '',
                        "personal_photo"=> null,
                        "post_date"=> $comment->created_at
                    ];
                }
            }
            if($video->categories){
                foreach ($video->categories as $category){
                    $data['categories'][] = [
                        "id"=> $comment->id,
                        "category_name"=> $category->name
                    ];
                }
            }
            return $this->sendResponse($data, '');
        }
        return $this->sendError('Not Found','Ресус не найден');
    }
}