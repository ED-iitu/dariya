<?php

namespace App\Providers;

use App\Book;
use App\Observers\BookObserver;
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
        Schema::defaultStringLength(191);
        Date::setlocale(config('app.locale'));
    }
}
