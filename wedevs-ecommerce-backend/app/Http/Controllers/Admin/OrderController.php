<?php

namespace App\Http\Controllers\Admin;

use App\CPU\Helpers;
use App\CPU\OrderManager;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetails;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function list($status)
    {
        $data = OrderDetails::pluck('order_id')->toArray();
        $query = Order::with(['customer'])->whereIn('id', array_unique($data));
        if ($status != 'all') {
            $orders = $query->where(['order_status' => $status])->latest()->paginate(25);
        } else {
            $orders = $query->latest()->paginate(15);
        }

        return view('admin-views.order.list', compact('orders'));
    }

    public function details($id)
    {
        $order = Order::with('details', 'shipping')->where(['id' => $id])->first();
        return view('admin-views.order.order-details', compact('order'));
    }

    public function status(Request $request)
    {
        $order = Order::find($request->id);
    
        $value = Helpers::order_status_update_message($request->order_status);
        try {
            if ($value) {
                $data = [
                    'title' => 'Order',
                    'description' => $value,
                    'order_id' => $order['id'],
                    'image' => '',
                ];
            }
        } catch (\Exception $e) {
            return response()->json([]);
        }

        $order->order_status = $request->order_status;
        OrderManager::stock_update_on_order_status_change($order, $request->order_status);

        $order->save();
        $data = $request->order_status;
        return response()->json($data);
    }

    public function payment_status(Request $request)
    {
        if ($request->ajax()) {
            $order = Order::find($request->id);
            $order->payment_status = $request->payment_status;
            $order->save();
            $data = $request->payment_status;
            return response()->json($data);
        }
    }

    public function generate_invoice($id)
    {
        $order = Order::with('shipping')->where('id', $id)->first();

        $data["email"] = $order->customer["email"];
        $data["client_name"] = $order->shipping["person_name"];
        $data["order"] = $order;
        //return view('admin-views.order.invoice', compact('order'));
        $pdf = PDF::loadView('admin-views.order.invoice', $data);
        return $pdf->download($order->id . '.pdf');
    }
}
