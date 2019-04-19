<?php

namespace App\Providers;

use App\Repositories\Fruit\FruitRepositoryInterface;
use App\Repositories\Fruit\FruitDbRepository;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Fruit
        $this->app->bind(
            FruitRepositoryInterface::class,
            FruitDbRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
