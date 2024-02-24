<?php

namespace App\Providers;

use App\Services\BorrowedBookService;
use App\Services\Impl\BorrowedBookServiceImpl;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class BorrowedBookServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        BorrowedBookService::class => BorrowedBookServiceImpl::class
    ];

    public function provides(): array
    {
        return [BorrowedBookService::class];
    }

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
