@extends('layouts.main')

@section('content')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Sales Table</h6>
        </div>
        <div class="flash-message text-center">
            @include('flash_message')
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="sale-dataTable" width="100%" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Invoice ID</th>
                        <th>Customer Name</th>
                        <th>Total Amount</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Sale Modal-->
    <div class="modal fade" id="saleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
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
                    <form id="sale-delete-form" method="POST">
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
        // flash message show
        setTimeout(function(){
            $("#alert").fadeOut(800);
        }, 4000);

        $("#sale-dataTable").DataTable({
            processing : true,
            serverSide: true,
            ajax : "{{ route('sales.list') }}",
            columns : [
                {data : 'invoice_id', name : 'invoice_id'},
                {data : 'customer_name', name : 'customer_name'},
                {data : 'total_amount', name : 'total_amount'},
                {data : 'action', name : 'action'},
            ]
        });
    </script>

    <script>
        // get item id and add to form action
        $("body").on('click','.delete-btn' ,function(){
            let id = $(this).attr('data-id')
            $('#sale-delete-form').attr('action', 'sales/'+id+'/delete')
        })

        // delete item from modal
        $("#sale-delete-form").on('submit', function(e){
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
                        $("#saleModal").modal('hide')
                        $("body .delete-btn[data-id='"+data.id+"']").parent().parent('tr').remove()
                    }
                },
            })
        })
    </script>

@endsection
