<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CreditSaleItem extends Model
{
    protected $table='credit_sale_items';

    protected $fillable=[
        'credit_sale_id',
        'product',
        'description',
        'quantity',
        'unit_price',
        'subtotal',
        'sales_date'
    ];

    public function creditSale() {
        return $this->belongsTo(CreditSale::class);
    }
}
