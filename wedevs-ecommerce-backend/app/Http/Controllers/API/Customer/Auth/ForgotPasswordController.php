<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Brian2694\Toastr\Facades\Toastr;

class ForgotPasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:customer', ['except' => ['logout']]);
    }

    public function reset_password_request(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $customer = Customer::Where(['email' => $request['email']])->first();

        if (isset($customer)) {
            $token = Str::random(120);
            DB::table('password_resets')->insert([
                'email' => $customer['email'],
                'token' => $token,
                'created_at' => now(),
            ]);
            $reset_url = url('/') . '/customer/auth/reset-password?token=' . $token;
            // Mail::to($customer['email'])->send(new \App\Mail\PasswordResetMail($reset_url));

            return back();
        }

        return back();
    }

    public function reset_password_index(Request $request)
    {
        $data = DB::table('password_resets')->where(['token' => $request['token']])->first();
        if (isset($data)) {
            $token = $request['token'];
            return view('customer-view.auth.reset-password', compact('token'));
        }
        Toastr::error('Invalid URL.');
        return redirect('/');
    }

    public function reset_password_submit(Request $request)
    {
        $data = DB::table('password_resets')->where(['token' => $request['reset_token']])->first();
        if (isset($data)) {
            if ($request['password'] == $request['confirm_password']) {
                DB::table('users')->where(['email' => $data->email])->update([
                    'password' => bcrypt($request['confirm_password'])
                ]);
                Toastr::success('Password reset successfully.');
                DB::table('password_resets')->where(['token' => $request['reset_token']])->delete();
                return redirect('/');
            }
            Toastr::error('Password did not match.');
            return back();
        }
        Toastr::error('Invalid URL.');
        return redirect('/');
    }
}
