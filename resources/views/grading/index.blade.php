@extends('layouts.master')
@push('css')
<link href="{{ url('assets/vendors/datatables/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@endpush
@section('content')
@include('components.breadcrumb', ['title' => 'Kelola Grading', 'lists' => ['Home' => '/', 'Grading' => '#']])

<div class="row">
    <div class="col-md-12 mb-4 d-flex justify-content-between align-items-end">
			<div class="d-flex align-items-end">
				<div class="form-group mb-0">
					<label for="date">Pilih periode</label>
					<input type="month" name="date" id="date" placeholder="Pilih periode" value="{{ $period }}" class="form-control" required>
				</div>
				<div class="form-group mb-0">
					<button class="ml-3 btn btn-primary" onclick="changePeriod()">Ubah periode</button>
				</div>
			</div>
			<div class="text-right">
				<a href="{{ route('admin.grading.create') }}" class="btn btn-success">Tambah data</a>
			</div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h3 class="text-center mb-5">LAPORAN GRADING PER {{ \Carbon\Carbon::parse($period)->locale('id')->format('F, Y') }}</h3>
								<div class="table-responsive">
									<table class="table table-bordered">
										<thead>
											<tr>
												<th class="text-center">Tanggal</th>
												@foreach($parameters as $parameter => $value)
												<th class="text-center">{{ $value['name'] }}</th>
												@endforeach
												<th rowspan="2">Action</th>
											</tr>
											<tr>
												<th class="text-center">Target</th>
												@foreach($parameters as $parameter => $value)
												<th class="text-center">{{ $value['target'] }}</th>
												@endforeach
											</tr>
										</thead>
										<tbody>
											@foreach($fullMonth as $month)
											<tr>
												<td class="text-center">{{ \Carbon\Carbon::parse($month)->format('d') }}</td>
												@foreach($parameters as $parameter => $value)
												@if(isset($reports[\Carbon\Carbon::parse($month)->format('Y-m-d')]))
												<td class="text-center">{{ $reports[\Carbon\Carbon::parse($month)->format('Y-m-d')]['data'][$parameter] }}</td>
												@else
												<td></td>
												@endif
												@endforeach
												@if(isset($reports[\Carbon\Carbon::parse($month)->format('Y-m-d')]))
												@php $id = $reports[\Carbon\Carbon::parse($month)->format('Y-m-d')]['id'] @endphp
												<td class="text-center">
													<div class="btn-group">
														<a href="{{ route('admin.grading.edit', $id) }}" class="btn btn-warning btn-sm">
															<i class='anticon anticon-edit'></i>
														</a>
														<button class='btn btn-danger btn-sm deleteButton' data-id='{{ $id }}' data-form='#userDeleteButton{{ $id }}'>
															<i class='anticon anticon-delete'></i>
														</button>
														<form id='userDeleteButton{{ $id }}' action='{{ route("admin.grading.destroy", $id) }}' method='POST'>
															@csrf
															@method('DELETE')
														</form>
													</div>
												</td>
												@else
												<td></td>
												@endif
											</tr>
											@endforeach
										</tbody>
									</table>
								</div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
	function changePeriod() {
		const date = $('#date').val().split('-');
		window.location.href = `{{ route('admin.grading.index') }}/${date[0]}/${date[1]}`;
	}
</script>
@endpush
