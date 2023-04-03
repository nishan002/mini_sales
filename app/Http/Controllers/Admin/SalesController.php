<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class SalesController extends Controller
{
    public function index(){
        return view('admin.sales.index');
    }

    public function sales_list(){
        $sales = Sales::all();
        return DataTables::of($sales)
            ->addColumn('customer_name', function($sale){
                return $sale->customer->name;
            })
            ->addColumn('action', function($sale){
                return '<a href="/sales/'. $sale->id .'/invoice" class="btn btn-primary btn-sm mr-3"><i class="fa fa-edit"></i></a><button class="btn btn-danger btn-sm delete-btn" data-id="'. $sale->id .'" data-toggle="modal" data-target="#saleModal"><i class="fa fa-trash"></i></button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create(){
        $customers = Customer::all();
        $products = Product::all();

        return view('admin.sales.create', compact('customers', 'products'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'customer_id' => 'required',
            'product_id.*' => 'required|distinct',
            'quantity.*' => 'required|numeric|max:10000000',
        ],
        [
            'customer_id' => 'Customer field is required',
            'product_id.*.required' => 'Product field is required',
            'product_id.*.distinct' => 'Product field has a duplicate value',
            'quantity.*.required' => 'Quantity is required',
            'quantity.*.numeric' => 'Quantity must be a number',
            'quantity.*.max' => 'Quantity may not be greater than 10000000'
        ]);

        if(!$validator->passes()) {
            return response()->json(['status' => 0, 'error' => $validator->errors()->toArray()]);
        }
        else{
            $sale = new Sales();
            $total = 0;
            for ($i=0; $i<count($request->product_id); $i++){
                $product = Product::find($request->product_id[$i]);
                $total += $product->sales_price * $request->quantity[$i];
            }

            // invoice id generating
            $date = date('dy');
            $time = date('hi');
            $rand = rand(10, 1000);

            $sale->invoice_id = 'INV-' . $date. '-' . $time . '-' . $rand;
            $sale->customer_id = $request->customer_id;
            $sale->total_amount = $total;


            $sale->save();

            for ($i=0; $i<count($request->product_id); $i++){
                $product = Product::find($request->product_id[$i]);
                $product->quantity = $product->quantity - $request->quantity[$i];
                $product->update();
                DB::table('product_sales')->insert([
                    'sales_id' => $sale->id,
                    'product_id' => $request->product_id[$i],
                    'quantity' => $request->quantity[$i],
                    'price' => $request->quantity[$i] * $product->sales_price
                ]);
            }
            Session::flash('success', 'Sales created successfully!');
            return response()->json(['status'=>1, 'msg'=>'Sales created successfully!']);
        }
    }

    public function destroy($id){
        $sale = Sales::find($id);
        $sale->delete();
        return response()->json(['status'=>1, 'msg'=>'done', 'id' => $id]);
    }
}
