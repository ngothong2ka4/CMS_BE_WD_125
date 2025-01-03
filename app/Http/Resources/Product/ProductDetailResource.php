<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\ComboResource;
use App\Http\Resources\Product\CommentResource;
use App\Http\Resources\Product\ImageResource;
use App\Http\Resources\Product\MaterialResource;
use App\Http\Resources\Product\VariantResource;
use App\Http\Resources\Product\StoneResource;
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
            'material' => new MaterialResource($this->whenLoaded('material')),
            'stone' => new StoneResource($this->whenLoaded('stone')),
            'description' => $this->description,
            'slideImages' => $this->slideImages,
            'averageRating' => (float) $this->average_rating,
            'comments' =>CommentResource::collection($this->whenLoaded('comments')),
            'relatedCombos' => ComboResource::collection($this->whenLoaded('combos')),
        ];
        return $data;
    }
}
