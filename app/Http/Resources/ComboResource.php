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
        $min_quantity = $this->products->map(function ($product) {
            return $product->variants->min('quantity');
        })->min();
        $quantity = $this->quantity;

        $available_quantity = min($min_quantity ?? 0, $quantity);
        
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
            'available_quantity' => $available_quantity,
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
