<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReceiptController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/kasir', function () {
    return view('kasir.index');
});

Route::get('/print-receipt', [ReceiptController::class, 'print'])->name('print.receipt');

Route::get('/login', [LoginController::class, 'index']);
Route::post('/login', [LoginController::class, 'authenticate'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('category', CategoryController::class)->except(['show']);
Route::resource('product', ProductController::class)->except(['show']);
Route::get('/product/{product}/invoice', [ProductController::class, 'generateInvoice'])->name('product.invoice');

Route::get('/buku', [BukuController::class, 'index']);
Route::get('/books', [BookController::class, 'index']);
