<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookShelfLink extends Model
{
    protected $table = 'book_shelf_links';

    protected $fillable = [
        'book_id', 'shelf_id'
    ];
}
