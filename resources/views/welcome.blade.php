@extends('layouts.app')

@section('content')
<div class="text-center py-5">
  <h1>Welcome to Photobooth</h1>
  <p class="lead">Ambil foto, tambahkan frame, simpan, dan bagikan!</p>
  <a href="{{ url('/capture') }}" class="btn btn-primary btn-lg">Start Photo</a>
</div>
@endsection
