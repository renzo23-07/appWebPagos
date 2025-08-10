<?php
namespace App\Repositories\PaymentRespository;

use App\Repositories\PaymentRespository\Contracts\IPaymentRepository;

class PaymentRepository implements IPaymentRepository
{
    public function show()
    {
        return 'hola';
    }
}


?>