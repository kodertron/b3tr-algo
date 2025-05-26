<?php

namespace App\Http\Actions\Plans;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use NotificationChannels\Telegram\TelegramMessage;
use Illuminate\Support\Facades\Mail;

use App\Http\Actions\Action;
use App\Http\Requests\SubscribePlanRequest;
use App\Models\Plan;
use App\Models\Payment;


class SubscribeToPlan extends Action {


    public function handle(SubscribePlanRequest $request) {

        try {
            Log::info("Recieved request to subscribe to plan", [$request]);

            $payment = Payment::create([
                "user_id" => $request->user()->id,
                "plan_id" => Plan::where("name", $request->plan)->first()->id,
                'reference' => $request->reference,
            ]);

            if (!$payment) throw Exception("Unable to save payment {$request->reference}");

            Log::info("Payment saved successfully", [$payment]);

            $this->sendTelegramMessage("🆕 New Plan Subscription\n\n👤 Username: {$request->user()->username}\n📧 Email: {$request->user()->email}\n📦 Plan: {$request->plan}\n 💫Amount Payed: $" . Plan::where("name", $request->plan)->first()->price);

            Mail::send('emails.client', [
                'username' => $request->user()->username,
                'email' => $request->user()->email,
                'plan' => Plan::where("name", $request->plan)->first(),
                'logo' => 'https://chentechnologies.com/images/logo.png'
            ], function($message) use ($request) {
                $message->to($request->user()->email)
                        ->cc(env("MAIL_FROM_ADDRESS"))
                        ->subject('Welcome To B3TR-ALGO');
            });

            return $payment;

            

    
        }
        catch(Exception $exception) {
            Log::error("Unable to save payment", $exception);
        }
    }

}