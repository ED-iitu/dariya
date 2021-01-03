<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VipCode extends Model
{
    const ARTICLE_TYPE = 'article';
    const VIDEO_TYPE = 'video';
    const BOOK_TYPE = 'book';

    protected $table = 'vip_codes';

    public function video()
    {
        return $this->hasOne(Video::class,'id', 'object_id');
    }
}
