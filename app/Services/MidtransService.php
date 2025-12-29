<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

class MidtransService
{
    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$clientKey = config('services.midtrans.client_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');
    }

    /**
     * Create Snap Token for payment
     * 
     * @param \App\Models\Order $order
     * @return string Snap token
     */
    public function createSnapToken($order)
    {
        // Siapkan item details
        $itemDetails = [];
        foreach ($order->items as $item) {
            $itemDetails[] = [
                'id' => $item->ticketType->id,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'name' => $item->ticketType->event->title . ' - ' . $item->ticketType->name,
            ];
        }

        // Transaction details
        $params = [
            'transaction_details' => [
                'order_id' => $order->order_code,
                'gross_amount' => $order->total_price,
            ],
            'item_details' => $itemDetails,
            'customer_details' => [
                'first_name' => $order->user->name,
                'email' => $order->user->email,
                'phone' => $order->user->phone ?? '081234567890',
            ],
            'enabled_payments' => [
                'credit_card', 
                'bca_va', 
                'bni_va', 
                'bri_va', 
                'permata_va',
                'other_va',
                'gopay', 
                'shopeepay',
                'qris',
                'cimb_clicks',
                'bca_klikbca',
                'bca_klikpay',
                'bri_epay',
                'echannel',
                'mandiri_clickpay',
                'indomaret',
                'alfamart',
            ],
            'callbacks' => [
                'finish' => route('payment.finish'),
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return $snapToken;
        } catch (\Exception $e) {
            throw new \Exception('Failed to create payment: ' . $e->getMessage());
        }
    }

    /**
     * Check transaction status
     * 
     * @param string $orderId
     * @return object Transaction status
     */
    public function checkTransactionStatus($orderId)
    {
        try {
            $status = Transaction::status($orderId);
            return $status;
        } catch (\Exception $e) {
            throw new \Exception('Failed to check status: ' . $e->getMessage());
        }
    }

    /**
     * Cancel transaction
     * 
     * @param string $orderId
     * @return object Cancel result
     */
    public function cancelTransaction($orderId)
    {
        try {
            $result = Transaction::cancel($orderId);
            return $result;
        } catch (\Exception $e) {
            throw new \Exception('Failed to cancel: ' . $e->getMessage());
        }
    }
}