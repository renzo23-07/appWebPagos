<?php

namespace App\Providers;

use App\Models\CreditSale;
use App\Repositories\CreditSaleRepository\Contracts\ICreditSaleRepository;
use App\Repositories\CreditSaleRepository\CreditSaleRepository;
use App\Repositories\PaymentRespository\Contracts\IPaymentRepository;
use App\Repositories\PaymentRespository\PaymentRepository;
use App\Services\CreditSaleService\Contracts\ICreditSaleService;
use App\Services\CreditSaleService\CreditSaleService;
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
        
        $this->app->bind(ICreditSaleService::class,CreditSaleService::class);
        $this->app->bind(ICreditSaleRepository::class,CreditSaleRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
