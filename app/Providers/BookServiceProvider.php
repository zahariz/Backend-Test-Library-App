<?php

namespace App\Providers;

use App\Services\BookService;
use App\Services\Impl\BookServiceImpl;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class BookServiceProvider extends ServiceProvider implements DeferrableProvider
{

    public array $singletons = [
        BookService::class => BookServiceImpl::class
    ];

    public function provides()
    {
        return [BookService::class];
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
