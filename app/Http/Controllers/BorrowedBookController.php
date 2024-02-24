<?php

namespace App\Http\Controllers;

use App\Http\Resources\BorrowedBookCollection;
use App\Http\Resources\BorrowedBookResource;
use App\Services\BorrowedBookService;
use Illuminate\Http\Request;

class BorrowedBookController extends Controller
{
    private BorrowedBookService $borrowedBookService;

    public function __construct(BorrowedBookService $borrowedBookService)
    {
        $this->borrowedBookService = $borrowedBookService;
    }

    public function getAllBeingBorrowedBook()
    {

        $getBorrowBook = $this->borrowedBookService->getAllBeingBorrowedBook();

        return new BorrowedBookCollection($getBorrowBook);

    }

    public function borrowBook(int $bookId, int $memberId)
    {
        $borrowBook = $this->borrowedBookService->borrowBook($memberId, $bookId);

        return new BorrowedBookResource($borrowBook);
    }

    public function returnBook(int $bookId, int $memberId)
    {

        $this->borrowedBookService->returnBook($memberId, $bookId);

        return response()->json([
            'data' => true
        ])->setStatusCode(200);

    }
}
