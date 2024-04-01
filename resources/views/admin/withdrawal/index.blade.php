@extends('layouts.admin')

@section('title', 'Daftar Pencairan Dana')

@section('content_header')
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">Pencairan Dana</h1>
    </div>
  </div>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Daftar Pencairan Dana</h3>
        </div>
        <div class="card-body">
          @include('partials.alerts')
          <div class="table-responsive">
            {{ $dataTable->table(['class' => 'table table-bordered table-striped table-hover datatable table-sm']) }}
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
  {{ $dataTable->scripts() }}
@endpush
