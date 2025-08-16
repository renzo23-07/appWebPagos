<?php

namespace App\Http\Controllers;

use App\Models\CreditSale;
use App\Models\CreditSaleItem;
use App\Models\Customer;
use App\Models\Transaction;
use App\Services\CreditSaleService\Contracts\ICreditSaleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class CreditSaleController extends Controller
{

    protected $creditSaleService;
    public function __construct(ICreditSaleService $creditSaleService)
    {
        $this->creditSaleService = $creditSaleService;
    }

    public function show(string $id){
        return Inertia::render('creditSales/Show', $this->creditSaleService->show($id));
    }

    public function create(string $id){
        return Inertia::render('creditSales/Create',[
            'customer_id'=>$id
        ]);
    }

    public function store(Request $request){
        return $this->creditSaleService->store($request);
    }
}
