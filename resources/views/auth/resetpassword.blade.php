@extends('layouts.app')

@section('content')
<div class="row align-items-center w-100">
    <div class="col-md-7 col-lg-5 m-h-auto">
        <div class="card shadow-lg">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between m-b-30">
                    <img class="img-fluid" alt="" src="assets/images/logo/logo.png">
                    <h2 class="m-b-0">Reset password</h2>
                </div>
                <form method="POST" action="{{ route('reset_password') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="form-group">
                        <label class="font-weight-semibold" for="password">New password</label>
                        <div class="input-affix">
                            <i class="prefix-icon anticon anticon-user"></i>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" required autofocus placeholder="New password">
                        </div>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="font-weight-semibold" for="password_confirmation">Confirm new password</label>
                        <div class="input-affix">
                            <i class="prefix-icon anticon anticon-user"></i>
                            <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" value="{{ old('password_confirmation') }}" required autofocus placeholder="Confirm new password">
                        </div>
                        @error('password_confirmation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="d-flex align-items-center justify-content-between">
                            <button class="btn btn-primary" type="submit">Change Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection