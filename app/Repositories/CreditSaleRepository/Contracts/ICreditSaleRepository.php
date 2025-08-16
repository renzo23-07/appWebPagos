<?php
    namespace App\Repositories\CreditSaleRepository\Contracts;

    interface ICreditSaleRepository
    {
        public function show(string $id);
        public function store( $data);
    }

?>