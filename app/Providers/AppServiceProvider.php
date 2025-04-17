<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Todo\TodoRepository;
use App\Infrastructure\Persistence\Todo\Eloquent\EloquentTodoRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            TodoRepository::class,
            EloquentTodoRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
