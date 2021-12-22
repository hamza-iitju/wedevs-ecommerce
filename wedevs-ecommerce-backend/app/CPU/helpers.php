<?php

namespace App\CPU;

use Illuminate\Support\Facades\Session;

class Helpers
{
    public static function status($id)
    {
        if ($id == 1) {
            $x = 'active';
        } elseif ($id == 0) {
            $x = 'inactive';
        }

        return $x;
    }
    
    public static function get_image_path($type)
    {
        $path = asset('storage/product');
        return $path;
    }

    public static function product_data_formatting($data, $multi_data = false)
    {
        $storage = [];
        if ($multi_data == true) {
            foreach ($data as $item) {
                $item['images'] = json_decode($item['images']);            
                array_push($storage, $item);
            }
            $data = $storage;
        } else {
            if($data){
                $data['images'] = json_decode($data['images']);
            }
        }

        return $data;
    }

    public static function error_processor($validator)
    {
        $err_keeper = [];
        foreach ($validator->errors()->getMessages() as $index => $error) {
            array_push($err_keeper, ['code' => $index, 'message' => $error[0]]);
        }
        return $err_keeper;
    }

    public static function order_status_update_message($status)
    {
        $data = "Order status changed successfully to ". $status;

        return $data;
    }
}
