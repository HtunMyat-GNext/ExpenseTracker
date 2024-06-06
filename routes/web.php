<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialLoginController;


Route::get('/', function () {
    return redirect('/dashboard');
});

// Social Login

Route::get('/auth/google', [SocialLoginController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [SocialLoginController::class, 'handleGoogleCallback'])->name('auth.google.callback');
Route::get('/auth/facebook', [SocialLoginController::class, 'redirectToFacebook'])->name('auth.facebook');
Route::get('/auth/facebook/callback', [SocialLoginController::class, 'handleFacebookCallback'])->name('auth.facebook.callback');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name("dashboard");
    // Route::post('/dashboard', [DashboardController::class, 'index'])->name("dashboard");

    // langauge switch
    Route::get('/language/switch/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //incomes
    Route::resource('categories', CategoryController::class);

    //incomes
    Route::resource('income', IncomeController::class)->except('show');
    Route::get('/income/export/{format}', [IncomeController::class, 'export'])->name('income.export');

    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');

    // expenses
    Route::resource('expenses', ExpenseController::class);
    Route::get('/expenses/export/excel', [ExpenseController::class, 'excelExport'])->name('expenses.export.excel');
    Route::get('/expenses/export/pdf', [ExpenseController::class, 'pdfExport'])->name('expenses.export.pdf');
});

require __DIR__ . '/auth.php';
