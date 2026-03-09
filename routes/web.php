<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\NewsletterController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('destinations')->name('destinations.')->group(function () {
    Route::get('/', [DestinationController::class, 'index'])->name('index');
    Route::get('/{slug}', [DestinationController::class, 'show'])->name('show');
});

Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

// ── AJAX Routes ──────────────────────────────────────────────────
Route::prefix('api')->name('api.')->group(function () {
    Route::get('/destinations/search',     [DestinationController::class, 'search'])->name('destinations.search');
    Route::get('/destinations/filter',     [DestinationController::class, 'filter'])->name('destinations.filter');
    Route::get('/destinations/featured',   [DestinationController::class, 'featured'])->name('destinations.featured');
    Route::post('/destinations/{id}/save', [DestinationController::class, 'toggleSave'])->name('destinations.save');
});
