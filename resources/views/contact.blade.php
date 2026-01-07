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
        
        /* Full height minus navbar */
        min-height: calc(100vh - 56px);
        width: 100vw;
        margin-left: calc(-50vw + 50%); /* Trik Full Width */
        margin-top: -1.5rem;
        padding-top: 100px; /* Padding atas besar agar tidak ketutup navbar */
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

    /* 3. TYPOGRAPHY */
    .section-title {
        color: #4ade80; /* Hijau Tosca */
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

    /* 4. CONTACT INFO ITEM */
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

    /* 5. FORM STYLES */
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

    .form-control-custom::placeholder {
        color: rgba(255, 255, 255, 0.5);
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
                                
                                <form>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="text" class="form-control-custom" placeholder="Your Name">
                                        </div>
                                        <div class="col-md-6">
                                            <input type="email" class="form-control-custom" placeholder="Your Email">
                                        </div>
                                    </div>
                                    
                                    <input type="text" class="form-control-custom" placeholder="Subject">
                                    
                                    <textarea class="form-control-custom" rows="4" placeholder="Write your message here..."></textarea>
                                    
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
@endsection