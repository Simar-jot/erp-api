<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\PurchaseOrderService;

class ReportingController extends Controller
{
    public function summary(){
        return (new PurchaseOrderService)->summary();
    }

    public function exportSummaryToPDF(){
        $summary = (new PurchaseOrderService)->summary();
        $pdf = Pdf::loadView('summary_report',compact('summary'));
        return $pdf->download('summary_report.pdf');
    }

    public function exportSummaryToCSV(){
        $summary = (new PurchaseOrderService)->summary();
        dd($summary);
    }
}
