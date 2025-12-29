<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Ticket;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    protected $midtrans;

    public function __construct(MidtransService $midtrans)
    {
        $this->midtrans = $midtrans;
    }

    /**
     * Create payment and get snap token
     */
    public function createPayment(Order $order)
    {
        try {
            // Cek apakah order milik user yang login
            if (!Auth::check() || $order->user_id !== Auth::id()) {
                abort(403, 'Unauthorized');
            }

            // Cek apakah sudah punya payment yang berhasil
            if ($order->payment && in_array($order->payment->status, ['success', 'paid'])) {
                return redirect()->route('my-tickets.show', $order->id)
                    ->with('info', 'Order sudah dibayar');
            }

            // Generate snap token baru (untuk retry payment atau payment pertama kali)
            $snapToken = $this->midtrans->createSnapToken($order);

            // Simpan atau update payment
            $payment = Payment::updateOrCreate(
                ['order_id' => $order->id],
                [
                    'payment_method' => 'midtrans',
                    'amount' => $order->total_price,
                    'status' => 'pending',
                    'snap_token' => $snapToken,
                ]
            );

            return view('payment.show', compact('order', 'payment'));
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal membuat payment: ' . $e->getMessage());
        }
    }

    /**
     * Handle Midtrans notification callback
     */
    public function notification(Request $request)
    {
        try {
            $notification = $request->all();
            
            $orderId = $notification['order_id'];
            $transactionStatus = $notification['transaction_status'];
            $fraudStatus = $notification['fraud_status'] ?? null;
            $transactionId = $notification['transaction_id'];

            // Cari payment berdasarkan order_code
            $order = Order::where('order_code', $orderId)->first();
            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            $payment = $order->payment;
            if (!$payment) {
                return response()->json(['message' => 'Payment not found'], 404);
            }

            // Update payment data
            $payment->transaction_id = $transactionId;
            $payment->payment_data = $notification;

            // Handle status berdasarkan transaction_status
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'accept') {
                    $this->handleSuccessPayment($order, $payment);
                }
            } elseif ($transactionStatus == 'settlement') {
                $this->handleSuccessPayment($order, $payment);
            } elseif ($transactionStatus == 'pending') {
                $payment->status = 'pending';
                $payment->save();
            } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                $payment->status = 'failed';
                $payment->save();
                
                $order->status = 'cancelled';
                $order->save();
            }

            return response()->json(['message' => 'Notification handled']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Handle successful payment
     */
    private function handleSuccessPayment($order, $payment)
    {
        DB::transaction(function () use ($order, $payment) {
            // Update payment status - set as both 'paid' and 'success' for consistency
            $payment->status = 'paid';
            $payment->paid_at = now();
            $payment->save();

            // Update order status
            $order->status = 'paid';
            $order->save();

            // Generate tickets untuk setiap order item (jika belum ada)
            foreach ($order->items as $item) {
                // Cek apakah tickets sudah pernah di-generate
                $existingTicketsCount = $item->tickets()->count();
                $ticketsToGenerate = $item->quantity - $existingTicketsCount;
                
                // Hanya generate jika masih kurang
                for ($i = 0; $i < $ticketsToGenerate; $i++) {
                    $ticketCode = 'TKT-' . date('YmdHis') . '-' . $order->id . '-' . str_pad($i + 1 + $existingTicketsCount, 3, '0', STR_PAD_LEFT);
                    $qrData = url('/verify-ticket/' . $ticketCode);
                    
                    Ticket::create([
                        'order_item_id' => $item->id,
                        'ticket_code' => $ticketCode,
                        'qr_code' => $qrData,
                        'status' => 'unused',
                    ]);
                }
            }
        });
    }

    /**
     * Payment finish page (redirect dari Midtrans)
     */
    public function finish(Request $request)
    {
        $orderId = $request->get('order_id');
        $order = Order::where('order_code', $orderId)->first();

        if (!$order) {
            return redirect()->route('home')->with('error', 'Order tidak ditemukan');
        }

        // Cek status terbaru dari Midtrans
        try {
            $status = $this->midtrans->checkTransactionStatus($orderId);
            
            // Update payment berdasarkan status
            $payment = $order->payment;
            if ($payment && $status->transaction_status == 'settlement') {
                $this->handleSuccessPayment($order, $payment);
            }
        } catch (\Exception $e) {
            // Ignore error, user bisa cek manual di my-tickets
        }

        return redirect()->route('my-tickets.show', $order->id)
            ->with('info', 'Pembayaran Anda sedang diproses. Silakan cek status pembayaran.');
    }

    /**
     * Check payment status manually
     */
    public function checkStatus(Order $order)
    {
        try {
            if (!Auth::check() || $order->user_id !== Auth::id()) {
                abort(403);
            }

            $status = $this->midtrans->checkTransactionStatus($order->order_code);
            
            $payment = $order->payment;
            
            // Handle berbagai status dari Midtrans
            if (in_array($status->transaction_status, ['capture', 'settlement'])) {
                // Payment berhasil
                $this->handleSuccessPayment($order, $payment);
                
                // Reload order to get fresh data
                $order->refresh();
                $payment->refresh();
                
                // Check if it's AJAX request
                if (request()->wantsJson() || request()->ajax()) {
                    return response()->json([
                        'success' => true,
                        'message' => 'Pembayaran berhasil dikonfirmasi!',
                        'status' => 'paid'
                    ]);
                }
                
                return back()->with('success', 'Pembayaran berhasil dikonfirmasi!');
            } elseif ($status->transaction_status === 'pending') {
                // Masih pending
                $payment->status = 'pending';
                $payment->save();
                
                if (request()->wantsJson() || request()->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Pembayaran masih dalam proses',
                        'status' => 'pending'
                    ]);
                }
                
                return back()->with('info', 'Pembayaran masih dalam proses. Silakan tunggu beberapa saat atau coba bayar kembali.');
            } elseif (in_array($status->transaction_status, ['deny', 'expire', 'cancel'])) {
                // Payment gagal
                $payment->status = 'failed';
                $payment->save();
                $order->status = 'cancelled';
                $order->save();
                
                if (request()->wantsJson() || request()->ajax()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Pembayaran gagal',
                        'status' => 'failed'
                    ]);
                }
                
                return back()->with('error', 'Pembayaran gagal atau dibatalkan.');
            }

            if (request()->wantsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Status: ' . $status->transaction_status,
                    'status' => $status->transaction_status
                ]);
            }
            
            return back()->with('info', 'Status pembayaran: ' . $status->transaction_status);
        } catch (\Exception $e) {
            if (request()->wantsJson() || request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat mengecek status',
                    'error' => $e->getMessage()
                ], 500);
            }
            
            return back()->with('warning', 'Tidak dapat mengecek status dari Midtrans. Silakan coba lagi atau hubungi customer service.');
        }
    }
}