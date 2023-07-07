<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\GeneralTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory, SoftDeletes, GeneralTrait;

    public function productCategory(): HasMany
    {
        return $this->hasMany(ProductCategory::class, 'product_id', 'id')->where('status', 1);
    }

}
