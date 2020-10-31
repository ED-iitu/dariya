<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    const ARTICLE_TYPE = 'article';
    const BOOK_TYPE = 'book';
    const VIDEO_TYPE = 'video';

    protected $table = 'ratings';

    protected $fillable = [
        'object_id', 'object_type', 'rate', 'author_id',
    ];

    public static function getObjectTypes(){
        return [self::ARTICLE_TYPE, self::BOOK_TYPE];
    }

    public static function calculateRating($object_id, $object_type){
        if(in_array($object_type, self::getObjectTypes())){
            $rating_summ  = 0;
            $rating_count = 1;
            Rating::query()->where(['object_type' => $object_type, 'object_id' => $object_id])->each(function ($rating) use (&$rating_summ, &$rating_count){
                $rating_summ += $rating->rate;
                $rating_count++;
            });
            $rating = $rating_summ/$rating_count;
            if($object_type == self::ARTICLE_TYPE){
                $article = Article::query()->find($object_id);
                $article->rate = $rating;
                $article->save();
            }elseif($object_type == self::BOOK_TYPE){
                $book = Book::query()->find($object_id);
                $book->rate = $rating;
                $book->save();
            }elseif($object_type == self::VIDEO_TYPE){
                $book = Video::query()->find($object_id);
                $book->rate = $rating;
                $book->save();
            }
        }
    }
}
