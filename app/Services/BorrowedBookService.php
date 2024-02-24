<?php

namespace App\Services;


interface BorrowedBookService{

    public function borrowBook(int $memberId , int $bookId);
    public function returnBook(int $memberId , int $bookId);

    public function getAllBeingBorrowedBook();

}
