@extends('layouts.app')

@section('content')
<div class="row align-items-center w-100">
    <div class="col-md-7 col-lg-5 m-h-auto">
        <div class="card shadow-lg">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between m-b-30">
                    <img class="img-fluid" alt="" src="assets/images/logo/logo.png">
                    <h2 class="m-b-0">Confirm Password</h2>
                </div>
                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf
                    <div class="form-group">
                        <label class="font-weight-semibold" for="password">Password</label>
                        @if (Route::has('password.request'))
                        <a class="float-right font-size-13 text-muted" href="{{ route('password.request') }}">Forget Password?</a>
                        @endif
                        <div class="input-affix m-b-10">
                            <i class="prefix-icon anticon anticon-lock"></i>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                        </div>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="d-flex align-items-center justify-content-between">
                            <button class="btn btn-primary" type="submit">Confirm Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection