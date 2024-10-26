<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListCommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'content' => $this->content,
            'rating' => $this->rating,
            'created_at' => $this->created_at,
            'product_name' => $this->variant->product->name,
            'image_variant' => $this->variant->image_color,
            'color' => $this->variant->color->name,
            'size' => $this->variant->size->name,
        ];
        return $data;
    }
}
