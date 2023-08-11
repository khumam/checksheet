<div class="card" style="height: 100%;">
	<div class="card-header">
		<h4 class="card-title">Losses Report</h4>
	</div>
	<div class="card-body">
		<table class="table table-bordered">
			<thead>
				<th>No</th>
				<th>Kategori</th>
				<th>%Avg</th>
			</thead>
			<tbody>
				@forelse($reports as $report => $value)
				<tr>
					<td>{{ $loop->iteration }}</td>
					<td>{{ $report }}</td>
					<td>{{ $value }}</td>
				</tr>
				@empty
				<tr>
					<td colspan="3" class="text-center">Tidak ada data</td>
				</tr>
				@endforelse
			</tbody>
		</table>
	</div>
</div>
