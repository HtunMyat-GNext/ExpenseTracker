<?php

namespace App\Providers;

use App\Repositories\expense\ExpenseRepository;
use App\Repositories\expense\ExpenseRepositoryInterface;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Dashboard\DashboardRepository;
use App\Repositories\Dashboard\DashboardRepositoryInterface;
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
        $this->app->bind(ExpenseRepositoryInterface::class, ExpenseRepository::class);
        $this->app->bind(IncomeRepositoryInterface::class, IncomeRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(DashboardRepositoryInterface::class, DashboardRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
