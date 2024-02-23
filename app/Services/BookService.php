<?php

namespace App\Services;

use App\Models\Member;

interface BookService {

    public function availableBooks();
    public function borrowBookForMember($userId, $bookId);
    public function returnBookForMember($userId, $bookId);

}
