<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'user_name' => $this->user->name,
            'color' => $this->variant?->color->name,
            'size' => $this->variant?->size->name,
            'content' => $this->content,
            'rating' => $this->rating,
            'created_at' => $this->created_at,
        ];
        return $data;
    }
}
