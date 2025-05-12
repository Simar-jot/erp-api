<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $fillable = [
        'vendor_name',
        'date',
        'status',
        'invoice_path',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function purchaseOrderItems(){
        return $this->hasMany(PurchaseOrderItem::class);
    }
}
