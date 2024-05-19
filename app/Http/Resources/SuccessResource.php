<?php

namespace App\Http\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

class SuccessResource extends JsonResource
{
    protected int $statusCode = 200;

    public function withResponse(Request $request, Response|JsonResponse $response): void
    {
        $response->setStatusCode($this->statusCode);
    }

    public function setStatusCode(int $statusCode): self
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'success' => true,
            'message' => $this['message'] ?? '',
            'data' => $this['data'] ?? [],
        ];
    }
}

