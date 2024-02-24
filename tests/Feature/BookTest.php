<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\BorrowedBook;
use App\Models\Member;
use App\Models\User;
use Database\Seeders\BookSeeder;
use Database\Seeders\BorrowedBookSeeder;
use Database\Seeders\MemberSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class BookTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testGetAvailableBooksSuccess()
    {
        // Kondisi dipinjam 1 buku ya
        $this->seed([BookSeeder::class, MemberSeeder::class, BorrowedBookSeeder::class]);
        $response = $this->get('/api/books')
        // Status harus 200
        ->assertStatus(200)
        // Total data harus 4
        ->assertJsonCount(4, 'data');

        Log::info(json_encode($response, JSON_PRETTY_PRINT));
    }




}
