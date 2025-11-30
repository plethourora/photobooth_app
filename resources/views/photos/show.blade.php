@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-8">
    <img src="{{ asset('storage/' . $photo->filename) }}" style="width:100%; display:block;">
  </div>
  <div class="col-md-4">
    <h5>Details</h5>
    <p>Frame: {{ $photo->frame ? $photo->frame->name : 'None' }}</p>
    <p>Taken at: {{ $photo->created_at }}</p>
    <a href="{{ asset('storage/' . $photo->filename) }}" class="btn btn-outline-primary" download>Download</a>
    <!-- Edit & Delete buttons will be added in later step -->
  </div>
</div>
@endsection
