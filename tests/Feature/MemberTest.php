<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Member;
use Database\Seeders\BookSeeder;
use Database\Seeders\BorrowedBookSeeder;
use Database\Seeders\MemberSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class MemberTest extends TestCase
{

    public function testGetAllMemberSuccess()
    {
        // Kondisi dipinjam 1 buku ya
        $this->seed([BookSeeder::class, MemberSeeder::class, BorrowedBookSeeder::class]);
        $response = $this->get('/api/members')
        // Status harus 200
        ->assertStatus(200);

        Log::info(json_encode($response, JSON_PRETTY_PRINT));
    }


    public function testGetSumBookByMember()
    {
        $this->seed([BookSeeder::class, MemberSeeder::class]);
        $books = Book::query()->limit(1)->first();
        $members = Member::query()->limit(1)->first();

        $this->post('/api/books/'.$books->id.'/members/'. $members->id .'/borrow');

        $books = Book::query()->limit(1)->first();
        $response = $this->get('/api/members/borrows')
        // Status harus 200
        ->assertStatus(200);

        Log::info(json_encode($response, JSON_PRETTY_PRINT));
    }

}
