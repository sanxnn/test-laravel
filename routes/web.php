<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/buku', [\App\Http\Controllers\BukuController::class, 'index']);
