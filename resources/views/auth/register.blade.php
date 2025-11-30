@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-6">
    <h3>Register</h3>
    <form method="POST" action="{{ url('/register') }}">
      @csrf
      <div class="mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control" value="{{ old('name') }}">
        @error('name') <div class="text-danger">{{ $message }}</div> @enderror
      </div>
      <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="{{ old('email') }}">
        @error('email') <div class="text-danger">{{ $message }}</div> @enderror
      </div>
      <div class="mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control">
        @error('password') <div class="text-danger">{{ $message }}</div> @enderror
      </div>
      <div class="mb-3">
        <label>Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control">
      </div>
      <button class="btn btn-primary">Register</button>
    </form>
  </div>
</div>
@endsection
