@extends('layouts.app')

@section('title', 'Manage Stores')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Community Stores</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">List of Community Stores</h2>
            <p class="section-lead">This page is for managing community stores.</p>
            <div class="card card-primary">
                <div class="card-header">
                    <h4>List of community stores</h4>
                </div>
                <div class="card-body">
                    @include('partials.alerts')
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
