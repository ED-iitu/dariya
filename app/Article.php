<?php

namespace App;

use App\Shared\Recentable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Article extends Model
{
    use Recentable;
    protected $table = 'articles';

    protected $fillable = [
        'name', 'preview_text', 'detail_text', 'author', 'categories', 'lang', 'image_link'
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class, 'object_id', 'id')->where('object_type','=', Comment::ARTICLE_TYPE);
    }

    public function categories(){
        return $this->hasManyThrough(Category::class, ArticleToCategory::class, 'article_id', 'id', 'id','category_id');
    }
    public function user_rate()
    {
        if (Auth::user()) {
            return Rating::query()
                ->where([
                    'author_id' => Auth::id(),
                    'object_type' => Rating::ARTICLE_TYPE,
                    'object_id' => $this->id
                ])
                ->orderBy('created_at')
                ->first();
        }
        return false;
    }

}
