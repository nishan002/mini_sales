@extends('layouts.main')

@section('content')
    <h3>Create Product</h3>
    <div class="alert alert-success" id="success-alert" style="display:none; text-align:center;">
        <button type="button" class="btn close" style="width: 20px !important" data-dismiss="alert">x</button>
        <strong style="text-align:center">Product Created Successfully!</strong>
    </div>
    <form id="product-form" method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Name</label>
                    <div class="col-sm-7">
                        <input type="text" name="name" class="form-control mb-2" />
                        <span class="text-danger small error-text name_error" ></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Quantity</label>
                    <div class="col-sm-7">
                        <input type="number" name="quantity" class="form-control mb-2" min="0"/>
                        <span class="text-danger small error-text quantity_error"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Purchase Price</label>
                    <div class="col-sm-7">
                        <input type="text" name="purchase_price" class="form-control mb-2" />
                        <span class="text-danger small error-text purchase_price_error" ></span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Sales Price</label>
                    <div class="col-sm-7">
                        <input type="text" name="sales_price" class="form-control mb-2"/>
                        <span class="text-danger small error-text sales_price_error" ></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Description</label>
                    <div class="col-sm-7">
                        <textarea id="description" class="form-control" name="description" rows="12"></textarea>
                        <p id="counter" class="text-primary text-end mb-2"><span id="letter_counter">0</span>/500 <span id="text_exceeded"></span></p>
                        <span class="text-danger small error-text description_error" ></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group row">
                    <label class="col-md-3">File upload</label>
                    <div class="col-md-7">
                        <input id="input-image" type="file" name="image" class="form-control file-upload-info" placeholder="Upload Image">
                    </div>
                    <span class="text-danger small error-text image_error"></span>
                </div>

                <div class="col-md-12 mb-2">
                    <img id="preview-image-before-upload" src="https://www.riobeauty.co.uk/images/product_image_not_found.gif"
                         alt="preview image" style="max-height: 100px; opacity:.8;transition: .5s; display: none">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 text-center">
                <button id="submit" type="submit" class="btn btn-primary btn-rounded btn-fw"><i id="load" style="display: none" class="fa fa-spinner fa-spin"></i> <span id="submit-text">Submit</span></button>
            </div>
        </div>
    </form>
@endsection

@section('script')
    {{--  Form subitting using ajax   --}}
    <script>
        $("#product-form").on('submit', function(e) {
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
                        $.each(data.error, function (prefix, val) {
                            $('span.' + prefix + '_error').text(val[0]);
                        });
                    } else {
                        $("#product-form input").val('')
                        $('html, body').animate({ scrollTop: 0 }, 0);
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
                $("#submit").prop("disabled", false);
                $("#submit-text").css("display", "block");
                $("#load").css("display", "none");
            })
        })
    </script>

    {{--  preview image--}}
    <script>
        $(document).ready(function (e) {
            $('#input-image').change(function(){
                $('#preview-image-before-upload').css("display", "block")
                let reader = new FileReader();

                reader.onload = (e) => {
                    $('#preview-image-before-upload').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });

        });
    </script>

    <!-- Description letter counter -->
    <script>

        const description = document.getElementById('description');
        const letter_counter = document.getElementById('letter_counter');
        const counter = document.getElementById('counter');
        const text_exceeded = document.getElementById('text_exceeded');

        description.addEventListener('input', () => {
            let letter_value = description.value.length;

            if(letter_value > 500){
                counter.classList.remove('text-primary');
                counter.classList.add('text-danger');
                text_exceeded.innerText = "Text limit exceeded!"
            }
            else{
                counter.classList.add('text-primary');
                counter.classList.remove('text-danger');
                text_exceeded.innerText = ""
            }
            letter_counter.innerHTML = letter_value;

        });

    </script>
@endsection
