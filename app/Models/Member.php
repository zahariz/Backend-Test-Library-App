<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Member extends Model
{
    protected $table = 'members';

    protected $fillable = [
        'name'
    ];

    public function borrowedBooks(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'borrowed_books')->withTimestamps();
    }
}
