<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VariantResource extends JsonResource
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
            'import_price' => $this->import_price,
            'list_price' => $this->list_price,
            'selling_price' => $this->selling_price,
            'quantity' => $this->quantity,
            'colors' => new ColorResource($this->whenLoaded('color')),
            'sizes' => new SizeResource($this->whenLoaded('size')),
        ];
        return $data;
        
        
    }
}
