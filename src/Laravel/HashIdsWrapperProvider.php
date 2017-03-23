<?php

namespace KennedyTedesco\HashIdsWrapper\Laravel;

use Illuminate\Support\ServiceProvider;

class HashIdsWrapperProvider extends ServiceProvider
{
    /**
     * Register the service provider
     */
    public function register()
    {
        if (file_exists($file = __DIR__ . '/helpers.php')) {
            require_once($file);
        }
    }
}
