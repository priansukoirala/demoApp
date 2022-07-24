<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * @group Authentication Management
 * 
 * To authenticate the user in the system
 * 
 */
class AuthController extends Controller
{
    /**
     * Login
     * 
     * API to log into the system
     * 
     * @bodyParam email string required Example: admin@test.com
     * @bodyParam password string required Example: qwerty
     * 
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = request(['email', 'password']);
        if (auth()->attempt($credentials)) {
            $tokenResult = auth()->user()->createToken('DemoApp');
            return $this->respond([
                'token' => $tokenResult->accessToken,
                'access_type' => 'bearer',
                'expires_in' => Carbon::parse(
                    $tokenResult->token->expires_at
                )->toDateTimeString(),
                'user_id' => auth()->id(),
            ]);
        }
        return $this->respondUnAuthenticated(251);
    }
}
