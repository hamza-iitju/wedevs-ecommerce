<?php

namespace App\CPU;

use App\Models\Product;

class ProductManager
{
    public static function get_product($id)
    {
        return Product::active()->where('id', $id)->first();
    }

    public static function search_products($name, $limit = 10, $offset = 1)
    {
        $key = explode(' ', $name);
        $paginator = Product::active()->where(function ($q) use ($key) {
            foreach ($key as $value) {
                $q->orWhere('name', 'like', "%{$value}%");
            }
        })->paginate($limit, ['*'], 'page', $offset);

        return [
            'total_size' => $paginator->total(),
            'limit' => (integer)$limit,
            'offset' => (integer)$offset,
            'products' => $paginator->items()
        ];
    }

    public static function product_image_path($image_type)
    {
        $path = '';
        if ($image_type == 'thumbnail') {
            $path = asset('storage/product/thumbnail');
        } elseif ($image_type == 'product') {
            $path = asset('storage/product');
        }
        return $path;
    }
}
