@extends('layouts.auth')

@section('content')
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-6 col-md-6">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="flash-message text-center">
                                @include('flash_message')
                            </div>
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                                </div>
                                <form class="user" id="register-form" method="POST" action="{{ route('register.store') }}">
                                    @csrf
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="text" name="first_name" class="form-control form-control-user" id="exampleFirstName"
                                                   placeholder="First Name">
                                            @if ($errors->has('first_name'))
                                                <small class="text-danger mb-3">{{ $errors->first('first_name') }}</small>
                                            @endif
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="text" name="last_name" class="form-control form-control-user" id="exampleLastName"
                                                   placeholder="Last Name">
                                            @if ($errors->has('last_name'))
                                                <small class="text-danger mb-3">{{ $errors->first('last_name') }}</small>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control form-control-user" id="exampleInputEmail"
                                               placeholder="Email Address">
                                        @if ($errors->has('email'))
                                            <small class="text-danger mb-3">{{ $errors->first('email') }}</small>
                                        @endif
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="password" name="password" class="form-control form-control-user"
                                                   id="exampleInputPassword" placeholder="Password">
                                            @if ($errors->has('password'))
                                                <small class="text-danger mb-3">{{ $errors->first('password') }}</small>
                                            @endif
                                        </div>
                                        <div class="col-sm-6">
                                            <input type="password" name="confirm_password" class="form-control form-control-user"
                                                   id="exampleRepeatPassword" placeholder="Repeat Password">
                                            @if ($errors->has('confirm_password'))
                                                <small class="text-danger mb-3">{{ $errors->first('confirm_password') }}</small>
                                            @endif
                                        </div>
                                    </div>
                                    <button type="submit" href="login.html" class="btn btn-primary btn-user btn-block">
                                        Register Account
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="forgot-password.html">Forgot Password?</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="{{ route('login') }}">Already have an account? Login!</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            // flash message show
            setTimeout(function(){
                $("#alert").fadeOut(800);
            }, 4000);
        })
    </script>
@endsection
