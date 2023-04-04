<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    public function index(){
        return view('admin.products.index');
    }

    public function product_list(){
        $products = Product::all();
        return DataTables::of($products)
            ->editColumn('description', function($product){
                return '<abbr title="'. $product->description .'">'. substr($product->description,0,10).'...' .'</abbr>';
            })
            ->addColumn('action', function($product){
                return '<a href="/products/'. $product->id .'/edit" class="btn btn-primary btn-sm mr-3"><i class="fa fa-edit"></i></a><button class="btn btn-danger btn-sm delete-btn" data-id="'. $product->id .'" data-toggle="modal" data-target="#productModal"><i class="fa fa-trash"></i></button>';
            })
            ->rawColumns(['description', 'action'])
            ->make(true);
    }

    public function create(){
        return view('admin.products.create');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:products,name|max:50|min:1',
            'description' => 'required|max:500|min:1',
            'quantity' => 'required|integer',
            'purchase_price' => 'required|numeric|max:10000000|regex:/^\d+(\.\d{1,2})?$/',
            'sales_price' => 'required|numeric|max:10000000|regex:/^\d+(\.\d{1,2})?$/',
            'image' => 'nullable | mimes:jpg,jpeg,png,gif | max:5120',
        ]);

        if(!$validator->passes()){
            return response()->json(['status'=>0, 'error'=> $validator->errors()->toArray()]);
        }else{

            $product = new Product();

            if($request->hasFile('image')){
                $destination = 'public/uploads/images/products';
                $file = $request->file('image');
                $file_name = $file->getClientOriginalName();
                $file_name_store = time().$file_name;
                $path = $request->file('image')->storeAs($destination, $file_name_store );
                $product->image = $file_name_store;
            }

            // product data inserting
            $product->name = $request->input('name');
            $product->description = $request->input('description');
            $product->quantity = $request->input('quantity');
            $product->purchase_price = $request->input('purchase_price');
            $product->sales_price = $request->input('sales_price');

            $product->save();

            Session::flash('success', 'Product created successfully!');
            return response()->json(['status'=>1, 'msg'=>'done']);

        }

    }

    public function edit($id){
        try{
            $product = Product::findOrFail($id);
        }
        catch (ModelNotFoundException $exception) {
            return view('404_page');
        }
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:products,name|max:50|min:1',
            'description' => 'required|max:500|min:1',
            'quantity' => 'required|integer',
            'purchase_price' => 'required|numeric|max:10000000|regex:/^\d+(\.\d{1,2})?$/',
            'sales_price' => 'required|numeric|max:10000000|regex:/^\d+(\.\d{1,2})?$/',
            'image' => 'nullable | mimes:jpg,jpeg,png,gif | max:5120',
        ]);

        if(!$validator->passes()){
            return response()->json(['status'=>0, 'error'=> $validator->errors()->toArray()]);
        }else{

            $product = Product::find($id);
            $directory = 'public/uploads/images/products/'.$product->image;
            //dd($directory);
            if(File::exists($directory)){
                File::delete($directory);
            }

            if($request->hasFile('image')){
                $destination = 'public/uploads/images/products';
                $file = $request->file('image');
                $file_name = $file->getClientOriginalName();
                $file_name_store = time().$file_name;
                $path = $request->file('image')->storeAs($destination, $file_name_store );
                $product->image = $file_name_store;
            }

            // product data updating
            $product->name = $request->input('name');
            $product->description = $request->input('description');
            $product->quantity = $request->input('quantity');
            $product->purchase_price = $request->input('purchase_price');
            $product->sales_price = $request->input('sales_price');

            $product->update();
            Session::flash('success', 'Product updated successfully!');
            return response()->json(['status'=>1, 'msg'=>'done']);

        }
    }

    public function destroy($id){
        $product = Product::find($id);
        $directory = 'assets/uploads/images/products/'.$product->image;

        if(File::exists($directory)){
            File::delete($directory);
        }
        $product->delete();
        return response()->json(['status'=>1, 'msg'=>'done', 'id' => $id]);
    }
}
