<?php

namespace Src\Infraestructure\Providers;

use Illuminate\Support\ServiceProvider;
use Src\Infraestructure\Contracts\IAuthRepository;
use Src\Infraestructure\Contracts\ILeadRepository;
use Src\Infraestructure\Repositories\AuthRepository;
use Src\Infraestructure\Repositories\LeadRepository;

class BindingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(IAuthRepository::class, AuthRepository::class);
        $this->app->bind(ILeadRepository::class, LeadRepository::class);
    }
}
