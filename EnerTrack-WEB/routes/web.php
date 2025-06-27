<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnalysisController;
use App\Http\Controllers\ProfileController;

// Public routes
Route::get('/', function () {
    return view('welcome');
});

// Authentication routes
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', [PageController::class, 'login'])->name('login');
    Route::post('/login', 'login')->name('login.post');
    Route::get('/logout', function() {
        session()->forget(['user', 'token', 'remember_token']);
        return redirect('/login');
    })->name('logout');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', [PageController::class, 'register'])->name('register');
    Route::post('/register', 'register')->name('register.post');
});

// Protected routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [PageController::class, 'dashboard'])->name('dashboard');
    Route::get('/calculator', [PageController::class, 'calculator'])->name('calculator');
    Route::get('/analysis', [PageController::class, 'analysis'])->name('analysis');
    Route::get('/profile', [PageController::class, 'profile'])->name('profile');

    // History routes
    Route::controller(HistoryController::class)->group(function () {
        Route::get('/history', 'index')->name('history');
        Route::get('/history/calculations', 'getCalculations')->name('history.calculations');
    });

    // Calculator API routes
    Route::controller(CalculatorController::class)->group(function () {
        Route::get('/calculator/brands', 'getBrands')->name('calculator.brands');
        Route::post('/calculator/submit', 'submitAndAnalyze')->name('calculator.submit');
        Route::post('/calculator/analyze', 'analyze')->name('calculator.analyze');
    });

    // Dashboard routes
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/recent-calculations', [DashboardController::class, 'getRecentCalculations'])->name('dashboard.recent-calculations');

    // Analysis routes
    Route::get('/analysis/daily-statistics', [AnalysisController::class, 'getDailyStatistics'])->name('analysis.daily-statistics');
    Route::get('/analysis/category-counts', [AnalysisController::class, 'getCategoryCounts'])->name('analysis.category-counts');
    Route::get('/analysis/weekly-cost-statistics', [AnalysisController::class, 'getWeeklyCostStatistics'])->name('analysis.weekly-cost-statistics');
});
