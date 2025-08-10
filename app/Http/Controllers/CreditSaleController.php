<?php

namespace App\Http\Controllers;

use App\Models\CreditSale;
use App\Models\CreditSaleItem;
use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class CreditSaleController extends Controller
{

    public function show(string $id){
        $customer=Customer::findOrFail($id);
        $result = DB::select('CALL GetTotalCreditAmountByCustomer(?)', [$id]);
        $totalAmount = $result[0]->total_amount ?? 0;

        $credit_sales_id=CreditSale::where('customer_id',$id)->value('id');

        $credit_sales=CreditSaleItem::where('credit_sale_id',$credit_sales_id)->get();

        return Inertia::render('creditSales/Show',[
            'customer'=>$customer,
            'total_amount'=>$totalAmount,
            'credit_sales'=>$credit_sales
        ]);
    }

    public function create(string $id){
        return Inertia::render('creditSales/Create',[
            'customer_id'=>$id
        ]);
    }

    public function store(Request $request){
        $request->validate([
            'product'=>'required|string',
            'description'=>'nullable|string',
            'unit_price'=>'required|numeric|min:0.01',
            'quantity'=>'required|numeric|min:1'
        ]);

        $customerId = $request->customer_id;
        $result = DB::select('CALL CheckCustomerHasPendingCreditSale(?)', [$customerId]);

        if(!empty($result)){
            $creditSale = CreditSale::find($result[0]->id);
        }else{
            $creditSale = CreditSale::create([
                'customer_id' => $request->customer_id,
                'total_amount' => 0, 
                'sales_date'=>now()
            ]);
        }

        $subtotal=$request->unit_price * $request->quantity;

        CreditSaleItem::create([
            'credit_sale_id'=>$creditSale->id,
            'product'=>$request->product,
            'description'=>$request->description ?? null,
            'quantity'=>$request->quantity,
            'unit_price'=>$request->unit_price,
            'subtotal'=>$subtotal,
            'sales_date'=>now()
        ]);

        $creditSale=CreditSale::findOrFail($creditSale->id);
        $creditSale->total_amount +=$subtotal;
        $creditSale->save();

        Transaction::create([
            'customer_id'=>$customerId,
            'action'=>$request->product,
            'type'=>'credito',
            'date'=>now(),
            'amount'=>$subtotal,
            'total_debt'=>$creditSale->total_amount
        ]);

        return to_route('transactions.show', $customerId)->with('success', 'Credit sale item added successfully.');
    }
}
