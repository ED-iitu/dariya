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
        'name', 'preview_text', 'detail_text', 'author', 'categories', 'lang', 'for_vip',
        'image_link', 'youtube_video_id', 'local_video_link', 'created_at', 'updated_at', 'in_home_screen', 'in_list'
    ];

    public function categories()
    {
        return $this->hasManyThrough(Category::class, VideoToCategory::class, 'video_id', 'id', 'id', 'category_id');
    }

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
    public function isFavorite()
    {
        if (Auth::user() &&
            Favorite::query()
                ->where([
                    'object_id' => $this->id,
                    'object_type' => Favorite::FAVORITE_VIDEO,
                    'user_id' => Auth::id()
                ])->exists()) {
            return true;
        }
        return false;
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'object_id', 'id')->where('object_type', '=', Comment::VIDEO_TYPE)->orderBy('comments.created_at', 'desc');
    }
}
