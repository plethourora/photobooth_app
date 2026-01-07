@extends('layouts.app')

@section('content')
<style>
    /* ---------------------------------- */
    /* 1. BACKGROUND UTAMA (ANIMATED GRADIENT) */
    /* ---------------------------------- */
    .about-wrapper {
        /* Warna Gradasi Animated (Sama dengan halaman lainnya) */
        background: linear-gradient(-45deg, #2b1055, #4e2a84, #7597de, #ed1e79);
        background-size: 400% 400%; /* Memperbesar background agar bisa digeser */
        
        /* Menjalankan animasi 'gradientBG' selama 15 detik, loop selamanya */
        animation: gradientBG 15s ease infinite;

        min-height: calc(100vh - 80px);
        width: 100vw;
        margin-left: calc(-50vw + 50%);
        margin-top: -80px;
        padding-top: 120px;
        padding-bottom: 50px;
        font-family: 'Poppins', sans-serif;
        color: white;
        overflow-x: hidden;
    }

    /* Keyframes untuk menggerakkan background */
    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* 2. TYPOGRAPHY & COMPONENTS */
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
        font-size: 3rem; 
        margin-bottom: 20px; 
        background: linear-gradient(to right, #fff, #f472b6); 
        -webkit-background-clip: text; 
        -webkit-text-fill-color: transparent; 
    }
    
    .text-description { 
        color: rgba(255, 255, 255, 0.8); 
        line-height: 1.8; 
        font-size: 1.1rem; 
    }
    
    .glass-card { 
        background: rgba(255, 255, 255, 0.05); 
        border: 1px solid rgba(255, 255, 255, 0.1); 
        border-radius: 20px; 
        padding: 30px; 
        backdrop-filter: blur(10px); 
        transition: 0.3s; 
        height: 100%; 
    }
    
    .glass-card:hover { 
        background: rgba(255, 255, 255, 0.1); 
        transform: translateY(-10px); 
        border-color: #4ade80; 
        box-shadow: 0 10px 30px rgba(74, 222, 128, 0.2); 
    }
    
    .feature-icon {
        font-size: 2.5rem;
        margin-bottom: 20px;
        color: #ffffff; 
        text-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    
    .dev-img-container {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        overflow: hidden;
        margin: 0 auto 20px;
        border: 3px solid rgba(255,255,255,0.2);
        box-shadow: 0 0 15px rgba(237, 30, 121, 0.5);
        background: #fff;
    }
    
    .dev-img { width: 100%; height: 100%; object-fit: cover; }
    
    @keyframes float { 
        0% { transform: translateY(0px); } 
        50% { transform: translateY(-15px); } 
        100% { transform: translateY(0px); } 
    }
    .floating { animation: float 4s ease-in-out infinite; }
    
    @media (max-width: 768px) { 
        .section-title { font-size: 2.5rem; } 
        .about-wrapper { text-align: center; } 
        .mt-lg-0 { margin-top: 3rem !important; } 
    }
    
    .dev-role { 
        color: #4ade80; 
        font-weight: 600; 
        font-size: 0.9rem; 
        display: block; 
        margin-bottom: 15px; 
    }
    
    .dev-quote { 
        font-size: 0.9rem; 
        color: rgba(255,255,255,0.7); 
        font-style: italic; 
    }
</style>

<div class="about-wrapper">
    <div class="container">
        
        <div class="row align-items-center mb-5">
            <div class="col-lg-6" data-aos="fade-right">
                <span class="section-subtitle">About PoseLab</span>
                <h1 class="section-title">More Than Just A Photo Booth.</h1>
                <p class="text-description mb-4">
                    PoseLab adalah platform photobooth digital berbasis web yang dirancang untuk menangkap momen terbaikmu dengan sentuhan teknologi modern.
                    <br><br>
                    Dibangun menggunakan <strong>Laravel</strong>, kami menghadirkan pengalaman foto instan yang estetik langsung dari browser Anda.
                </p>
                <a href="{{ url('/capture') }}" class="btn btn-primary rounded-pill px-4 py-2 fw-bold shadow-lg">
                    Start Now 📸
                </a>
            </div>
            <div class="col-lg-6 text-center text-lg-end mt-5 mt-lg-0" data-aos="zoom-in" data-aos-delay="200">
                <img src="https://cdn-icons-png.flaticon.com/512/10473/10473491.png" alt="Camera" class="img-fluid floating" style="width: 100%; max-width: 500px; filter: drop-shadow(0 15px 30px rgba(0,0,0,0.4));">
            </div>
        </div>

        <div class="row mb-5" style="margin-top: 100px;">
            <div class="col-12 text-center mb-5" data-aos="fade-up">
                <h2 class="fw-bold section-title" style="font-size: 2.5rem;">Why Choose Us?</h2>
            </div>
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="glass-card text-center">
                    <div class="feature-icon">⚡</div> <h4 class="fw-bold mb-3">Instant Capture</h4> <p class="text-white-50">Tangkap foto secara realtime.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="glass-card text-center">
                    <div class="feature-icon">🎨</div> <h4 class="fw-bold mb-3">Creative Frames</h4> <p class="text-white-50">Berbagai bingkai unik dan estetik.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="glass-card text-center">
                    <div class="feature-icon">🔒</div> <h4 class="fw-bold mb-3">Private Gallery</h4> <p class="text-white-50">Simpan aman di galeri pribadi.</p>
                </div>
            </div>
        </div>

        <div class="row" style="margin-top: 100px;">
            <div class="col-12 text-center mb-5" data-aos="fade-up">
                <h3 class="fw-bold section-title" style="font-size: 2.5rem;">Meet The Developers</h3>
                <p class="text-white-50">Tim hebat dibalik PoseLab</p>
            </div>
        </div>

        <div class="row justify-content-center mb-5">
            
            <div class="col-md-6 col-lg-3 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="glass-card text-center p-4">
                    <div class="dev-img-container">
                        <img src="{{ asset('img/1.png') }}" class="dev-img" alt="Dev 1">
                    </div>
                    <h5 class="fw-bold text-white mb-1">Keisha Naiza Djalle</h5>
                    <span class="dev-role">Backend Developer</span>
                    <p class="dev-quote">Membuat fitur CRUD</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="glass-card text-center p-4">
                    <div class="dev-img-container">
                        <img src="{{ asset('img/2.png') }}" class="dev-img" alt="Dev 2">
                    </div>
                    <h5 class="fw-bold text-white mb-1">Luvita Rizki Ruswandi</h5>
                    <span class="dev-role">Frontend Developer</span>
                    <p class="dev-quote">Membuat tampilan website</p>
                </div>
            </div>

            <div class="col-md-6 col-lg-3 mb-4" data-aos="fade-up" data-aos-delay="300">
                <div class="glass-card text-center p-4">
                    <div class="dev-img-container">
                        <img src="{{ asset('img/3.png') }}" class="dev-img" alt="Dev 3">
                    </div>
                    <h5 class="fw-bold text-white mb-1">Mutiara Syafitri Kurnniawan</h5>
                    <span class="dev-role">Frontend Developer</span>
                    <p class="dev-quote">Membuat tampilan website</p>
                </div>
            </div>

             <div class="col-md-6 col-lg-3 mb-4" data-aos="fade-up" data-aos-delay="400">
                <div class="glass-card text-center p-4">
                    <div class="dev-img-container">
                        <img src="{{ asset('img/4.png') }}" class="dev-img" alt="Dev 4">
                    </div>
                    <h5 class="fw-bold text-white mb-1">Cantika Ismayanie</h5>
                    <span class="dev-role">Frontend Developer</span>
                    <p class="dev-quote">Membuat tampilan website</p>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection