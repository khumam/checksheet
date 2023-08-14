<div class="card">
	<div class="card-header">
		<h4 class="card-title">
			Mill Profit > OER
		</h4>
	</div>
	<div class="card-body text-center">
		@if($data)
		<h1 style="font-size: 42px;">{{$value}}</h1>
		<button class="btn btn-warning btn-sm" style="color: #000000;" wire:click="hideOrShowForm"><i class="anticon anticon-edit"></i></button>
		@if(!$formHide)
		<div class="form-group mt-3">
			<input type="text" class="form-control" value="{{ $value }}" wire:model="value" wire:change="update">
		</div>
		@endif
		@else
		<p>Tidak ada data</p>
		@endif
	</div>
</div>
