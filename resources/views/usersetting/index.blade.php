@extends('layouts.master')

@section('content')
<div class="page-header no-gutters has-tab">
    <h2 class="font-weight-normal">Setting</h2>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#tab-account">Account</a>
        </li>
    </ul>
</div>
<div class="container">
    <div class="tab-content m-t-15">
        <div class="tab-pane fade show active" id="tab-account">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Upload Foto Profil</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.setting.save.profile.picture') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="photo" id="photo" class="form-control" accept="image/*" hidden>
                        <div class="media align-items-center">
                            <div class="avatar avatar-image  m-h-10 m-r-15" style="height: 80px; width: 80px">
                                <img id="photoarea" src="{{ (Auth()->user()->pic != null) ? \Storage::url(Auth()->user()->pic) : 'https://ui-avatars.com/api/?background=random&name=' . Str::slug(Auth()->user()->name) }}" alt="{{ Auth()->user()->name }}">
                            </div>
                            <div class="m-l-20 m-r-20">
                                <h5 class="m-b-5 font-size-18">Ubah Foto Profil</h5>
                                <p class="opacity-07 font-size-13 m-b-0">
                                    Rekomendasi: <br>
                                    120x120px Max fil size: 1MB
                                </p>
                            </div>
                            <div>
                                <button class="btn btn-tone btn-info" type="button" id="openphoto">Pilih gambar</button>
                                <button class="btn btn-tone btn-primary">Upload</button>
                                @error('photo')
                                <div class="text-danger">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="tab-content m-t-15 row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Informasi Umum</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.setting.save.user') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="font-weight-semibold" for="name">Nama lengkap</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="User Name" value="{{ Auth()->user()->name }}">
                            @error('name')
                            <div class="invalid-feedback" role="alert"> {{ $message }} </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="font-weight-semibold" for="email">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="email" value="{{ Auth()->user()->email }}">
                            @error('email')
                            <div class="invalid-feedback" role="alert"> {{ $message }} </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button class="btn btn-block btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Sunting Password</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.setting.save.password') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="font-weight-semibold" for="old_password">Password lama</label>
                            <input type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password" id="old_password" placeholder="Password lama">
                            @error('old_password')
                            <div class="invalid-feedback" role="alert"> {{ $message }} </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="font-weight-semibold" for="password">Password baru</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="password" placeholder="Password baru">
                            @error('password')
                            <div class="invalid-feedback" role="alert"> {{ $message }} </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="font-weight-semibold" for="password_confirmation">Konfirmasi password</label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" id="password_confirmation" placeholder="Konfirmasi password">
                            @error('password_confirmation')
                            <div class="invalid-feedback" role="alert"> {{ $message }} </div>
                            @enderror
                        </div>
                        <div class="form-group ml-auto">
                            <button class="btn btn-block btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    $('#openphoto').click(function() {
        $('#photo').trigger('click');
    });

    $('#photo').on('change', function() {
        setImagePreview(this);
    });

    function setImagePreview(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('#photoarea').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush