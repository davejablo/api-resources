<?php

namespace App\Providers;

use App\Http\Repositories\ProjectRepository;
use App\Http\RepositoryInterfaces\ProjectRepositoryInterface;
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
        $this->app->bind(ProjectRepositoryInterface::class, ProjectRepository::class);
    }
}
