@extends('layouts.app')

@section('content')
<div class="row align-items-center w-100">
    <div class="col-md-7 col-lg-5 m-h-auto">
        <div class="card shadow-lg">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between m-b-30">
                    <img class="img-fluid" alt="" src="assets/images/logo/logo.png">
                    <h2 class="m-b-0">Sign In</h2>
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label class="font-weight-semibold" for="email">Email</label>
                        <div class="input-affix">
                            <i class="prefix-icon anticon anticon-user"></i>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                        </div>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="font-weight-semibold" for="password">Password</label>
                        <a class="float-right font-size-13 text-muted" href="{{ route('reset_password_confirm') }}">Forget Password?</a>
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
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="font-size-13 text-muted">
                                Don't have an account?
                                <a class="small" href="{{ route('register') }}"> Signup</a>
                            </span>
                            <button class="btn btn-primary" type="submit">Sign In</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection