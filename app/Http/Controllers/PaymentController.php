<?php

namespace App\Http\Controllers;

use App\Models\CreditPayment;
use App\Models\CreditSale;
use App\Models\Customer;
use App\Models\Transaction;
use App\Services\PaymentService\Contracts\IPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class PaymentController extends Controller
{

    protected $PaymentService;

    function __construct(IPaymentService $PaymentService)
    {
        $this->PaymentService=$PaymentService;
    }


    public function index()
    {
        
    }

    public function create(string $customer_id)
    {
        return Inertia::render('payment/Create', [
            'customer_id' => $customer_id,
        ]);
    }

    public function show(string $id)
    {
        /*$customer=Customer::findOrFail($id);
        $result = DB::select('CALL GetTotalCreditAmountByCustomer(?)', [$id]);
        $totalAmount = $result[0]->total_amount ?? 0;
        
        $Payment_id=CreditSale::where('customer_id',$id)->value('id');
        $Payemnts=CreditPayment::where('credit_sales_id',$Payment_id)->get();

        return Inertia::render('payment/Show',[
           'payments'=>$Payemnts,
           'customer'=>$customer,
           'total_amount'=>$totalAmount
        ]);*/
        $data=$this->PaymentService->show($id);

        return Inertia::render('payment/Show',$data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount_paid' => 'required|numeric|min:0.01',
            'note' => 'nullable|string|max:255',
        ]);

        $creditSale = CreditSale::where('customer_id', $request->customer_id)
            ->where('status', 'pending')
            ->first();
        if (!$creditSale) {
            return redirect()->back()->withErrors(['credit_sale' => 'No pending credit sale found for this customer.']);
        }else {

            CreditPayment::create([
                'credit_sales_id' => $creditSale->id,
                'amount_paid' => $request->amount_paid,
                'notes' => $request->note,
                'paymens_date' => now(),
            ]);

            $amountPaid = $request->amount_paid;

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
                'customer_id' => $request->customer_id,
                'action' => 'Pago a cuenta ',
                'type' => 'pago',
                'amount' => $request->amount_paid,
                'total_debt' => $creditSale->total_amount,
                'date' => now(),
            ]);
        }

        return to_route('transactions.show', $request->customer_id)
            ->with('success', 'Payment recorded successfully.');
    }
}
