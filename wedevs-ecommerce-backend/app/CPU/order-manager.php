<?php

namespace App\CPU;

use App\Models\Admin;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderManager
{

    public static function place_order($cart)
    {
        
        $order_id = 100000 + Order::all()->count() + 1;
        try {
            // shipping_addresses insert
            $shipping_req = $cart['shipping'];
            $shipping = [
                'person_name' => $shipping_req['person_name'],
                'phone' => $shipping_req['phone'],
                'email' => $shipping_req['email'],
                'address' => $shipping_req['address'],
                'city' => $shipping_req['city'],
                'created_at' => now(),
                'updated_at' => now()
            ];

            $shipping_id = DB::table('shipping_addresses')->insertGetId($shipping);

            // order insert
            $order = [
                'id' => $order_id,
                'customer_id' => $cart['customer_id'],
                'customer_type' => 'customer',
                'payment_status' => 'unpaid',
                'order_status' => 'pending',
                'payment_method' => 'not choosen yet',
                'transaction_ref' => null,
                'discount_amount' => 0,
                'discount_type' => 'coupon_discount',
                'order_amount' => $cart["total"],
                'shipping_address_id' => $shipping_id,
                'created_at' => now(),
                'updated_at' => now()
            ];

            $order_id = DB::table('orders')->insertGetId($order);

            // order details insert
            foreach ($cart['products'] as $pro) {
                $product = Product::where(['id' => $pro['id']])->first();
                $or_details = [
                    'order_id' => $order_id,
                    'product_id' => $product['id'],
                    'product_details' => $product,
                    'qty' => $pro['quantity'],
                    'price' => $product['price'],
                    'discount' => 0,
                    'created_at' => now(),
                    'updated_at' => now()
                ];

                Product::where(['id' => $product['id']])->update([
                    'qty' => $product['qty'] - $pro['quantity']
                ]);

                DB::table('order_details')->insert($or_details);
            }

        } catch (\Exception $e) {
            return response()->json(["Something is not found", 400]);
        }

        return $order_id;
    }

    public static function stock_update_on_order_status_change($order, $status)
    {
        if ($status == 'returned' || $status == 'failed' || $status == 'canceled') {
            foreach ($order->details as $detail) {
                if ($detail['is_stock_decreased'] == 1) {
                    $product = Product::find($detail['product_id']);
                    Product::where(['id' => $product['id']])->update([
                        'qty' => $product['qty'] + $detail['quantity'],
                    ]);
                    OrderDetails::where(['id' => $detail['id']])->update([
                        'is_stock_decreased' => 0
                    ]);
                }
            }
        } else {
            foreach ($order->details as $detail) {
                if ($detail['is_stock_decreased'] == 0) {
                    $product = Product::find($detail['product_id']);

                    Product::where(['id' => $product['id']])->update([
                        'qty' => $product['qty'] - $detail['quantity'],
                    ]);
                    OrderDetails::where(['id' => $detail['id']])->update([
                        'is_stock_decreased' => 1
                    ]);
                }
            }
        }
    }
}
