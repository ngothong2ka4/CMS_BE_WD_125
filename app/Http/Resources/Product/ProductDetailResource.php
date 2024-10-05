<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\Product\VariantResource;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'name' => $this->name,
            'thumbnail' => $this->thumbnail,
            'variant' =>VariantResource::collection($this->whenLoaded('variants')),
            'description' => $this->description,
        ];
        return $data;
    }
}
