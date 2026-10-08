<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/books', [App\Http\Controllers\Api\BookController::class, 'index']);
Route::post('/books', [App\Http\Controllers\Api\BookController::class, 'store']);
Route::get('/books/{id}', [App\Http\Controllers\Api\BookController::class, 'show']);
Route::put('/books/{id}', [App\Http\Controllers\Api\BookController::class, 'update']);
Route::delete('/books/{id}', [App\Http\Controllers\Api\BookController::class, 'destroy']);

Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout']);
    Route::get('/me', [App\Http\Controllers\Api\AuthController::class, 'me']);
});
