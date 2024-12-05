<?php

namespace App\Exceptions;

use App\Http\Resources\ErrorResource;
use Exception;
use Throwable;

class ApiErrorException extends Exception
{
    protected $code;
    public function __construct(string $message = "", int $code = 500, ?Throwable $previous = null)
    {
        parent::__construct(
            $message,
            $code,
            $previous
        );
        $this->code = $code;
    }

    public function render(): ErrorResource
    {
        return ErrorResource::make([
            'message' => trans('message.access_denied')
        ])->setStatusCode($this->code);
    }
}
