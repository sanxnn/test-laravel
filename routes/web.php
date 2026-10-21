<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/kasir', function () {
    return view('kasir.index');
});

Route::get('/login', [\App\Http\Controllers\LoginController::class, 'index']);
Route::post('/login', [\App\Http\Controllers\LoginController::class, 'authenticate'])->name('login');
Route::post('/logout', [\App\Http\Controllers\LoginController::class, 'logout'])->name('logout');
Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
Route::resource('category', CategoryController::class)->except(['show']);
Route::resource('product', ProductController::class)->except(['show']);


Route::get('/buku', [\App\Http\Controllers\BukuController::class, 'index']);
Route::get('/books', [\App\Http\Controllers\BookController::class, 'index']);
