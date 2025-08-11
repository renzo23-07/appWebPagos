<?php
    namespace App\Services\PaymentService\Contracts;

    interface IPaymentService 
    {
        public function show(string $id);
        public function store($data);
    }
?>