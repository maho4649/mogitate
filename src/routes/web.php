<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

// 商品一覧（トップ）
Route::get('/products', [ProductController::class, 'search'])->name('products.index');

// 商品登録
Route::get('/products/register', [ProductController::class, 'create'])->name('products.create');
Route::post('/products/register', [ProductController::class, 'store'])->name('products.store');

// 商品詳細
Route::get('/products/{productId}', [ProductController::class, 'show'])->name('products.show');
Route::post('/products', [ProductController::class, 'store'])->name('products.store');

// 商品更新
Route::put('/products/{productId}/update', [ProductController::class, 'update'])->name('products.update');

// 商品検索
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');

// 商品削除
Route::delete('/products/{productId}/delete', [ProductController::class, 'delete'])->name('products.delete');


