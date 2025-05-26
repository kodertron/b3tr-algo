<?php

namespace App\Http\Actions\Plans;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Http\Actions\Action;
use App\Models\Plan;


class GetPlan extends Action {


    public function handle(Request $request) {

        try {
            Log::info("Recieved request to retrieve plan", [$request]);

            $request->validate([
                "plan" => ["required", "exists:plans,name"]
            ]);

            $plan = Plan::where('name', $request->plan)->first();

            if (!$plan) throw Exception("Plan {$plan} does not exist");

            return $plan;

            Log::info("Plan retrieved successfully", [$plan]);
    
        }
        catch(Exception $exception) {
            Log::error("Unable to retrieve plan", $exception);
        }
    }

    public function all(Request $request) {

        try {
    
            Log::info("Recieved request to retrieve all plans", [$request]);

            $plan = Plan::all();

            if (!$plan) throw Exception("System has no plans at the moment");

            Log::info("Plans retrieved successfully", [$plan]);

            return $plan;
    
        }
        catch(Exception $exception) {
            Log::error("Unable to retrieve plan", $exception);
        }

    }

}