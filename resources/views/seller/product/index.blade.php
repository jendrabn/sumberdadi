@extends('layouts.app')

@section('title', 'Daftar Produk')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Daftar Produk</h1>
        </div>
        <div class="section-body">
            <h2 class="section-title">Daftar Produk</h2>
            <p class="section-lead">Halaman ini berguna untuk melihat daftar produk dari toko Anda.</p>
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Daftar Produk</h4>
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
