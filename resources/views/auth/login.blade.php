@extends('layouts.app')
@section('content')
<div class="container" style="max-width:400px; margin-top:40px;">
    <h2 class="mb-4">Login</h2>
    <form method="POST" action="{{ url('/login') }}">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
    <div class="mt-3 text-center">
        <a href="{{ route('register') }}">Don't have an account? Register</a>
    </div>
</div>
@endsection
