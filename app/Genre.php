<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $table = 'genres';

    public function books() {
        return $this->belongsToMany(Book::class, 'book_to_genres');
    }

    public function objectToGenre()
    {
        return $this->belongsToMany(BookToGenre::class);
    }
}
