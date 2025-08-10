<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transactions';

    protected $fillable = [
        'customer_id',
        'action',
        'type',
        'date',
        'amount',
        'total_debt'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
