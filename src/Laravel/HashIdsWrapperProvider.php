<?php

declare(strict_types=1);

namespace KennedyTedesco\HashIdsWrapper\Laravel;

use Illuminate\Support\ServiceProvider;

class HashIdsWrapperProvider extends ServiceProvider
{
    public function register() : void
    {
        if (\file_exists($file = __DIR__ . '/helpers.php')) {
            require_once($file);
        }
    }
}
