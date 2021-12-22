<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function customer_list()
    {
        $customers = Customer::with(['orders'])->latest()->paginate(25);
        return view('admin-views.customer.list', compact('customers'));
    }

    public function status_update(Request $request)
    {
        Customer::where(['id' => $request['id']])->update([
            'is_active' => $request['status']
        ]);

        return response()->json([], 200);
    }
}
