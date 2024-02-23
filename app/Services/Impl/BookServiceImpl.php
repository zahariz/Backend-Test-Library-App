<?php

namespace App\Services\Impl;

use App\Models\Book;
use App\Models\BorrowedBook;
use App\Models\Member;
use App\Models\User;
use App\Services\BookService;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;

class BookServiceImpl implements BookService {

    public function availableBooks()
    {
        $books = Book::whereDoesntHave('borrowedBy')->get();
        return $books;
    }

    public function getById($bookId)
    {
        $books = Book::where('id', $bookId)->first();
        if(!$books)
        {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    "message" => [
                        "Not found"
                    ]
                ]
            ])->setStatusCode(404));
        }
        return $books;
    }

    public function borrowBookForMember($userId, $bookId)
    {
        // Pastikan pengguna terotentikasi
        $user = User::find($userId);
        if (!$user) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    "message" => [
                        "Unauthorized"
                    ]
                ]
            ])->setStatusCode(400));
        }

        // Cari anggota berdasarkan pengguna yang terotentikasi
        $member = Member::where('user_id', $userId)->first();
        if (!$member) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    "message" => [
                        "Member not found"
                    ]
                ]
            ])->setStatusCode(404));
        }

        // Lanjutkan dengan logika peminjaman buku
        $this->borrowBook($member, $bookId);
    }

    public function borrowBook(Member $member, $bookId): void
    {
        if($member->borrowedBooks()->count() >= 2) {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    "message" => [
                        "You can only borrow up to 2 books."
                    ]
                ]
            ])->setStatusCode(400));
        }

        $books = $this->getById($bookId);

        if($books->stock <= 0)
        {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    "message" => [
                        "Book is not available."
                    ]
                ]
            ])->setStatusCode(400));
        }

        if($member->is_penalized)
        {
            throw new HttpResponseException(response()->json([
                'errors' => [
                    "message" => [
                        "You are currently penalized and cannot borrow books."
                    ]
                ]
            ])->setStatusCode(400));
        }

        $borrowedBook = new BorrowedBook();
        $borrowedBook->member_id = $member->id;
        $borrowedBook->book_id = $bookId;
        $borrowedBook->borrowed_at = Carbon::now();
        $borrowedBook->save();

        $books->stock--;
        $books->save();
    }

}
