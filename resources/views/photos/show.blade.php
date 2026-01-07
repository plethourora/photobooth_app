@extends('layouts.app')

@section('content')
<style>
    /* ---------------------------------- */
    /* 1. BACKGROUND UTAMA (ANIMATED GRADIENT) */
    /* ---------------------------------- */
    .view-wrapper {
        /* Warna Gradasi Animated (Sama dengan Home, Capture, Gallery, Edit) */
        background: linear-gradient(-45deg, #2b1055, #4e2a84, #7597de, #ed1e79);
        background-size: 400% 400%; /* Memperbesar background agar bisa digeser */
        
        /* Menjalankan animasi 'gradientBG' selama 15 detik, loop selamanya */
        animation: gradientBG 15s ease infinite;

        min-height: calc(100vh - 56px);
        width: 100vw;
        margin-left: calc(-50vw + 50%);
        margin-top: -1.5rem;
        padding: 40px 20px;
        font-family: 'Inter', sans-serif;
        color: white;
    }

    /* Keyframes untuk menggerakkan background */
    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* 2. GLASS PANEL (KOTAK TRANSPARAN) */
    .glass-panel {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        height: 100%;
        backdrop-filter: blur(5px); /* Efek blur halus */
    }

    /* 3. JUDUL DETAIL */
    .detail-title {
        color: #4ade80; /* Hijau Tosca */
        font-weight: 800;
        font-size: 1.8rem;
        margin-bottom: 20px;
        border-bottom: 1px solid rgba(255,255,255,0.2);
        padding-bottom: 10px;
        text-shadow: 0 0 10px rgba(74, 222, 128, 0.3);
    }

    /* 4. STYLE GAMBAR */
    .photo-container {
        display: flex;
        justify-content: center;
        align-items: center;
        background: rgba(0,0,0,0.3); /* Sedikit gelap di belakang foto agar kontras */
        border-radius: 15px;
        padding: 10px;
        min-height: 400px;
        border: 1px solid rgba(255,255,255,0.1);
    }

    .preview-image {
        width: 100%;
        display: block;
        max-height: 75vh;
        height: auto;
        object-fit: contain;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.5);
    }

    /* 5. INFO LIST STYLE */
    .info-item {
        margin-bottom: 15px;
        font-size: 1rem;
    }
    .info-label {
        font-weight: bold;
        color: rgba(255,255,255,0.7);
        display: block;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .info-value {
        font-weight: 500;
        font-size: 1.1rem;
    }

    /* 6. TOMBOL AKSI */
    .btn-action-group {
        display: flex;
        flex-direction: column;
        gap: 12px;
        margin-top: 30px;
    }

    .btn-download {
        background: linear-gradient(to right, #22d3ee, #f472b6);
        border: none;
        color: white;
        font-weight: bold;
        border-radius: 50px;
        padding: 12px;
        transition: 0.3s;
        text-decoration: none;
    }
    
    .btn-download:hover {
        transform: scale(1.02);
        box-shadow: 0 0 15px rgba(34, 211, 238, 0.6);
        color: white;
    }

    .btn-edit {
        background: transparent;
        border: 2px solid white;
        color: white;
        border-radius: 50px;
        padding: 10px;
        font-weight: bold;
        transition: 0.3s;
        text-decoration: none;
    }

    .btn-edit:hover {
        background: white;
        color: #662d8c;
    }

    .btn-delete {
        background: rgba(220, 53, 69, 0.2);
        border: 1px solid #dc3545;
        color: #ffadad;
        border-radius: 50px;
        padding: 10px;
        font-weight: bold;
        transition: 0.3s;
        width: 100%;
    }

    .btn-delete:hover {
        background: #dc3545;
        color: white;
    }
</style>

<div class="view-wrapper">
    <div class="container">
        
        <div class="mb-4">
            <a href="{{ url('/photos') }}" class="text-white text-decoration-none fw-bold" style="opacity: 0.8;">
                &larr; Back to Gallery
            </a>
        </div>

        <div class="row">
            <div class="col-md-8 mb-4">
                <div class="glass-panel">
                    <div class="photo-container">
                        <img 
                            src="{{ asset('storage/' . $photo->filename) }}" 
                            class="preview-image"
                            alt="User Photo"
                        >
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="glass-panel">
                    <h5 class="detail-title">Photo Details</h5>
                    
                    <div class="info-item">
                        <span class="info-label">Frame Used</span>
                        <span class="info-value">
                            {{ $photo->frame ? $photo->frame->name : 'No Frame' }}
                        </span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">Taken At</span>
                        <span class="info-value">
                            {{ $photo->created_at->format('d M Y, H:i') }}
                        </span>
                    </div>
                    
                    <div class="btn-action-group">
                        <a href="{{ asset('storage/' . $photo->filename) }}" class="btn btn-download text-center" download>
                            ⬇ Download Photo
                        </a>

                        <a href="{{ route('photos.edit', $photo->id) }}" class="btn btn-edit text-center">
                            ✏ Edit Details
                        </a>

                        <form action="{{ route('photos.destroy', $photo->id) }}" method="POST" onsubmit="return confirm('Are you sure want to delete this photo?');" style="width: 100%;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete">
                                🗑 Delete Photo
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection