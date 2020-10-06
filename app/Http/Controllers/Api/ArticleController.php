<?php


namespace App\Http\Controllers\Api;


use App\Article;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class ArticleController extends Controller
{
    public function index(Request $request){
        $page = $request->get('page') ? $request->get('page') : 1;
        $pageSize = $request->get('pageSize') ? $request->get('pageSize') : 5;
        $artiles = [];
        $res = Article::query()->paginate($pageSize,['*'],'page', $page);
        $res->each(function ($article) use (&$artiles){
            $artiles[] = [
                "id"=> $article->id,
                "name"=> $article->name,
                "rating"=> $article->rate,
                "forum_message_count"=> ($article->comments) ? $article->comments->count() : 0,
                "show_counter"=> $article->show_counter,
                "image_url"=> ($article->image_link) ? url($article->image_link) : null
            ];
        });
        return $this->sendResponse([
            'articles' =>$artiles, 'count' => $res->count(), 'all_count' => $res->total()
        ], '');
    }

    public function view($id){
        if($article = Article::query()->find($id)){
            $data = [
                "id"=> $article->id,
                "name"=> $article->name,
                "preview_text"=> $article->preview_text,
                "detail_text"=> $article->detail_text,
                "rating"=> $article->rate,
                "forum_message_count"=> ($article->comments) ? $article->comments->count() : 0 ,
                "show_counter"=> $article->show_counter,
                "image_url"=> ($article->image_link) ? url($article->image_link) : null,
            ];
            if($article->comments){
                foreach ($article->comments as $comment){
                    $data['comments'][] = [
                        "message"=> $comment->message,
                        "author_id"=> $comment->author_id,
                        "author_name"=> ($comment->author) ? $comment->author->name : '',
                        "personal_photo"=> null,
                        "post_date"=> $comment->created_at
                    ];
                }
            }
            return $this->sendResponse($data, '');
        }
        return $this->sendError('Not Found','Ресус не найден');
    }
}