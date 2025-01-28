<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Payout;
use App\Models\SubOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayoutsController extends Controller
{
    public function getSellersWithBalances()
    {
        $sellers = SubOrder::where('status', 'delivered')
            ->where('payout_status', 'pending')
            ->groupBy('seller_id')
            ->select(
                'seller_id',
                DB::raw('SUM(payable_amount) as balance')
            )
            ->with('seller:id,name,email') // Assuming `SubOrder` has a `seller` relationship
            ->orderByDesc('balance') // Optional: order by balance
            ->get();

        if ($sellers->isEmpty()) {
            return response()->json([
                'status' => 'success',
                'message' => 'No sellers found with pending balances.',
                'data' => [],
            ], 200);
        }

        return response()->json([
            'status' => 'success',
            'data' => $sellers,
        ]);
    }

    public function makePayouts()
    {
        // Step 1: Fetch eligible sellers and their total payout amounts
        $eligibleSellers = SubOrder::join('bank_details', 'sub_orders.seller_id', '=', 'bank_details.user_id')
            ->select(
                'sub_orders.seller_id',
                'bank_details.paypal_email',
                DB::raw('SUM(sub_orders.payable_amount) as total_payout')
            )
            ->where('sub_orders.payout_status', 'pending')
            ->groupBy('sub_orders.seller_id', 'bank_details.paypal_email')
            ->get();

        if ($eligibleSellers->isEmpty()) {
            return response()->json(['message' => 'No payouts to process'], 200);
        }

        // Step 2: Configure PayPal Client
        $paypal = new PayPalClient();
        $paypal->setApiCredentials(config('paypal'));
        $accessToken = $paypal->getAccessToken();
        $paypal->setAccessToken($accessToken);

        $payoutBatch = [];

        // Step 3: Prepare Payout Batch
        foreach ($eligibleSellers as $seller) {
            $payoutBatch[] = [
                'recipient_type' => 'EMAIL',
                'receiver' => $seller->paypal_email,
                'amount' => [
                    'value' => number_format($seller->total_payout, 2, '.', ''),
                    'currency' => 'USD' // Adjust this based on your business currency
                ],
                'note' => 'Seller payout',
                'sender_item_id' => uniqid('seller_' . $seller->seller_id . '_') // Unique identifier for each payout
            ];
        }

        // Step 4: Call PayPal Payouts API
        try {
            $response = $paypal->createBatchPayout([
                'sender_batch_header' => [
                    'sender_batch_id' => uniqid('batch_'),
                    'email_subject' => 'You have received a payout!',
                    'email_message' => 'You have received a payout for your sales on our platform.'
                ],
                'items' => $payoutBatch,
            ]);

            // Step 5: Process Successful Payouts
            if ($response['batch_header']['batch_status'] === 'PENDING' || $response['batch_header']['batch_status'] === 'SUCCESS') {
                foreach ($eligibleSellers as $seller) {
                    // Mark related sub_orders as paid
                    SubOrder::where('seller_id', $seller->seller_id)
                        ->where('payout_status', 'pending')
                        ->update([
                            'payout_status' => 'paid',
                            'payout_date' => now(),
                        ]);

                    // Log payout in the payouts table
                    Payout::create([
                        'seller_id' => $seller->seller_id,
                        'amount' => $seller->total_payout,
                        'transaction_id' => $response['batch_header']['payout_batch_id'],
                        'status' => 'completed',
                    ]);
                }

                return response()->json(['message' => 'Payouts processed successfully'], 200);
            } else {
                throw new \Exception('Payout batch status: ' . $response['batch_header']['batch_status']);
            }
        } catch (\Exception $e) {
            // Step 6: Handle Errors
            Log::error('Payout Error: ' . $e->getMessage());
            return response()->json(['message' => 'Payouts failed', 'error' => $e->getMessage()], 500);
        }
    }
}
