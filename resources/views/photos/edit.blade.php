@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8">
        <h4>Edit Foto</h4>
        <div class="photo-wrapper mb-3" style="position:relative; max-width:720px;">
            {{-- photoPreview = always original photo --}}
            <img src="{{ asset('storage/' . ($photo->original_filename ?: $photo->filename)) }}" 
                 id="photoPreview" style="width:100%; display:block;">

            {{-- overlay = frame yang dipilih --}}
            <img id="overlay" 
                 src="{{ $photo->frame ? asset('storage/' . $photo->frame->image_path) : '' }}" 
                 style="display:{{ $photo->frame ? 'block' : 'none' }};
                        position:absolute; top:0; left:0; width:100%; height:100%; object-fit:contain;">
        </div>

        <form id="updateForm" action="{{ route('photos.update', $photo->id) }}" method="POST" class="mb-2">
            @csrf
            @method('PUT')
            <input type="hidden" name="frame_id" id="frameInput" value="{{ $photo->frame_id }}">
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="{{ asset('storage/' . $photo->filename) }}" class="btn btn-outline-primary" download>Download</a>
        </form>

        <p>Taken at: {{ $photo->created_at }}</p>
    </div>

    <div class="col-md-4">
        <h5>Pilih Frame</h5>
        <div class="d-flex flex-wrap" id="framesList">
            <div class="mb-2">
                <button type="button" id="noFrame" class="btn btn-sm btn-outline-secondary">No Frame</button>
            </div>
            @foreach($frames as $f)
            <div class="me-2 mb-2 text-center">
                <img src="{{ asset('storage/' . $f->image_path) }}" data-id="{{ $f->id }}" 
                     class="frame-thumb {{ $photo->frame_id == $f->id ? 'selected' : '' }}" 
                     title="{{ $f->name }}" style="cursor:pointer; width:100px; height:auto;">
                <div style="font-size:12px">{{ $f->name }}</div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let selectedFrame = {{ $photo->frame_id ?? 'null' }};

// frame selection
document.querySelectorAll('.frame-thumb').forEach(function(el) {
    el.addEventListener('click', function() {
        document.querySelectorAll('.frame-thumb').forEach(i => i.classList.remove('selected'));
        el.classList.add('selected');
        selectedFrame = el.getAttribute('data-id');
        document.getElementById('overlay').src = el.src;
        document.getElementById('overlay').style.display = 'block';
        document.getElementById('frameInput').value = selectedFrame;
    });
});

// No Frame
document.getElementById('noFrame').addEventListener('click', function() {
    document.querySelectorAll('.frame-thumb').forEach(i => i.classList.remove('selected'));
    selectedFrame = null;
    document.getElementById('overlay').style.display = 'none';
    document.getElementById('frameInput').value = '';
});
</script>
@endpush
