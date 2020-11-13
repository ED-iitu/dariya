<?php

namespace App\Observers;

use App\Article;

class ArticleObserver
{
    /**
     * Handle the book "deleted" event.
     *
     * @param  \App\Article  $article
     * @return void
     */
    public function deleted(Article $article)
    {
        if($article->image_link && file_exists(public_path($article->image_link))){
            unlink(public_path($article->image_link));
        }
    }
}
