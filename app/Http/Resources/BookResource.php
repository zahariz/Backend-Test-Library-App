<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->code,
            'title' => $this->title,
            'author' => $this->author,
            'stock' => $this->stock,
            'borrowedBy' => BorrowedBookResource::collection($this->whenLoaded('borrowedBy'))
        ];
    }
}
