@extends('layouts.app')

@section('content')
<style>
    /* Wrapper kamera supaya ratio stabil */
    .capture-wrapper {
        position: relative;
        width: 100%;
        max-width: 720px;
        aspect-ratio: 4 / 3;
        background: #000;
        overflow: hidden;
        border-radius: 8px;
    }

    #camera video,
    #camera canvas {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important;
    }

    /* Overlay frame kamera */
    .overlay-frame {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
    }

    /* Preview juga menggunakan ratio 4:3 */
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

    #preview {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Overlay frame untuk preview */
    #preview-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        display: none;
    }

    .frame-thumb {
        width: 80px;
        border: 2px solid transparent;
        cursor: pointer;
        border-radius: 6px;
    }

    .frame-thumb.selected {
        border-color: #0d6efd;
    }
</style>

<div class="row">
    <div class="col-md-8">
        <h4>Capture Photo</h4>

        {{-- Kamera --}}
        <div class="capture-wrapper mb-3" id="captureBox">
            <div id="camera"></div>
            <img id="overlay" class="overlay-frame" src="" style="display:none;">
        </div>

        {{-- Preview --}}
        <div id="preview-wrapper" class="mb-3">
            <img id="preview" src="">
            <img id="preview-overlay" class="overlay-frame">
        </div>

        {{-- Buttons --}}
        <div>
            <button id="btnCapture" class="btn btn-success">Capture</button>
            <button id="btnRetake" class="btn btn-secondary" style="display:none;">Retake</button>
            <button id="btnSave" class="btn btn-primary" style="display:none;">Save Photo</button>
        </div>

        {{-- Hidden form --}}
        <form id="saveForm" method="POST" action="{{ route('photos.store') }}">
            @csrf
            <input type="hidden" name="image" id="imageInput">
            <input type="hidden" name="frame_id" id="frameInput">
        </form>
    </div>

    <div class="col-md-4">
        <h5>Choose Frame</h5>
        <div id="framesList" class="d-flex flex-wrap">

            <button id="noFrame" class="btn btn-sm btn-outline-secondary mb-2">No Frame</button>

            @foreach($frames as $f)
            <div class="me-2 mb-3 text-center">
                <img src="{{ asset('storage/'.$f->image_path) }}"
                     data-id="{{ $f->id }}"
                     class="frame-thumb">
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
    /* ==========================
       WEBCAM SETUP
    ========================== */
    Webcam.set({
        width: 720,
        height: 540,
        image_format: 'jpeg',
        jpeg_quality: 92,
        constraints: {
            video: true
        }
    });
    Webcam.attach('#camera');

    let selectedFrame = null;
    const overlay = document.getElementById('overlay');
    const previewOverlay = document.getElementById('preview-overlay');

    /* ==========================
       SELECT FRAME
    ========================== */
    document.querySelectorAll('.frame-thumb').forEach(item => {
        item.addEventListener('click', () => {
            document.querySelectorAll('.frame-thumb')
                .forEach(i => i.classList.remove('selected'));

            item.classList.add('selected');
            selectedFrame = item.dataset.id;

            overlay.src = item.src;
            overlay.style.display = 'block';

            previewOverlay.src = item.src;
            previewOverlay.style.display = 'block';

            document.getElementById('frameInput').value = selectedFrame;
        });
    });

    document.getElementById('noFrame').addEventListener('click', () => {
        document.querySelectorAll('.frame-thumb')
            .forEach(i => i.classList.remove('selected'));

        selectedFrame = null;
        overlay.style.display = 'none';
        previewOverlay.style.display = 'none';
        document.getElementById('frameInput').value = '';
    });

    /* ==========================
       CAPTURE
    ========================== */
    document.getElementById('btnCapture').addEventListener('click', () => {
        Webcam.snap(function(data_uri) {

            // show preview
            document.getElementById('preview').src = data_uri;
            document.getElementById('preview-wrapper').style.display = 'block';

            // apply frame overlay to preview
            if (selectedFrame) {
                previewOverlay.style.display = 'block';
            }

            // hide camera
            document.getElementById('captureBox').style.display = 'none';

            // save data
            document.getElementById('imageInput').value = data_uri;

            // toggle buttons
            document.getElementById('btnCapture').style.display = 'none';
            document.getElementById('btnRetake').style.display = 'inline-block';
            document.getElementById('btnSave').style.display = 'inline-block';
        });
    });

    /* ==========================
       RETAKE
    ========================== */
    document.getElementById('btnRetake').addEventListener('click', () => {
        document.getElementById('preview-wrapper').style.display = 'none';
        document.getElementById('captureBox').style.display = 'block';

        document.getElementById('btnCapture').style.display = 'inline-block';
        document.getElementById('btnRetake').style.display = 'none';
        document.getElementById('btnSave').style.display = 'none';
    });

    /* ==========================
       SAVE PHOTO
    ========================== */
    document.getElementById('btnSave').addEventListener('click', () => {
        document.getElementById('saveForm').submit();
    });
</script>
@endpush
