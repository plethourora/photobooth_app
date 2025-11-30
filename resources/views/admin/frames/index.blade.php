@extends('layouts.app')

@section('content')
<div class="container py-4">

    <h2 class="mb-3">Admin – Manage Frames</h2>

    {{-- Success Alert (hanya di sini, tidak di layout) --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Upload form -->
    <div class="card mb-4">
        <div class="card-header">Upload Frame Baru</div>
        <div class="card-body">
            <form action="/admin/frames" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-2">
                    <label class="form-label">Nama Frame</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-2">
                    <label class="form-label">Frame Image (PNG Recommended)</label>
                    <input type="file" name="image" class="form-control" accept="image/png,image/jpeg" required>
                </div>

                <button class="btn btn-primary">Upload</button>
            </form>
        </div>
    </div>

    <!-- List Frame -->
    <h4 class="mb-3">Daftar Frame</h4>

    @if ($frames->count() == 0)
        <p class="text-muted">Belum ada frame.</p>
    @endif

    <div class="row">
        @foreach ($frames as $frame)
            <div class="col-md-3 mb-4">
                <div class="card">
                    <img src="{{ asset('storage/' . $frame->image_path) }}"
                         class="card-img-top" alt="Frame">

                    <div class="card-body text-center">
                        <p class="fw-bold mb-2">{{ $frame->name }}</p>

                        <form action="/admin/frames/{{ $frame->id }}" method="POST"
                              onsubmit="return confirm('Yakin hapus frame ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection

@push('scripts')
<script>
    // auto hide success alert after 3 seconds
    setTimeout(() => {
        const alert = document.querySelector('.alert');
        if (alert) {
            alert.style.transition = '0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }
    }, 3000);
</script>
@endpush
