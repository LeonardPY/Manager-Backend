<?php

namespace App\Exceptions;

use App\Http\Resources\ErrorResource;
use Exception;

class AccessDeniedException extends Exception
{
    public function render(): ErrorResource
    {
        return ErrorResource::make([
            'message' => trans('message.access_denied')
        ]);
    }
}
