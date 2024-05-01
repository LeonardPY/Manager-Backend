<?php

use App\Http\Controllers\Api\User\UserAddressController;
use Illuminate\Support\Facades\Route;


//api/user
Route::apiResource('userAddress', UserAddressController::class);

