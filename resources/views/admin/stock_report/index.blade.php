@extends('layouts.main')

@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-md-9">
                    <h6 class="m-0 font-weight-bold text-primary">Stock Report Table</h6>
                </div>
                <div class="col-md-3">
                    <a class="btn btn-success" href="{{ route('stock_report.pdf') }}">Download Report</a>
                </div>
            </div>


        </div>
        <div class="flash-message text-center">
            @include('flash_message')
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="sale-dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Quantity Sold</th>
                        <th>Current Stock</th>
                        <th>Purchase Price</th>
                        <th>Sales Price</th>
                        <th>Total Current Stock Sales Price</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('script')

    <script>
        // flash message show
        setTimeout(function(){
            $("#alert").fadeOut(800);
        }, 4000);

        $("#sale-dataTable").DataTable({
            processing : true,
            serverSide: true,
            ajax : "{{ route('stock_report.list') }}",
            columns : [
                {data : 'name', name : 'name'},
                {data : 'quantity_sold'},
                {data : 'quantity', name : 'quantity'},
                {data : 'purchase_price', name : 'purchase_price'},
                {data : 'sales_price', name : 'sales_price'},
                {data : 'total_current_stock_sales_price', name : 'total_current_stock_sales_price'},
            ]
        });
    </script>

@endsection
