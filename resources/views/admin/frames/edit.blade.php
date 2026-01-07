@extends('layouts.app')

@section('content')
<style>
    /* ---------------------------------- */
    /* 1. BACKGROUND UTAMA (ANIMATED GRADIENT) */
    /* ---------------------------------- */
    .admin-wrapper {
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

    /* 2. GLASS CARD STYLE */
    .admin-wrapper .card {
        background: rgba(255, 255, 255, 0.1);
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

    /* 4. TOMBOL GRADIENT */
    .btn-save-custom {
        background: linear-gradient(to right, #4ade80, #22d3ee); 
        border: none; 
        color: #1a0b2e; 
        font-weight: bold;
    }
    
    .btn-save-custom:hover {
        opacity: 0.9;
        color: #1a0b2e;
    }
</style>

<div class="admin-wrapper">
    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold" style="text-shadow: 0 2px 4px rgba(0,0,0,0.3);">✏️ Edit Frame</h2>
            <a href="{{ route('admin.frames.index') }}" class="btn btn-outline-light btn-sm" style="border-radius: 20px; padding: 5px 20px;">
                &larr; Back
            </a>
        </div>

        <div class="row">
            <div class="col-md-8 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        Editing: <span class="text-white">{{ $frame->name }}</span>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.frames.update', $frame->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-4">
                                <label for="name" class="form-label">Frame Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                       value="{{ old('name', $frame->name) }}" required placeholder="Masukkan nama baru">

                                @error('name')
                                    <div class="text-danger mt-1 small bg-white rounded px-2 d-inline-block mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-save-custom px-4">
                                    Save Changes
                                </button>
                                <a href="{{ route('admin.frames.index') }}" class="btn btn-outline-light px-4">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <h4 class="mb-3 fw-bold" style="text-shadow: 0 2px 4px rgba(0,0,0,0.3);">🖼️ Preview</h4>
                <div class="card p-2" style="background: rgba(0,0,0,0.2);">
                    <div style="width: 100%; height: 300px; display: flex; align-items: center; justify-content: center; overflow: hidden; border-radius: 10px;">
                        <img src="{{ asset('storage/' . $frame->image_path) }}" 
                             class="img-fluid" 
                             style="max-height: 100%; object-fit: contain;" 
                             alt="{{ $frame->name }}">
                    </div>
                    <div class="card-body text-center p-2">
                        <small class="text-white-50">Current Frame Image</small>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection