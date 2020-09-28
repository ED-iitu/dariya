<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'articles';

    protected $fillable = [
        'name', 'preview_text', 'detail_text', 'author_id', 'lang', 'image_link'
    ];

    public function authors()
    {
        return $this->hasOne(Author::class, 'id', 'author_id');
    }
}
