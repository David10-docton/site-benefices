<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\DashboardController;

// Page d'accueil redirige vers le dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Redirection /home vers /dashboard
Route::get('/home', function () {
    return redirect()->route('dashboard');
});

// Routes protégées (vendeur doit être connecté)
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
         ->name('dashboard');

    // Produits
    Route::resource('products', ProductController::class);

    // Ventes
    Route::resource('sales', SaleController::class);

});

// Routes d'authentification (login, register, logout)
Auth::routes();