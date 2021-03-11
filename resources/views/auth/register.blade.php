@extends('layouts.app')

@section('content')
<div class="row align-items-center w-100">
    <div class="col-md-7 col-lg-5 m-h-auto">
        <div class="card shadow-lg">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between m-b-30">
                    <img class="img-fluid" alt="" src="assets/images/logo/logo.png">
                    <h2 class="m-b-0">Sign Up</h2>
                </div>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-group">
                        <label class="font-weight-semibold" for="name">Name</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Name">
                        @error('name')
                        <div class="invalid-feedback" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="font-weight-semibold" for="email">Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email">
                        @error('email')
                        <div class="invalid-feedback" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="font-weight-semibold" for="password">Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">
                        @error('password')
                        <div class="invalid-feedback" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="font-weight-semibold" for="password-confirm">Confirm Password</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                    </div>
                    <div class="form-group">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="font-size-13 text-muted">
                                Have an account?
                                <a class="small" href="{{ route('login') }}"> Sign in</a>
                            </span>
                            <button class="btn btn-primary" type="submit">Sign Up</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection