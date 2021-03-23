@extends('layouts.master')

@section('content')
<div class="page-header no-gutters has-tab">
    <h2 class="font-weight-normal">{{ $detail->name }}</h2>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#tab-detail">Detail</a>
        </li>
    </ul>
</div>
<div class="container">
    <div class="tab-content m-t-15">
        <div class="tab-pane fade show active" id="tab-detail">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Detail</h4>
                </div>
                <div class="card-body">
                    <table class="product-info-table">
                        <tbody>
                            <tr>
                                <td>Nama</td>
                                <td class="text-dark font-weight-semibold">{{ $detail->name }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>{{ $detail->email }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection