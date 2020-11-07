<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookPages extends Model
{
    protected $table = 'book_pages';

    protected $fillable = [
        'book_id', 'page', 'original_content', 'content', 'status'
    ];

    public function book(){
        return $this->hasOne(Book::class,'id','book_id');
    }
}
