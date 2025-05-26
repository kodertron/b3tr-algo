<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Actions\Plans\GetPlan;
use App\Http\Actions\Plans\GetUserPlan;
use App\Http\Actions\Plans\SubscribeToPlan;
use App\Http\Requests\SignUpRequest;
use App\Http\Requests\SubscribePlanRequest;

class PlanController extends Controller
{
    public function getPlan(Request $request, GetPlan $action) {
        return $action->handle($request);
    }

    public function getUserPlan(Request $request, GetuserPlan $action) {
        return $action->handle($request);
    }

    public function getPlans(Request $request, GetPlan $action) {
        return $action->all($request);
    }

    public function subscribe(SubscribePlanRequest $request, SubscribeToPlan $action) {
        return $action->handle($request);
    }
}