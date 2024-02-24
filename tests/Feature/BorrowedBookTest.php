<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\BorrowedBook;
use App\Models\Member;
use Database\Seeders\BookSeeder;
use Database\Seeders\BorrowedBookSeeder;
use Database\Seeders\MemberSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class BorrowedBookTest extends TestCase
{


    public function testBorrowBooksSuccess()
    {
        $this->seed([BookSeeder::class, MemberSeeder::class]);
        $books = Book::query()->limit(1)->first();
        $members = Member::query()->limit(1)->first();

        $response = $this->post('/api/books/'.$books->id.'/members/'. $members->id .'/borrow')->assertStatus(201);
        Log::info(json_encode($response, JSON_PRETTY_PRINT));
    }

    public function testBorrowBooksFailedPenalty()
    {
        $this->seed([BookSeeder::class, MemberSeeder::class, BorrowedBookSeeder::class]);
        $books = Book::query()->limit(1)->first();
        $members = Member::query()->limit(1)->first();

        Member::where('id', $members->id)->update([
            'is_penalized' => true
        ]);

        $this->post('/api/books/'.$books->id.'/members/'. $members->id .'/borrow')
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
        $members = Member::query()->limit(1)->first();


        Book::where('id', $books->id)->update([
            'stock' => 0
        ]);

        $this->post('/api/books/'.$books->id.'/members/'. $members->id .'/borrow')
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

        BorrowedBook::create([
            'book_id' => $books->id,
            'member_id' => $members->id,
            'borrowed_at' => now()
        ]);

        $this->post('/api/books/'.$books->id.'/members/'. $members->id .'/borrow')
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
        $members = Member::query()->limit(1)->first();

        $this->post('/api/books/'.($books->id+6).'/members/'. $members->id .'/borrow')
        ->assertStatus(404)
        ->assertJson([
            'errors' => [
                'message' => [
                    'Not Found'
                ]
            ]
        ]);
    }

    public function testReturnBookSuccess()
    {
        $this->testBorrowBooksSuccess();
        $books = Book::query()->limit(1)->first();
        $members = Member::query()->limit(1)->first();

        $response = $this->post('/api/books/'.$books->id.'/members/'. $members->id .'/return')->assertStatus(200);
        Log::info(json_encode($response, JSON_PRETTY_PRINT));
    }

    public function testReturnBookNotFound()
    {
        $this->testBorrowBooksSuccess();
        $members = Member::query()->limit(1)->first();
        $books = Book::query()->limit(1)->first();

        $response = $this->post('/api/books/'.($books->id+6).'/members/'. $members->id .'/return')
                         ->assertStatus(404)
                         ->assertJson([
                            'errors' => [
                                'message' => [
                                    'Not Found'
                                ]
                            ]
                         ]);
        Log::info(json_encode($response, JSON_PRETTY_PRINT));
    }


    public function testGetAllBeingBorrowedBookSuccess()
    {
        $this->seed([BookSeeder::class, MemberSeeder::class]);
        $books = Book::query()->limit(1)->first();
        $members = Member::query()->limit(1)->first();

        $this->post('/api/books/'.$books->id.'/members/'. $members->id .'/borrow');

        $books = Book::query()->limit(1)->first();
        $response = $this->get('/api/borrowed-books')
        // Status harus 200
        ->assertStatus(200);
        // Stock yang dipinjam harus 0
        $this->assertEquals(0, $books->stock);

        Log::info(json_encode($response, JSON_PRETTY_PRINT));
    }


}
