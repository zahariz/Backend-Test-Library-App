<?php

namespace App\Providers;

use App\Services\Impl\MemberServiceImpl;
use App\Services\MemberService;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class MemberServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        MemberService::class => MemberServiceImpl::class
    ];

    public function provides(): array
    {
        return [MemberService::class];
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
