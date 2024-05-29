<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('auth.login');
// });
Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // get total income
    // Route::get('/dashboard', [DashboardController::class, 'index'])->name("dashboard");
    // Route::post('/dashboard', [DashboardController::class, 'index'])->name("dashboard");
    // langauge switch
    Route::get('/language/switch/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('categories', CategoryController::class);

    Route::resource('income', IncomeController::class)->except('show');
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');

    Route::resource('expenses', ExpenseController::class);
    // Route::post('expenses/search', [ExpenseController::class, 'search'])->name('expenses.search');
    // Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');
});

require __DIR__ . '/auth.php';
