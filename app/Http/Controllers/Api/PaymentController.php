<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PaymentService\Contracts\IPaymentService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentController extends Controller
{
    protected $PaymentService;

    function __construct(IPaymentService $PaymentService)
    {
        $this->PaymentService=$PaymentService;
    }


    public function show(string $id){
        $respuesta=$this->PaymentService->show($id);
        return Inertia::render('payment/Show',$respuesta);
    }

    public function store(){

    }

    
}
