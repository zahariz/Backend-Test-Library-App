<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    protected $table = 'books';

    protected $fillable = [
        'title',
        'author',
        'stock'
    ];

    public function borrowers(): BelongsToMany
    {
        return $this->belongsToMany(Member::class, 'borrowed_books')->withTimestamps();
    }

}
