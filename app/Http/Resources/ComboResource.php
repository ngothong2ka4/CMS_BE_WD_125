<?php

namespace App\Http\Resources;

use App\Http\Resources\Product\VariantResource;
use App\Models\Combo;
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
        $sum_price = $this->products->map(function ($product) {
            return $product->variants->min('selling_price');
        })->sum();

        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'description' => $this->description,
            'available_quantity' => $this->quantity,
            'sum_price' => $sum_price,
            'products' => $this->products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'thumbnail' => $product->thumbnail,
                    'variants' => VariantResource::collection($product->variants),
                ];
            }),
        ];
    }
}
