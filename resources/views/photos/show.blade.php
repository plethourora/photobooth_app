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

    <div class="d-flex flex-wrap gap-2 mb-2">
        <!-- Download -->
        <a href="{{ asset('storage/' . $photo->filename) }}" class="btn btn-outline-primary" download>Download</a>

        <!-- Edit -->
        {{-- <a href="{{ route('photos.edit', $photo->id) }}" class="btn btn-outline-warning">Edit</a> --}}

        <!-- Delete -->
        {{-- <form action="{{ route('photos.destroy', $photo->id) }}" method="POST" onsubmit="return confirm('Apakah kamu yakin ingin menghapus foto ini?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger">Delete</button>
        </form> --}}
    </div>
  </div>
</div>
@endsection
