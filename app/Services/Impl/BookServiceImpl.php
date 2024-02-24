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

}
