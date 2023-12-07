@extends('layouts.guest')

@section('content')
    <h4 class="text-center mb-4">Sign in your account</h4>
    <form action="{{ route('login') }}" method="post">
        @csrf

        <div class="mb-3">
            <label class="mb-1"><strong>Email</strong></label>
            <input type="email" name="email"
                class="form-control @error('email') is-invalid @enderror gray-border gray-placeholder"
                placeholder="{{ __('Email') }}" required autofocus>
            @error('email')
                <span class="error invalid-feedback">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label class="mb-1"><strong>Password</strong></label>
            <div class="form-group-password-reset">
                <input type="password" name="password" id="password"
                    class="form-control @error('password') is-invalid @enderror gray-border gray-placeholder"
                    placeholder="{{ __('Password') }}" required>
                <span class="eye-toggle"><i class="fas fa-eye" id="password-toggle"></i></span>
            </div>
            @error('password')
                <span class="error invalid-feedback">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <div class="row d-flex justify-content-between mt-4 mb-2">
            <div class="mb-3">
                <div class="form-check custom-checkbox ms-1">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="basic_checkbox_1">
                        {{ __('Remember Me') }}
                    </label>
                </div>
            </div>
            @if (Route::has('password.request'))
                <p class="mb-3">
                    <a href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a>
                </p>
            @endif
        </div>
        <!-- /.col -->
        <div class="new-account mt-3">
            <button type="submit" class="btn btn-primary btn-block">{{ __('Login') }}</button>
        </div>
        <!-- /.col -->
        </div>
    </form>

    </div>
    <!-- /.login-card-body -->
@endsection
