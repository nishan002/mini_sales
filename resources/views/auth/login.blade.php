@extends('layouts.auth')

@section('content')
    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-6 col-lg-6 col-md-6">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <div class="flash-message text-center">
                                @include('flash_message')
                            </div>
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                </div>
                                <form class="user" id="loginform" method="POST" action="{{ route('login.store') }}">
                                    @csrf

                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control form-control-user"
                                               id="exampleInputEmail" aria-describedby="emailHelp"
                                               placeholder="Enter Email Address...">
                                        @if ($errors->has('email'))
                                            <span class="text-danger mb-3">{{ $errors->first('email') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control form-control-user"
                                               id="exampleInputPassword" placeholder="Password">
                                        @if ($errors->has('password'))
                                            <span class="text-danger mb-3">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                    <button type="submit" href="index.html" class="btn btn-primary btn-user btn-block">
                                        Login
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="forgot-password.html">Forgot Password?</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="{{ route('register') }}">Create an Account!</a>
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
