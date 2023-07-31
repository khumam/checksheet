@extends('layouts.master')
@section('content')
@include('components.breadcrumb', ['title' => 'Kelola Checksheet', 'lists' => ['Home' => '/', 'Checksheet' => '#', 'Create' => '#']])

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.checksheet.store') }}" method="POST" enctype="multipart/form-data">
                  @csrf
									<div class="row">
										<div class="col">
											<div class="form-group">
												<label for="date">Tanggal</label>
												<input type="date" id="date" name="date" class="form-control @error('date') is-invalid @enderror" placeholder="" value="{{ old('date') }}" required>
												@error('date')
													<div class="invalid-feedback" role="alert">
														{{ $message }}
													</div>
												@enderror
											</div>
										</div>
										<div class="col">
											<div class="form-group">
												<label for="location">Lokasi</label>
												<input type="location" id="location" name="location" class="form-control @error('location') is-invalid @enderror" placeholder="Lokasi" value="{{ old('location') }}" required>
												@error('location')
													<div class="invalid-feedback" role="alert">
														{{ $message }}
													</div>
												@enderror
											</div>
										</div>
									</div>
									<div class="form-group">
										<label for="created_by">Dibuat oleh</label>
										<input type="created_by" id="created_by" name="created_by" class="form-control @error('created_by') is-invalid @enderror" placeholder="Dibuat oleh" value="{{ old('created_by') }}" required>
										@error('created_by')
											<div class="invalid-feedback" role="alert">
												{{ $message }}
											</div>
										@enderror
									</div>
									<div class="form-group">
										<label for="checked_by">Diperiksa oleh (pisahkan dengan koma)</label>
										<input type="checked_by" id="checked_by" name="checked_by" class="form-control @error('checked_by') is-invalid @enderror" placeholder="Nama 1, Nama 2, dst" value="{{ old('checked_by') }}" required>
										@error('checked_by')
											<div class="invalid-feedback" role="alert">
												{{ $message }}
											</div>
										@enderror
									</div>
									<div class="form-group">
										<button class="btn btn-success">Tambah Laporan</button>
									</div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
