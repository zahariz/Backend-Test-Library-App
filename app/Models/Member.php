<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Member extends Model
{
    protected $table = 'members';

    protected $fillable = [
        'name',
        'code',
        'is_penalized',
        'penalty_date'
    ];


    public function borrow()
    {
        return $this->hasMany(BorrowedBook::class);
    }

    public function borrowedBooks()
    {
        return $this->belongsToMany(Book::class, 'borrowed_books', 'member_id', 'book_id')
                    ->withPivot('borrowed_at', 'returned_at');
    }
}
