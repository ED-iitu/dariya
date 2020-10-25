<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    protected $table = 'genres';

    protected $fillable = [
      'name'
    ];

    public function books() {
        return $this->belongsToMany(Book::class, 'book_to_genres')->where('type', Book::BOOK_TYPE);
    }

    public function audio_books() {
        return $this->belongsToMany(Book::class, 'book_to_genres')->where('type', Book::AUDIO_BOOK_TYPE);
    }

    public function objectToGenre()
    {
        return $this->belongsToMany(BookToGenre::class);
    }
}
