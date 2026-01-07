@extends('layouts.app')

@section('content')
<style>
    /* ---------------------------------- */
    /* 1. BACKGROUND UTAMA (ANIMATED GRADIENT) */
    /* ---------------------------------- */
    .contact-wrapper {
        background: linear-gradient(-45deg, #2b1055, #4e2a84, #7597de, #ed1e79);
        background-size: 400% 400%;
        animation: gradientBG 15s ease infinite;
        min-height: calc(100vh - 56px);
        width: 100vw;
        margin-left: calc(-50vw + 50%);
        margin-top: -1.5rem;
        padding-top: 100px;
        padding-bottom: 50px;
        font-family: 'Inter', sans-serif;
        color: white;
    }

    @keyframes gradientBG {
        0% { background-position: 0% 50%; }
        50% { background-position: 100% 50%; }
        100% { background-position: 0% 50%; }
    }

    /* 2. GLASS CARD */
    .glass-card {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        backdrop-filter: blur(15px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        padding: 40px;
        overflow: hidden;
    }

    .section-title {
        color: #4ade80;
        font-weight: 800;
        font-size: 2.5rem;
        margin-bottom: 10px;
        text-shadow: 0 0 15px rgba(74, 222, 128, 0.3);
    }

    .section-subtitle {
        color: rgba(255, 255, 255, 0.7);
        font-size: 1rem;
        margin-bottom: 30px;
    }

    .contact-item {
        display: flex;
        align-items: flex-start;
        margin-bottom: 25px;
        padding: 15px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 15px;
        transition: 0.3s;
        border: 1px solid transparent;
    }

    .contact-item:hover {
        background: rgba(255, 255, 255, 0.1);
        border-color: #4ade80;
        transform: translateX(5px);
    }

    .icon-box {
        background: linear-gradient(135deg, #4ade80, #22d3ee);
        width: 50px;
        height: 50px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        margin-right: 15px;
        box-shadow: 0 5px 15px rgba(74, 222, 128, 0.3);
    }

    .form-control-custom {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white !important;
        border-radius: 10px;
        padding: 12px;
        width: 100%;
        margin-bottom: 15px;
        transition: 0.3s;
    }

    .form-control-custom:focus {
        background: rgba(255, 255, 255, 0.15);
        border-color: #4ade80;
        box-shadow: 0 0 10px rgba(74, 222, 128, 0.3);
        outline: none;
    }

    .btn-send {
        background: linear-gradient(to right, #f472b6, #22d3ee);
        border: none;
        border-radius: 50px;
        padding: 12px 30px;
        color: white;
        font-weight: bold;
        transition: 0.3s;
        width: 100%;
        margin-top: 10px;
    }

    .btn-send:hover {
        opacity: 0.9;
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(244, 114, 182, 0.5);
        color: white;
    }

    /* Tambahan animasi fade untuk notifikasi */
    .fade-out {
        transition: opacity 0.5s ease-out;
    }
</style>

<div class="contact-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="glass-card">
                    <div class="row">
                        <div class="col-md-5 mb-5 mb-md-0">
                            <h2 class="section-title">Get in Touch</h2>
                            <p class="section-subtitle">Punya pertanyaan atau ingin kerjasama? Hubungi kami langsung!</p>

                            <div class="contact-item">
                                <div class="icon-box">📍</div>
                                <div>
                                    <h5 class="fw-bold mb-1">Our Studio</h5>
                                    <p class="mb-0 text-white-50 small">Jl. Telkom No. 12, Bandung, Indonesia</p>
                                </div>
                            </div>

                            <div class="contact-item">
                                <div class="icon-box">💌</div>
                                <div>
                                    <h5 class="fw-bold mb-1">Email Us</h5>
                                    <p class="mb-0 text-white-50 small">poselabid@gmail.com</p>
                                </div>
                            </div>

                            <div class="contact-item">
                                <div class="icon-box">📞</div>
                                <div>
                                    <h5 class="fw-bold mb-1">WhatsApp</h5>
                                    <p class="mb-0 text-white-50 small">+62 81++++++++++</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-7">
                            <div class="p-4" style="background: rgba(0,0,0,0.2); border-radius: 15px;">
                                <h4 class="fw-bold mb-4">Send a Message 🚀</h4>

                                @if(session('success'))
                                    <div id="alert-notif" class="fade-out" style="background: rgba(74, 222, 128, 0.15); border: 1px solid #4ade80; border-radius: 12px; color: #4ade80; padding: 15px; margin-bottom: 25px; backdrop-filter: blur(10px); display: flex; align-items: center;">
                                        <span style="font-size: 1.2rem; margin-right: 10px;">✅</span>
                                        <span>Pesan Anda sudah tersampaikan!</span>
                                    </div>
                                @endif

                                @if($errors->any())
                                    <div id="alert-notif-error" class="fade-out" style="background: rgba(237, 30, 121, 0.15); border: 1px solid #ed1e79; border-radius: 12px; color: #f472b6; padding: 15px; margin-bottom: 25px; backdrop-filter: blur(10px);">
                                        <ul style="margin: 0; padding-left: 15px; font-size: 0.85rem;">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                
                                <form action="{{ route('contact.store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" name="name" class="form-control-custom" placeholder="Your Name" value="{{ old('name') }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="email" name="email" class="form-control-custom" placeholder="Your Email" value="{{ old('email') }}" required>
                                        </div>
                                    </div>
                                    
                                    <input type="text" name="subject" class="form-control-custom" placeholder="Subject" value="{{ old('subject') }}" required>
                                    
                                    <textarea name="message" class="form-control-custom" rows="4" placeholder="Write your message here..." required>{{ old('message') }}</textarea>
                                    
                                    <button type="submit" class="btn btn-send">
                                        Send Message
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Script untuk menghilangkan notifikasi otomatis setelah 3 detik
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = [
            document.getElementById('alert-notif'),
            document.getElementById('alert-notif-error')
        ];

        alerts.forEach(alert => {
            if (alert) {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        alert.style.display = 'none';
                    }, 500); // Waktu transisi fade out
                }, 3000); // Muncul selama 3 detik
            }
        });
    });
</script>
@endsection