<?php

namespace App\Providers;

use App\Repositories\expense\ExpenseRepository;
use App\Repositories\expense\ExpenseRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ExpenseRepositoryInterface::class, ExpenseRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
