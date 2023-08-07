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
				@foreach($data as $type => $value)
				<tr>
					<td>{{ \Str::ucfirst(\Str::replace('_', '', $type)) }}</td>
					<td>{{ $value }}%</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>
