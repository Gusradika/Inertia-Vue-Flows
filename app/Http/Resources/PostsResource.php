<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return
            [
                "id" => $this->id,
                "title" => $this->title,
                "body" => $this->body,
                "created_at" => $this->created_at->toFormattedDateString(),
                "user" => UserResource::make($this->whenLoaded('user'))
            ];
    }
}
