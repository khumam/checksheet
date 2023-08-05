@extends('layouts.master')
@section('content')
@include('components.breadcrumb', ['title' => 'Kelola Grading', 'lists' => ['Home' => '/', 'Grading' => '#', 'Edit' => '#']])

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.grading.update', $grading) }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method("PUT")
                  <div class="form-group">
                    <label for="date">Tanggal</label>
                    <input type="date" id="date" name="date" class="form-control @error('date') is-invalid @enderror" placeholder="" value="{{ \Carbon\Carbon::parse($grading->date)->format('Y-m-d') }}" required>
                    @error('date')
                      <div class="invalid-feedback" role="alert">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
									@foreach($parameters as $parameter => $value)
									<div class="form-group">
                    <label for="{{ $parameter }}">{{ $value['name'] }}</label>
                    <input type="number" step="0.01" id="{{ $parameter }}" name="{{ $parameter }}" class="form-control @error('{{ $parameter }}') is-invalid @enderror" placeholder="{{ $value['name']  }} ({{ $value['target'] }})" value="{{ $data[$parameter] }}" required>
                    @error('{{ $parameter }}')
                      <div class="invalid-feedback" role="alert">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
									@endforeach
									<div class="form-group">
										<button class="btn btn-success">Simpan data</button>
									</div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
