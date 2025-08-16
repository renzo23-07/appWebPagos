<?php 
namespace App\Services\PaymentService;

use App\Models\CreditSale;
use App\Repositories\PaymentRespository\Contracts\IPaymentRepository;
use App\Services\PaymentService\Contracts\IPaymentService;

class PaymentService implements IPaymentService
{

    protected $PaymentRepository;

    function __construct(IPaymentRepository $PaymentRepository) {
        $this->PaymentRepository=$PaymentRepository;
    }

    public function show($data){
        $respuesta=$this->PaymentRepository->show($data);
        return $respuesta;
    }

    public function store($data) {
        $data->validate([
            'amount_paid' => 'required|numeric|min:0.01',
            'note' => 'nullable|string|max:255',
        ]);
        $creditSale = CreditSale::where('customer_id', $data->customer_id)
            ->where('status', 'pending')
            ->first();
        if (!$creditSale) {
            return redirect()->back()->withErrors(['credit_sale' => 'No pending credit sale found for this customer.']);
        } else {
            return $this->PaymentRepository->store($data, $creditSale);
        }
    }
}

?>