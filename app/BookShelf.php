<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookShelf extends Model
{
    protected $table = 'book_shelfs' ;
    protected $fillable = [
        'title', 'description', 'image_url'
    ] ;

    public function books(){
        return $this->hasManyThrough(
            Book::class,
            BookShelfLink::class,
            'shelf_id',
            'id',
            'id',
            'book_id'
        );
    }
}
