@extends('layouts.app')

@section('title', 'Manage Products')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Community Products</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">List of Community Products</h2>
            <p class="section-lead">This page is for managing community products.</p>
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Community Products</h4>
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
