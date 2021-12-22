<?php

namespace App\Http\Controllers\API\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum', ['except' => ['login', 'logout']]);
    }

    public function login(Request $request) {
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        // Check email
        $customer = Customer::where('email', $fields['email'])->first();

        // Check password
        if(!$customer || !Hash::check($fields['password'], $customer->password)) {
            return response([
                'message' => 'Bad creds'
            ], 401);
        }

        $token = $customer->createToken('myapptoken')->plainTextToken;

        $response = [
            'token' => $token
        ];

        return $response;
    }

    public function user() {
        return response(['user' => auth()->user()]);
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();

        return [
            'message' => 'Logged out'
        ];
    }
}
