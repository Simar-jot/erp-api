<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use Illuminate\Support\Facades\Auth;
use App\Services\PurchaseOrderService;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PurchaseOrderRequest;

class PurchaseOrderController extends Controller
{
    public function store(Request $request)
    {
        $res = (new PurchaseOrderService)->store($request);
        if (!$res['status']) {
            return response()->json(['message' => $res['message']], $res['code']);
        }
    
        return response()->json([
            'message' => $res['message'],
            'data' => $res['purchaseOrder']
        ], 201);
    }

    public function approve($id){
        return (new PurchaseOrderService)->approve($id);
    }

    public function reject($id){
        return (new PurchaseOrderService)->reject($id);
    }

    public function downloadInvoice($id){
        $purchaseOrder = PurchaseOrder::findOrFail($id);

        if (!$purchaseOrder->invoice_path || !Storage::exists($purchaseOrder->invoice_path)) {
            return response()->json(['message' => 'Invoice not found.'], 404);
        }

        return Storage::download($purchaseOrder->invoice_path);
    }
}
