@extends('layouts.app')

@section('content')
<style>
/* ---------------------------------- */
/* 1. BACKGROUND UTAMA (ANIMATED GRADIENT SAMA DENGAN HOME) */
/* ---------------------------------- */
.main-wrapper {
    /* Warna Gradasi Animated (Sama dengan Home) */
    background: linear-gradient(-45deg, #2b1055, #4e2a84, #7597de, #ed1e79);
    background-size: 400% 400%; /* Memperbesar background agar bisa digeser */
    
    /* Menjalankan animasi 'gradientBG' selama 15 detik, loop selamanya */
    animation: gradientBG 15s ease infinite;

    min-height: calc(100vh - 56px); /* Full height dikurangi tinggi navbar */
    width: 100vw; /* Paksa lebar penuh layar */
    margin-left: calc(-50vw + 50%); /* Trik agar keluar dari container layout */
    margin-top: -1.5rem; /* Naik sedikit agar nempel navbar */
    padding-top: 30px;
    padding-bottom: 50px;
    color: white; /* Semua teks jadi putih */
    font-family: 'Inter', sans-serif;
    overflow-x: hidden;
}

/* Keyframes untuk menggerakkan background */
@keyframes gradientBG {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}

/* Judul Section (Warna Tosca seperti Login) */
.section-title {
    color: #4ade80; 
    font-weight: 800;
    text-shadow: 0 0 10px rgba(74, 222, 128, 0.3);
    margin-bottom: 15px;
}

/* ---------------------------------- */
/* STYLE UNTUK FUNGSI CAPTURE */
/* ---------------------------------- */
.capture-wrapper {
    position: relative;
    width: 100%;
    max-width: 720px;
    aspect-ratio: 4 / 3;
    background: #000;
    overflow: hidden;
    border-radius: 20px; /* Lebih rounded */
    margin: 0 auto;
    border: 4px solid rgba(255, 255, 255, 0.2); /* Border transparan */
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
}

#camera video,
#camera canvas {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
}

.overlay-frame {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    pointer-events: none;
}

#countdown {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 80px;
    color: white;
    font-weight: bold;
    text-shadow: 3px 3px 10px rgba(0,0,0,0.8);
    display: none;
    pointer-events: none;
    z-index: 100;
}

#flash {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: white;
    opacity: 0;
    pointer-events: none;
    z-index: 999;
}

/* ---------------------------------- */
/* PILIHAN FRAME */
/* ---------------------------------- */
.frame-thumb {
    width: 80px;
    border: 3px solid transparent;
    cursor: pointer;
    border-radius: 10px;
    transition: 0.3s;
    background: rgba(255,255,255,0.1); /* Background tipis kotak frame */
}

.frame-thumb:hover {
    transform: scale(1.1);
}

.frame-thumb.selected {
    border-color: #4ade80; /* Hijau tosca saat dipilih */
    box-shadow: 0 0 15px rgba(74, 222, 128, 0.5);
    transform: scale(1.05);
}

#noFrame {
    color: white;
    border-color: white;
}
#noFrame:hover {
    background: white;
    color: #662d8c;
}

/* ---------------------------------- */
/* PRINTER ANIMATION & PREVIEW */
/* ---------------------------------- */
#collage-preview {
    display: none;
    margin: 0 auto; 
    max-width: 100%; 
    padding-top: 5px;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.mini-previews {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin: 15px 0;
}

.mini-previews img {
    width: 100px;
    height: auto;
    border-radius: 8px;
    border: 2px solid rgba(255,255,255,0.5);
}

.printer-stage {
    position: relative;
    width: 320px; 
    height: 520px; 
    margin: 0 auto;
    display: flex;
    justify-content: center;
}

.printer-casing-style {
    background: #f0f0f0; /* Tetap putih/abu agar kontras dengan background ungu */
    width: 100%;
    position: absolute; 
    left: 0;
}

.printer-head-top {
    z-index: 30;
    top: 0;
    height: 40px; 
    border-radius: 15px 15px 0 0;
    box-shadow: 0 -2px 5px rgba(0,0,0,0.05) inset;
    display: flex;
    align-items: flex-end;
    justify-content: center;
}

.printer-slot-hole {
    width: 240px; 
    height: 18px; 
    background: #1a1a1a;
    border-radius: 10px;
    box-shadow: inset 0 2px 5px rgba(0,0,0,0.8);
    margin-bottom: -9px; 
    position: relative;
    z-index: 40;
}

.paper-wrapper {
    position: absolute; 
    z-index: 20;
    width: 220px;
    left: 50%;
    transform: translateX(-50%);
    top: 28px; 
    background: white;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    max-height: 0;
    overflow: hidden;
}

