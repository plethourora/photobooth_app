<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Photobooth</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/css/app.css">

  <style>
    .capture-wrapper { position: relative; width: 100%; max-width: 720px; margin: 0 auto; }
    #camera, #preview { width: 100%; height: auto; display: block; }
    .overlay-frame { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; pointer-events: none; }
    .frame-thumb { width: 80px; height: 60px; object-fit: cover; cursor: pointer; border: 2px solid transparent; }
    .frame-thumb.selected { border-color: #0d6efd; }
  </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-4">
  <div class="container">
    <a class="navbar-brand" href="/">Photobooth</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="/">Start Photo</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ url('/capture') }}">Capture</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ url('/photos') }}">Gallery</a></li>
      </ul>
      <ul class="navbar-nav">
        @if(session('user_id'))
          <li class="nav-item"><span class="nav-link">Hi, {{ session('user_name') }}</span></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/logout') }}">Logout</a></li>
        @else
          <li class="nav-item"><a class="nav-link" href="{{ url('/login') }}">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ url('/register') }}">Register</a></li>
        @endif
      </ul>
    </div>
  </div>
</nav>

<div class="container">
  {{-- @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif --}}

  @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

@stack('scripts')
</body>
</html>
