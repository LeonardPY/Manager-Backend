<?php

use App\Http\Controllers\Api\Department\CategoryController;
use App\Http\Controllers\Api\Department\ProductController;
use Illuminate\Support\Facades\Route;


//api/department
//Create Category
Route::apiResource('/categories', CategoryController::class, ['store', 'index', 'show', 'destroy']);
Route::post('/categories/{category}', [CategoryController::class, 'update']);

//Create Product
Route::apiResource('/products', ProductController::class)->only(['store', 'index', 'show', 'destroy']);
Route::post('products/{product}', [ProductController::class, 'update']);
