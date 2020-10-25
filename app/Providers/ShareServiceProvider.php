<?php


namespace App\Providers;
use App\Helpers\Share;

class ShareServiceProvider extends \Jorenvh\Share\Providers\ShareServiceProvider
{
    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->bind('share', function () {
            return new Share();
        });
        $this->mergeConfigFrom(__DIR__ . '/../../config/laravel-share.php', 'laravel-share');
    }
}
