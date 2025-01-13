<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaymentController extends Controller
{
    public function createOrder(Request $request, $order)
    {
        // $request->validate([
        //     'price' => 'required|numeric',
        //     'currency' => 'required|string|max:3',
        //     'description' => 'required|string',
        // ]);

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));

        try {
            $provider->getAccessToken();
            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => route('paypal.success'),
                    "cancel_url" => route('paypal.cancel'),
                ],
                "purchase_units" => [
                    [
                        "amount" => [
                            "currency_code" => "USD",
                            "value" => $order->total_price,
                        ],
                        "description" => "Test Payment",
                    ],
                ],
            ]);

            Log::info("PayPal Order Created: ", $response);

            $user = auth()->user();

            if (isset($response['id'])) {
                $approvalUrl = collect($response['links'])->firstWhere('rel', 'approve')['href'] ?? null;

                // Create a payment record with a pending status
                $paymentDetails = Payment::create([
                    'buyer_id' => $user->id,
                    'order_id' => $order->id,
                    'amount' => $order->total_price,
                    'payment_method' => "paypal",
                    'transaction_id' => $response['id'],
                    'status' => 'pending'
                ]);

                if ($approvalUrl) {
                    return [
                        'success' => true,
                        'approval_url' => $approvalUrl,
                        'order_id' => $response['id'],
                        'payment' => $paymentDetails
                    ];
                }
            }

            return ['success' => false, 'message' => 'Failed to create PayPal order'];

        } catch (\Exception $e) {
            Log::error("Error Creating PayPal Order: ", ['error' => $e->getMessage()]);
            return ['success' => false, 'message' => 'An error occurred'];
        }
    }

    public function success(Request $request)
    {
        // Retrieve the PayPal token from the query string
        $orderId = $request->query('token');

        if (!$orderId) {
            return response()->json(['success' => false, 'message' => 'No order ID provided'], 400);
        }

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));

        try {
            $provider->getAccessToken();
            $response = $provider->capturePaymentOrder($orderId);

            Log::info("PayPal Payment Captured: ", $response);

            $payment = Payment::where('transaction_id', $orderId)->firstOrFail();
            $order = Order::with('subOrders')->findOrFail($payment->order_id);
            
            if (isset($response['status']) && $response['status'] === 'COMPLETED') {
                // Save payment details to the database

                // Update payment record
                $payment->update([
                    'status' => $response['status']
                ]);

                // Update order and sub-orders to delivered
                $order->update(['status' => 'delivered']);
                foreach ($order->subOrders as $subOrder) {
                    $subOrder->update(['status' => 'delivered']);
                }

                return response()->json([
                    'success' => true, 
                    'message' => 'Payment completed',
                    'payment' => $payment,
                    'order' => $order, 
                    'res' => $response
                ]);
            }

            // Update order and sub-orders to failed
            $order->update(['status' => 'failed']);
            foreach ($order->subOrders as $subOrder) {
                $subOrder->update(['status' => 'failed']);
            }

            return response()->json(['success' => false, 'message' => 'Payment not completed', 'data' => $response], 400);
            
        } catch (\Exception $e) {
            Log::error("Error Capturing PayPal Payment: ", ['error' => $e->getMessage()]);
            return response()->json(['success' => false, 'message' => 'An error occurred'], 500);
        }
    }


    public function cancel()
    {
        return response()->json(['success' => false, 'message' => 'Payment cancelled']);
    }
}
