<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use JsonSerializable;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array|\Illuminate\Contracts\Support\Arrayable|JsonSerializable
    {
        return parent::toArray($request);
    }
}
