@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h3 class="mb-3">Admin Login</h3>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="/admin/login" method="POST">
        @csrf
        <div class="mb-2">
            <label>Username</label>
            <input type="text" name="username" class="form-control">
        </div>

        <div class="mb-2">
            <label>Password</label>
            <input type="password" name="password" class="form-control">
        </div>

        <button class="btn btn-primary">Login</button>
    </form>

    <p class="mt-3"><a href="/admin/register">Register Admin</a></p>
</div>
@endsection
