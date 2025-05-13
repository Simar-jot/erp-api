<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ReportingController;
use App\Http\Controllers\PurchaseOrderController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/register',[RegisterController::class,'register']);
Route::post('/login',[RegisterController::class,'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('/item',ItemController::class)->except('show');
    Route::post('/purchase-order', [PurchaseOrderController::class, 'store']);
    Route::post('/purchase-order/{id}/approve', [PurchaseOrderController::class, 'approve']);
    Route::post('/purchase-order/{id}/reject', [PurchaseOrderController::class, 'reject']);
    Route::get('/purchase-order/{id}/invoice', [PurchaseOrderController::class, 'downloadInvoice']);
    Route::get('/reports/summary',[ReportingController::class, 'summary']);
    Route::get('/reports/summary/pdf', [ReportingController::class, 'exportSummaryToPDF']);
    Route::get('/reports/summary/csv', [ReportingController::class, 'exportSummaryToCSV']);
});
