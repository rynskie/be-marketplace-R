<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    Protected $fillable = [
        'product_type_id',
        'product_name',
        'description',
        'stock',
        'price',
        'img_url',
        'img_name',
    ];

}
