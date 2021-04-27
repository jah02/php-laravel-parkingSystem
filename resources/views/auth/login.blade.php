@extends('base')

@section('stylesheets')
    <link rel="stylesheet" href="{{ asset('assets/css/auth/login.css') }}"
@endsection

@section('body')
<form class="login-form" method="post" action="{{ route('login') }}">
    <h3 class="text-center mb-5 login-text">Sign in</h3>
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
    <div class="form-group mb-3">
        <input type="email" name="email" class="form-control text-center" aria-describedby="emailHelp" placeholder="Enter email" required>
    </div>
    <div class="form-group mb-4">
        <input type="password" name="password" class="form-control text-center" placeholder="Password" required>
    </div>
    <div class="form-group mb-4">
        <input type="checkbox" name="remember-me">
        <label for="remember_token">Remember me</label>
    </div>
    @csrf
    <div class="text-center">
        <button type="submit" class="btn btn-primary btn-block">Login</button>
    </div>
</form>
@endsection
