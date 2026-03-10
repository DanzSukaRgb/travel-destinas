<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\DestinationController as AdminDestination;
use App\Http\Controllers\Admin\BlogController as AdminBlog;
use App\Http\Controllers\Admin\PageContentController as AdminPageContent;

// ── Public Pages ─────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('destinations')->name('destinations.')->group(function () {
    Route::get('/',       [DestinationController::class, 'index'])->name('index');
    Route::get('/{slug}', [DestinationController::class, 'show'])->name('show');
});

Route::get('/about',       [PageController::class, 'about'])->name('about');
Route::get('/guide',       [PageController::class, 'guide'])->name('guide');
Route::get('/contact',     [PageController::class, 'contact'])->name('contact');
Route::post('/contact',    [PageController::class, 'contactSend'])->name('contact.send');
Route::get('/blog',        [PageController::class, 'blog'])->name('blog.index');
Route::get('/blog/{slug}', [PageController::class, 'blogShow'])->name('blog.show');

Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

// ── AJAX Routes ──────────────────────────────────────────────────
Route::prefix('api')->name('api.')->group(function () {
    Route::get('/destinations/search',     [DestinationController::class, 'search'])->name('destinations.search');
    Route::get('/destinations/filter',     [DestinationController::class, 'filter'])->name('destinations.filter');
    Route::get('/destinations/featured',   [DestinationController::class, 'featured'])->name('destinations.featured');
    Route::post('/destinations/{id}/save', [DestinationController::class, 'toggleSave'])->name('destinations.save');
});

// ── Auth ─────────────────────────────────────────────────────────
Route::get('/login',   [LoginController::class, 'showLogin'])->name('login');
Route::post('/login',  [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// ── Admin Panel ──────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminDashboard::class, 'index'])->name('dashboard');
    Route::resource('destinations', AdminDestination::class)->except(['show']);
    Route::resource('blog', AdminBlog::class)->except(['show']);

    // Page CMS
    Route::get('pages', [AdminPageContent::class, 'index'])->name('pages.index');
    Route::get('pages/{page}/edit', [AdminPageContent::class, 'edit'])->name('pages.edit');
    Route::put('pages/{page}', [AdminPageContent::class, 'update'])->name('pages.update');
});
