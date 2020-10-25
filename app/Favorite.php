<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    const FAVORITE_BOOK_TYPE = 'BOOK';
    const FAVORITE_AUDIO_BOOK_TYPE = 'AUDIO';
    const FAVORITE_ARTICLE_TYPE = 'ARTICLE';
    const FAVORITE_VIDEO = 'VIDEO';
    protected $table = 'favorites';
}
