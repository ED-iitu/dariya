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

    public function getContentAttribute($value)
    {
        $value = str_replace(['<body>', '</body>'],'', $value);
        $value = preg_replace('/(left|top|right|bottom):[0-9]{1,}px;/', '', $value);
        return $value;
    }
}
