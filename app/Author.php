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
        return $this->hasMany(Book::class, 'author_id');
    }
}
