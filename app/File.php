<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $table = 'files';
    protected $fillable = ['original_name', 'path', 'url', 'size', 'type'];
}
