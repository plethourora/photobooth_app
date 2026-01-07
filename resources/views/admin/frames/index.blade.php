@extends('layouts.app')

@section('content')
<style>
    /* ---------------------------------- */
    /* 1. BACKGROUND UTAMA (ANIMATED GRADIENT) */
    /* ---------------------------------- */
    .admin-wrapper {
        /* Warna Gradasi Animated (Sama dengan halaman user) */
        background: linear-gradient(-45deg, #2b1055, #4e2a84, #7597de, #ed1e79);
        background-size: 400% 400%;
        animation: gradientBG 15s ease infinite;

        /* Full height minus navbar */
        min-height: calc(100vh - 56px);
        width: 100vw;
        margin-left: calc(-50vw + 50%); /* Trik Full Width */
        margin-top: -1.5rem;
        padding-top: 30px;
        padding-bottom: 50px;
        font-family: 'Inter', sans-serif;
        color: white;
    }

    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* 2. OVERRIDE BOOTSTRAP CARD (GLASS EFFECT) */
    .admin-wrapper .card {
        background: rgba(255, 255, 255, 0.1); /* Transparan */
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 15px;
        backdrop-filter: blur(10px);
        color: white;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .admin-wrapper .card-header {
        background: rgba(255, 255, 255, 0.1);
        border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        font-weight: bold;
        color: #4ade80; /* Hijau Tosca */
    }

    /* 3. INPUT FORM CUSTOM */
    .admin-wrapper .form-control {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
    }
    
    .admin-wrapper .form-control:focus {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border-color: #4ade80;
        box-shadow: none;
    }

    .admin-wrapper .form-label {
        color: rgba(255, 255, 255, 0.9);
    }

    /* 4. TEXT COLORS */
    .admin-wrapper h2, .admin-wrapper h4 {
        color: white;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        font-weight: 700;
    }
    
    .text-muted {
        color: rgba(255,255,255,0.6) !important;
    }
</style>

<div class="admin-wrapper">
    <div class="container"> <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Admin – Manage Frames</h2>
            <a href="{{ route('admin.logout') }}" class="btn btn-outline-light btn-sm" style="border-radius: 20px; padding: 5px 20px;">
                Logout
            </a>
        </div>

        {{-- Success Alert --}}
        @if (session('success'))
            <div class="alert alert-success" style="background: rgba(74, 222, 128, 0.2); border-color: #4ade80; color: white;">
                {{ session('success') }}
            </div>
        @endif

        {{-- CARD UPLOAD --}}
        <div class="card mb-5">
            <div class="card-header">Upload New Frames</div>
            <div class="card-body">
                <form action="{{ route('admin.frames.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" required placeholder="Nama Frame">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Frame Image (PNG Recommended)</label>
                        <input type="file" name="image" class="form-control" accept="image/png,image/jpeg" required>
                    </div>

                    <button class="btn btn-primary" style="background: linear-gradient(to right, #4ade80, #22d3ee); border: none; color: #1a0b2e; font-weight: bold;">
                        Upload Frame
                    </button>
                </form>
            </div>
        </div>

        <h4 class="mb-3 border-bottom pb-2" style="border-color: rgba(255,255,255,0.2) !important;">List Frames</h4>

        @if ($frames->count() == 0)
            <p class="text-muted text-center py-5">There are no frames yet.</p>
        @endif

        <div class="row">
            @foreach ($frames as $frame)
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <div style="height: 200px; overflow: hidden; display: flex; align-items: center; justify-content: center; background: rgba(0,0,0,0.2);">
                             <img src="{{ asset('storage/' . $frame->image_path) }}" 
                                  style="max-width: 100%; max-height: 100%; object-fit: contain;" 
                                  alt="Frame">
                        </div>

                        <div class="card-body text-center d-flex flex-column justify-content-between">
                            <p class="fw-bold mb-2 text-white">{{ $frame->name }}</p>

                            <div>
                                {{-- Tombol Edit --}}
                                <a href="{{ route('admin.frames.edit', $frame->id) }}" class="btn btn-sm btn-info text-white mb-2 w-100">
                                    Edit Name
                                </a>

                                {{-- Form Delete --}}
                                <form action="{{ route('admin.frames.destroy', $frame->id) }}" method="POST"
                                      onsubmit="return confirm('Yakin hapus frame ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm w-100">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

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