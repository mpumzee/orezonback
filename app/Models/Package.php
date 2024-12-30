<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $guarded = [];

    public function users()
    {
        return $this->hasManyThrough(User::class, UserPackage::class, 'package_id', 'id', 'id', 'user_id');
    }
}
