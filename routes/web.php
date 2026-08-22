<?php

use App\Http\Controllers\MemoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
Route::get('/memos', [MemoController::class, 'index'])
    ->name('memos.index');

Route::get('/memo/form', [MemoController::class, 'create'])
    ->name('memos.create');

Route::post('/memo/store', [MemoController::class, 'store'])
    ->name('memos.store');

Route::get('/memo/{id}/edit', [MemoController::class, 'edit'])
    ->name('memos.edit');

Route::put('/memo/{id}', [MemoController::class, 'update'])
    ->name('memos.update');

Route::delete('/memo/{id}', [MemoController::class, 'destroy'])
    ->name('memos.destroy');
});

/*
|--------------------------------------------------------------------------
| Breezeが追加したプロフィール関連Route
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Breezeの認証用Routeを読み込む
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';