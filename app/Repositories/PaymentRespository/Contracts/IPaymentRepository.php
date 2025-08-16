<?php
    namespace App\Repositories\PaymentRespository\Contracts;

    interface IPaymentRepository
    {
        public function show($data);
        public function store($data, $creditSale);
    }

?>
