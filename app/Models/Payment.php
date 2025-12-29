<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    use HasFactory;

     protected $fillable = [
        'order_id',
        'payment_method',
        'payment_reference',
        'transaction_id',
        'snap_token',
        'payment_data',
        'amount',
        'status',
        'paid_at',
    ];
    
    protected $casts = [
        'payment_data' => 'array',
        'paid_at' => 'datetime',
    ];
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
