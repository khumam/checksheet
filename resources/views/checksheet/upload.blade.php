@extends('layouts.master')
@push('css')
<link href="https://checksheet.test/assets/vendors/datatables/dataTables.bootstrap.min.css" rel="stylesheet">
@endpush

@section('content') @include('components.breadcrumb',
['title' => 'Kelola Checksheet', 'lists' => ['Home' => '/', 'Checksheet' => '#',
'Upload' => '#']])

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<h3 class="mb-3">Upload Bukti Check Sheet</h3>
				<table class="table table-bordered">
					<tr>
						<td style="font-weight: 600; width: 100px">Tanggal</td>
						<td>{{ $checksheet->date }}</td>
					</tr>
					<tr>
						<td style="font-weight: 600; width: 100px">Lokasi</td>
						<td>{{ $checksheet->location }}</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<form action="{{ route('admin.checksheet.upload', $checksheet->id) }}" method="POST" enctype="multipart/form-data">
					@csrf
					<div class="form-group">
						<label for="time">Input waktu</label>
						<input type="text" class="form-control" placeholder="08:00" id="time" name="time" required>
					</div>
					<div class="form-group">
						<label for="photo">Pilih foto</label>
						<input type="file" class="form-control" placeholder="Pilih foto" id="photo" name="photo" required>
					</div>
					<div class="form-group">
						<button class="btn btn-success">Upload foto</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<table class="table" id="datatable">
					<thead>
						<th>No</th>
						<th>Waktu</th>
						<th>Foto</th>
						<th></th>
					</thead>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection @push('js')
<script src="https://checksheet.test/assets/vendors/datatables/jquery.dataTables.min.js"></script>
<script src="https://checksheet.test/assets/vendors/datatables/dataTables.bootstrap.min.js"></script>
<script>
	$(document).ready(function() {
		var table = $("#datatable").DataTable({
			paginate:true,
			info:true,
			sort:true,
			processing:true,
			serverside:true,
			ajax:{
				headers:{"X-CSRF-TOKEN":"{{ csrf_token() }}"},
				url:"{{ route('admin.checksheet.photo.list', $checksheet->id) }}",
				method:"POST"
			},
			columns:[
				{
					data: "DT_RowIndex",
					orderable: false,
					searchable: false,
					class: "text-center",
					width: "10px"
				},
				{
					data: "time"
				},
				{
					data: "photo"
				},
				{
					data: "action",
					width: '50px',
					class: 'text-center'
				}
			]
		});
	});
</script>
@endpush
