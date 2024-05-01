<?php

declare(strict_types=1);

namespace App\Http\Resources\User;

use App\Http\Resources\Citizen\CitizenCompanyResource;
use App\Http\Resources\Judge\JudgeResource;
use App\Http\Resources\Mediator\MediatorResource;
use App\Http\Resources\Role\RoleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'email' => $this->resource->email,
            'role' => $this->resource->user_role_id->getRole(),
        ];
    }
}
