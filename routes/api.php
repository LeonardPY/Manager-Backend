<?php

use App\Http\Controllers\Api\Admin\UserController;
use Illuminate\Support\Facades\Route;


//api/admin
Route::prefix('admin')->group(function () {
    Route::apiResource('users', UserController::class);
});
