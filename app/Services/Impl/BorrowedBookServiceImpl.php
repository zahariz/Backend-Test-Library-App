<?php

namespace App\Services\Impl;

use App\Models\Book;
use App\Models\BorrowedBook;
use App\Models\Member;
use App\Services\BorrowedBookService;
use Carbon\Carbon;
use Illuminate\Http\Exceptions\HttpResponseException;

class BorrowedBookServiceImpl implements BorrowedBookService {


    public function exceptionError($message, int $statusCode)
    {
        throw new HttpResponseException(response()->json([
            'errors' => [
                "message" => [
                    $message
                ]
            ]
        ])->setStatusCode($statusCode));
    }

    public function getBookById(int $bookId)
    {
        $books = Book::where('id', $bookId)->first();
        if(!$books)
        {
            $this->exceptionError('Not Found', 404);
        }
        return $books;
    }

    public function getMemberById(int $memberId)
    {
        $member = Member::where('id', $memberId)->first();
        if (!$member) {
            $this->exceptionError('Member not found', 404);
        }
        return $member;
    }


    public function getAllBeingBorrowedBook()
    {
        $borrow = BorrowedBook::query()->with(['member', 'book'])->get();

        return $borrow;
    }

    public function borrowBook(int $memberId, int $bookId)
    {
        // Cari anggota berdasarkan pengguna yang terotentikasi
        $member = $this->getMemberById($memberId);
        if($member->borrowedBooks()->count() >= 2) {
            $this->exceptionError('You can only borrow up to 2 books.', 400);
        }

        $books = $this->getBookById($bookId);

        if($books->stock <= 0)
        {
            $this->exceptionError('Book is not available.', 400);
        }

        if($member->is_penalized)
        {
            $this->exceptionError('You are currently penalized and cannot borrow books.', 400);
        }

        $borrowedBook = new BorrowedBook();
        $borrowedBook->member_id = $member->id;
        $borrowedBook->book_id = $bookId;
        $borrowedBook->borrowed_at = Carbon::now();
        $borrowedBook->save();

        $books->stock--;
        $books->save();

        return $borrowedBook;
    }

    public function returnBook(int $memberId, int $bookId)
    {
        $book = $this->getBookById($bookId);
        // Pastikan pengguna terotentikasi

        // Cari anggota berdasarkan pengguna yang terotentikasi
        $member = $this->getMemberById($memberId);

        $borrowedBook = BorrowedBook::where('member_id', $member->id)
                        ->where('book_id', $bookId)
                        ->first();

        if (!$borrowedBook) {
            $this->exceptionError('Book not borrowed by member.', 404);
        }

        $returnDate = Carbon::parse($borrowedBook->borrowed_at);
        $lateDays = max(0, $returnDate->diffInDays(Carbon::now()));

        if($lateDays > 7)
        {
            // Terapkan sanksi kepada anggota
            $member = Member::where('id', $memberId)->first();
            $member->is_penalized = true;
            $member->save();
        }

        // Update status peminjaman buku
        $borrowedBook->delete();

        // Update stok buku

        $book->stock++;
        $book->save();
    }

}
