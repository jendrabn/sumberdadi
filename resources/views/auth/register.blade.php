@extends('layouts.auth')

@section('title', 'Register')

@section('content')
<div class="card card-primary">
    <div class="card-header"><h4>{{ __('Register') }}</h4></div>

    <div class="card-body">
        <form method="POST" action="{{ route('register') }}" class="needs-validation">
            @csrf

            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="name">{{ __('First Name') }}</label>

                        <input id="name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="name" autofocus>

                        @error('first_name')
                        <div class="invalid-feedback" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="name">{{ __('Last Name') }}</label>

                        <input id="name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" autocomplete="last_name">

                        @error('last_name')
                        <div class="invalid-feedback" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

            </div>

            <div class="form-group">
                <label for="email">{{ __('E-Mail Address') }}</label>

                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                @error('email')
                    <div class="invalid-feedback" role="alert">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">{{ __('Password') }}</label>

                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                @error('password')
                    <div class="invalid-feedback" role="alert">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password-confirm">{{ __('Confirm Password') }}</label>

                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg btn-block">
                    {{ __('Register') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('footer')
    @if (Route::has('login'))
        <div class="mt-5 text-muted text-center">
            Already have an account? <a href="{{ route('login') }}">Login</a>
        </div>
    @endif
@endsection
