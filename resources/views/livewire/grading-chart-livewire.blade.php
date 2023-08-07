<div class="card">
	<div class="card-header">
		<h4 class="card-title">Grading Chart</h4>
	</div>
	<div class="card-body">
		@if(count($data) > 0)
    <canvas id="gradingchart" style="display:block;margin:0 auto;"></canvas>
		@else
		<h5 class="text-center">Tidak ada data</h5>
		@endif
	</div>

	@if(count($data))
	@push('js')
	<script>
		Chart.register(ChartDataLabels);
		const ctx = document.getElementById('gradingchart');
		const data = {
			labels: @js($types),
			datasets: [{
				label: 'Average (%)',
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
					},
					datalabels: {
							anchor: 'middle',
							align: 'middle',
							font: {
									weight: 'normal',
									size: 12
							}
					}
				}
			}
		}
		const chart = new Chart(ctx, config)
	</script>
	@endpush
	@endif
</div>
