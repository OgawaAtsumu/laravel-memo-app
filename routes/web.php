<?php

use App\Http\Controllers\MemoController;
use App\Http\Controllers\ProfileController;
use App\Http\Resources\MemoResource;
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

    Route::get('/api-test/memos', function () {
        $memos = auth()->user()
            ->memos()
            ->with('category')
            ->latest()
            ->get();
        return MemoResource::collection($memos);
        })->name('api-test.memos');

    Route::get('/api-test/memos/create', function () {
        $categories = \App\Models\Category::all();
        return view('api_test_memo_create', compact('categories'));
    })->name('api-test.memos.create');

    Route::post(
        '/api-test/memos',
        [\App\Http\Controllers\Api\MemoApiController::class, 'store']
    )->name('api-test.memos.store');

    Route::get('/api-test/memos/{id}', function ($id) {
        $memos = auth()->user()
            ->memos()
            ->with('category')
            ->where('id', $id)
            ->firstOrFail();
        return new MemoResource($memos);
    })->name('api-test.memos.show');

    Route::put(
    '/api-test/memos/{id}',
    [\App\Http\Controllers\Api\MemoApiController::class, 'update']
    )->name('api-test.memos.update');

    Route::get('/api-test/memos/{id}/edit', function ($id) {
        $memo = auth()->user()
            ->memos()
            ->where('id', $id)
            ->firstOrFail();

        $categories = \App\Models\Category::all();

        return view('api_test_memo_edit', compact('memo', 'categories'));
    })->name('api-test.memos.edit');

    Route::delete(
        '/api-test/memos/{id}',
        [\App\Http\Controllers\Api\MemoApiController::class, 'destroy']
    )->name('api-test.memos.destroy');

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