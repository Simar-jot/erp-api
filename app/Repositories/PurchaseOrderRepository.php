<?php

namespace App\Repositories;

use App\Models\Item;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use Illuminate\Support\Facades\DB;

class PurchaseOrderRepository{

    public function store($data)
    {
        DB::beginTransaction();

        try {
            // Create Purchase Order
            $purchaseOrder = PurchaseOrder::create([
                'vendor_name' => $data['vendor_name'],
                'date' => $data['date'],
                'status' => 'pending',
                'invoice_path' => $data['invoice_path'],
            ]);

            // Create Puchase Order Items
            foreach ($data['items'] as $itemData) {
                PurchaseOrderItem::create([
                    'purchase_order_id' => $purchaseOrder->id,
                    'item_id' => $itemData['item_id'],
                    'quantity' => $itemData['quantity'],
                    'price' => $itemData['price'],
                ]);
            }

            DB::commit();

            return [
                'status' => true, 'message' => 'Purchase Order Created Successfully',
                'code' => 200, 'purchaseOrder' => $purchaseOrder->load('purchaseOrderItems.item')
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            return ['status' => false, 'message' => $th->getMessage(), 'code' => 400 ];
        }
    }
    
    public function approve($id){
        try {
            $purchaseOrder = PurchaseOrder::with('purchaseOrderItems')->findOrFail($id);

            if ($purchaseOrder->status !== 'pending') {
                return ['message' => 'Purchase Order already processed.', 'code' => 422];
            }

            DB::beginTransaction();

            foreach ($purchaseOrder->purchaseOrderItems as $purchaseOrderItem) {
                $item = Item::find($purchaseOrderItem->item_id);
                if ($item) {
                    $item->stock_quantity += $purchaseOrderItem->quantity;
                    $item->save();
                }
            }

            $purchaseOrder->status = 'approved';
            $purchaseOrder->save();

            DB::commit();

            return ['message' => 'Purchase order approved and inventory updated.', 'code' => 200];
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Purchase Order not found.'], 404);
        } catch (\Throwable $th) {
            DB::rollBack();
            return ['message' => $th->getMessage(), 'code' => 500];
        }
    }

    public function reject($id){
        try {
            $purchaseOrder = PurchaseOrder::findOrFail($id);

            if ($purchaseOrder->status !== 'pending') {
                return ['message' => 'Purchase Order already processed.', 'code' => 422];
            }

            $purchaseOrder->status = 'rejected';
            $purchaseOrder->save();

            return ['message' => 'Purchase order rejected.', 'code' => 200];
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Purchase Order not found.'], 404);
        } catch (\Throwable $th) {
            return ['message' => $th->getMessage(), 'code' => 500];
        }
    }
}

?>