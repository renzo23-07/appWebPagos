<?php
namespace App\Repositories\PaymentRespository;

use App\Models\CreditPayment;
use App\Models\CreditSale;
use App\Models\Customer;
use App\Models\Transaction;
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

    public function store($data, $creditSale)
    {
        try {
            DB::beginTransaction();
            CreditPayment::create([
                'credit_sales_id' => $creditSale->id,
                'amount_paid' => $data->amount_paid,
                'notes' => $data->note,
                'paymens_date' => now(),
            ]);

            $amountPaid = $data->amount_paid;

            if($amountPaid > $creditSale->total_amount) {
                $amountPaid = $creditSale->total_amount;
            }
            $creditSale->total_amount -= $amountPaid;
            $creditSale->save();

            if ($creditSale->total_amount < 0) {
                $creditSale->total_amount = 0;
            }

            $creditSale->save();

            if($creditSale->total_amount == 0) {
                $creditSale->status = 'paid';
                $creditSale->save();
            }

            Transaction::create([
                'customer_id' => $data->customer_id,
                'action' => 'Pago a cuenta ',
                'type' => 'pago',
                'amount' => $data->amount_paid,
                'total_debt' => $creditSale->total_amount,
                'date' => now(),
            ]);
            DB::commit();
            return to_route('transactions.show', $data->customer_id)
            ->with('success', 'Payment recorded successfully.');   
        } catch (Exception $e) {
            DB::rollBack(); 
            return redirect()->back()->withErrors(['error' => 'An error occurred while processing the payment.']);          
        }
   }
}


?>