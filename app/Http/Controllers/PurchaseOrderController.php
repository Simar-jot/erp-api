<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use Illuminate\Support\Facades\Auth;

class PurchaseOrderController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'vendor_name' => 'required|string',
                'date' => 'required|date',
                'items' => 'required|array|min:1',
                'items.*.item_id' => 'required|exists:items,id',
                'items.*.quantity' => 'required|integer|min:1',
                'items.*.price' => 'required|numeric|min:0',
                'invoice' => 'nullable|file|mimes:pdf|max:2048',
            ]);

            $purchaseOrder = PurchaseOrder::create([
                'vendor_name' => $request->vendor_name,
                'date' => $request->date,
                'status' => 'pending',
            ]);

            foreach ($request->items as $itemData) {
                PurchaseOrderItem::create([
                    'purchase_order_id' => $purchaseOrder->id,
                    'item_id' => $itemData['item_id'],
                    'quantity' => $itemData['quantity'],
                    'price' => $itemData['price'],
                ]);
            }

            if ($request->hasFile('invoice')) {
                $path = $request->file('invoice')->store('invoices');
                $purchaseOrder->invoice_path = $path;
                $purchaseOrder->save();
            }

            return response()->json([
                'message' => 'Purchase order created successfully.',
                'data' => $purchaseOrder->load('purchaseOrderItems.item')
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'Failed to create purchase order.', 'error' => $th->getMessage()], 500);
        }
    }

    public function approve($id){
        try {
            $user = Auth::user();
            dd($user);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
