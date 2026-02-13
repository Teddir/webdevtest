@extends('layouts.app')

@section('content')
  <div class="login-auth-card">
    <h1 style="text-align: center; margin-bottom: 2rem; font-weight: 800; letter-spacing: -1px;">
      {{ __('messages.login') }}
    </h1>

    @if ($errors->any())
      <div class="alert alert-danger">
        {{ $errors->first() }}
      </div>
    @endif

    <form method="POST" action="{{ route('login.submit') }}">
      @csrf

      <div class="form-group">
        <label class="form-label">{{ __('messages.username') }}</label>
        <input type="text" name="username" class="form-control" value="{{ old('username') }}" required autofocus>
      </div>

      <div class="form-group">
        <label class="form-label">{{ __('messages.password') }}</label>
        <input type="password" name="password" class="form-control" required>
      </div>

      <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; margin-top: 1rem;">
        {{ __('messages.login') }}
      </button>
    </form>

    <div style="margin-top: 2rem; text-align: center; color: var(--text-muted); font-size: 0.8rem;">
      <p>Demo Account: <strong>aldmic</strong> / <strong>123abc123</strong></p>
    </div>
  </div>
@endsection