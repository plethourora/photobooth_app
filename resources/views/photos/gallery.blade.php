@extends('layouts.app')

@section('content')
<style>
    /* ---------------------------------- */
    /* 1. BACKGROUND UTAMA (ANIMATED GRADIENT) */
    /* ---------------------------------- */
    .gallery-wrapper {
        /* Warna Gradasi Animated (Sama dengan Home, Capture, Edit) */
        background: linear-gradient(-45deg, #2b1055, #4e2a84, #7597de, #ed1e79);
        background-size: 400% 400%; /* Memperbesar background agar bisa digeser */
        
        /* Menjalankan animasi 'gradientBG' selama 15 detik, loop selamanya */
        animation: gradientBG 15s ease infinite;

        min-height: calc(100vh - 56px); /* Full height minus navbar */
        width: 100vw;
        margin-left: calc(-50vw + 50%); /* Trik full width */
        margin-top: -1.5rem;
        padding: 40px 20px;
        font-family: 'Inter', sans-serif;
    }

    /* Keyframes untuk menggerakkan background */
    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* 2. JUDUL */
    .section-title {
        color: #4ade80; /* Hijau Tosca */
        font-weight: 800;
        font-size: 2.5rem;
        text-shadow: 0 0 15px rgba(74, 222, 128, 0.4);
        margin-bottom: 30px;
        text-align: center;
    }

    /* 3. CARD STYLE (Glassmorphism) */
    .gallery-card {
        background: rgba(255, 255, 255, 0.1); /* Transparan */
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.3s ease;
        position: relative;
        backdrop-filter: blur(5px); /* Efek Blur di belakang kartu */
    }

    .gallery-card:hover {
        transform: translateY(-5px); /* Efek naik saat dihover */
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        border-color: #4ade80; /* Glow hijau saat hover */
        background: rgba(255, 255, 255, 0.15);
    }

    .card-img-wrapper {
        overflow: hidden;
        height: 200px;
        position: relative;
    }

    .card-img-top {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .gallery-card:hover .card-img-top {
        transform: scale(1.1); /* Gambar membesar sedikit saat hover */
    }

    /* 4. TEXT & BUTTONS */
    .card-body-glass {
        padding: 15px;
        color: white;
    }

    .frame-badge {
        background: rgba(0, 0, 0, 0.3);
        padding: 5px 10px;
        border-radius: 10px;
        font-size: 0.8rem;
        color: #e0e0e0;
        display: inline-block;
        margin-bottom: 10px;
    }

    .btn-view {
        background: linear-gradient(to right, #22d3ee, #f472b6);
        border: none;
        border-radius: 50px;
        color: white;
        font-weight: bold;
        width: 100%;
        padding: 8px;
        transition: 0.3s;
    }

    .btn-view:hover {
        opacity: 0.9;
        box-shadow: 0 0 15px rgba(34, 211, 238, 0.5);
        color: white;
        transform: scale(1.02);
    }

    /* 5. CUSTOM PAGINATION (Agar cocok di dark mode) */
    .pagination {
        justify-content: center;
        margin-top: 20px;
    }
    
    .page-item .page-link {
        background-color: rgba(255,255,255,0.1);
        border: 1px solid rgba(255,255,255,0.2);
        color: white;
        margin: 0 5px;
        border-radius: 5px;
    }

    .page-item.active .page-link {
        background-color: #4ade80;
        border-color: #4ade80;
        color: #1a1a1a;
        font-weight: bold;
    }

    .page-item.disabled .page-link {
        background-color: rgba(255,255,255,0.05);
        color: rgba(255,255,255,0.3);
    }
    
    /* 6. EMPTY STATE */
    .empty-state {
        text-align: center;
        color: white;
        padding: 50px;
        background: rgba(0,0,0,0.2);
        border-radius: 20px;
        border: 1px dashed rgba(255,255,255,0.3);
    }
</style>

<div class="gallery-wrapper">
    <div class="container">
        
        <h2 class="section-title">📸 My Gallery</h2>

        @if($photos->count() == 0)
            <div class="empty-state">
                <h4 class="mb-3">Oops, Belum ada foto!</h4>
                <p class="text-white-50 mb-4">Mulai ambil foto kerenmu sekarang.</p>
                <a href="{{ url('/capture') }}" class="btn btn-view" style="max-width: 200px;">Mulai Foto</a>
            </div>
        @else
            <div class="row">
                @foreach($photos as $photo)
                    <div class="col-md-3 col-sm-6 mb-4">
                        <div class="gallery-card">
                            
                            <div class="card-img-wrapper">
                                <img src="{{ asset('storage/' . ($photo->thumb_path ?? $photo->filename)) }}" class="card-img-top" alt="Photo">
                            </div>

                            <div class="card-body-glass">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="frame-badge">
                                        🖼️ {{ $photo->frame ? $photo->frame->name : 'No Frame' }}
                                    </span>
                                    <small class="text-white-50" style="font-size: 0.75rem;">
                                        {{ $photo->created_at->diffForHumans() }}
                                    </small>
                                </div>
                                
                                <a href="{{ url('/photos/'.$photo->id) }}" class="btn btn-view mt-2">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $photos->links() }}
            </div>
        @endif

    </div>
</div>
@endsection