@extends('layouts.app')

@section('content')
<div class="login-wrapper d-flex">
    <div class="login-background">
        <h1>BRAND NAME</h1>
    </div>
    <div class="divider"></div>
    <div class="login-form-container">
        <div class="login-form">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3 position-relative">
                    <i class="fas fa-user icon"></i>
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Username">
                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-3 position-relative">
                    <i class="fas fa-lock icon"></i>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                    <span id="togglePassword" class="toggle-password">
                        <i class="fas fa-eye" id="toggleIcon"></i>
                    </span>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                {{-- <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <input type="checkbox" name="remember" id="remember">
                        <label for="remember">Remember me</label>
                    </div>
                    <a href="#">Forgot Password?</a>
                </div> --}}
                <div class="d-flex justify-content-center">
                    <button type="submit" class="button-login">
                        {{ __('LOGIN') }}
                    </button>
                </div>
            </form>
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
