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
use App\Http\Controllers\SocialLoginController;


Route::get('/', function () {
    return view('auth.login');
});

// Social Login
Route::get('/auth/google', [SocialLoginController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [SocialLoginController::class, 'handleGoogleCallback'])->name('auth.google.callback');
Route::get('/auth/facebook', [SocialLoginController::class, 'redirectToFacebook'])->name('auth.facebook');
Route::get('/auth/facebook/callback', [SocialLoginController::class, 'handleFacebookCallback'])->name('auth.facebook.callback');

Route::middleware('auth')->group(function () {
    // get total income
    Route::get('/dashboard', [DashboardController::class, 'index'])->name("dashboard");
    Route::post('/dashboard', [DashboardController::class, 'index'])->name("dashboard");
    // langauge switch
    Route::get('/language/switch/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::delete('/categories/delete', [CategoryController::class, 'delete'])->name('categories.delete');

    Route::resource('income', IncomeController::class)->except('show');
    Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar');

    Route::resource('expenses', ExpenseController::class);
});

require __DIR__ . '/auth.php';
