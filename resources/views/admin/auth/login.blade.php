@extends('layouts.app')

@section('content')
<style>
    /* ---------------------------------- */
    /* 1. BACKGROUND UTAMA (ANIMATED GRADIENT) */
    /* ---------------------------------- */
    .login-wrapper {
        /* Warna Gradasi Animated (Sama dengan User Login & Home) */
        background: linear-gradient(-45deg, #2b1055, #4e2a84, #7597de, #ed1e79);
        background-size: 400% 400%; /* Memperbesar background agar bisa digeser */
        
        /* Menjalankan animasi 'gradientBG' selama 15 detik, loop selamanya */
        animation: gradientBG 15s ease infinite;

        /* Mengatur tinggi & posisi */
        min-height: calc(100vh - 80px); 
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Inter', sans-serif;
        
        /* Trik Full Width keluar dari container layout */
        width: 100vw;
        margin-left: calc(-50vw + 50%);
        margin-top: -1.5rem; /* Menarik ke atas agar nempel navbar */
        padding: 20px;
    }

    /* Keyframes untuk menggerakkan background */
    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* 2. Style Card PoseLab */
    .poselab-card {
        background: rgba(30, 10, 30, 0.6); /* Lebih transparan dikit biar gradasi kelihatan */
        border-radius: 30px;
        padding: 40px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 0 25px rgba(255, 50, 255, 0.2); /* Glow Pink halus */
        color: white;
        width: 100%;
        backdrop-filter: blur(10px); /* Efek blur di belakang kartu */
    }

    .poselab-title {
        color: #4ade80;
        font-weight: 800;
        font-size: 3rem;
        margin-bottom: 0;
        text-shadow: 0 0 10px rgba(74, 222, 128, 0.4);
    }

    .form-control-custom {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white !important;
        border-radius: 10px;
        padding: 12px;
        width: 100%;
        display: block;
        transition: 0.3s;
    }

    .form-control-custom:focus {
        background: rgba(255, 255, 255, 0.15);
        color: white !important;
        border-color: #4ade80;
        box-shadow: 0 0 10px rgba(74, 222, 128, 0.3);
        outline: none;
    }

    .form-control-custom::placeholder {
        color: rgba(255, 255, 255, 0.6);
    }

    /* Tombol Login Gradient */
    .btn-poselab {
        background: linear-gradient(to right, #f472b6, #22d3ee);
        border: none;
        border-radius: 25px;
        font-weight: bold;
        padding: 12px;
        color: white;
        transition: 0.3s;
        width: 100%;
    }

    .btn-poselab:hover {
        opacity: 0.9;
        transform: scale(1.02);
        color: white;
        box-shadow: 0 0 15px rgba(244, 114, 182, 0.5);
    }
</style>

<div class="login-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="poselab-card">
                    <h1 class="poselab-title">Admin</h1>
                    <p class="mb-4 text-white-50">Portal Administrator PoseLab</p>

                    @if(session('error'))
                        <div class="alert alert-danger mb-4" style="border-radius: 15px; background: rgba(220, 53, 69, 0.2); border: 1px solid #dc3545; color: #fff;">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="/admin/login" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label text-white">Email Address</label>
                            <input type="email" name="email" class="form-control-custom" placeholder="admin@poselab.com" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-white">Password</label>
                            <input type="password" name="password" class="form-control-custom" placeholder="••••••••" required>
                        </div>

                        <div class="d-grid">
                            <button class="btn btn-poselab shadow-lg">
                                🚀 Login Admin
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <a href="/" class="text-white-50 small text-decoration-none">← Back to Home</a>
                    </div>
                </div>
                
                <p class="text-center mt-4 text-white-50 small">© 2026 PoseLab Admin Panel.</p>
            </div>
        </div>
    </div>
</div>
@endsection