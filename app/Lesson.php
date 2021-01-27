<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Lesson extends Model
{
    public function videos()
    {
        return $this->hasMany(LessonVideo::class);
    }

    public function files()
    {
        return $this->hasMany(LessonFiles::class, 'lesson_id', 'id');
    }

    public function is_finished()
    {
        if(Auth::check() && UserLessonLog::query()->where(
            [
                'user_id' => Auth::id(),
                'lesson_id' => $this->id,
                'course_id' => $this->course_id
            ])->exists()){
            return true;
        }
        return false;
    }
}
