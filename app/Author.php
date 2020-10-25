<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $table = 'authors';

    protected $fillable = [
        'name', 'surname'
    ];

    public function books() {
        return $this->hasMany(Book::class, 'author_id')->where('type', Book::BOOK_TYPE);
    }

    public function audio_books() {
        return $this->hasMany(Book::class, 'author_id')->where('type', Book::AUDIO_BOOK_TYPE);
    }

    public function getFullName(){
        $full_name = $this->name;
        if($this->surname){
            $full_name .= ' '.$this->surname;
        }
        return $full_name;
    }
}
