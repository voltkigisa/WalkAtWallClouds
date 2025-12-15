<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    /** @use HasFactory<\Database\Factories\TicketFactory> */
    use HasFactory;

    protected $fillable = [
        'order_item_id',
        'ticket_code',
        'qr_code',
        'status',
        'used_at',
    ];
    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }
}
