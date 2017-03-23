<?php

namespace KennedyTedesco\HashidsWrapper\Laravel;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        if (file_exists($file = __DIR__ . '/helpers.php')) {
            require_once($file);
        }
    }
}
