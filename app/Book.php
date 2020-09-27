<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $table = 'books';

    protected $fillable = [
        'name', 'preview_text', 'detail_text', 'lang',
        'publisher_id', 'price', 'author_id', 'image_link', 'book_link', 'is_free',
    ];

    public function authors() {
        return $this->hasOne(Author::class, 'id', 'author_id');
    }

    public function genres() {
        return $this->hasMany(Genre::class, 'id');
    }


}
