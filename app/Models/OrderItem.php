<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    /** @use HasFactory<\Database\Factories\OrderItemFactory> */
    use HasFactory;

    // Disable timestamps karena migration tidak punya created_at/updated_at
    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'ticket_type_id',
        'quantity',
        'price',
        'subtotal',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function ticketType()
    {
        return $this->belongsTo(TicketType::class);
    }
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}