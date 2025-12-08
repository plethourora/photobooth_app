@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h3 class="mb-3">Register Admin</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="/admin/register" method="POST">
        @csrf
        <div class="mb-2">
            <label>Username</label>
            <input type="text" name="username" class="form-control">
        </div>

        <div class="mb-2">
            <label>Password</label>
            <input type="password" name="password" class="form-control">
        </div>

        <button class="btn btn-success">Register</button>
    </form>
</div>
@endsection
