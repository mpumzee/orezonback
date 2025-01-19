<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubOrder extends Model
{
    protected $guarded = [];
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_products')
                    ->withPivot('quantity', 'price');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }

}
