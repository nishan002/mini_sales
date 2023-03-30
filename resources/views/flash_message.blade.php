@if (Session::has('success'))
    <div id="alert" class="alert alert-success alert-dismissible align-items-center text-center" style="display: flex" role="alert">
        <div>
            {{ Session::get('success') }}
        </div>
    </div>
@endif

@if (Session::has('store'))
    <div id="alert" class="alert alert-success alert-dismissible align-items-center text-center" style="display: flex" role="alert">
        <div>
            {{ Session::get('success') }}
        </div>
    </div>
@endif


@if (Session::has('danger'))
    <div id="alert" class="alert alert-danger alert-dismissible align-items-center text-center" style="display: flex" role="alert">
        <div>
            {{ Session::get('danger') }}
        </div>
    </div>
@endif

@if ($message = Session::get('warning'))
    <div class="alert alert-warning alert-block">
        <strong>{{ $message }}</strong>
    </div>
@endif


@if ($message = Session::get('info'))
    <div class="alert alert-info alert-block">
        <strong>{{ $message }}</strong>
    </div>
@endif
