@extends('layouts.main')

@section('content')
    <h3>Edit Customer Info</h3>
    <form id="customer-form" class="mt-5" method="POST" action="{{ route('customers.update', $customer->id) }}">
        @csrf
        <div class="row">
            <div class="col-md-8">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Customer Name</label>
                    <div class="col-sm-7">
                        <input type="text" name="name" class="form-control mb-2"  value="{{ $customer->name }}"/>
                        <span class="text-danger small error-text name_error" ></span>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Phone Number</label>
                    <div class="col-sm-7">
                        <input type="text" name="phone_number" class="form-control mb-2"  value="{{ $customer->phone_number }}"/>
                        <span class="text-danger small error-text phone_number_error" ></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row content-wrapper">
            <div class="col-md-8">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Address</label>
                    <div class="col-sm-7">
                        <input type="text" name="address" class="form-control mb-2" value="{{ $customer->address }}"/>
                        <span class="text-danger small error-text address_error" ></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 text-center">
                <button id="customer-form-submit" type="submit" class="btn btn-primary btn-rounded btn-fw"><i id="load" style="display: none" class="fa fa-spinner fa-spin"></i> <span id="submit-text">Update</span></button>
            </div>
        </div>
    </form>
@endsection

@section('script')
    {{--  Form subitting using ajax   --}}
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
                        $("#submit").prop("disabled", false);
                        $.each(data.error, function (prefix, val) {
                            $('span.' + prefix + '_error').text(val[0]);
                        });
                    } else {
                        window.location = "{{ url('/customers') }}";
                    }
                },
            }).done(() => {
                $("#submit-text").css("display", "block");
                $("#load").css("display", "none");
            })
        })
    </script>

@endsection