.printer-head-bottom {
    z-index: 10;
    top: 40px;
    height: 35px;
    border-radius: 0 0 15px 15px;
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}

.printing-active {
    animation: print-process 8s steps(60, end) forwards;
}

@keyframes print-process {
    0% { max-height: 0; }
    100% { max-height: 800px; } 
}

/* ---------------------------------- */
/* BUTTONS (Sesuai Tema) */
/* ---------------------------------- */
.btn-capture {
    background: linear-gradient(to right, #f472b6, #22d3ee);
    border: none;
    border-radius: 50px;
    font-weight: bold;
    padding: 12px 40px;
    color: white;
    font-size: 1.1rem;
    box-shadow: 0 4px 15px rgba(34, 211, 238, 0.4);
    transition: 0.3s;
}

.btn-capture:hover {
    transform: scale(1.05);
    box-shadow: 0 6px 20px rgba(34, 211, 238, 0.6);
    color: white;
}

.mt-2-custom {
    display: flex;
    justify-content: center;
    gap: 15px;
    margin-top: 20px;
}
</style>

<div class="main-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">

                <div class="capture-wrapper mb-4" id="captureBox">
                    <div id="camera"></div>
                    <img id="overlay" class="overlay-frame" src="" style="display:none;">
                    <div id="countdown"></div>
                    <div id="flash"></div>
                </div>

                <div id="collage-preview" class="mb-4" style="display: none;">
                    <h5 class="section-title mb-4">✨ Your Photo Result ✨</h5> 
                    
                    <div class="printer-stage">
                        <div class="printer-head-top printer-casing-style">
                            <div class="printer-slot-hole"></div>
                        </div>

                        <div class="paper-wrapper" id="paperArea">
                            <img id="collageImg" src="" style="width:100%;">
                        </div>

                        <div class="printer-head-bottom printer-casing-style"></div>
                    </div>
                    <div style="height: 20px;"></div> 
                </div>

                <div id="frameSection">
                    <h5 class="section-title">Choose Frame</h5>
                    <div id="frameChooser" class="d-flex justify-content-center flex-wrap mb-4">
                        <button id="noFrame" class="btn btn-sm btn-outline-light mb-2 me-2" style="border-radius: 20px;">No Frame</button>
                        @foreach($frames as $f)
                        <div class="me-2 mb-3 text-center">
                            <img src="{{ asset('storage/'.$f->image_path) }}" data-id="{{ $f->id }}" class="frame-thumb">
                            <div style="font-size:11px; margin-top:5px; color: rgba(255,255,255,0.8);">{{ $f->name }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="mini-previews" id="miniPreviews"></div>

                <div class="mt-2-custom">
                    <button id="btnCapture" class="btn btn-capture">📸 Capture</button>
                    
                    <button id="btnRetake" class="btn btn-outline-light rounded-pill px-4 fw-bold" style="display:none;">
                        🔄 Retake
                    </button>
                    <button id="btnSave" class="btn btn-capture" style="display:none;">
                        💾 Save to Gallery
                    </button>
                </div>

                <form id="saveForm" method="POST" action="{{ route('photos.store') }}">
                    @csrf
                    <input type="hidden" name="image" id="collageInput">
                    <input type="hidden" name="frame_id" id="frameInput">
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
<script>
    /* SCRIPT TETAP SAMA SEPERTI SEBELUMNYA, TIDAK ADA PERUBAHAN LOGIKA */
    Webcam.set({
        width: 720,
        height: 540,
        image_format: 'jpeg',
        jpeg_quality: 92,
        constraints: { video: true }
    });
    Webcam.attach('#camera');

    let selectedFrame = null;
    const overlay = document.getElementById('overlay');
    const countdownEl = document.getElementById('countdown');
    const flash = document.getElementById('flash');
    const miniPreviews = document.getElementById('miniPreviews');
    const collagePreview = document.getElementById('collage-preview');
    const collageImg = document.getElementById('collageImg');
    const frameSection = document.getElementById('frameSection');
    const captureBox = document.getElementById('captureBox');
    const btnCapture = document.getElementById('btnCapture');

    function loadImage(src){
        return new Promise(resolve=>{
            if(!src) resolve(null);
            const img = new Image();
            img.onload = () => resolve(img);
            img.src = src;
        });
    }

    async function mergeFrameToSinglePhoto(photoDataUri, frameSrc) {
        const img = await loadImage(photoDataUri);
        const frameImg = await loadImage(frameSrc);
        if (!frameImg) return photoDataUri;

        const canvas = document.createElement('canvas');
        canvas.width = img.width;
        canvas.height = img.height;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(img, 0, 0);
        ctx.drawImage(frameImg, 0, 0, canvas.width, canvas.height); 
        return canvas.toDataURL('image/png');
    }

    document.querySelectorAll('.frame-thumb').forEach(item=>{
        item.addEventListener('click',()=>{
            document.querySelectorAll('.frame-thumb').forEach(i=>i.classList.remove('selected'));
            item.classList.add('selected');
            selectedFrame = item.dataset.id;
            overlay.src = item.src;
            overlay.style.display = 'block';
            document.getElementById('frameInput').value = selectedFrame;
        });
    });

    document.getElementById('noFrame').addEventListener('click',()=>{
        document.querySelectorAll('.frame-thumb').forEach(i=>i.classList.remove('selected'));
        selectedFrame = null;
        overlay.style.display = 'none';
        document.getElementById('frameInput').value = '';
    });

    async function countdown(seconds){
        return new Promise(resolve=>{
            countdownEl.innerText = seconds;
            countdownEl.style.display = 'block';
            let interval = setInterval(()=>{
                seconds--;
                if(seconds > 0) countdownEl.innerText = seconds;
                else {
                    clearInterval(interval);
                    countdownEl.style.display = 'none';
                    resolve();
                }
            }, 1000);
        });
    }

    function snapPhoto(){
        return new Promise(resolve=>{
            Webcam.snap(async data_uri=>{
                flash.style.opacity = 1;
                setTimeout(() => { flash.style.opacity = 0; }, 150);
                resolve(data_uri); 
            });
        });
    }

    btnCapture.addEventListener('click', async () => {
        frameSection.style.display = 'none';
        btnCapture.style.display = 'none';
        
        miniPreviews.innerHTML = '';
        collagePreview.style.display = 'none';
        let photos = [];
        
        const currentFrameId = selectedFrame;
        const currentFrameSrc = overlay.src;

        for(let i=0; i<3; i++){
            await countdown(3);
            const rawDataUri = await snapPhoto();
            photos.push(rawDataUri);

            const miniImg = document.createElement('img');
            if (currentFrameId && currentFrameSrc) {
                const framedMiniUri = await mergeFrameToSinglePhoto(rawDataUri, currentFrameSrc);
                miniImg.src = framedMiniUri;
            } else {
                miniImg.src = rawDataUri;
            }
            miniPreviews.appendChild(miniImg);
        }

        const canvas = document.createElement('canvas');
        const imgObjs = [];
        for(let p of photos){
            const img = new Image();
            img.src = p;
            imgObjs.push(img);
            await new Promise(r => img.onload = r);
        }

        canvas.width = imgObjs[0].width;
        canvas.height = imgObjs[0].height * 3;
        const ctx = canvas.getContext('2d');

        for(let i=0; i<imgObjs.length; i++){
            ctx.drawImage(imgObjs[i], 0, imgObjs[0].height * i);
        }
        
        const previewDataUri = canvas.toDataURL('image/png'); 

        if (currentFrameId && currentFrameSrc) {
            const previewImage = await loadImage(previewDataUri);
            const previewCanvas = document.createElement('canvas');
            previewCanvas.width = previewImage.width;
            previewCanvas.height = previewImage.height;
            const previewCtx = previewCanvas.getContext('2d');
            previewCtx.drawImage(previewImage, 0, 0);
            
            const slotHeight = previewImage.height / 3;
            for(let i=0; i<3; i++){
                const frameSlot = await loadImage(currentFrameSrc);
                previewCtx.drawImage(frameSlot, 0, i * slotHeight, previewImage.width, slotHeight);
            }
            collageImg.src = previewCanvas.toDataURL('image/png');
        } else {
            collageImg.src = previewDataUri;
        }

        captureBox.style.display = 'none';
        miniPreviews.style.display = 'none';
        collagePreview.style.display = 'flex'; // Flex agar center

        const paper = document.getElementById('paperArea');
        paper.classList.remove('printing-active'); 
        void paper.offsetWidth; 
        paper.classList.add('printing-active'); 

        document.getElementById('collageInput').value = previewDataUri; 
        document.getElementById('btnRetake').style.display = 'inline-block';
        document.getElementById('btnSave').style.display = 'inline-block';
    });

    document.getElementById('btnRetake').addEventListener('click', () => {
        miniPreviews.innerHTML = '';
        collagePreview.style.display = 'none';
        miniPreviews.style.display = 'flex';
        
        captureBox.style.display = 'block';
        frameSection.style.display = 'block';
        btnCapture.style.display = 'inline-block';
        
        document.getElementById('btnRetake').style.display = 'none';
        document.getElementById('btnSave').style.display = 'none';
    });

    document.getElementById('btnSave').addEventListener('click', () => {
        document.getElementById('saveForm').submit();
    });
</script>
@endpush