<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name',
        'sku',
        'unit',
        'price',
        'stock_quantity',
    ];
}
