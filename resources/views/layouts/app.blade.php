@extends('layouts.skeleton')

@section('app')
    <div class="main-wrapper">
        <div class="navbar-bg"></div>
        <nav class="navbar navbar-expand-lg main-navbar">
            @include('partials.dashboard.topnav')
        </nav>
        <div class="main-sidebar">
            @include('partials.dashboard.sidebar')
        </div>

        <!-- Main Content -->
        <div class="main-content">
            @yield('content')
        </div>
        <footer class="main-footer">
            @include('partials.dashboard.footer')
        </footer>
    </div>
@endsection

@push('javascript')
    <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
@endpush

