<?php


namespace App\Http\Controllers\Api;


use App\Article;
use App\Book;
use App\Rating;
use App\Video;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    public function create($object_type,$id){

        $vote = $this->getParsedBody('vote');
        if(in_array($object_type, Rating::getObjectTypes()) && $vote){
            $object = null;
            if($object_type == Rating::ARTICLE_TYPE){
                $object = Article::query()->find($id);
            }
            if($object_type == Rating::BOOK_TYPE){
                $object = Book::query()->find($id);
            }
            if($object_type == Rating::VIDEO_TYPE){
                $object = Video::query()->find($id);
            }
            if($object){
                $rating = new Rating();
                $rating->setRawAttributes([
                    'object_id' => $id,
                    'object_type' => $object_type,
                    'rate' => $vote,
                    'author_id' => Auth::id()
                ]);
                if($rating->save()){
                    Rating::calculateRating($id,$object_type);
                    return $this->sendResponse([
                        "rating_id" => $rating->id
                    ],'Голос успешно добавлен');
                }
            }
            return $this->sendError('Not Found.',[],404);
        }
        return $this->sendError('Bad request.',[],403);
    }
}