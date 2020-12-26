<?php


namespace App\Http\Controllers\Api;


use App\Article;
use App\Category;
use App\Rating;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request){
        $page = $request->get('page') ? $request->get('page') : 1;
        $pageSize = $request->get('pageSize') ? $request->get('pageSize') : 5;
        $artiles = [];
        $res = Article::query()->orderBy('created_at','desc')->orderBy('updated_at', 'desc')->paginate($pageSize,['*'],'page', $page);
        $res->each(function ($article) use (&$artiles){
            $artiles[] = [
                "id"=> $article->id,
                "name"=> $article->name,
                "rating"=> $article->rate,
                "is_favorite"=> $article->isFavorite(),
                "author"=> $article->author ? $article->author : null,
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
                "is_favorite"=> $article->isFavorite(),
                "user_rating"=> ($article->user_rate()) ? $article->user_rate()->rate : null,
                "author"=> $article->author ? $article->author : null,
                "forum_message_count"=> ($article->comments) ? $article->comments->count() : 0 ,
                "show_counter"=> $article->show_counter,
                "image_url"=> ($article->image_link) ? url($article->image_link) : null,
                "share_link"=> route('article', $article->id)
            ];
            if($article->comments){
                foreach ($article->comments()->paginate(5) as $comment){
                    $rating = Rating::query()->where([
                        'author_id' => $comment->author_id,
                        'object_type' => Rating::ARTICLE_TYPE,
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
            if($article->categories){
                foreach ($article->categories as $category){
                    $data['categories'][] = [
                        "id"=> $category->id,
                        "category_name"=> $category->name
                    ];
                }
            }
            return $this->sendResponse($data, '');
        }
        return $this->sendError('Статья не найдено!','Ресус не найден');
    }

    public function categories(){
        $categories = Category::query()->where('parent_id',0)->pluck('id','slug')->toArray();
        foreach ($categories as &$category){
            $category = Category::query()->where('parent_id', $category)->get()->toArray();
        }
        return $this->sendResponse([
            'categories' =>$categories
        ], '');
    }
}