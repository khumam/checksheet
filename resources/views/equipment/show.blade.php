@extends('layouts.master') @section('content') @include('components.breadcrumb',
['title' => 'Kelola Equipment', 'lists' => ['Home' => '/', 'Equipment' => route('admin.equipment.index'),
'Detail' => '#']])

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h3 class="card-title">{{ $equipment->name }}</h3>
			</div>
			<div class="card-body">
				<table class="table table-bordered">
					<thead>
						<th>Deskripsi</th>
						<th>Satuan</th>
						<th>Standard</th>
					</thead>
					<tbody>
						@foreach($equipment->descriptions as $desc)
						<tr>
							<td>{{ $desc->desc }}</td>
							<td>{{ $desc->satuan }}</td>
							<td>{{ $desc->standard }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection
