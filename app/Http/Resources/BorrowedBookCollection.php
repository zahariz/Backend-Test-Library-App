<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BorrowedBookCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->transform(function ($borrow) {
                return [
                    'id' => $borrow->id,
                    'members' => new MemberResource($borrow->member),
                    'books' => new BookResource($borrow->book)
                ];
            })
        ];
    }
}
