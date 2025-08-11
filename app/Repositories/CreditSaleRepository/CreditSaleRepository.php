<?php
namespace App\Repositories\CreditSaleRepository;

use App\Models\CreditSale;
use App\Models\CreditSaleItem;
use App\Models\Customer;
use App\Repositories\CreditSaleRepository\Contracts\ICreditSaleRepository;
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
}

?>