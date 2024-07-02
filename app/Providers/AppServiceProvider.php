<?php

namespace App\Providers;

use App\Repositories\Category\CategorRepository;
use App\Repositories\Category\CategorRepositoryInterface;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\CategoryRepositoryInterface;
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
        $this->app->bind(IncomeRepositoryInterface::class, IncomeRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
