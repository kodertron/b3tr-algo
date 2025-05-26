<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SignUpRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Actions\Users\SignUp;
use App\Http\Actions\Users\Login;


class UserController extends Controller
{
    //

    public function signUp(SignUpRequest $request, SignUp $action) {
        return $action->handle($request);
    }

    public function login(LoginRequest $request, Login $action) {
        return $action->handle($request);
    }
}
