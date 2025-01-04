<?php

use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Organization\CategoryController;
use App\Http\Controllers\Api\Organization\ProductController;
use App\Http\Controllers\Api\Organization\ProductDescriptionController;
use App\Http\Controllers\Api\Organization\ProductPictureController;
use App\Http\Controllers\Api\Order\OrderController;
use App\Http\Controllers\Api\Organization\OrderController as DepartmentOrderController;
use App\Http\Controllers\Api\Order\OrderProcessController;
use App\Http\Controllers\Api\Order\OrderProductController;
use App\Http\Controllers\Api\Organization\WorkerController;
use App\Http\Controllers\Api\Refund\Organization\OrganizationRefundOrderController;
use App\Http\Controllers\Api\Refund\Store\StoreRefundOrderController;
use App\Http\Controllers\Api\User\OrganizationController;
use App\Http\Controllers\Api\User\FavoriteController;
use App\Http\Controllers\Api\User\UserAddressController;
use App\Http\Controllers\VideoUploadController;
use Illuminate\Support\Facades\Route;

//api/auth
Route::middleware('throttle:10,1')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [ForgotPasswordController::class, 'forgotPassword']);
    Route::post('/check-code', [ForgotPasswordController::class, 'checkResetCode']);
    Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword']);
});

Route::middleware(['auth:sanctum', 'verified'])->prefix('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user', [AuthController::class, 'user']);
});

//api/admin
Route::middleware(['auth:sanctum','verified','admin',])->prefix('admin')->group(function () {
    Route::apiResource('users', UserController::class);
});

//api/admin
Route::middleware(['auth:sanctum','verified','worker',])->prefix('worker')->group(function () {
    Route::put('order/{order}', [OrderProcessController::class, 'workerOrderShipped']);
});


//api/department Factory
Route::middleware(['auth:sanctum', 'verified', 'organization'])->prefix('organization')->group(function () {
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

    //Order
    Route::apiResource('/orders', DepartmentOrderController::class)->only(['index', 'show', 'update']);

    //Refund Order
    Route::get('/order-refund', [OrganizationRefundOrderController::class, 'index']);

    //Workers
    Route::apiResource('/workers', WorkerController::class);
});

//api/department Store
Route::middleware(['auth:sanctum', 'verified', 'department_store'])->prefix('department/store')->group(function () {
    //Department
    Route::get('/', [OrganizationController::class, 'index']);
    Route::get('/{user}', [OrganizationController::class, 'show'])->where('user', '[0-9]+');
    //Order
    Route::apiResource('/orders', OrderController::class);
    Route::post('/order-confirm/{order}', [OrderProcessController::class, 'confirmOrder']);
    //OrderProduct
    Route::apiResource('/order-product', OrderProductController::class)->only(['update', 'destroy']);
    //Order Refund
    Route::post('/order-refund/{order}', [StoreRefundOrderController::class, 'store']);
    Route::get('/order-refund', [StoreRefundOrderController::class, 'index']);
});

//user
Route::middleware(['auth:sanctum', 'verified'])->prefix('user')->group(function () {
    Route::apiResource('userAddress', UserAddressController::class);
    //Favorite
    Route::apiResource('favorite', FavoriteController::class, ['index', 'store', 'destroy']);
    Route::post('save-favorites', [FavoriteController::class, 'saveFavorites']);
});

Route::post('/video', [VideoUploadController::class, 'store']);

