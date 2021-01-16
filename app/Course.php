<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'name', 'description', 'author', 'image_link'
    ];

    public function lessons(){
        return $this->hasMany(Lesson::class);
    }
}
