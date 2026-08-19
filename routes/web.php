<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemoController;
use App\Models\Memo;

Route::get('/', function () {
    return view('home');
});

Route::get('/memos', [MemoController::class, 'index'])->name('memos.index');

Route::get('/memo/form', [MemoController::class, 'create'])->name('memos.create');

Route::post('/memo/store', [MemoController::class, 'store'])->name('memos.store');

Route::delete('/memo/{id}', [MemoController::class, 'destroy'])->name('memos.destroy');

Route::get('/memo/{id}/edit', [MemoController::class, 'edit'])->name('memos.edit');

Route::put('/memo/{id}', [MemoController::class, 'update'])->name('memos.update');
