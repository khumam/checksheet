<div class="card">
    <div class="card-header">
			<h4 class="card-title">
				Scoring
			</h4>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-bordered">
					<thead>
						<th>Stasiun</th>
						<th>Score</th>
					</thead>
					<tbody>
						@foreach($scorings as $category => $value)
						<tr>
							<td>{{ $category }}</td>
							<td>{{ $value }}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
</div>
