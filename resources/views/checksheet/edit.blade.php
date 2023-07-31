@extends('layouts.master')
@section('content')
@include('components.breadcrumb', ['title' => 'Kelola Checksheet', 'lists' => ['Home' => '/', 'Checksheet' => '#', 'Edit' => '#']])

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.checksheet.update') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method("PUT")
                  <div class="form-group">
                    <label for="">Label</label>
                    <input type="text" id="" name="" class="form-control @error('') is-invalid @enderror" placeholder="" value="{{  }}" required>
                    @error('')
                      <div class="invalid-feedback" role="alert">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection