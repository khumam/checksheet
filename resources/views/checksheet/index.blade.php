@extends('layouts.master')
@push('css')
<link href="{{ url('assets/vendors/datatables/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@endpush
@section('content')
@include('components.breadcrumb', ['title' => 'Kelola Checksheet', 'lists' => ['Home' => '/', 'Checksheet' => '#']])

<div class="row">
    <div class="col-md-12 mb-3 text-right">
      <a href="{{ route('admin.checksheet.create') }}" class="btn btn-success">Tambah data</a>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                {!! $datatable !!}
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="{{ url('assets/vendors/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('assets/vendors/datatables/dataTables.bootstrap.min.js') }}"></script>
{!! $datatableScript !!}
@endpush