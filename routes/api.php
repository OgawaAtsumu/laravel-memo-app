<?php

use App\Http\Controllers\Api\MemoApiController;
use App\Models\Memo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', function () {
    return response()->json([
        'message' => 'API接続成功',
    ]);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('memos', MemoApiController::class);
});