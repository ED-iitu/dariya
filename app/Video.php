<?php

namespace App;

use App\Shared\Recentable;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use Recentable;
    protected $table = 'videos';

    protected $fillable = [
        'youtube_video_id'
    ];
}
