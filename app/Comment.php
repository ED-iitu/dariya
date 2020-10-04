<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    const ARTICLE_TYPE = 'article';
    const BOOK_TYPE = 'book';

    protected $table = 'comments';

    protected $fillable = [
        'object_id', 'object_type', 'message', 'author_id', 'nickname'
    ];

    public static function getObjectTypes(){
        return [self::ARTICLE_TYPE, self::BOOK_TYPE];
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
