<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\SummaryExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
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
        return Excel::download(new SummaryExport, 'summary_report.csv');
    }
}
