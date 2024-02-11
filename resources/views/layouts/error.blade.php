@extends('layouts.skeleton')

@section('app')
    <section class="section">
        <div class="container mt-5">
            <div class="page-error">
                <div class="page-inner">
                    <h1>@yield('code')</h1>
                    <div class="page-description">
                        @yield('message')
                    </div>
                    <div class="page-search">
                        <div class="mt-3">
                            <a href="{{url('/')}}">Back to Home</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="simple-footer mt-5">
                Copyright &copy; {{config('app.name')}} &mdash; {{date('Y')}}
            </div>
        </div>
    </section>
@endsection
