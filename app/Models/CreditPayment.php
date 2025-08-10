<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditPayment extends Model
{
    protected $table='credit_payments';

    protected $fillable=[
        'credit_sales_id',
        'paymens_date',
        'amount_paid',
        'notes'
    ];

    public function creditSale() {
        return $this->belongsTo(CreditSale::class);
    } 
}
