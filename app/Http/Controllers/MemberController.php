<?php

namespace App\Http\Controllers;

use App\Http\Resources\BorrowedBookCollection;
use App\Http\Resources\BorrowedBookResource;
use App\Http\Resources\MemberResource;
use App\Services\MemberService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MemberController extends Controller
{

    private MemberService $memberService;

    public function __construct(MemberService $memberService){
        $this->memberService = $memberService;
    }

    public function getAllMember()
    {
        $members = $this->memberService->getAllMember();

        return (MemberResource::collection($members))->response()->setStatusCode(200);
    }

    public function getSumBooksByMember(): JsonResponse
    {
        $members = $this->memberService->getSumBooksByMember();

        return response()->json(['data' => $members])->setStatusCode(200);
    }
}
