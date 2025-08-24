<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoteController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StorySelectionController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/stories/{story:slug}', [StoryController::class, 'show'])->name('stories.show');
Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');

Route::middleware('auth')->group(function () {
    Route::middleware(['role:penulis'])->group(function () {
        // Trending
        Route::get('/trending/stories', [UserController::class, 'getTrendingbyUser'])->name('stories.trending');

        // Melaporkan
        Route::get('/melaporkan/stories', [ReportController::class, 'storiesmelaporkan'])->name('storie.melaporkan');
        Route::get('/melaporkan/comment', [ReportController::class, 'commentmelaporkan'])->name('comment.melaporkan');

        // Dilaporkan
        Route::get('/dilaporkan/stories', [ReportController::class, 'storiesdilaporkan'])->name('storie.dilaporkan');
        Route::get('/dilaporkan/comment', [ReportController::class, 'commentdilaporkan'])->name('comment.dilaporkan');
    });

    Route::middleware(['role:admin|penulis'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Story
        Route::get('/stories', [StoryController::class, 'index'])->name('stories.index');
        Route::get('/stories/create/new', [StoryController::class, 'create'])->name('stories.create');
        Route::post('/stories', [StoryController::class, 'store'])->name('stories.store');
        Route::get('/stories/{story}/edit', [StoryController::class, 'edit'])->name('stories.edit');
        Route::patch('/stories/{story}', [StoryController::class, 'update'])->name('stories.update');
        Route::delete('/stories/{story}', [StoryController::class, 'destroy'])->name('stories.destroy');

        // Comments
        Route::get('/comments', [CommentController::class, 'index'])->name('comments.index');
        Route::post('/stories/{story}/comments', [CommentController::class, 'store'])->name('comments.store');
        Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
        Route::patch('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
        Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

        // Vote
        Route::post('/stories/{story}/vote', [VoteController::class, 'vote'])->name('stories.vote');
    });

    // Admin only routes
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class);
        Route::resource('categories', CategoryController::class);

        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::patch('/reports/{report}', [ReportController::class, 'update'])->name('reports.update');

        Route::get('/story-selections', [StorySelectionController::class, 'index'])->name('story-selections.index');
        Route::patch('/story-selections/{story}/approve', [StorySelectionController::class, 'approve'])->name('story-selections.approve');
        Route::patch('/story-selections/{story}/reject', [StorySelectionController::class, 'reject'])->name('story-selections.reject');
        Route::post('story-selections/bulk-action', [StorySelectionController::class, 'bulkAction'])->name('story-selections.bulk-action');
    });
});

require __DIR__.'/auth.php';
