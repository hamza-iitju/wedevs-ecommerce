<?php

namespace App\Http\Controllers\Admin;

use App\CPU\Helpers;
use App\CPU\ImageManager;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function add_new()
    {
        return view('admin-views.product.add-new');
    }

    public function view($id)
    {
        $product = Product::where(['id' => $id])->first();
        return view('admin-views.product.view', compact('product'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'images' => 'required',
            'price' => 'required|numeric|min:1',
        ], [
            'images.required' => 'Product images is required!',
            'name.required' => 'Product name is required!',
            'price.required' => 'Price is required!',
        ]);

        if ($validator->errors()->count() > 0) {
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }

        $p = new Product();
        $p->name = $request->name;
        $p->slug = Str::slug($request->name, '-') . '-' . Str::random(6);

        $p->price = (Double)$request->price;

        $p->qty = $request->qty;
        $p->description = $request->description;

        if ($request->file('images')) {
            foreach ($request->file('images') as $img) {
                $product_images[] = ImageManager::upload('product/', 'png', $img);
            }
            $p->images = json_encode($product_images);
        }
        
        $p->save();

        Toastr::success('Product added successfully!');
        return redirect()->route('admin.product.list', ['in_house']);
    }

    function list($type)
    {
        $pro = Product::latest()->paginate(25);

        return view('admin-views.product.list', compact('pro'));
    }

    public function products_search(Request $request)
    {
        $key = explode(' ', $request->name);
        $name = $request->name;


        if (!empty($name)) {
            $pro = Product::active()->where(function ($q) use ($key) {
                foreach ($key as $value) {
                    $q->orWhere('name', 'like', "%{$value}%");
                }
            })->latest()->paginate(25);
        } 

        return response()->json([
            'result' => view('admin-views.product.partials._search_results', compact('pro'))->render(),
        ]);

    }

    public function status_update(Request $request)
    {
        Product::where(['id' => $request['id']])->update([
            'status' => $request['status'],
        ]);
        return response()->json([
            'success' => 1,
        ], 200);
    }

    public function edit($id)
    {
        $product = Product::find($id);
        
        return view('admin-views.product.edit', compact('product'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required|numeric|min:1',
        ], [
            'name.required' => 'Product name is required!',
            'price.required' => 'Product price is required!',
        ]);

        
        if ($validator->errors()->count() > 0) {
            return response()->json(['errors' => Helpers::error_processor($validator)]);
        }

        if ($validator->fails()) {
            return back()->withErrors($validator)
                ->withInput();
        }

        $product = Product::find($id);
        $product->name = $request->name;
        $product->slug = Str::slug($request->name, '-') . '-' . Str::random(6);
        $product->price = $request->price;
        $product->qty = $request->qty;
        $product->description = $request->description;

        if ($request->file('images')) {
            foreach ($request->file('images') as $img) {
                $product_images[] = ImageManager::upload('product/', 'png', $img);
            }
            $product->images = json_encode($product_images);
        }

        $product->save();

        Toastr::success('Product updated successfully.');
        return back();
    }

    public function remove_image(Request $request)
    {
        ImageManager::delete('/product/' . $request['image']);
        $product = Product::find($request['id']);
        $array = [];
        if (count(json_decode($product['images'])) < 2) {
            Toastr::warning('You cannot delete all images!');
            return back();
        }
        foreach (json_decode($product['images']) as $image) {
            if ($image != $request['name']) {
                array_push($array, $image);
            }
        }
        Product::where('id', $request['id'])->update([
            'images' => json_encode($array),
        ]);
        Toastr::success('Product image removed successfully!');
        return back();
    }

    public function delete($id)
    {
        $product = Product::find($id);
        foreach (json_decode($product['images'], true) as $image) {
            ImageManager::delete('/product/' . $image);
        }
        $product->delete();
        Toastr::success('Product removed successfully!');
        return back();
    }
}
