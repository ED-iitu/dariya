<?php

namespace App\Providers;

use App\Article;
use App\Book;
use App\Observers\ArticleObserver;
use App\Observers\BookObserver;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Jenssegers\Date\Date;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Book::observe(BookObserver::class);
        Article::observe(ArticleObserver::class);
        Schema::defaultStringLength(191);
        Date::setlocale(config('app.locale'));
        Paginator::defaultView('vendor.pagination.bootstrap-4');
    }
}
