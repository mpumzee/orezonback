<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products')->withPivot('quantity', 'price');
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'user_id'); // The product owner
    }
}
