<?php

namespace App\Http\Resources;

use App\Http\Resources\Product\VariantResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'variant' => [
                'id' => $this->variant->id,
                'product_id' => $this->variant->id_product,
                'color' => $this->variant->color->name,
                'size' => $this->variant->size->name,
                'import_price' => $this->variant->import_price,
                'list_price' => $this->variant->list_price,
                'selling_price' => $this->variant->selling_price,
                'image_color' => $this->variant->image_color,
                'quantity' => $this->variant->quantity,
                'product' => [
                    'id' => $this->variant->product->id,
                    'name' => $this->variant->product->name,
                    'description' => $this->variant->product->description,
                    'thumbnail' => $this->variant->product->thumbnail,
                ],
            ],
            'quantity' => $this->quantity,
        ];
    }
}
