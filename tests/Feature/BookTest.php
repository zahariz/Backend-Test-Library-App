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

    public function testBorrowBooksSuccess()
    {
        $this->seed([BookSeeder::class, MemberSeeder::class]);
        $books = Book::query()->limit(1)->first();
        $members = Member::query()->limit(1)->first();
        $user = User::query()->limit(1)->first();

        $this->actingAs($user);

        $response = $this->post('/api/books/'.$books->id.'/borrow')->assertStatus(200);
        Log::info(json_encode($response, JSON_PRETTY_PRINT));
    }

    public function testBorrowBooksFailedPenalty()
    {
        $this->seed([BookSeeder::class, MemberSeeder::class, BorrowedBookSeeder::class]);
        $books = Book::query()->limit(1)->first();
        $members = Member::query()->limit(1)->first();
        $user = User::query()->limit(1)->first();

        Member::where('id', $members->id)->update([
            'is_penalized' => true
        ]);

        $this->actingAs($user);

        $this->post('/api/books/'.$books->id.'/borrow')
        ->assertStatus(400)
        ->assertJson([
            'errors' => [
                'message' => [
                    'You are currently penalized and cannot borrow books.'
                ]
            ]
        ]);
    }

    public function testBorrowBooksNotAvailable()
    {
        $this->seed([BookSeeder::class, MemberSeeder::class, BorrowedBookSeeder::class]);
        $books = Book::query()->limit(1)->first();
        $user = User::query()->limit(1)->first();

        Book::where('id', $books->id)->update([
            'stock' => 0
        ]);

        $this->actingAs($user);

        $this->post('/api/books/'.$books->id.'/borrow')
        ->assertStatus(400)
        ->assertJson([
            'errors' => [
                'message' => [
                    'Book is not available.'
                ]
            ]
        ]);
    }

    public function testBorrowBooksFailedMoreThanTwo()
    {
        $this->seed([BookSeeder::class, MemberSeeder::class, BorrowedBookSeeder::class]);
        $books = Book::query()->limit(1)->first();
        $members = Member::query()->limit(1)->first();
        $user = User::query()->limit(1)->first();

        BorrowedBook::create([
            'book_id' => $books->id,
            'member_id' => $members->id,
            'borrowed_at' => now()
        ]);

        $this->actingAs($user);

        $this->post('/api/books/'.$books->id.'/borrow')
        ->assertStatus(400)
        ->assertJson([
            'errors' => [
                'message' => [
                    'You can only borrow up to 2 books.'
                ]
            ]
        ]);
    }

    public function testBorrowBooksNotFound()
    {
        $this->seed([BookSeeder::class, MemberSeeder::class, BorrowedBookSeeder::class]);
        $books = Book::query()->limit(1)->first();
        $user = User::query()->limit(1)->first();

        $this->actingAs($user);

        $this->post('/api/books/'.($books->id+5).'/borrow')
        ->assertStatus(404)
        ->assertJson([
            'errors' => [
                'message' => [
                    'Not found'
                ]
            ]
        ]);
    }

    public function testReturnBookSuccess()
    {
        $this->testBorrowBooksSuccess();
        $books = Book::query()->limit(1)->first();
        $user = User::query()->limit(1)->first();

        $this->actingAs($user);

        $response = $this->post('/api/books/'.$books->id.'/return')->assertStatus(200);
        Log::info(json_encode($response, JSON_PRETTY_PRINT));
    }
}
