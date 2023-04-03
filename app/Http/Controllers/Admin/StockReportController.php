<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
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
                $total_quantity_sold = 0;
                foreach ($product->sales as $sold_quantity) {
                    $total_quantity_sold += $sold_quantity->pivot->quantity;
                }
                return $total_quantity_sold;
            })
            ->addColumn('total_current_stock_sales_price', function($product){
                return $product->quantity * $product->sales_price;
            })
            ->make(true);
    }
}
