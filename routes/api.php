<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowedBookController;
use App\Http\Controllers\MemberController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
});

    // Route Books
    Route::get('/books', [BookController::class, 'getAllBook']);

    // Route BorrowedBooks
    Route::get('/borrowed-books', [BorrowedBookController::class, 'getAllBeingBorrowedBook']);
    Route::post('/books/{bookId}/members/{memberId}/borrow', [BorrowedBookController::class, 'borrowBook'])
    ->where('bookId', '[0-9]+')
    ->where('memberId', '[0-9]+');
    Route::post('/books/{bookId}/members/{memberId}/return', [BorrowedBookController::class, 'returnBook'])
    ->where('bookId', '[0-9]+')
    ->where('memberId', '[0-9]+');

    // Route Members
    Route::get('/members', [MemberController::class, 'getAllMember']);
    Route::get('/members/borrows', [MemberController::class, 'getSumBooksByMember']);
