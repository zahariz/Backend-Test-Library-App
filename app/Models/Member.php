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
        'user_id',
        'code',
        'is_penalized'
    ];


    public function user():BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function borrowedBooks()
    {
        return $this->belongsToMany(Book::class, 'borrowed_books', 'member_id', 'book_id')
                    ->withPivot('borrowed_at', 'returned_at');
    }
}
