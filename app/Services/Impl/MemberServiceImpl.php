<?php

namespace App\Services\Impl;

use App\Models\BorrowedBook;
use App\Models\Member;
use App\Services\MemberService;
use Illuminate\Support\Facades\DB;

class MemberServiceImpl implements MemberService
{
    public function getAllMember()
    {
        $members = Member::all();

        return $members;
    }

    public function getSumBooksByMember()
    {
        $members = Member::withCount('borrowedBooks')->get();

        return $members;
    }
}
