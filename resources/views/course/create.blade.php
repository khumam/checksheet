@extends('layouts.master')
@section('content')
@include('components.breadcrumb', ['title' => 'Kelola Course', 'lists' => ['Home' => '/', 'Course' => '#', 'Create' => '#']])

<div class="row">
	<div class="col-md-6">
		<div class="card">
			<div class="card-body">
				<form action="{{ route('admin.course.store') }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group">
						<label for="course_name">Course name</label>
						<input type="text" id="course_name" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Course name" value="{{ old('name') }}" required>
						@error('name')
						<div class="invalid-feedback" role="alert">
							{{ $message }}
						</div>
						@enderror
					</div>
					<div class="form-group">
						<label for="course_trailer">Course trailer</label>
						<input type="text" id="course_trailer" name="trailer" class="form-control @error('trailer') is-invalid @enderror" placeholder="Course trailer" value="{{ old('trailer') }}" required>
						@error('trailer')
						<div class="invalid-feedback" role="alert">
							{{ $message }}
						</div>
						@enderror
					</div>
					<div class="form-group">
						<label for="course_desc">Course description</label>
						<textarea type="text" id="course_desc" name="desc" class="form-control @error('desc') is-invalid @enderror" placeholder="Course description" required>{{ old('desc') }}</textarea>
						@error('desc')
						<div class="invalid-feedback" role="alert">
							{{ $message }}
						</div>
						@enderror
					</div>
					<div class="form-group">
						<label for="course_banner">Course banner</label>
						<input type="file" id="course_banner" name="banner" class="form-control @error('banner') is-invalid @enderror" placeholder="Course banner" value="{{ old('banner') }}" required>
						@error('banner')
						<div class="invalid-feedback" role="alert">
							{{ $message }}
						</div>
						@enderror
					</div>
					<div class="form-group">
						<button class="btn btn-success">Add new course</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
