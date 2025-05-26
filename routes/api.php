<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/plan/me',              [PlanController::class, "getUserPlan"]);
    Route::post('/plan/subscribe',      [PlanController::class, "subscribe"]);
    
});




Route::get('/plan',                 [PlanController::class, "getPlan"]);
Route::get('/plans',                [PlanController::class, "getPlans"]);


Route::get('/payment/confirm',      [PaymentController::class, "confirmPayment"]);

Route::post('/signup', [UserController::class, "signUp"]);
Route::post('/login', [UserController::class, "login"]);


