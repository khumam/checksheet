@extends('layouts.master')
@push('css')
<link href="{{ url('assets/vendors/datatables/dataTables.bootstrap.min.css') }}" rel="stylesheet">
@endpush
@section('content')
@include('components.breadcrumb', ['title' => 'Item', 'lists' => ['Home' => '/', 'Item' => '#']])

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4>List Item</h4>
                        <p>Di bawah ini merupakan list item yang terdata di dalam sistem.</p>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary float-right" data-toggle="modal" data-target="#itemModal">Tambah item</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <table class="table" id="datatable">
                    <thead>
                        <th>No</th>
                        <th>Nama</th>
                        <th style="width: 50px">Stok</th>
                        <th style="width: 10px; text-align: center"><i class='anticon anticon-setting'></i></th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="itemModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="itemModalLabel">Tambah item</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <i class="anticon anticon-close"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('item_store') }}" id="formdata" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name item</label>
                        <input type="text" name="name" id="name" placeholder="Nama item" required class="form-control">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="formdata" onclick="loading(this)">Simpan</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script src="{{ url('assets/vendors/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('assets/vendors/datatables/dataTables.bootstrap.min.js') }}"></script>

<script>
    $(document).ready(function() {
        var table = $('#datatable').DataTable({
            paginate: true,
            info: true,
            sort: true,
            processing: true,
            serverSide: true,
            order: [1, 'ASC'],
            ajax: {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: "{{ route('item_list') }}",
            },
            columns: [{
                    data: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    class: 'text-center',
                    width: '10px'

                },
                {
                    data: 'name',
                },
                {
                    data: 'stock',
                    class: 'text-right'
                },
                {
                    data: 'action'
                }
            ]
        });

        $(document).on('click', '.deleteButton', function() {
            Swal.fire({
                title: 'Apakah kamu yakin?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#E7472C'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ route('item_delete') }}",
                        method: 'DELETE',
                        data: {
                            id: $(this).data('id'),
                            _token: "{{ csrf_token() }}"
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(res) {
                            Swal.fire({
                                title: res.title,
                                text: res.text,
                                icon: res.icon,
                            }).then((result) => {
                                window.location.reload();
                            });
                        }
                    });
                }
            });
        })

    })

    function loading(obj) {
        $(obj).html("Menyimpan...");
    }
</script>
@endpush