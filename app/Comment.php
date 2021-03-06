<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    const ARTICLE_TYPE = 'article';
    const VIDEO_TYPE = 'video';
    const BOOK_TYPE = 'book';

    protected $table = 'comments';

    protected $fillable = [
        'object_id', 'object_type', 'message', 'author_id', 'nickname'
    ];

    public static function getObjectTypes(){
        return [
            self::ARTICLE_TYPE,
            self::BOOK_TYPE,
            self::VIDEO_TYPE,
        ];
    }


    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function author(){
        return $this->hasOne(User::class,'id', 'author_id');
    }
}
