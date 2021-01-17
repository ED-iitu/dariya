<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Course extends Model
{
    protected $fillable = [
        'name', 'description', 'author', 'image_link'
    ];

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function getFinishedCount()
    {
        return UserLessonLog::query()->where([
            'user_id' => (Auth::check()) ? Auth::id() : 0,
            'course_id' => $this->id,
        ])->count();
    }
}
