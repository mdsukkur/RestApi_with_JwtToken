<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'App\Interfaces\Product\ProductInterface',
            'App\Repositories\Product\ProductRepository'
        );
    }
}
