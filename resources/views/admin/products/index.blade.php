@extends('layouts.main')

@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="product-dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Purchase Price</th>
                        <th>Sales Price</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Purchase Price</th>
                        <th>Sales Price</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')

    <script>
        $("#product-dataTable").DataTable({
            processing : true,
            serverSide: true,
            ajax : "{{ route('products.list') }}",
            columns : [
                {data : 'name', name : 'name'},
                {data : 'description', name : 'description'},
                {data : 'quantity', name : 'quantity'},
                {data : 'purchase_price', name : 'purchase_price'},
                {data : 'sales_price', name : 'sales_price'},
                {data : 'action', name : 'action'},
            ]
        });
    </script>

@endsection
