<?php

namespace Src\Aplication\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Aplication\Contracts\IAuthService;
use Src\Aplication\Contracts\ILeadService;
use Src\Aplication\Services\AuthService;
use Src\Aplication\Services\LeadService;

class BindingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(IAuthService::class, AuthService::class);
        $this->app->bind(ILeadService::class, LeadService::class);
    }
}
