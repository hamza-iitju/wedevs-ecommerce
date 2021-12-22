<?php

namespace App\Http\Controllers\API;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\CPU\Helpers;
use App\CPU\ProductManager;
use App\CPU\ImageManager;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function index()
    {
        $products = Product::latest()->paginate(25);
        $pro = Helpers::product_data_formatting($products, true);

        return response()->json($pro, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'images' => 'required',
            'price' => 'required|numeric',
        ], [
            'images.required' => 'Product images is required!',
            'price.required' => 'Price is required!',
            'price.numeric' => 'Price should be numeric!',
        ]);

        $p = new Product();
        $p->name = $request->name;
        $p->slug = Str::slug($request->name, '-') . '-' . Str::random(6);

        $p->qty = $request->qty;
        $p->price = $request->price;
        $p->description = $request->description;

        if ($validator->errors()->count() > 0) {
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }

        if ($request->file('images')) {
            foreach ($request->file('images') as $img) {
                $product_images[] = ImageManager::upload('product/', 'png', $img);
            }
            $p->images = json_encode($product_images);
        }

        $product = $p->save();

        return response()->json([
            'message' => 'Product created successfully!',
            'status' => 200
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = ProductManager::get_product($id);
        $product = Helpers::product_data_formatting($product, false);
        return response()->json($product, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if(!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        
        $validator = Validator::make($request->all(), []);

        if($request->name != $product->name)
            $product->slug = Str::slug($request->name, '-') . '-' . Str::random(6);
        
        if ($validator->errors()->count() > 0 || $validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }

        if ($request->file('images')) {
            foreach ($request->file('images') as $img) {
                $product_images[] = ImageManager::upload('product/', 'png', $img);
            }
            $product->images = json_encode($product_images);
        }

        $product->update($request->all());

        $formated_product = Helpers::product_data_formatting($product, false);

        return response()->json(['success' => true, 'message' => 'Product updated successfully!', 
                           'updated_data' => $formated_product], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Product::destroy($id);
    }

     /**
     * Search for a name
     *
     * @param  str  $name
     * @return \Illuminate\Http\Response
     */
    // public function search($name)
    // {
    //     return Product::where('name', 'like', '%'.$name.'%')->get();
    // }


    public function get_searched_products(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $products = ProductManager::search_products($request['name'], $request['limit'], $request['offset']);
        $products['products'] = Helpers::product_data_formatting($products['products'], true);
        return response()->json($products, 200);
    }
}
