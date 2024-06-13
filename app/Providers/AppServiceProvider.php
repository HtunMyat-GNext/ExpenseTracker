<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Income\IncomeRepository;
use App\Repositories\Income\IncomeRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IncomeRepository::class, IncomeRepositoryInterface::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
