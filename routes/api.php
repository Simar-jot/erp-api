<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register',[RegisterController::class,'register']);
Route::post('/login',[RegisterController::class,'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/item',ItemController::class)->except('show');
    Route::post('/purchase-order', [PurchaseOrderController::class, 'store']);
    // Route::post('/purchase-order/{id}/approve', [PurchaseOrderController::class, 'approve']);
    // Route::post('/purchase-order/{id}/reject', [PurchaseOrderController::class, 'reject']);
    // Route::get('/purchase-order/{id}/invoice', [PurchaseOrderController::class, 'downloadInvoice']);
});
