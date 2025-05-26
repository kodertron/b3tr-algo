<?php

namespace App\Http\Actions\Users;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

use App\Http\Requests\LoginRequest;
use App\Http\Actions\Action;
use App\Models\User;
use Exception;

class Login extends Action
{
    public function handle(LoginRequest $request)
    {
        try {
            Log::info("Received login request", [$request->only(['email', 'username'])]);

            $user = User::where('email', $request->email)
                        ->orWhere('username', $request->username)
                        ->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    "success" => false,
                    "message" => "Invalid credentials"
                ], 401);
            }

            $token = $user->createToken($user->username)->plainTextToken;

            Log::info("User logged in successfully", [$user]);

            return response()->json([
                "success" => true,
                "message" => "Login successful",
                "token" => $token,
                "user" => $user,
            ], 200);
        } catch (Exception $exception) {
            Log::error("Login error", [$exception->getMessage(), $request->all()]);

            return response()->json([
                'success' => false,
                'error' => 'Login failed',
                'message' => $exception->getMessage(),
            ], 500);
        }
    }
}
