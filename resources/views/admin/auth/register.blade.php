@extends('layouts.app')

@section('content')
<style>
    /* ---------------------------------- */
    /* 1. BACKGROUND UTAMA (ANIMATED GRADIENT) */
    /* ---------------------------------- */
    .login-wrapper {
        /* Warna Gradasi Animated (Sama dengan halaman lain) */
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
        
        /* Trik Full Width */
        width: 100vw;
        margin-left: calc(-50vw + 50%);
        margin-top: -1.5rem;
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
        background: rgba(30, 10, 30, 0.6); /* Lebih transparan */
        border-radius: 30px;
        padding: 40px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        box-shadow: 0 0 25px rgba(255, 50, 255, 0.2);
        color: white;
        width: 100%;
        backdrop-filter: blur(10px); /* Efek blur di belakang kartu */
    }

    .poselab-title {
        color: #4ade80;
        font-weight: 800;
        font-size: 2.5rem;
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

    /* Tombol Register Gradient (Hijau ke Biru - Khas Admin) */
    .btn-poselab-success {
        background: linear-gradient(to right, #4ade80, #22d3ee); 
        border: none;
        border-radius: 25px;
        font-weight: bold;
        padding: 12px;
        color: #1a0b2e; /* Teks gelap biar kontras */
        transition: 0.3s;
        width: 100%;
    }

    .btn-poselab-success:hover {
        opacity: 0.9;
        transform: scale(1.02);
        box-shadow: 0 0 15px rgba(74, 222, 128, 0.5);
    }
</style>

<div class="login-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="poselab-card">
                    <h1 class="poselab-title">New Admin</h1>
                    <p class="mb-4 text-white-50">Daftarkan akun administrator baru</p>

                    @if(session('success'))
                        <div class="alert alert-success mb-4 text-center" style="border-radius: 15px; background: rgba(74, 222, 128, 0.2); border: 1px solid #4ade80; color: #fff;">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="/admin/register" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label text-white">Username</label>
                            <input type="text" name="username" class="form-control-custom" placeholder="Buat username admin" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label text-white">Password</label>
                            <input type="password" name="password" class="form-control-custom" placeholder="Buat password kuat" required>
                        </div>

                        <div class="d-grid">
                            <button class="btn btn-poselab-success shadow-lg">
                                ✨ Register Admin
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <a href="{{ url('/admin/login') }}" class="text-white-50 small text-decoration-none">
                            Sudah punya akun? <span class="fw-bold" style="color: #4ade80;">Login di sini</span>
                        </a>
                    </div>
                </div>
                
                <p class="text-center mt-4 text-white-50 small">© 2026 PoseLab Admin Panel.</p>
            </div>
        </div>
    </div>
</div>
@endsection