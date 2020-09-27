<?php


namespace App\Http\Controllers\Api;



use App\Article;
use App\Book;
use App\Comment;
use Illuminate\Support\Facades\App;

class CommentController extends Controller
{
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
            if($object){
                $comment = new Comment();
                $comment->setRawAttributes([
                    'object_id' => $id,
                    'object_type' => $object_type,
                    'message' => $message,
                    'status' => true,
                    'author_id' => 1
                ]);
                if($comment->save()){
                    return $this->sendResponse([
                        "comment_id" => $comment->id
                    ],'Комментарий успешно добавлен');
                }
            }
            return $this->sendError('Not Found.',[],404);
        }
        return $this->sendError('Bad equest.',[],403);
    }
}