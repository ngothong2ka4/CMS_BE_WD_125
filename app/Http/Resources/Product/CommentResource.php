<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [
            'id_user' => $this->id_user,
            'content' => $this->content,
            'posting_date' => $this->posting_date,
            'status' => $this->status
        ];
        return $data;
    }
}
