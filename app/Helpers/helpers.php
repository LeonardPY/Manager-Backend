<?php

use App\Exceptions\ApiErrorException;
use App\Models\User;

if (!function_exists('authUser')) {

    /** @throws ApiErrorException */
    function authUser(): User
    {
        try {
            /** @var User $user */
            $user = auth()->user();
            if (!$user) {
                throw new ApiErrorException('User not authenticated', 401);
            }
            return $user;
        } catch (Exception $exception) {
            throw new ApiErrorException(
                'Failed to retrieve the authenticated user',
                401,
                $exception
            );
        }
    }
}
