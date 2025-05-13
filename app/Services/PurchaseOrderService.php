<?php

namespace App\Services;

use App\Models\Item;
use App\Models\PurchaseOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Repositories\PurchaseOrderRepository;

class PurchaseOrderService{

    public function store($request){
        if ($request->hasFile('invoice')) {
            $path = $request->file('invoice')->store('invoices');
            $data['invoice_path'] = $path;
        }
        $request->request->add($data);
        $data = $request->except(['invoice']);
        return (new PurchaseOrderRepository)->store($data);
    }

    public function approve($id){
        $user = Auth::user();

        if ($user->role !== 'admin') {
            return ['message' => 'You do not have permission to approve this order.'];
        }

        return (new PurchaseOrderRepository)->approve($id);
    }

    public function reject($id){
        $user = Auth::user();

        if ($user->role !== 'admin') {
            return ['message' => 'You do not have permission to reject this order.'];
        }

        return (new PurchaseOrderRepository)->reject($id);
    }

    public function summary(){
        $purchaseOrder = PurchaseOrder::select(['id','status'])->get();
        $summary = [
            'total_items' => Item::count(),
            'total_purchase_orders' => $purchaseOrder->count(),
            'approved_orders' => $purchaseOrder->where('status', 'approved')->count(),
            'rejected_orders' => $purchaseOrder->where('status', 'rejected')->count(),
            'pending_orders' => $purchaseOrder->where('status', 'pending')->count(),
            'total_stock_value' => Item::sum(DB::raw('price * stock_quantity')),
        ];
        return $summary;
    }

}

?>