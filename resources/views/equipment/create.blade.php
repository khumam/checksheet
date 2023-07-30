@extends('layouts.master')
@section('content')
@include('components.breadcrumb', ['title' => 'Kelola Equipment', 'lists' => ['Home' => '/', 'Equipment' => route('admin.equipment.index'), 'Create' => '#']])

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.equipment.store') }}" method="POST" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group">
                    <label for="name">Nama Equipment</label>
                    <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nama Equipment" value="{{ old('name') }}" required>
                    @error('name')
                      <div class="invalid-feedback" role="alert">
                        {{ $message }}
                      </div>
                    @enderror
                  </div>
									<div id="descArea">
										<div class="card">
											<div class="card-body">
												<div class="row">
													<div class="col">
														<div class="form-group">
															<label for="desc">Deskripsi</label>
															<input type="text" id="desc" name="desc[]" class="form-control @error('desc') is-invalid @enderror" placeholder="Deskripsi" required>
														</div>
													</div>
													<div class="col">
														<div class="form-group">
															<label for="satuan">Satuan</label>
															<input type="text" id="satuan" name="satuan[]" class="form-control @error('satuan') is-invalid @enderror" placeholder="Deskripsi" required>
														</div>
													</div>
													<div class="col">
														<div class="form-group">
															<label for="standard">Standard</label>
															<input type="text" id="standard" name="standard[]" class="form-control @error('standard') is-invalid @enderror" placeholder="Deskripsi" required>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<button type="button" class="btn btn-default btn-block" onclick="addNewDesc()">Tambah Deskripsi</button>
									</div>
									<div class="form-group">
										<button class="btn btn-success">Tambahkan Equipment</button>
									</div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
	function addNewDesc() {
		const increment = $('#descArea').length;
		const randomId = `desc${increment + 1}`;
		const element = `<div class="card mt-3" id="${randomId}">
											<div class="card-body">
												<div class="row">
													<div class="col text-right mb-3">
														<button class="btn btn-danger" type="button" onclick="deleteRowDescription('${randomId}')">Hapus</button>
													</div>
												</div>
												<div class="row">
													<div class="col">
														<div class="form-group">
															<label for="desc">Deskripsi</label>
															<input type="text" id="desc" name="desc[]" class="form-control @error('desc') is-invalid @enderror" placeholder="Deskripsi" required>
														</div>
													</div>
													<div class="col">
														<div class="form-group">
															<label for="satuan">Satuan</label>
															<input type="text" id="satuan" name="satuan[]" class="form-control @error('satuan') is-invalid @enderror" placeholder="Deskripsi" required>
														</div>
													</div>
													<div class="col">
														<div class="form-group">
															<label for="standard">Standard</label>
															<input type="text" id="standard" name="standard[]" class="form-control @error('standard') is-invalid @enderror" placeholder="Deskripsi" required>
														</div>
													</div>
												</div>
											</div>
										</div>`;
		$('#descArea').append(element);
	}

	function deleteRowDescription(elementId) {
		$(`#${elementId}`).remove();
	}
</script>
@endpush
