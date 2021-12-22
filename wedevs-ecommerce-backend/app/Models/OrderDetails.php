<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetails extends Model
{
    use HasFactory;

    public function product()
    {
        return $this->belongsTo(Product::class)->where('status', 1);
    }

    public function active_product()
    {
        return $this->belongsTo(Product::class)->where('status', 1);
    }
    
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
