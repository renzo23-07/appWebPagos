<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditSale extends Model
{
    protected $table='credit_sales';

    protected $fillable=[
        'customer_id',
        'sales_date',
        'total_amount',
        'status'
    ];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    //este modelo actual tien muchos registros de CreditSaleItem
    public function items() {
        return $this->hasMany(CreditSaleItem::class);
    }

    public function payments() {
        return $this->hasMany(CreditPayment::class);
    }

    public function getTotalPaidAttribute() {
        return $this->payments()->sum('amount_paid');
    }

    public function getRemainingAmountAttribute() {
        return $this->total_amount - $this->total_paid;
    }
}
