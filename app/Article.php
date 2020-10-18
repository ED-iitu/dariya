<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'articles';

    protected $fillable = [
        'name', 'preview_text', 'detail_text', 'author', 'categories', 'lang', 'image_link'
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class, 'object_id', 'id')->where('object_type','=', Comment::ARTICLE_TYPE);
    }

    public function categories(){
        return $this->hasManyThrough(Category::class, ArticleToCategory::class, 'article_id', 'id', 'id','category_id');
    }
}
