<?php
    namespace App\Services\PaymentService\Contracts;

    interface IPaymentService 
    {
        public function show($data);
        public function store($data);
    }
?>