@extends('layouts.master')
@section('content')
@include('components.breadcrumb', ['title' => 'View', 'lists' => ['Home' => '/', 'View' => '#']])

<div class="row">
    <div class="col-md-6">
        Test
    </div>
</div>
@endsection