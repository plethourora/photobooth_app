@extends('layouts.app')

@section('content')
<style>
    /* ---------------------------------- */
    /* 1. BACKGROUND UTAMA (ANIMATED GRADIENT) */
    /* ---------------------------------- */
    .edit-wrapper {
        /* Warna Gradasi Animated (Sama dengan Home & Capture) */
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
        overflow-x: hidden;
    }

    /* Keyframes untuk menggerakkan background */
    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* 2. GLASS PANEL */
    .glass-card {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        backdrop-filter: blur(5px); /* Tambahan blur biar makin estetik */
    }

    /* 3. JUDUL */
    .section-title {
        color: #4ade80;
        font-weight: 800;
        margin-bottom: 20px;
        text-shadow: 0 0 10px rgba(74, 222, 128, 0.3);
    }

    /* 4. PHOTO SLOT (Compact) */
    .photo-slot { 
        transition: all 0.3s ease; 
        border: 2px solid rgba(255,255,255,0.3); 
        background: #000; 
        position: relative;
        width: 100%;
        max-width: 260px; 
        aspect-ratio: 4 / 3; 
        overflow: hidden;
        border-radius: 10px;
        margin: 0 auto;
        box-shadow: 0 5px 15px rgba(0,0,0,0.5);
    }
    
    .photo-slot img.main-photo {
        position: absolute;
        width: 100%;
        height: 300%; 
        left: 0;
        object-fit: cover;
    }

    /* 5. CONTROLS (Tombol Panah) */
    .btn-control {
        background: rgba(255,255,255,0.2);
        color: white;
        border: 1px solid rgba(255,255,255,0.3);
        border-radius: 5px;
        padding: 2px 8px;
        font-size: 12px;
    }
    .btn-control:hover {
        background: white;
        color: #662d8c;
    }

    /* 6. FRAME THUMBNAILS */
    .frame-thumb {
        width: 70px;
        height: 55px;
        object-fit: contain;
        cursor: pointer;
        border: 2px solid rgba(255,255,255,0.3);
        border-radius: 8px;
        transition: 0.2s;
        background: rgba(255,255,255,0.1);
    }

    .frame-thumb:hover {
        transform: scale(1.1);
        background: rgba(255,255,255,0.2);
    }

    .frame-thumb.selected {
        border-color: #4ade80; /* Hijau Tosca */
        box-shadow: 0 0 10px rgba(74, 222, 128, 0.5);
        transform: scale(1.1);
    }

    /* 7. SAVE BUTTON */
    .btn-save {
        background: linear-gradient(to right, #22d3ee, #f472b6);
        border: none;
        border-radius: 50px;
        color: white;
        font-weight: bold;
        padding: 10px;
        transition: 0.3s;
    }
    .btn-save:hover {
        opacity: 0.9;
        transform: translateY(-2px);
        color: white;
        box-shadow: 0 5px 15px rgba(34, 211, 238, 0.4);
    }

    .btn-remove-frame {
        color: #ffadad;
        border-color: #ffadad;
        border-radius: 20px;
    }
    .btn-remove-frame:hover {
        background: #dc3545;
        color: white;
        border-color: #dc3545;
    }
</style>

<div class="edit-wrapper">
    <div class="container">
        
        <div class="mb-4 text-center">
            <a href="{{ route('photos.index') }}" class="text-white text-decoration-none fw-bold" style="opacity: 0.8;">
                &larr; Cancel & Back to Gallery
            </a>
        </div>

        <div class="row justify-content-center">
            
            <div class="col-md-5 mb-4">
                <div class="glass-card text-center">
                    <h5 class="section-title">Reorder Preview</h5>
                    <p class="small text-white-50 mb-3">Click arrows to move photo position</p>
                    
                    <div id="photoOrderContainer" class="mb-4">
                        @for($i=0; $i<3; $i++)
                        <div class="photo-slot mb-3" data-index="{{ $i }}">
                            <img src="{{ asset('storage/' . $photo->original_filename) }}" 
                                 class="main-photo"
                                 style="top: -{{ $i * 100 }}%;">
                            
                            <img class="overlay-frame-preview" src="" 
                                 style="display:none; position:absolute; top:0; left:0; width:100%; height:100%; pointer-events:none; object-fit:contain; z-index: 10;">

                            <div class="controls" style="position:absolute; right:8px; top:50%; transform:translateY(-50%); display: flex; flex-direction: column; gap: 4px; z-index: 20;">
                                <button type="button" class="btn btn-control move-up">▲</button>
                                <button type="button" class="btn btn-control move-down">▼</button>
                            </div>
                        </div>
                        @endfor
                    </div>

                    <form id="updateForm" action="{{ route('photos.update', $photo->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="frame_id" id="frameInput" value="{{ $photo->frame_id }}">
                        <input type="hidden" name="photo_order" id="orderInput" value="0,1,2">
                        
                        <button type="submit" class="btn btn-save w-100 shadow-lg">
                            💾 Save Changes
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-md-4">
                <div class="glass-card text-center">
                    <h5 class="section-title">Change Frame</h5>
                    <p class="small text-white-50 mb-3">Select a new frame style</p>

                    <div id="framesList" class="d-flex flex-wrap gap-2 justify-content-center mb-4">
                        @foreach($frames as $f)
                        <img src="{{ asset('storage/'.$f->image_path) }}" 
                             data-id="{{ $f->id }}" 
                             class="frame-thumb"
                             title="{{ $f->name }}">
                        @endforeach
                    </div>

                    <button type="button" id="noFrame" class="btn btn-sm btn-outline-danger w-100 btn-remove-frame">
                        🚫 Remove Frame
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const container = document.getElementById('photoOrderContainer');
    const orderInput = document.getElementById('orderInput');
    const frameInput = document.getElementById('frameInput');

    function updateOrderValue() {
        const slots = document.querySelectorAll('.photo-slot');
        orderInput.value = Array.from(slots).map(s => s.dataset.index).join(',');
    }

    container.addEventListener('click', (e) => {
        const slot = e.target.closest('.photo-slot');
        if (!slot) return;
        if (e.target.classList.contains('move-up') && slot.previousElementSibling) {
            container.insertBefore(slot, slot.previousElementSibling);
        } else if (e.target.classList.contains('move-down') && slot.nextElementSibling) {
            container.insertBefore(slot.nextElementSibling, slot);
        }
        updateOrderValue();
    });

    function applyFramePreview(src) {
        const overlays = document.querySelectorAll('.overlay-frame-preview');
        overlays.forEach(img => {
            img.src = src || '';
            img.style.display = src ? 'block' : 'none';
        });
    }

    window.addEventListener('DOMContentLoaded', () => {
        if (frameInput.value) {
            const img = document.querySelector(`.frame-thumb[data-id="${frameInput.value}"]`);
            if (img) { img.classList.add('selected'); applyFramePreview(img.src); }
        }
    });

    document.querySelectorAll('.frame-thumb').forEach(el => {
        el.addEventListener('click', () => {
            document.querySelectorAll('.frame-thumb').forEach(i => i.classList.remove('selected'));
            el.classList.add('selected');
            frameInput.value = el.dataset.id;
            applyFramePreview(el.src);
        });
    });

    document.getElementById('noFrame').addEventListener('click', () => {
        document.querySelectorAll('.frame-thumb').forEach(i => i.classList.remove('selected'));
        frameInput.value = '';
        applyFramePreview(null);
    });
</script>
@endpush