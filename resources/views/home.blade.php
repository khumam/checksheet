@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-md-6 mb-3">
        <livewire:grading-chart-livewire></livewire:grading-chart-livewire>
    </div>
    <div class="col-md-6 mb-3">
        <livewire:grading-table-livewire></livewire:grading-table-livewire>
    </div>
    <div class="col-md-6 mb-3">
        <livewire:losses-report-livewire></livewire:losses-report-livewire>
    </div>
    <div class="col-md-6 mb-3">
        <livewire:oer-management-livewire></livewire:oer-management-livewire>
    </div>
    <div class="col-md-6 mb-3">
        <livewire:scoring-livewire></livewire:scoring-livewire>
    </div>
</div>
@endsection
