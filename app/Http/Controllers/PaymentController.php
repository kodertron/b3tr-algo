<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Actions\Payment\ConfirmPayment;


class PaymentController extends Controller
{
    
    public function confirmPayment(Request $request, ConfirmPayment $action) {
        $action->handle($request);
    }

}
