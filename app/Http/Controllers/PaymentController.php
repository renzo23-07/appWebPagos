<?php

namespace App\Http\Controllers;

use App\Models\CreditPayment;
use App\Models\CreditSale;
use App\Models\Customer;
use App\Models\Transaction;
use App\Services\PaymentService\Contracts\IPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PaymentController extends Controller
{

    protected $PaymentService;

    function __construct(IPaymentService $PaymentService)
    {
        $this->PaymentService=$PaymentService;
    }

    public function create(string $customer_id)
    {
        return Inertia::render('payment/Create', [
            'customer_id' => $customer_id,
        ]);
    }

    public function show(Request $request)
    {
        return Inertia::render('payment/Show',$this->PaymentService->show($request));
    }

    public function store(Request $request)
    {
        return $this->PaymentService->store($request); 
    }
}
