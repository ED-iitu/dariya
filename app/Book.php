<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';

    protected $fillable = [
        'name', 'type', 'preview_text', 'detail_text', 'lang',
        'publisher_id', 'price', 'author_id', 'image_link', 'book_link', 'is_free',
    ];

    public function authors()
    {
        return $this->hasOne(Author::class, 'id', 'author_id');
    }

    public function publishers()
    {
        return $this->hasOne(Publisher::class, 'id', 'publisher_id');
    }

    public function genres()
    {
        return $this->hasMany(Genre::class, 'id');
    }

    public function objectToGenres()
    {
        return $this->hasMany(BookToGenre::class);
    }
}
