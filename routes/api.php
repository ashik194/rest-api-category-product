<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CategoryProductController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\ReviewController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// ============== Category ===============
Route::apiResource('categories', CategoryController::class);

// ============== Product ===============
Route::apiResource('products', ProductController::class);
// ============== Order ===============
Route::post('/orders', [OrderController::class, 'store']);

// ============== Review ===============
Route::post('/products/{productId}/reviews', [ReviewController::class, 'store']);
Route::get('/products/{productId}/reviews', [ReviewController::class, 'index']);
Route::put('/reviews/{reviewId}', [ReviewController::class, 'update']);
Route::delete('/reviews/{reviewId}', [ReviewController::class, 'destroy']);

Route::get('/category/{slug}/products', [CategoryProductController::class, 'getProducts']);
