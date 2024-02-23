<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\BorrowedBook;
use App\Models\Member;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BorrowedBookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $books = Book::query()->limit(1)->first();
        $members = Member::query()->limit(1)->first();

        // Kondisi di pinjam buku 1 guys
        $data = [
            'book_id' => $books->id,
            'member_id' => $members->id,
            'borrowed_at' => now(),
        ];

        BorrowedBook::create($data);
    }
}
