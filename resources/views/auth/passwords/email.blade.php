@extends('layouts.guest')

@section('content')
    <h4 class="text-center mb-4">Forgot Password</h4>
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-3">
            <label><strong>Email</strong></label>
            <input type="email" name="email" class="form-control gray-border gray-placeholder @error('email') is-invalid @enderror"
                placeholder="{{ __('Email') }}" required autofocus>
            @error('email')
                <span class="error invalid-feedback">
                    {{ $message }}
                </span>
            @enderror
        </div>

        <div class="row">
            <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block">{{ __('Send Password Reset Link') }}</button>
            </div>
            <!-- /.col -->
        </div>
    </form>
@endsection
