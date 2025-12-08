@extends('layouts.app')

@section('content')
<style>
.capture-wrapper {
    position: relative;
    width: 100%;
    max-width: 720px;
    aspect-ratio: 4 / 3;
    background: #000;
    overflow: hidden;
    border-radius: 8px;
}
#camera video, #camera canvas {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
}
.overlay-frame {
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    pointer-events: none;
}
#countdown {
    position: absolute;
    top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    font-size: 72px;
    color: white;
    font-weight: bold;
    text-shadow: 2px 2px 6px black;
    display: none;
    pointer-events: none;
}
#flash {
    position: absolute;
    top:0; left:0;
    width:100%; height:100%;
    background:white;
    opacity:0;
    pointer-events:none;
    z-index:999;
}
#preview-wrapper {
    position: relative;
    width: 100%;
    max-width: 720px;
    aspect-ratio: 4 / 3;
    overflow: hidden;
    border-radius: 8px;
    background: #000;
    display: none;
}
#preview { width: 100%; height: 100%; object-fit: cover; }
#preview-overlay { position: absolute; top:0; left:0; width:100%; height:100%; pointer-events:none; display:block; }

.frame-thumb { width:80px; border:2px solid transparent; cursor:pointer; border-radius:6px; }
.frame-thumb.selected { border-color: #0d6efd; }
</style>

<div class="row">
    <div class="col-md-8">
        <h4>Capture Photo</h4>

        <!-- Camera Wrapper -->
        <div id="cameraWrapper">
            <div class="capture-wrapper mb-3" id="captureBox">
                <div id="camera"></div>
                <img id="overlay" class="overlay-frame" src="" style="display:none;">
                <div id="countdown"></div>
                <div id="flash"></div>
            </div>
        </div>

        <!-- Preview -->
        <div id="preview-wrapper" class="mb-3">
            <img id="preview" src="">
            <img id="preview-overlay" class="overlay-frame">
        </div>

        <div>
            <button id="btnCapture" class="btn btn-success">Capture</button>
            <button id="btnRetake" class="btn btn-secondary" style="display:none;">Retake</button>
            <button id="btnSave" class="btn btn-primary" style="display:none;">Save Photo</button>
        </div>

        <form id="saveForm" method="POST" action="{{ route('photos.store') }}">
            @csrf
            <input type="hidden" name="image" id="imageInput">
            <input type="hidden" name="frame_id" id="frameInput">
        </form>
    </div>

    <!-- Frame chooser column -->
    <div class="col-md-4" id="frameColumn">
        <h5>Choose Frame</h5>
        <div id="frameChooser" class="d-flex flex-wrap mb-3">
            <button id="noFrame" class="btn btn-sm btn-outline-secondary mb-2 me-2">No Frame</button>

            @foreach($frames as $f)
            <div class="me-2 mb-3 text-center">
                <img src="{{ asset('storage/'.$f->image_path) }}" data-id="{{ $f->id }}" class="frame-thumb">
                <div style="font-size:12px">{{ $f->name }}</div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
<script>
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
const previewOverlay = document.getElementById('preview-overlay');
const countdownEl = document.getElementById('countdown');
const flash = document.getElementById('flash');

// === Select Frame BEFORE capture
document.querySelectorAll('.frame-thumb').forEach(item => {
    item.addEventListener('click', () => {
        document.querySelectorAll('.frame-thumb').forEach(i => i.classList.remove('selected'));
        item.classList.add('selected');
        selectedFrame = item.dataset.id;
        overlay.src = item.src;
        overlay.style.display = 'block';
        document.getElementById('frameInput').value = selectedFrame;
    });
});

document.getElementById('noFrame').addEventListener('click', () => {
    document.querySelectorAll('.frame-thumb').forEach(i => i.classList.remove('selected'));
    selectedFrame = null;
    overlay.style.display = 'none';
    document.getElementById('frameInput').value = '';
});

// === Capture with countdown & flash
document.getElementById('btnCapture').addEventListener('click', () => {
    let count = 3;
    countdownEl.innerText = count;
    countdownEl.style.display = 'block';

    const timer = setInterval(() => {
        count--;
        if(count > 0){
            countdownEl.innerText = count;
        } else {
            clearInterval(timer);
            countdownEl.style.display = 'none';

            Webcam.snap(data_uri => {
                // flash effect
                flash.style.opacity = 1;
                setTimeout(()=>{ flash.style.opacity = 0; }, 150);

                // show preview
                const previewWrapper = document.getElementById('preview-wrapper');
                const preview = document.getElementById('preview');
                preview.src = data_uri;
                previewWrapper.style.display = 'block';

                // overlay only if frame selected
                if(selectedFrame){
                    previewOverlay.src = overlay.src;
                    previewOverlay.style.display = 'block';
                } else {
                    previewOverlay.style.display = 'none';
                    previewOverlay.src = '';
                }

                // hide camera wrapper and frame chooser column
                document.getElementById('captureBox').style.display = 'none';
                document.getElementById('frameColumn').style.display = 'none';

                // save data
                document.getElementById('imageInput').value = data_uri;

                // toggle buttons
                document.getElementById('btnCapture').style.display = 'none';
                document.getElementById('btnRetake').style.display = 'inline-block';
                document.getElementById('btnSave').style.display = 'inline-block';
            });
        }
    }, 1000);
});

// === Retake
document.getElementById('btnRetake').addEventListener('click', () => {
    document.getElementById('preview-wrapper').style.display = 'none';
    document.getElementById('captureBox').style.display = 'block';
    document.getElementById('frameColumn').style.display = 'block';

    document.getElementById('btnCapture').style.display = 'inline-block';
    document.getElementById('btnRetake').style.display = 'none';
    document.getElementById('btnSave').style.display = 'none';
});

// === Save
document.getElementById('btnSave').addEventListener('click', () => {
    document.getElementById('saveForm').submit();
});
</script>
@endpush