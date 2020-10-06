<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBuyedBook extends Model
{
    protected $table = 'user_buyed_books';
    protected $fillable = [
        'user_id', 'book_id'
    ];
}
