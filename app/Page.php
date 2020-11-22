<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'pages';

    protected $fillable = ['title', 'slug', 'data', 'status'];

    protected $casts = ["data" => "array"];
}
