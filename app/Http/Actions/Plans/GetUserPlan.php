<?php

namespace App\Http\Actions\Plans;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Http\Actions\Action;
use App\Models\Payment;


class GetUserPlan extends Action {


    public function handle(Request $request) {

        try {   
            Log::info("Recieved request to retrieve a user's plan", [$request]);

            $payments = Payment::with("plan")->where("user_id", $request->user()->id)->orderBy("created_at", "desc")->paginate();

            Log::info("Plan retrieved successfully", [$payments]);

            return $payments;

    
        }
        catch(Exception $exception) {
            Log::error("Unable to retrieve plan", $exception);
        }
    }

}