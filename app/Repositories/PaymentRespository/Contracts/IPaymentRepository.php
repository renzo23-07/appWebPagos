<?php
    namespace App\Repositories\PaymentRespository\Contracts;

    interface IPaymentRepository
    {
        public function show(string $id);
        public function store($data, $creditSale);
    }

?>
