<?php

namespace App\Providers;

use App\Infrastructure\Database\Mysql\UserRepository;
use App\Infrastructure\Repositories\IUserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->registerRepositories();

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }


    /**
     * Register repositories
     * @return void
     */
    private function registerRepositories(): void
    {
        //UserRepository
        $this->app->bind(IUserRepository::class,UserRepository::class);
    }
}
