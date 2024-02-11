@extends('layouts.app')

@section('title', 'Manage Communities')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Communities</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">List of all communities</h2>
            <p class="section-lead">This page is for managing communities.</p>
            <div class="card">
                <div class="card-header">
                    <h4>List of all communities</h4>
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
