<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookMark extends Model
{
    protected $table = 'bookmarks';

    public function book(){
        return $this->hasOne(Book::class,'id','book_id');
    }
    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }
}
