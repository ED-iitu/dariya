<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleToCategory extends Model
{
    protected $table = 'article_to_category';

    protected $fillable = [
        'article_id', 'category_id'
    ];

    public function articles()
    {
        return $this->belongsToMany(Book::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
