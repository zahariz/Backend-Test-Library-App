<?php

namespace App\Http\Controllers;


use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Models\Member;
use App\Services\BookService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{

    private BookService $bookServices;

    public function __construct(BookService $bookServices)
    {
        $this->bookServices = $bookServices;
    }


    public function getAllBook(): JsonResponse
    {
        $availableBooks = $this->bookServices->availableBooks();

        return (BookResource::collection($availableBooks))->response()->setStatusCode(200);

    }
}
