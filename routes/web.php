<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // get total income
    Route::post('/total-income', [DashboardController::class, 'getTotalIncome'])->name("totalIncome");
    // langauge switch
    Route::get('/language/switch/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/categories/create', [CategoryController::class,'create'])->name('categories.create');
    Route::get('categories', [CategoryController::class,'index'])->name('categories.index');
    Route::delete('/categories/delete',[CategoryController::class,'delete'])->name('categories.delete');

    Route::resource('income', IncomeController::class)->except('show');
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');

    Route::resource('expenses', ExpenseController::class);
});

require __DIR__ . '/auth.php';
