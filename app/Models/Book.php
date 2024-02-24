<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    protected $table = 'books';

    protected $fillable = [
        'code',
        'title',
        'author',
        'stock'
    ];

    public function borrow()
    {
        return $this->hasMany(BorrowedBook::class);
    }

    public function borrowedBy()
    {
        return $this->belongsToMany(Member::class, 'borrowed_books', 'book_id', 'member_id')
                    ->withPivot('borrowed_at', 'returned_at');
    }

}
