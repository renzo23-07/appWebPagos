<?php 
namespace App\Services\PaymentService;

use App\Repositories\PaymentRespository\Contracts\IPaymentRepository;
use App\Services\PaymentService\Contracts\IPaymentService;

class PaymentService implements IPaymentService
{

    protected $PaymentRepository;

    function __construct(IPaymentRepository $PaymentRepository) {
        $this->PaymentRepository=$PaymentRepository;
    }

    public function show(){
        $respuesta=$this->PaymentRepository->show();
        return $respuesta;
    }
}

?>