<?php

namespace App\Repository;

use Illuminate\Support\ServiceProvider;
use App\Repository\RepositoryServices\RepositoryInterfaceService;
use App\Repository\RepositoryServices\RepositoryService;
class RepositoryServiceProvider extends ServiceProvider
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
        $this->app->bind(
            RepositoryInterfaceService::class,
            RepositoryService::class
        );
    }
}
