<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierMessage extends Model
{
    protected $guarded = [];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }
}
