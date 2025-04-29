<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Route;

// Public routes (with or without authentication)
Route::get('/', [StoryController::class, 'home'])->name('home');
Route::get('/stories/{story}', [StoryController::class, 'show'])->name('stories.show');


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::middleware(['role:user'])->group(function () {
        Route::get('/stories', [StoryController::class, 'index'])->name('stories.index');

        // Story submission
        Route::get('/stories/create/new', [StoryController::class, 'create'])->name('stories.create');
        Route::post('/stories', [StoryController::class, 'store'])->name('stories.store');

        // Comments
        Route::post('/stories/{story}/comments', [CommentController::class, 'store'])->name('comments.store');

        // Vote routes
        Route::post('/stories/{story}/vote', [VoteController::class, 'vote'])->name('stories.vote');

        Route::get('/stories/{story}/edit', [StoryController::class, 'edit'])->name('stories.edit');
        Route::patch('/stories/{story}', [StoryController::class, 'update'])->name('stories.update');
        Route::delete('/stories/{story}', [StoryController::class, 'destroy'])->name('stories.destroy');
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/followers', [DashboardController::class, 'followers'])->name('profile.followers');
    Route::get('/following', [DashboardController::class, 'following'])->name('profile.following');
    Route::get('/follow/{user}', [DashboardController::class, 'follow'])->name('profile.follow');
    Route::get('/unfollow/{user}', [DashboardController::class, 'unfollow'])->name('profile.unfollow');

    Route::middleware(['role:admin|moderator|user'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });

    // Admin & Moderator routes
    Route::middleware(['role:admin|moderator'])->group(function () {
        Route::get('/moderate', [StoryController::class, 'moderate'])->name('stories.moderate');
        Route::patch('/stories/{story}/sensitive', [StoryController::class, 'markSensitive'])->name('stories.sensitive');
    });

    Route::middleware(['role:user|moderator'])->group(function () {
        Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    });

    // Admin only routes
    Route::middleware(['role:admin'])->group(function () {
        Route::patch('/stories/{story}/approve', [StoryController::class, 'approve'])->name('stories.approve');
        Route::patch('/stories/{story}/reject', [StoryController::class, 'reject'])->name('stories.reject');
        Route::resource('users', UserController::class)->except(['show']);
        Route::resource('categories', CategoryController::class);
    });
});

require __DIR__.'/auth.php';
