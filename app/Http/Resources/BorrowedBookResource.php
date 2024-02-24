<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BorrowedBookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'book_id' => $this->book_id,
            'member_id' => $this->member_id,
            'borrowed_at' => $this->borrowed_at,
            'members' => new MemberResource($this->whenLoaded('member'))
        ];
    }
}
