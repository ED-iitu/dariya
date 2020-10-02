<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ArticleToGenre extends Model
{
    protected $table = 'article_to_genres';

    protected $fillable = [
        'article_id', 'genre_id'
    ];

    public function articles()
    {
        return $this->belongsToMany(Book::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }
}
