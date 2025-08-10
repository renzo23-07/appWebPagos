<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'cellNumber',
        'id_address',
        'state'
    ];

    /**
     * Get the address associated with the customer.
     */
    public function address()
    {
        return $this->belongsTo(Address::class, 'id_address');
    }
}
