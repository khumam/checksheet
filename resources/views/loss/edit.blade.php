@extends('layouts.master')
@section('content')
@include('components.breadcrumb', ['title' => 'Kelola Loss', 'lists' => ['Home' => '/', 'Loss' => '#', 'Edit' => '#']])

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.loss.update', $loss) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method("PUT")
                  <div class="form-group">
                    <label for="date">Date</label>
                    <input type="date" id="date" name="date" class="form-control @error('date') is-invalid @enderror" placeholder="Date" value="{{ \Carbon\Carbon::parse($loss->date)->format('Y-m-d') }}" required>
                    @error('date')
                      <div class="invalid-feedback" role="alert">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
									<div class="form-group">
										<button class="btn btn-success">Simpan data</button>
									</div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
