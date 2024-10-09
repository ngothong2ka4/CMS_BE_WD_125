<?php

namespace App\Http\Resources;

use App\Http\Resources\Product\VariantResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'quantity' => $this->quantity,
            'variant' => new VariantResource($this->whenLoaded('variant')),
        ];
        return $data;
    }
}
