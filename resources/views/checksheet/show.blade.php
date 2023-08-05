@extends('layouts.master') @section('content') @include('components.breadcrumb',
['title' => 'Kelola Checksheet', 'lists' => ['Home' => '/', 'Checksheet' => '#',
'Detail' => '#']])

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<h3 class="text-center">CHECK SHEET PROCES & INSTRUMENTATION</h3>
				<table class="table mt-5 table-bordered">
					<tr>
						<td style="font-weight: 600">Tanggal</td>
						<td>{{ $checksheet->date }}</td>
					</tr>
					<tr>
						<td style="font-weight: 600; width: 100px">Lokasi</td>
						<td>{{ $checksheet->location }}</td>
					</tr>
					<tr>
						<td style="font-weight: 600; width: 100px">Dibuat</td>
						<td>{{ $checksheet->created_by }}</td>
					</tr>
					<tr>
						<td style="font-weight: 600; width: 100px">Diperiksa</td>
						<td>{{ $checksheet->checked_by }}</td>
					</tr>
				</table>
				<a href="{{ route('admin.checksheet.uploadpage', $checksheet->id) }}" class="btn btn-primary">Detail Bukti</a>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-body">
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<th style="font-weight: 600">No</th>
							<th style="font-weight: 600">Station / Equipment</th>
							<th style="font-weight: 600">Description</th>
							<th style="font-weight: 600">Satuan</th>
							<th style="font-weight: 600">Standard</th>
							@foreach($periodData as $period)
							<th style="font-weight: 600">{{ $period }}</th>
							@endforeach
							<th style="font-weight: 600">Rata-rata hari ini</th>
							<th style="font-weight: 600">Keterangan</th>
						</thead>
						<tbody>
							@foreach(json_decode($checksheet->descs) as $desc => $detail) @php
							$iteration = $loop->iteration @endphp @foreach($detail as
							$descItem)
							<tr>
								@if($loop->first)
								<td rowspan="{{ count($detail) }}">{{ $iteration }}</td>
								<td rowspan="{{ count($detail) }}">{{ $desc }}</td>
								@endif
								<td>{{ $descItem->desc }}</td>
								<td>{{ $descItem->satuan }}</td>
								<td>{{ $descItem->standard }}</td>
								@php $total = 0 @endphp
								@foreach(json_decode($checksheet->reports,
								true)[$descItem->equipment_id][$descItem->id] as $key => $value)
								@php $total += array_values($value)[0] @endphp
								<td>
									<input
										type="number"
										step="0.01"
										data-equipmentid="{{ $descItem->equipment_id }}"
										data-descid="{{ $descItem->id }}"
										data-time="{{ array_keys($value)[0] }}"
										placeholder="Nilai"
										required
										class="form-control"
										style="width: 80px"
										value="{{ array_values($value)[0] }}"
										onchange="updateRow(this)"
									/>
								</td>
								@endforeach
								<td>{{ number_format($total / count($periodData), 3) }}</td>
								<td>
									<input
										type="text"
										step="0.01"
										data-equipmentid="{{ $descItem->equipment_id }}"
										data-descid="{{ $descItem->id }}"
										placeholder="Keterangan"
										required
										class="form-control"
										style="width: 80px"
										value="{{ $descItem->keterangan }}"
										onkeyup="updateKeterangan(this)"
									/>
								</td>
							</tr>
							@endforeach @endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection @push('js')
<script>
	function updateRow(inputElement) {
		const equipmentId = $(inputElement).data("equipmentid");
		const descId = $(inputElement).data("descid");
		const checksheetId = "{{ $checksheet->id }}";
		const time = $(inputElement).data("time");
		const value = $(inputElement).val();

		$.ajax({
			url: "{{ route('admin.checksheet.updatetimerow') }}",
			headers: {
				"X-CSRF-TOKEN": "{{ csrf_token() }}",
			},
			method: "POST",
			data: {
				equipment_id: equipmentId,
				desc_id: descId,
				value: value,
				time: time,
				checksheet_id: checksheetId
			},
			success: function (res) {
				console.log(res);
			},
			error: function (err) {
				console.log(err);
			}
		});
	}

	function updateKeterangan(inputElement) {
		const equipmentId = $(inputElement).data("equipmentid");
		const descId = $(inputElement).data("descid");
		const checksheetId = "{{ $checksheet->id }}";
		const value = $(inputElement).val();

		$.ajax({
			url: "{{ route('admin.checksheet.updateketerangan') }}",
			headers: {
				"X-CSRF-TOKEN": "{{ csrf_token() }}",
			},
			method: "POST",
			data: {
				equipment_id: equipmentId,
				desc_id: descId,
				value: value,
				checksheet_id: checksheetId
			},
			success: function (res) {
				console.log(res);
			},
			error: function (err) {
				console.log(err);
			}
		});
	}
</script>
@endpush
