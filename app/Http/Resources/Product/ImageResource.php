<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id_product' => $this->id_product,
            'id_attribute_color' => $this->id_attribute_color,
            'link_image' => $this->link_image,
        ];
        return $data;
    }
}
