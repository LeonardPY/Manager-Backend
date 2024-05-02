<?php

use App\Http\Controllers\Api\Department\CategoryController;
use App\Http\Controllers\Api\Department\ProductController;
use App\Http\Controllers\Api\Department\ProductDescriptionController;
use App\Http\Controllers\Api\Department\ProductPictureController;
use Illuminate\Support\Facades\Route;


//api/department
//Create Category
Route::apiResource('/categories', CategoryController::class, ['store', 'index', 'show', 'destroy']);
Route::post('/categories/{category}', [CategoryController::class, 'update']);

//Create Product
Route::apiResource('/products', ProductController::class)->only(['store', 'index', 'show', 'destroy']);
Route::post('products/{product}', [ProductController::class, 'update']);

//Create Product Description
Route::post('/product/{productId}/description', [ProductDescriptionController::class, 'store']);
Route::put('/product/{productId}/description', [ProductDescriptionController::class, 'update']);
Route::delete('/product/productPicture/{productPicture}', [ProductPictureController::class, 'destroy']);
