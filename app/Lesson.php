<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    public function videos(){
        return $this->hasMany(LessonVideo::class);
    }
}
