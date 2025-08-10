<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class CustomerController extends Controller
{

    public function index()
    {
        $customers=DB::select('CALL GetActiveCustomersWithAddress()');

        return Inertia::render('customers/Index',[
            'customers' => $customers
        ]);
    }

    public function create()
    {
        return Inertia::render('customers/Create',[
            'addresses'=>Address::where('state',1)->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string|max:250',
            'cellNumber'=>'required|string|digits:9',
            'id_address'=>'required|integer'
        ]);

        Customer::create([
            'name'=>$request->name,
            'cellNumber'=>$request->cellNumber,
            'id_address'=>$request->id_address
        ]);

        return to_route('customers.index');
    }

    public function edit(string $id)
    {
        $addresses=Address::where('state',true)->select('id','name')->get();

        return Inertia::render('customers/Edit',[
            'customer'=>Customer::findOrFail($id),
            'addresses'=>$addresses
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'=>'required|string|max:255',
            'cellNumber'=>'required|string|digits:9',
            'id_address'=>'required|integer'
        ]);

        $customer=Customer::findOrFail($id);
        $customer->name=$request->name;
        $customer->cellNumber=$request->cellNumber;
        $customer->id_address=$request->id_address;
        $customer->save();

        return to_route('customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy(string $id)
    {
        $customer=Customer::findOrFail($id);
        $customer->state=0;
        $customer->save();

        return to_route('customers.index');
    }
}
