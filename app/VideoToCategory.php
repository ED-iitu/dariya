<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VideoToCategory extends Model
{
    protected $table = 'video_to_categories';
    protected $fillable = [
        'video_id', 'category_id'
    ];

    public function videos()
    {
        return $this->belongsToMany(Video::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
