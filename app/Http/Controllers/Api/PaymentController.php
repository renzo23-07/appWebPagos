<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PaymentService\Contracts\IPaymentService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $PaymentService;

    function __construct(IPaymentService $PaymentService)
    {
        $this->PaymentService=$PaymentService;
    }


    public function show(){
        $respuesta=$this->PaymentService->show();

        return $respuesta;
    }

    public function store(){

    }

    
}
