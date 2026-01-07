@extends('layouts.app')

@section('content')
<style>
    /* --- 1. GLOBAL WRAPPER (ANIMATED BACKGROUND) --- */
    .home-wrapper {
        /* Definisi warna gradasi (Saya tambah variasi agar loop-nya halus) */
        background: linear-gradient(-45deg, #2b1055, #4e2a84, #7597de, #ed1e79);
        background-size: 400% 400%; /* Memperbesar background agar bisa digeser */
        
        /* Menjalankan animasi 'gradientBG' selama 15 detik, loop selamanya */
        animation: gradientBG 15s ease infinite;

        min-height: calc(100vh - 80px);
        width: 100vw;
        margin-left: calc(-50vw + 50%); /* Trik Full Width */
        margin-top: -80px;
        padding-top: 120px;
        padding-bottom: 50px;
        font-family: 'Poppins', sans-serif;
        color: white;
        overflow-x: hidden;
    }

    /* Definisi Keyframes untuk menggeser background */
    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* --- 2. TYPOGRAPHY --- */
    .section-subtitle {
        color: #4ade80;
        font-weight: 600;
        letter-spacing: 2px;
        text-transform: uppercase;
        margin-bottom: 10px;
        display: block;
    }

    .section-title {
        font-family: 'Inter', sans-serif;
        font-weight: 800;
        font-size: 3.5rem;
        margin-bottom: 20px;
        background: linear-gradient(to right, #fff, #f472b6);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        line-height: 1.2;
    }

    .text-description {
        color: rgba(255, 255, 255, 0.85);
        line-height: 1.8;
        font-size: 1.1rem;
    }

    /* --- 3. GLASS CARD --- */
    .glass-card {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        padding: 30px;
        backdrop-filter: blur(10px);
        transition: 0.3s;
        height: 100%;
        position: relative;
        overflow: hidden;
    }

    .glass-card:hover {
        background: rgba(255, 255, 255, 0.1);
        transform: translateY(-10px);
        border-color: #4ade80;
        box-shadow: 0 10px 30px rgba(74, 222, 128, 0.2);
    }

    /* Step Number */
    .step-number {
        position: absolute;
        top: -10px;
        right: 10px;
        font-size: 5rem;
        font-weight: 800;
        color: rgba(255,255,255,0.05);
        z-index: 0;
    }

    /* --- 4. BUTTON & ANIMATION --- */
    .btn-hero {
        background: linear-gradient(to right, #4ade80, #22d3ee);
        border: none;
        color: #1a0b2e;
        font-weight: 700;
        transition: 0.3s;
    }
    
    .btn-hero:hover {
        transform: scale(1.05);
        box-shadow: 0 0 20px rgba(74, 222, 128, 0.6);
        color: #1a0b2e;
    }

    /* Animasi Gambar Melayang */
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
        100% { transform: translateY(0px); }
    }
    .floating { animation: float 4s ease-in-out infinite; }

    /* --- 5. ICON --- */
    .step-icon {
        font-size: 3rem;
        margin-bottom: 20px;
        position: relative;
        z-index: 1;
        text-shadow: 0 0 15px rgba(255,255,255,0.3);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .section-title { font-size: 2.5rem; }
        .home-wrapper { text-align: center; }
        .mt-lg-0 { margin-top: 3rem !important; }
    }
</style>

<div class="home-wrapper">
    <div class="container">
        
        <div class="row align-items-center mb-5">
            <div class="col-lg-6" data-aos="fade-right">
                <span class="section-subtitle">Welcome to PoseLab</span>
                <h1 class="section-title">Capture Memories,<br>Create Magic.</h1>
                <p class="text-description mb-4">
                    Abadikan momen seru bareng teman-temanmu sekarang juga! 
                    Pilih bingkai favoritmu, bergaya sesuka hati, dan simpan kenangannya selamanya.
                    Tanpa antri, tanpa ribet.
                </p>
                
                <div class="d-flex gap-3 justify-content-lg-start justify-content-center">
                    <a href="{{ url('/capture') }}" class="btn btn-hero rounded-pill px-5 py-3 shadow-lg">
                        🚀 Mulai Foto
                    </a>
                    
                    <a href="{{ url('/photos') }}" class="btn btn-outline-light rounded-pill px-4 py-3 fw-bold">
                        Lihat Galeri
                    </a>
                </div>
            </div>
            
            <div class="col-lg-6 text-center text-lg-end mt-5 mt-lg-0" data-aos="zoom-in" data-aos-delay="200">
                <img src="https://cdn-icons-png.flaticon.com/512/10473/10473491.png" 
                     alt="Photo Booth Illustration" 
                     class="img-fluid floating" 
                     style="width: 100%; max-width: 550px; filter: drop-shadow(0 20px 40px rgba(0,0,0,0.3));">
            </div>
        </div>

        <div class="row mb-5" style="margin-top: 120px;">
            <div class="col-12 text-center mb-5" data-aos="fade-up">
                <h2 class="fw-bold section-title" style="font-size: 2.5rem;">How It Works?</h2>
                <p class="text-white-50">3 Langkah mudah untuk foto kece</p>
            </div>

            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="glass-card text-center">
                    <div class="step-number">1</div>
                    <div class="step-icon">🖼️</div> 
                    <h4 class="fw-bold mb-3 text-white">Select Frame</h4>
                    <p class="text-white-50">Pilih berbagai bingkai estetik yang sesuai dengan mood atau outfit kamu hari ini.</p>
                </div>
            </div>

            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="glass-card text-center">
                    <div class="step-number">2</div>
                    <div class="step-icon">📸</div> 
                    <h4 class="fw-bold mb-3 text-white">Strike a Pose</h4>
                    <p class="text-white-50">Siapkan gaya terbaikmu! Timer otomatis akan menghitung mundur. Cheese!</p>
                </div>
            </div>

            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="glass-card text-center">
                    <div class="step-number">3</div>
                    <div class="step-icon">💾</div> 
                    <h4 class="fw-bold mb-3 text-white">Download & Share</h4>
                    <p class="text-white-50">Foto tersimpan otomatis. Download ke HP-mu atau share langsung ke medsos.</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center" style="margin-top: 80px;">
            <div class="col-lg-8 text-center" data-aos="zoom-in">
                <div class="glass-card p-5" style="background: rgba(74, 222, 128, 0.1); border-color: #4ade80;">
                    <h2 class="fw-bold mb-3 text-white">Ready to Pose?</h2>
                    <p class="text-white-50 mb-4">Jangan biarkan momen spesialmu terlewat begitu saja.</p>
                    <a href="{{ url('/capture') }}" class="btn btn-hero rounded-pill px-5 py-3 fw-bold shadow-lg">
                        📸 Start Photo Booth Now
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection