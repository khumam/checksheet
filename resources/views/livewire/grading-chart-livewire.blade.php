<div class="card">
	<div class="card-header">
		<h4 class="card-title">Grading Chart</h4>
	</div>
	<div class="card-body">
    <canvas id="gradingchart" style="display:block;margin:0 auto;"></canvas>
	</div>

	@push('js')
	<script>
		const ctx = document.getElementById('gradingchart');
		const data = {
			labels: @js($types),
			datasets: [{
				label: 'Nilai',
				data: @js($data),
				backgroundColor: @js($colors),
				hoverOffset: 4
			}]
		};
		const config = {
			type: 'pie',
			data: data,
			options: {
				plugins: {
					legend: {
						position: 'right'
					}
				}
			}
		}
		const chart = new Chart(ctx, config)
	</script>
	@endpush
</div>
