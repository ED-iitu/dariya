<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookToGenre extends Model
{

    protected $table = 'book_to_genres';

    protected $fillable = [
        'book_id', 'genre_id'
    ];

    public function books()
    {
        return $this->belongsToMany(Book::class);
    }

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }
}
