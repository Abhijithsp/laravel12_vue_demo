<?php

use App\Http\Controllers\Admin\PostIndexController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('posts',PostIndexController::class)->name('admin.posts.index');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
