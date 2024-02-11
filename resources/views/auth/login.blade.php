@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="card card-primary">
    <div class="card-header"><h4>{{ __('Login') }}</h4></div>

    <div class="card-body">
        <form method="POST" action="{{ route('login') }}" class="needs-validation">
            @csrf

            <div class="form-group">
                <label for="email">{{ __('E-Mail Address') }}</label>

                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', 'user@jcoffee.test') }}" required autocomplete="email" autofocus>

                @error('email')
                    <div class="invalid-feedback" role="alert">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <div class="d-block">
                    <label for="password" class="control-label">{{ __('Password') }}</label>

                    @if (Route::has('password.request'))
                        <div class="float-right">
                            <a class="text-small" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        </div>
                    @endif
                </div>

                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="123" required autocomplete="current-password">

                @error('password')
                    <div class="invalid-feedback" role="alert">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                    <label class="custom-control-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary btn-lg btn-block">
                    {{ __('Login') }}
                </button>


            </div>
        </form>
    </div>
</div>
@endsection

@section('footer')
    @if (Route::has('register'))
        <div class="mt-5 text-muted text-center">
            Don't have an account? <a href="{{ route('register') }}">Create One</a>
        </div>
    @endif
@endsection
