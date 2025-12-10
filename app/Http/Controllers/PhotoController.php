<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\Frame;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    // -------------------
    // C: Capture Collage 3x
    // -------------------
    public function create()
    {
        $userId = session('user_id');
        if (!$userId) return redirect('/login')->with('error', 'Silakan login dahulu.');

        $frames = Frame::where('active', true)->get();
        return view('photos.capture', compact('frames'));
    }

    public function store(Request $request)
    {
        $userId = session('user_id');
        if (!$userId) return redirect('/login')->with('error', 'Silakan login dahulu.');

        $request->validate([
            'image' => 'required|string',
            'frame_id' => 'nullable|exists:frames,id'
        ]);

        // $request->image sekarang berisi kolase TANPA FRAME (setelah perbaikan JS)
        $this->saveImage($request->image, $request->frame_id, $userId, $isCollage = true);

        return redirect('/photos')->with('success', 'Collage berhasil disimpan!');
    }

    // -------------------
    // Helper: Save Image / Collage
    // -------------------
    private function saveImage($dataUri, $frameId, $userId, $isCollage = false)
    {
        // Decode base64
        if (preg_match('/^data:image\/(\w+);base64,/', $dataUri, $type)) {
            $data = substr($dataUri, strpos($dataUri, ',') + 1);
            $type = strtolower($type[1]);
            if (!in_array($type, ['jpg','jpeg','png'])) throw new \Exception('Format file tidak didukung.');
            $data = base64_decode($data);
            if ($data === false) throw new \Exception('Gagal decode gambar.');
        } else {
            throw new \Exception('Invalid image data.');
        }

        $timestamp = time();
        $tmpPath = "tmp/{$userId}_{$timestamp}.{$type}";
        Storage::disk('public')->put($tmpPath, $data);

        // $image di sini adalah foto KOLASE MENTAH (TANPA FRAME)
        $image = Image::make(storage_path("app/public/{$tmpPath}"));

        // Resize max width
        $maxWidth = 1280;
        if ($image->width() > $maxWidth) {
            $image->resize($maxWidth, null, function($constraint){
                $constraint->aspectRatio();
                $constraint->upsize();
            });
        }

        // Simpan ORIGINAL IMAGE (SANGAT PENTING: ini harus MENTAH/TANPA FRAME)
        $originalPath = "photos/original_{$userId}_{$timestamp}.png";
        Storage::disk('public')->put($originalPath, (string)$image->encode('png',90));

        // --- Proses Pemberian Frame di Back-End ---
        $finalImage = clone $image; 
        
        if ($frameId) {
            $frame = Frame::find($frameId);
            if ($frame && Storage::disk('public')->exists($frame->image_path)) {
                $overlay = Image::make(storage_path('app/public/' . $frame->image_path));

                $numSlots = $isCollage ? 3 : 1; 
                $slotHeight = intval($finalImage->height() / $numSlots);

                for ($i=0; $i<$numSlots; $i++){
                    $slotOverlay = clone $overlay;
                    $slotOverlay->resize($finalImage->width(), $slotHeight, function($constraint){
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $finalImage->insert($slotOverlay, 'top-left', 0, $i*$slotHeight);
                }
            }
        }

        // File utama (gambar BERFRAME atau TANPA FRAME jika $frameId null)
        $suffix = $isCollage ? '_collage' : '';
        $fileName = "photos/{$userId}_{$timestamp}{$suffix}.png";
        Storage::disk('public')->put($fileName, (string)$finalImage->encode('png',90));

        // Thumbnail
        $thumbName = "photos/thumbs/{$userId}_{$timestamp}{$suffix}.jpg";
        $thumbnail = clone $finalImage;
        $thumbnail->resize(300, null, function($constraint){
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        Storage::disk('public')->put($thumbName, (string)$thumbnail->encode('jpg',85));

        // Cleanup tmp
        Storage::disk('public')->delete($tmpPath);

        // DB
        Photo::create([
            'user_id' => $userId,
            'filename' => $fileName,
            'thumb_path' => $thumbName,
            'frame_id' => $frameId,
            'original_filename' => $originalPath,
        ]);
    }

    // -------------------
    // R: Gallery
    // -------------------
    public function index()
    {
        $userId = session('user_id');
        if (!$userId) return redirect('/login')->with('error','Silakan login dahulu.');

        $photos = Photo::where('user_id', $userId)->orderBy('created_at','desc')->paginate(12);
        return view('photos.gallery', compact('photos'));
    }

    public function show($id)
    {
        $photo = Photo::findOrFail($id);
        return view('photos.show', compact('photo'));
    }

    // -------------------
    // U: Edit / Update Frame (Sudah Benar, selalu mulai dari original_filename)
    // -------------------
    public function edit($id)
    {
        $photo = Photo::findOrFail($id);
        $frames = Frame::where('active', true)->get();
        return view('photos.edit', compact('photo','frames'));
    }

    public function update(Request $request, $id)
    {
        $photo = Photo::findOrFail($id);

        $request->validate(['frame_id'=>'nullable|exists:frames,id']);
        
        // 1. Ambil Gambar Asli (Original Image - TANPA FRAME)
        $originalPath = storage_path('app/public/' . $photo->original_filename);
        if (!file_exists($originalPath)) {
             return back()->with('error', 'File original tidak ditemukan untuk diedit.');
        }

        // Image ini sekarang benar-benar mentah
        $image = Image::make($originalPath); 
        $isCollage = true; 

        // 2. Aplikasikan Frame Baru (Hanya jika frameId ada)
        if($request->frame_id){ 
            $frame = Frame::find($request->frame_id);
            
            if($frame && Storage::disk('public')->exists($frame->image_path)){
                $overlay = Image::make(storage_path('app/public/' . $frame->image_path));

                $numSlots = $isCollage ? 3 : 1;
                $slotHeight = intval($image->height() / $numSlots);

                for($i=0;$i<$numSlots;$i++){
                    $slotOverlay = clone $overlay;
                    $slotOverlay->resize($image->width(), $slotHeight, function($constraint){
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    // Gabungkan frame baru ke gambar asli ($image)
                    $image->insert($slotOverlay,'top-left',0,$i*$slotHeight); 
                }
            }
        } 
        // JIKA "No Frame", $image tetap mentah.

        // 3. Simpan Hasil dan Buat Record Baru
        $timestamp = time();
        $fileName = "photos/{$photo->user_id}_{$timestamp}_edit.png";
        Storage::disk('public')->put($fileName, (string)$image->encode('png',90));

        // Buat thumbnail
        $thumbName = "photos/thumbs/{$photo->user_id}_{$timestamp}_edit.jpg";
        $thumbnail = clone $image;
        $thumbnail->resize(300, null, function($constraint){
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        Storage::disk('public')->put($thumbName, (string)$thumbnail->encode('jpg',85));

        // DB: Buat record baru
        Photo::create([
            'user_id' => $photo->user_id,
            'filename' => $fileName,
            'thumb_path' => $thumbName,
            'frame_id' => $request->frame_id, 
            'original_filename' => $photo->original_filename 
        ]);

        return redirect('/photos')->with('success','Frame foto berhasil diperbarui!');
    }

    // -------------------
    // D: Delete
    // -------------------
    public function destroy($id)
    {
        $photo = Photo::findOrFail($id);

        if($photo->filename && Storage::disk('public')->exists($photo->filename)){
            Storage::disk('public')->delete($photo->filename);
        }
        if($photo->thumb_path && Storage::disk('public')->exists($photo->thumb_path)){
            Storage::disk('public')->delete($photo->thumb_path);
        }

        // original jangan dihapus
        $photo->delete();

        return redirect('/photos')->with('success','Foto berhasil dihapus!');
    }
}