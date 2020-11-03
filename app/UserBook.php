<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserBook extends Model
{
    const USER_BOOK_PURCHASED = 'PURCHASED';
    const USER_BOOK_SUBSCRIPTION = 'SUBSCRIPTION';
    protected $table = 'user_books';
    protected $fillable = [
        'user_id', 'book_id','type_of_acquisition'
    ];
}
