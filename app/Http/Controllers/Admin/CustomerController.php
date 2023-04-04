<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{
    public function index(){
        return view('admin.customers.index');
    }

    public function customer_list(){
        $customers = Customer::all();
        return DataTables::of($customers)
            ->addColumn('action', function($customer){
                return '<a href="/customers/'. $customer->id .'/edit" class="btn btn-primary btn-sm mr-3"><i class="fa fa-edit"></i></a><button class="btn btn-danger btn-sm delete-btn" data-id="'. $customer->id .'" data-toggle="modal" data-target="#customerModal"><i class="fa fa-trash"></i></button>';
            })
            ->rawColumns([ 'action'])
            ->make(true);
    }

    public function create(){
        return view('admin.customers.create');
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required|unique:customers,name|max:100',
            'phone_number' => 'required|max:500',
            'address' => 'required|max:200',
        ]);

        if(!$validator->passes()){
            return response()->json(['status'=>0, 'error'=> $validator->errors()->toArray()]);
        }else{

            $customer = new Customer();

            // customers data inserting
            $customer->name = $request->input('name');
            $customer->phone_number = $request->input('phone_number');
            $customer->address = $request->input('address');

            $customer->save();

            return response()->json(['status'=>1, 'msg'=>'Customer created successfully!', 'customer' => $customer]);

        }

    }

    public function edit($id){
        try {
            $customer = Customer::findOrFail($id);
        }
        catch (ModelNotFoundException $exception) {
            return view('404_page');
        }
        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(),[
            'name' => 'required|max:100|unique:customers,name,'.$id,
            'phone_number' => 'required|max:500',
            'address' => 'required|max:200',
        ]);

        if(!$validator->passes()){
            return response()->json(['status'=>0, 'error'=> $validator->errors()->toArray()]);
        }else{

            $customer = Customer::find($id);

            // customers data updating
            $customer->name = $request->input('name');
            $customer->phone_number = $request->input('phone_number');
            $customer->address = $request->input('address');

            $customer->update();
            Session::flash('success', 'Customer updated successfully!');
            return response()->json(['status'=>1, 'msg'=>'done']);

        }
    }

    public function destroy($id){
        $customer = Customer::find($id);
        $customer->delete();
        return response()->json(['status'=>1, 'msg'=>'done', 'id' => $id]);
    }
}
