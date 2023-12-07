@extends('layouts.guest')

@section('content')
    <div class="card-body login-card-body">
        <h4 class="text-center mb-4">Forgot Password</h4>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">
            <div class="mb-3">
                <label><strong>Email</strong></label>
                <input type="email" name="email"
                    class="form-control gray-border gray-placeholder @error('email') is-invalid @enderror"
                    placeholder="Email" required autofocus>
                @error('email')
                    <span class="error invalid-feedback">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="mb-3">
                <label><strong>Password</strong></label>
                <div class="form-group-password-reset">
                    <input type="password" name="password" id="password"
                        class="form-control gray-border gray-placeholder @error('password') is-invalid @enderror"
                        placeholder="{{ __('Password') }}" required>
                    <span class="eye-toggle"><i class="fas fa-eye" id="password-toggle"></i></span>
                    @error('password')
                        <span class="error invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label><strong>Confirm Password</strong></label>
                <div class="form-group-password-reset">
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="form-control gray-border gray-placeholder @error('password_confirmation') is-invalid @enderror"
                        placeholder="{{ __('Confirm Password') }}" required>
                    <span class="eye-toggle"><i class="fas fa-eye" id="password-confirmation-toggle"></i></span>
                    @error('password_confirmation')
                        <span class="error invalid-feedback">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-block">{{ __('Reset Password') }}</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
    </div>
@endsection
