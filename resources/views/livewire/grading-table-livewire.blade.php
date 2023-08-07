<div class="card">
	<div class="card-header">
		<h4 class="card-title">Grading table</h4>
	</div>
	<div class="card-body">
		<table class="table table-bordered">
			<thead>
				<th>Parameter</th>
				<th>Average</th>
			</thead>
			<tbody>
				@forelse($data as $type => $value)
				<tr>
					<td>{{ \Str::ucfirst(\Str::replace('_', '', $type)) }}</td>
					<td>{{ $value }}%</td>
				</tr>
				@empty
				<tr>
					<td class="text-center" colspan="2">Tidak ada data</td>
				</tr>
				@endforelse
			</tbody>
		</table>
	</div>
</div>
