@extends('layouts.app')

@section('content')
<div class="container d-flex align-items-center justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card shadow-sm">

            <div class="card-body p-5">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="form-label">{{ __('Email Address') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-center">
                        <button type="submit" class="button-login px-5">
                            {{ __('Login') }}
                        </button>
                    </div>

                    {{-- Uncomment if you want to add the "Forgot Your Password?" link --}}
                    {{-- @if (Route::has('password.request'))
                        <div class="d-flex justify-content-center mt-3">
                            <a class="btn btn-link" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        </div>
                    @endif --}}
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
