<?php

namespace App\Providers;

use App\Http\Repositories\GroupRepository;
use App\Http\RepositoryInterfaces\GroupRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(GroupRepositoryInterface::class, GroupRepository::class);
    }
}
