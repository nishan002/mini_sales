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
                        <th>Customer Name</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Purchase Price</th>
                        <th>Sales Price</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Product Modal-->
    <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Are you sure you want to delete this item?</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <form id="product-delete-form" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

    <script>
        $("#product-dataTable").DataTable({
            processing : true,
            serverSide: true,
            ajax : "{{ route('sales.list') }}",
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

    <script>
        // get item id and add to form action
        $("body").on('click','.delete-btn' ,function(){
            let id = $(this).attr('data-id')
            $('#product-delete-form').attr('action', 'products/'+id+'/delete')
        })

        // delete item from modal
        $("#product-delete-form").on('submit', function(e){
            e.preventDefault()
            $.ajax({
                url:$(this).attr('action'),
                method:$(this).attr('method'),
                data: new FormData(this),
                processData:false,
                dataType:'json',
                contentType:false,
                beforeSend:function(){
                    $(document).find('span.error-text').text('');
                },
                success:function(data){
                    if(data.status === 1){
                        $("#productModal").modal('hide')
                        $("body .delete-btn[data-id='"+data.id+"']").parent().parent('tr').remove()
                    }
                },
            })
        })
    </script>

@endsection
