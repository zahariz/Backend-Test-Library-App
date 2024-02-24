<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BorrowedBook extends Model
{
    protected $table = 'borrowed_books';
    protected $fillable = ['book_id', 'member_id', 'borrowed_at', 'returned_at'];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class, "member_id", "id");
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class, "book_id", "id");
    }
}
