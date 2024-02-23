<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        DB::delete("DELETE FROM borrowed_books");
        DB::delete("DELETE FROM users");
        DB::delete("DELETE FROM books");
        DB::delete("DELETE FROM members");
    }

    use CreatesApplication;
}
