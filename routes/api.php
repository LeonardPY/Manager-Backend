<?php

use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Department\CategoryController;
use App\Http\Controllers\Api\Department\ProductController;
use App\Http\Controllers\Api\Department\ProductDescriptionController;
use App\Http\Controllers\Api\Department\ProductPictureController;
use App\Http\Controllers\Api\User\FavoriteController;
use App\Http\Controllers\Api\User\UserAddressController;
use Illuminate\Support\Facades\Route;




//api/admin
Route::middleware(['auth:api','verified','admin',])->prefix('admin')->group(function () {
    Route::apiResource('users', UserController::class);
});

//api/auth
Route::middleware(['auth:api', 'verified'])->prefix('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user', [AuthController::class, 'user']);
});
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
Route::post('/check-code', [ForgotPasswordController::class, 'checkResetCode']);
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword']);

//api/department
Route::middleware(['auth:api','verified','department'])->prefix('department')->group(function () {
    //Create Category
    Route::apiResource('/categories', CategoryController::class, ['store', 'index', 'show', 'destroy']);
    Route::post('/categories/{category}', [CategoryController::class, 'update']);

    //Create Product
    Route::apiResource('/products', ProductController::class)->only(['store', 'index', 'show', 'destroy']);
    Route::post('products/{product}', [ProductController::class, 'update']);

    //Create Product Description
    Route::post('/product/{product}/description', [ProductDescriptionController::class, 'store']);
    Route::put('/product/{product}/description', [ProductDescriptionController::class, 'update']);
    Route::delete('/product/productPicture/{productPicture}', [ProductPictureController::class, 'destroy']);
});

//user
Route::middleware(['auth:api', 'verified'])->prefix('user')->group(function () {
    Route::apiResource('userAddress', UserAddressController::class);
    //Favorite
    Route::apiResource('favorite', FavoriteController::class, ['index', 'store', 'destroy']);
    Route::post('save-favorites', [FavoriteController::class, 'saveFavorites']);
});

