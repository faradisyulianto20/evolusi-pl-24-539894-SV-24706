<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BookController::class, 'index']);
Route::get('/books/{id}', [BookController::class, 'show']);

Route::resource('products', ProductController::class);
