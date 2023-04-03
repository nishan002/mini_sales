@extends('layouts.main')

@section('content')
    <h3>Create Sales</h3>
    <div class="alert alert-success" id="success-alert" style="display:none; text-align:center;">
        <button type="button" class="btn close" style="width: 20px !important" data-dismiss="alert">x</button>
        <strong id="success-message" style="text-align:center"></strong>
    </div>
    <form id="sales-form" method="POST" action="{{ route('sales.store') }}">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Customer</label>
                    <div class="col-sm-7">
                        <select class="form-control" name="customer_id" id="customer-select">
                            <option value="">Select Customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger small error-text customer_id_error" ></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#customerModal">Create Customer</button>
                </div>
            </div>
        </div>
        <hr>
        <div class="product-field-set-wrapper">
            <div class="row content-wrapper">
                <div class="col-md-5">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Product</label>
                        <div class="col-sm-7">
                            <select class="form-control" name="product_id[]" id="product-select">
                                <option value="">Select Product</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger small error-text product_id_error" ></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group row">
                        <label class="col-sm-3 col-form-label">Quantity</label>
                        <div class="col-sm-7">
                            <input type="number" name="quantity[]" class="form-control mb-2"/>
                            <span class="text-danger small error-text quantity_error" ></span>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-2">
                    <a href="javascript:void(0);" class="add_button btn btn-info btn-sm">Add More</a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 text-center">
                <button id="submit" type="submit" class="btn btn-primary btn-rounded btn-fw"><i id="load" style="display: none" class="fa fa-spinner fa-spin"></i> <span id="submit-text">Submit</span></button>
            </div>
        </div>
    </form>

    <!-- Customer Create Modal-->
    <div class="modal fade" id="customerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Customer</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="customer-form" method="POST" action="{{ route('customers.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Customer Name</label>
                                    <div class="col-sm-7">
                                        <input type="text" name="name" class="form-control mb-2"/>
                                        <span class="text-danger small error-text name_error" ></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Phone Number</label>
                                    <div class="col-sm-7">
                                        <input type="text" name="phone_number" class="form-control mb-2"/>
                                        <span class="text-danger small error-text phone_number_error" ></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row content-wrapper">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Address</label>
                                    <div class="col-sm-7">
                                        <input type="text" name="address" class="form-control mb-2"/>
                                        <span class="text-danger small error-text address_error" ></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 text-center">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                <button id="customer-form-submit" type="submit" class="btn btn-primary btn-rounded btn-fw"><i id="load" style="display: none" class="fa fa-spinner fa-spin"></i> <span id="submit-text">Submit</span></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    {{--  Form subitting using ajax   --}}
    <script>
        $("#sales-form").on('submit', function(e) {
            $("#submit-text").css("display", "none");
            $("#load").css("display", "block");
            $("#submit").prop("disabled", true);
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: new FormData(this),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function () {
                    $(document).find('span.error-text').text('');
                },
                success: function (data) {
                    if (data.status === 0) {
                        console.log(data.error)
                        $.each(data.error, function(prefix, val){
                            error_name = prefix.split('.')[0];
                            error_index = prefix.split('.')[1];

                            console.log(error_name)
                            if(error_name == 'product_id' || error_name == 'quantity'){
                                $($('.content-wrapper')[error_index]).find('span.'+error_name+'_error').text(val[0]);
                            }
                            else{
                                $('span.'+error_name+'_error').text(val[0])
                            }
                        });
                    } else {
                        window.location.href = "{{ route('sales.index') }}"
                    }
                },
            }).done(() => {
                $("#submit").prop("disabled", false);
                $("#submit-text").css("display", "block");
                $("#load").css("display", "none");
            })
        })
    </script>

    <!-- Adding more product and quantity field -->
    <script>
        function increaseValue() {
            var value = parseInt(document.getElementById('number').value, 10);
            value = isNaN(value) ? 0 : value;
            value++;
            document.getElementById('number').value = value;
        }

        function decreaseValue() {
            var value = parseInt(document.getElementById('number').value, 10);
            value = isNaN(value) ? 0 : value;
            value < 1 ? value = 1 : '';
            value--;
            document.getElementById('number').value = value;
        }

        $(document).ready(function(){
            var maxField = 30; //Input fields increment limitation
            var addButton = $('.add_button'); //Add button selector
            var wrapper = $('.product-field-set-wrapper'); //Input field wrapper
            var x = 1; //Initial field counter is 1

            //Once add button is clicked
            $(addButton).click(function(){
                var productFieldsHTML = `  <div class="row content-wrapper">
                                                    <div class="col-md-5">
                                                        <div class="form-group row">
                                                            <label class="col-sm-3 col-form-label">Product</label>
                                                            <div class="col-sm-7">
                                                                <select class="form-control" name="product_id[]" id="product-select">
                                                                    <option value="">Select Product</option>
                                                                    @foreach($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                                    @endforeach
                                                    </select>
                                                    <span class="text-danger small error-text product_id_error" ></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Quantity</label>
                                                <div class="col-sm-7">
                                                    <input type="number" name="quantity[]" class="form-control mb-2"/>
                                                    <span class="text-danger small error-text quantity_error" ></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <a href="javascript:void(0);" class="remove_button btn btn-danger btn-sm">Remove</a>
                                        </div>
                                    </div>`; //New input field html
                        //Check maximum number of input fields
                        if(x < maxField){
                        x++; //Increment field counter
                        $(wrapper).append(productFieldsHTML); //Add field html
                    }
                });

                //Once remove button is clicked
                $(wrapper).on('click', '.remove_button', function(e){
                e.preventDefault();
                $(this).parent().parent('div').remove(); //Remove field html
                x--; //Decrement field counter
            });
        });

    </script>

    <script>
        $("#customer-form").on('submit', function(e) {
            $("#submit-text").css("display", "none");
            $("#load").css("display", "block");
            $("#submit").prop("disabled", true);
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: $(this).attr('method'),
                data: new FormData(this),
                processData: false,
                dataType: 'json',
                contentType: false,
                beforeSend: function () {
                    $(document).find('span.error-text').text('');
                },
                success: function (data) {
                    if (data.status === 0) {
                        console.log(data.error)
                        $.each(data.error, function(prefix, val){
                            error_name = prefix.split('.')[0];
                            error_index = prefix.split('.')[1];
                            $('span.'+error_name+'_error').text(val[0])
                        });
                    } else {
                        $("#customerModal").modal('hide')
                        $("#success-message").text(data.msg)
                        $("#success-alert").fadeIn(800);
                        setTimeout(function(){
                            $("#success-alert").fadeOut();
                        }, 5000);
                        $(".close").click(function(){
                            $("#success-alert").fadeOut(800);
                        });
                    }
                },
            }).done(() => {
                $("#customer-form-submit").prop("disabled", false);
                $("#submit-text").css("display", "block");
                $("#load").css("display", "none");
            })
        })
    </script>
@endsection
