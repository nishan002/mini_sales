<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class StockReportController extends Controller
{
    public function index(){
        return view('admin.stock_report.index');
    }

    public function stock_report_list(){
        $product_stock_report = Product::with('sales')->get();
        return DataTables::of($product_stock_report)
            ->addColumn('quantity_sold', function($product){
                return $product->sales->sum('pivot.quantity');
            })
            ->addColumn('total_current_stock_sales_price', function($product){
                return number_format($product->quantity * $product->sales_price, 2);
            })
            ->make(true);
    }

    public function stock_report_pdf(){
        $stock_reports = Product::with('sales')->orderBy('name', 'asc')->get();
        $pdf = Pdf::loadView('admin.pdf.stock_report',compact('stock_reports'));
        return $pdf->download( 'stock-report.pdf');
    }
}
