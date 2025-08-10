<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class TransactionController extends Controller
{
    public function index()
    {
        return Inertia::render('transactions/Index');
    }

    public function show(string $id_customer)
    {
        $customer = Customer::findOrFail($id_customer);
        $result = DB::select('CALL GetTotalCreditAmountByCustomer(?)', [$id_customer]);
        $totalAmount = $result[0]->total_amount ?? 0;
        
        $transactions = Transaction::where('customer_id', $id_customer)->get();
        return Inertia::render('customers/Profile', [
            'customer' => $customer,
            'total_amount' => $totalAmount,
            'customerTransaction' => $transactions
        ]);
    }
}
