<?php
namespace App\Repositories\PaymentRespository;

use App\Models\CreditPayment;
use App\Models\CreditSale;
use App\Models\Customer;
use App\Repositories\PaymentRespository\Contracts\IPaymentRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PaymentRepository implements IPaymentRepository
{
    public function show(string $id)
    {
        try{
            $customer=Customer::findOrFail($id);
            $result = DB::select('CALL GetTotalCreditAmountByCustomer(?)', [$id]);
            $totalAmount = isset($result[0]->total_amount) ? (float)$result[0]->total_amount : 0;
            
            $Payment_id=CreditSale::where('customer_id',$id)->value('id');
            $Payemnts=CreditPayment::where('credit_sales_id',$Payment_id)->get();

            return [
                'payments'=>$Payemnts,
                'customer'=>$customer,
                'total_amount'=>$totalAmount,
                'error' => null
            ];
        }catch(Exception $e){
            return [
                'payments' => [],
                'customer' => null,
                'total_amount' => 0,
                'error' => 'Ocurrió un error al cargar los datos del cliente.'
            ];
        }
    }
}


?>