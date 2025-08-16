<?php
namespace App\Repositories\CreditSaleRepository;

use App\Models\CreditSale;
use App\Models\CreditSaleItem;
use App\Models\Customer;
use App\Models\Transaction;
use App\Repositories\CreditSaleRepository\Contracts\ICreditSaleRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class CreditSaleRepository implements ICreditSaleRepository
{
    public function show(string $id)
    {
        try{
            $customer = Customer::findOrFail($id);
            $result = DB::select('CALL GetTotalCreditAmountByCustomer(?)', [$id]);
            $totalAmount = isset($result[0]->total_amount) ? (float)$result[0]->total_amount : 0;

            $credit_sales_id = CreditSale::where('customer_id', $id)->value('id');

            $credit_sales = CreditSaleItem::where('credit_sale_id', $credit_sales_id)->get();

            return [
                'customer' => $customer,
                'total_amount' => $totalAmount,
                'credit_sales' => $credit_sales,
                'error' => null
            ];
        } catch (\Exception $e) {
            return [
                'customer' => null,
                'total_amount' => null,
                'credit_sales' => null,
                'error' => $e->getMessage()
            ];
        }
    }
    
    public function store($data)
    {
        try{
            DB::beginTransaction();
            $data->validate([
                'product'=>'required|string',
                'description'=>'nullable|string',
                'unit_price'=>'required|numeric|min:0.01',
                'quantity'=>'required|numeric|min:1'
            ]);

            $customerId = $data->customer_id;
            $result = DB::select('CALL CheckCustomerHasPendingCreditSale(?)', [$customerId]);

            if(!empty($result)){
                $creditSale = CreditSale::find($result[0]->id);
                if($creditSale->status=='paid'){
                    $creditSale->update([
                        'status'=>'pending',
                    ]);
                }
            }else{
                $creditSale = CreditSale::create([
                    'customer_id' => $data->customer_id,
                    'total_amount' => 0, 
                    'sales_date'=>now()
                ]);
            }

            $subtotal=$data->unit_price * $data->quantity;

            CreditSaleItem::create([
                'credit_sale_id'=>$creditSale->id,
                'product'=>$data->product,
                'description'=>$data->description ?? null,
                'quantity'=>$data->quantity,
                'unit_price'=>$data->unit_price,
                'subtotal'=>$subtotal,
                'sales_date'=>now()
            ]);

            $creditSale=CreditSale::findOrFail($creditSale->id);
            $creditSale->total_amount +=$subtotal;
            $creditSale->save();

            Transaction::create([
                'customer_id'=>$customerId,
                'action'=>$data->product,
                'type'=>'credito',
                'date'=>now(),
                'amount'=>$subtotal,
                'total_debt'=>$creditSale->total_amount
            ]);

            DB::commit();
            return to_route('transactions.show', $customerId)->with('success', 'Credit sale item added successfully.');

        }catch(Exception $e){
            DB::rollBack();
            return back()->withErrors(['error' => 'Failed to add credit sale item: ' . $e->getMessage()]);
        }
    }
}

?>