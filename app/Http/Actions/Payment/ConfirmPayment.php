<?php

namespace App\Http\Actions\Payment;

use App\Http\Actions\Action;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Plan;
use App\Models\Payment;
use App\Models\User;
use Exception;
use Carbon\Carbon;

// Assume $plan is already retrieved

class ConfirmPayment extends Action
{
    public function handle(Request $request)
    {
        try {
            Log::info('Received Paystack webhook', [
                'payload' => $request->all(),
            ]);

            // Optional: verify Paystack signature
            $signature = $request->header('x-paystack-signature');
            $computed = hash_hmac('sha512', $request->getContent(), env('PAYSTACK_SECRET_KEY'));

            if ($signature !== $computed) {
                Log::warning('Invalid Paystack signature');
                return response()->json(['message' => 'Invalid signature'], 403);
            }

            $event = $request->input('event');
            $data = $request->input('data');

            $now = Carbon::now();
            $expires_at = $now->copy()->addMonths($plan->month_count);


            if ($event === 'charge.success' && $data['status'] === 'success') {
                $reference = $data['reference'];
                $email = $data['customer']['email'];

                $user = User::where('email', $email)->first();
                $planName = $data['metadata']['plan'] ?? null;
                $plan = Plan::where('name', $planName)->first();

                if (!$user || !$plan) {
                    Log::warning('User or plan not found', compact('email', 'planName'));
                    return response()->json(['message' => 'User or plan not found'], 404);
                }

                $payment = Payment::where('reference', $reference)->first();

                if ($payment) {
                    if ($payment->status !== 'completed') {
                        $payment->update([
                            'status' => 'completed',
                            'amount' => $data['amount'] / 100,
                            'currency' => $data['currency'] / 100,
                            'payed_at' => $now,
                            'expires_at' => $expires_at,
                        ]);
                        Log::info('Payment status updated to completed', ['reference' => $reference]);
                    } else {
                        Log::info('Payment already verified', ['reference' => $reference]);
                    }
                } else {
                    $payment = Payment::create([
                        'user_id' => $user->id,
                        'plan_id' => $plan->id,
                        'reference' => $reference,
                        'amount' => $data['amount'] / 100, // Paystack sends in kobo
                        'status' => 'completed',
                        'currency' => $data['currency'] / 100,
                        'payed_at' => $now,
                        'expires_at' => $expires_at,
                    ]);
                    Log::info('New payment created', ['reference' => $reference]);
                }

                return response()->json(['message' => 'Payment processed'], 200);
            }

            return response()->json(['message' => 'Unhandled event'], 200);
        } catch (Exception $e) {
            Log::error('Payment webhook failed', [
                'error' => $e->getMessage(),
            ]);

            return response()->json(['message' => 'Server error'], 500);
        }
    }
}
