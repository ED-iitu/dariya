<?php

namespace App;

use App\Shared\Recentable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Video extends Model
{
    use Recentable;
    protected $table = 'videos';

    protected $fillable = [
        'youtube_video_id'
    ];

    public function user_rate()
    {
        if (Auth::user()) {
            return Rating::query()
                ->where([
                    'author_id' => Auth::id(),
                    'object_type' => Rating::VIDEO_TYPE,
                    'object_id' => $this->id
                ])
                ->orderBy('created_at')
                ->first();
        }
        return false;
    }
}
