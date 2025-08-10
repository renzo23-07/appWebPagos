<?php

namespace App\Providers;

use App\Repositories\PaymentRespository\Contracts\IPaymentRepository;
use App\Repositories\PaymentRespository\PaymentRepository;
use App\Services\PaymentService\Contracts\IPaymentService;
use App\Services\PaymentService\PaymentService;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(IPaymentRepository::class,PaymentRepository::class);
        $this->app->bind(IPaymentService::class,PaymentService::class);        
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
