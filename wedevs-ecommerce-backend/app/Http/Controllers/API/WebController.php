<?php

namespace App\Http\Controllers\API;

use App\CPU\Helpers;
use App\CPU\OrderManager;
use App\CPU\ProductManager;
use App\Http\Controllers\Controller;
use App\Models\OrderDetails;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WebController extends Controller
{
    public function shop(Request $request) {
        $fetched = Product::latest();
        $products = $fetched->paginate(20);
        $products = $this->getLocaleProduct($products);

        $data = [
            'id' => $request['id'],
            'name' => $request['name'],
            'data_from' => $request['data_from'],
            'sort_by' => $request['sort_by'],
            'page_no' => $request['page'],
            'min_price' => $request['min_price'],
            'max_price' => $request['max_price'],
            'page_number' => $products->lastPage(),
        ];

        return view('web-views.products.view', compact('products', 'data'), $data);
    }

    public function searched_products(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ], [
            'name.required' => 'Product name is required!',
        ]);

        $result = ProductManager::search_products($request['name']);
        $products = $result['products'];

        return response()->json($products, 200);
    }

    public function checkout(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'total' => 'required',
            'shipping' => 'required',
            'products' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        //check stock
        /*return response()->json($c);*/
        foreach ($request['products'] as $pro) {
            $product = Product::find($pro['id']);
            if (isset($product)) {
                if ($product['qty'] < $pro['quantity']) {
                    $validator->getMessageBag()->add('stock', 'Stock is insufficient! available stock ' . $product['qty']);
                }
            }
        }

        if ($validator->getMessageBag()->count() > 0) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $data = OrderManager::place_order($request);

        return response()->json([
            'message' => 'Order placed successfully!',
            'order_id' => $data
        ], 200);

    }

    public function quick_view(Request $request)
    {
        $product = ProductManager::get_product($request->product_id);
        
        if(count($product->translations) > 0) {
            if ( ($product->translations[0]->locale == app()->getLocale()) && $product->translations[0]->key == 'name' ) {
                $product->name = $product->translations[0]->value;
            }
            if ( ($product->translations[0]->locale == app()->getLocale()) && $product->translations[0]->key == 'short_description' ) {
                $product->name = $product->translations[0]->value;
            }
        }
        $order_details = OrderDetails::where('product_id', $product->id)->get();
        $countOrder = count($order_details);
        // $relatedProducts = $this->getLocaleProduct($relatedProducts);
        return response()->json([
            'success' => 1,
            'view' => view('web-views.partials._quick-view-data', compact('product'))->render(),
        ]);
    }
}
