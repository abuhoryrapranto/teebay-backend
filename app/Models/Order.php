<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\belongsTo;

class Order extends Model
{
    use HasFactory,SoftDeletes;

    public function product(): belongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id')->where('status', 1);
    }
}
