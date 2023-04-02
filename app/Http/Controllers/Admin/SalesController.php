<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SalesController extends Controller
{
    public function index(){
        return view('admin.sales.index');
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

            $sale->customer_id = $request->customer_id;
            $sale->total_amount = $total;

            $sale->save();

            for ($i=0; $i<count($request->product_id); $i++){
                $product = Product::find($request->product_id[$i]);
                DB::table('product_sale')->insert([
                    'sale_id' => $sale->id,
                    'product_id' => $request->product_id[$i],
                    'quantity' => $request->quantity[$i],
                    'price' => $request->quantity[$i] * $product->sales_price
                ]);
            }

        }
    }
}
