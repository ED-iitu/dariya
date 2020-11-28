<?php


namespace App\Http\Controllers\Api;



use App\Article;
use App\Book;
use App\Comment;
use App\Rating;
use App\Video;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index($object_type,$id){
        $comments = [];
        $res = Comment::query()->where(['object_type' => $object_type, 'object_id' => $id])->orderBy('created_at','desc')->orderBy('updated_at', 'desc')->paginate(20);
        $res->each(function ($comment) use (&$comments){
            $rating = Rating::query()->where([
                'author_id' => $comment->author_id,
                'object_type' => $comment->object_type,
                'object_id' => $comment->object_id
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
            $comments[] = $comment;
        });
        return $this->sendResponse([
            'comments' =>$comments, 'count' => $res->count(), 'all_count' => $res->total()
        ], '');
    }

    public function create($object_type,$id){

        $message = $this->getParsedBody('message');
        if(in_array($object_type, Comment::getObjectTypes()) && $message){
            $object = null;
            if($object_type == Comment::ARTICLE_TYPE){
                $object = Article::query()->find($id);
            }
            if($object_type == Comment::BOOK_TYPE){
                $object = Book::query()->find($id);
            }

            if($object_type == Comment::VIDEO_TYPE){
                $object = Video::query()->find($id);
            }

            if($object){
                $comment = new Comment();
                $comment->setRawAttributes([
                    'object_id' => $id,
                    'object_type' => $object_type,
                    'message' => $message,
                    'status' => true,
                    'author_id' => Auth::id()
                ]);
                if($comment->save()){
                    return $this->sendResponse([
                        "comment_id" => $comment->id
                    ],'Комментарий успешно добавлен');
                }
            }
            return $this->sendError('Not Found.',[],404);
        }
        return $this->sendError('Bad request.',[],403);
    }
}