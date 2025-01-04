<?php

namespace App\Http\Resources\Worker;

use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkerResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        /** @var Worker $resource */
        $resource = $this->resource;
        return [
            'id' => $resource->id,
            'name' => $resource->name,
            'email' => $resource->email,
            'picture' => $resource->picture
        ];
    }
}
