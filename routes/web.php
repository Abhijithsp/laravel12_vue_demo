<?php

use App\Http\Controllers\Admin\Chat\ChatController;
use App\Http\Controllers\Admin\Post\PostDeleteController;
use App\Http\Controllers\Admin\Post\PostEditController;
use App\Http\Controllers\Admin\Post\PostIndexController;
use App\Http\Controllers\Admin\Post\PostStoreController;
use App\Http\Controllers\Admin\Post\PostUpdateController;
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
    Route::inertia('posts/create','admin/posts/Create');
    Route::put('posts/{post}/edit',PostEditController::class)->name('posts.edit');
    Route::put('posts/{post}',PostUpdateController::class)->name('posts.update');
    Route::delete('posts/{post}',PostDeleteController::class)->name('posts.destroy');



    Route::post('grok_chat',ChatController::class)->name('grok_chat ');

});



require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
