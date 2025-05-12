<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrderItem extends Model
{
    protected $fillable = [
        'purchase_order_id',
        'item_id',
        'quantity',
        'price',
    ];

    public function puchaseOrder(){
        return $this->belongsTo(PurchaseOrder::class);
    } 
    public function item(){
        return $this->belongsTo(Item::class);
    } 
}
