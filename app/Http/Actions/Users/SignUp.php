<?php

namespace App\Http\Actions\Users;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

use App\Http\Requests\SignUpRequest;
use App\Http\Actions\Action;
use App\Models\User;


class SignUp extends Action {


    public function handle(SignUpRequest $request) {

        try {
            Log::info("Recieved request to create user", [$request]);

            $user = User::create([
                "username" => $request->username,
                "email" => $request->email,
                "password" => Hash::make($request->password),
            ]);

            if (!$user) throw Exception("Unable to create user");

            Log::info("User created successfully", [$user]);

            return response()->json([
                "success" => true,
                "message" => "user created successfully",
                "token" => $user->createToken($user->username),
                "user" => $user,
            ], 200);
        }
        catch(Exception $exception) {
            Log::error("Unable to create user", [$exception, $request]);
            return response()->json([
                'error' => 'Unable to create user',
                'message' => $exception->getMessage(),
            ], 500)->header('Access-Control-Allow-Origin', '*');
        }
    }

}