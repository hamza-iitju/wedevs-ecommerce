<?php

namespace App\Http\Controllers\API\Customer\Auth;

use App\CPU\Helpers;
use App\CPU\ImageManager;
use App\Models\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:customers',
            'phone' => 'unique:customers',
            'password' => 'required|confirmed'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }

        $customer_image = '';
        if ($request->file('image')) {
            $customer_image = ImageManager::upload('customer/', 'png', $request->file('image'));
            $customer_image = json_encode($customer_image);
        }

        $customer = Customer::create([
            'name' => $request['name'],
            'phone' => $request['phone'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'address' => $request['address'],
            'image' => $customer_image
        ]);

        $token = $customer->createToken('myapp')->plainTextToken;

        $response = [
            'customer' => $customer,
            'token' => $token
        ];

        return response($response, 201);
    }
}
