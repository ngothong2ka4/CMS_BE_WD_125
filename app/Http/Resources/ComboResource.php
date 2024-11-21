<?php

namespace App\Http\Resources;

use App\Http\Resources\Product\VariantResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ComboResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'description' => $this->description,
            'products' => $this->products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'thumbnail' => $product->thumbnail,
                    'variants' => VariantResource::collection($product->variants), // Sử dụng VariantResource
                ];
            }),
        ];
    }
}
