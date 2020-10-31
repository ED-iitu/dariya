<?php
/**
 * Created by PhpStorm.
 * User: eduard
 * Date: 10/5/20
 * Time: 00:05
 */

namespace App\Http\Controllers\Site;
use App\Comment;
use App\Rating;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        if($request->stars){
            $rating = new Rating();
            $rating->setRawAttributes([
                'object_id' => $request->object_id,
                'object_type' => $request->object_type,
                'rate' => $request->stars,
                'author_id' => $request->author_id
            ]);

            if($rating->save()){
                Rating::calculateRating($request->object_id,$request->object_type);
            }
        }
        if($request->message){
            $data = [
                'object_id' => $request->object_id,
                'object_type' => $request->object_type,
                'author_id' => $request->author_id,
                'message' => $request->message,
            ];

            Comment::create($data);
        }


        return redirect()->back()->with('success','Комментарий успешно отправлен');
    }
}