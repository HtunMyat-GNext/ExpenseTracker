<?php

use App\Http\Controllers\BudgetController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExchangeController;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name("dashboard");
    // Route::post('/dashboard', [DashboardController::class, 'index'])->name("dashboard");

    // langauge switch
    Route::get('/language/switch/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // categories
    Route::resource('categories', CategoryController::class);

    //incomes
    Route::resource('income', IncomeController::class)->except('show', 'index');
    Route::get('/income/{filter?}', [IncomeController::class, 'index'])->name('income.index');
    Route::get('/income/export/{format?}/{filter?}/{query?}', [IncomeController::class, 'export'])->name('income.export');


    // expenses
    Route::resource('expenses', ExpenseController::class)->except('show', 'index');
    Route::get('/expenses/{filter?}', [ExpenseController::class, 'index'])->name('expenses.index');
    Route::get('/expenses/export/{format?}/{filter?}/{query?}', [ExpenseController::class, 'export'])->name('expenses.export');

    // events
    Route::resource('events', EventController::class);

    // calendar
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');
    Route::post('/calendar/store', [CalendarController::class, 'store'])->name('calendar.store');
    Route::get('/calendar/events', [CalendarController::class, 'fetchEvents'])->name('calendar.fetch_events');
    Route::delete('/calendar/{id}', [CalendarController::class, 'destroy'])->name('calendar.destroy');

    // buget
    Route::post('/budget', [BudgetController::class, 'store'])->name('budget.store');

    // Curreny Exchange
    Route::get('/currency-exchange', [ExchangeController::class, 'index'])->name('currency.exchange');
});

require __DIR__ . '/auth.php';
