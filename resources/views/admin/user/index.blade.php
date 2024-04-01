@extends('layouts.admin')

@section('title', 'Manage Users')

@section('content_header')
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">Users</h1>
      <p class="m-0">This page is for managing users.</p>
    </div>
  </div>
@endsection

@section('content')
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">List of all users</h4>
        </div>
        <div class="card-body">
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
