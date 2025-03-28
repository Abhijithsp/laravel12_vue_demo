<?php

use App\Http\Controllers\Admin\Chat\ChatController;
use App\Http\Controllers\Admin\Post\PostIndexController;
use App\Http\Controllers\Admin\Post\PostStoreController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('posts',PostIndexController::class)->name('posts.index');
    Route::post('posts',PostStoreController::class)->name('posts.store');

    Route::post('grok_chat',ChatController::class)->name('grok_chat ');

});



require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
