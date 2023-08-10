@extends('layouts.master')
@section('content')
@include('components.breadcrumb', ['title' => 'Kelola Loss', 'lists' => ['Home' => '/', 'Loss' => '#', 'Detail' => '#']])

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="text-center">REKAP ANALISA HARIAN</h4>
								<table class="table mt-5 table-bordered">
									<tr>
										<td style="font-weight: 600">Tanggal</td>
										<td>{{ \Carbon\Carbon::parse($loss->date)->format('d F Y') }}</td>
									</tr>
									<tr>
										<td style="font-weight: 600; width: 100px">Hari</td>
										<td>{{ \Carbon\Carbon::parse($loss->date)->dayName }}</td>
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
				<div class="table-responsive">
					<table class="table table-bordered">
						<thead>
							<th>No</th>
							<th>Item</th>
							<th>Detail</th>
							<th>Standard Losses</th>
							<th>O/WM</th>
							<th>Mass Balance (MB)</th>
							<th>Hasil</th>
						</thead>
						<tbody>
							@php $no = 1 @endphp
							@foreach($reports as $detail => $item)
							@foreach($item as $itemName => $value)
							<tr>
								<td>{{ $no++ }}</td>
								<td>{{ $itemName }}</td>
								@if($loop->first)
								<td rowspan="{{ count($item) }}">{{ $detail }}</td>
								@endif
								<td>{{ $value['standard_losses'] }}</td>
								<td>
									<input
										type="number"
										step="0.01"
										data-detail="{{ $detail }}"
										data-item="{{ $itemName }}"
										data-name="o/wm"
										placeholder="Nilai"
										required
										class="form-control"
										style="width: 80px"
										value="{{ $value['o/wm'] }}"
										onchange="updateRow(this)"
									/>
								</td>
								<td>
									<input
										type="number"
										step="0.01"
										data-detail="{{ $detail }}"
										data-item="{{ $itemName }}"
										data-name="mass_balance"
										placeholder="Nilai"
										required
										class="form-control"
										style="width: 80px"
										value="{{ $value['mass_balance'] }}"
										onchange="updateRow(this)"
									/>
								</td>
								<td>
									<input
										type="number"
										step="0.01"
										data-detail="{{ $detail }}"
										data-item="{{ $itemName }}"
										data-name="hasil"
										placeholder="Nilai"
										required
										class="form-control"
										style="width: 80px"
										value="{{ $value['hasil'] }}"
										onchange="updateRow(this)"
									/>
								</td>
							</tr>
							@endforeach
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
	function updateRow(inputElement) {
		const detail = $(inputElement).data("detail");
		const item = $(inputElement).data("item");
		const name = $(inputElement).data("name");
		const value = $(inputElement).val();
		const id = "{{ $loss->id }}"

		$.ajax({
			url: "{{ route('admin.loss.updaterow') }}",
			headers: {
				"X-CSRF-TOKEN": "{{ csrf_token() }}",
			},
			method: "POST",
			data: {
				id,
				detail,
				item,
				name,
				value
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
