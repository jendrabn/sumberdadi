@extends('layouts.app')

@section('title', 'Daftar Pencairan Dana')

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="card card-primary">
                <div class="card-header">
                    <h4>Daftar Pencairan Dana</h4>
                </div>
                <div class="card-body">
                    @include('partials.alerts')
                    <p>Ajukan pencairan baru dengan mengklik tombol +Create</p>
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
