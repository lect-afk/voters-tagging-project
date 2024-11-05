@extends('layouts.app')

@section('content')
<div class="container d-flex align-items-center justify-content-center mt-5">
    <div class="col-md-6">
        <div class="card shadow-sm">

            <div class="card-body p-5">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="form-label">{{ __('Username') }}</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-4 position-relative">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        <span id="togglePassword" style="cursor: pointer; position: absolute; right: 10px; top: 50%; transform: translateY(20%);">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </span>
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

<script>
    document.getElementById('togglePassword').addEventListener('click', function () {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');
        
        // Toggle the type attribute
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        
        // Toggle the eye / eye slash icon
        toggleIcon.classList.toggle('fa-eye');
        toggleIcon.classList.toggle('fa-eye-slash');
    });
</script>
@endsection
