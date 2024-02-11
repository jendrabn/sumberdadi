@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Users</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">List of all users</h2>
            <p class="section-lead">This page is for managing users.</p>
            <div class="card">
                <div class="card-header">
                    <h4>List of all users</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        {{ $dataTable->table() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('javascript')
    {{ $dataTable->scripts() }}
@endpush
