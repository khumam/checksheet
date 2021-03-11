@extends('layouts.app')

@section('content')
<div class="row align-items-center w-100">
    <div class="col-md-7 col-lg-5 m-h-auto">
        <div class="card shadow-lg">
            <div class="card-body">
                <div class="d-flex align-items-center justify-content-between m-b-30">
                    <img class="img-fluid" alt="" src="{{ url('assets/images/logo/logo.png') }}">
                    <h2 class="m-b-0">Reset Password</h2>
                </div>
                @if (session('status'))
                <div class="alert alert-success my-2" role="alert">
                    {{ session('status') }}
                </div>
                @endif
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="form-group">
                        <label class="font-weight-semibold" for="email">Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                        @error('email')
                        <div class="invalid-feedback" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <div class="d-flex align-items-center justify-content-between">
                            <button class="btn btn-primary" type="submit">Send Reset Password Link</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection