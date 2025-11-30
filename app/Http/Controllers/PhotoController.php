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
    // C: Capture & Store
    // -------------------
    public function create()
    {
        $userId = session('user_id');
        if (!$userId) {
            return redirect('/login')->with('error', 'Silakan login/register dulu untuk mengambil foto.');
        }

        $frames = Frame::where('active', true)->get();
        return view('photos.capture', compact('frames'));
    }

    public function store(Request $request)
    {
        $userId = session('user_id');
        if (!$userId) {
            return redirect('/login')->with('error', 'Silakan login dahulu.');
        }

        $request->validate([
            'image' => 'required', // dataURI
            'frame_id' => 'nullable|exists:frames,id',
        ]);

        $dataUri = $request->input('image');

        // parse base64
        if (preg_match('/^data:image\/(\w+);base64,/', $dataUri, $type)) {
            $data = substr($dataUri, strpos($dataUri, ',') + 1);
            $type = strtolower($type[1]);
            if (!in_array($type, ['jpg', 'jpeg', 'png', 'gif'])) {
                return redirect()->back()->with('error', 'Format file tidak didukung.');
            }
            $data = base64_decode($data);
            if ($data === false) {
                return redirect()->back()->with('error', 'Gagal decode gambar.');
            }
        } else {
            return redirect()->back()->with('error', 'Invalid image data.');
        }

        $timestamp = time();

        // simpan temporary
        $tmpPath = "tmp/{$userId}_{$timestamp}.{$type}";
        Storage::disk('public')->put($tmpPath, $data);

        $image = Image::make(storage_path("app/public/{$tmpPath}"));

        // resize max width
        $maxWidth = 1280;
        if ($image->width() > $maxWidth) {
            $image->resize($maxWidth, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        // simpan versi asli tanpa frame
        $originalPath = "photos/original_{$userId}_{$timestamp}.png";
        Storage::disk('public')->put($originalPath, (string) $image->encode('png', 90));

        // apply frame jika ada
        if ($request->frame_id) {
            $frame = Frame::find($request->frame_id);
            if ($frame && Storage::disk('public')->exists($frame->image_path)) {
                $overlay = Image::make(storage_path('app/public/' . $frame->image_path));
                $overlay->resize($image->width(), $image->height(), function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $image->insert($overlay, 'center');
            }
        }

        // save final image
        $fileName = "photos/{$userId}_{$timestamp}.png";
        Storage::disk('public')->put($fileName, (string) $image->encode('png', 90));

        // create thumbnail
        $thumbName = "photos/thumbs/{$userId}_{$timestamp}.jpg";
        $thumbnail = $image->resize(300, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        Storage::disk('public')->put($thumbName, (string) $thumbnail->encode('jpg', 85));

        // cleanup tmp
        Storage::disk('public')->delete($tmpPath);

        // save DB
        Photo::create([
            'user_id' => $userId,
            'filename' => $fileName,
            'thumb_path' => $thumbName,
            'frame_id' => $request->frame_id,
            'original_filename' => $originalPath,
        ]);

        return redirect('/photos')->with('success', 'Foto berhasil disimpan!');
    }

    // -------------------
    // R: Gallery
    // -------------------
    public function index()
    {
        $userId = session('user_id');
        if (!$userId) {
            return redirect('/login')->with('error', 'Silakan login dahulu.');
        }

        $photos = Photo::where('user_id', $userId)->orderBy('created_at', 'desc')->paginate(12);
        return view('photos.gallery', compact('photos'));
    }

    public function show($id)
    {
        $photo = Photo::findOrFail($id);
        return view('photos.show', compact('photo'));
    }

    // -------------------
    // U: Edit / Update frame
    // -------------------
    public function edit($id)
    {
        $photo = Photo::findOrFail($id);
        $frames = Frame::where('active', true)->get();
        return view('photos.edit', compact('photo', 'frames'));
    }

    public function update(Request $request, $id)
    {
        $photo = Photo::findOrFail($id);

        $request->validate([
            'frame_id' => 'nullable|exists:frames,id'
        ]);

        $photo->frame_id = $request->frame_id;

        // mulai dari foto asli
        $originalPath = storage_path('app/public/' . $photo->original_filename);
        $image = Image::make($originalPath);

        // apply overlay baru jika ada frame
        if ($request->frame_id) {
            $frame = Frame::find($request->frame_id);
            if ($frame && Storage::disk('public')->exists($frame->image_path)) {
                $overlay = Image::make(storage_path('app/public/' . $frame->image_path));
                $overlay->resize($image->width(), $image->height(), function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $image->insert($overlay, 'center');
            }
        }

        // simpan ke file utama
        Storage::disk('public')->put($photo->filename, (string) $image->encode('png', 90));

        // update thumbnail
        $thumbnail = $image->resize(300, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        Storage::disk('public')->put($photo->thumb_path, (string) $thumbnail->encode('jpg', 85));

        $photo->save();

        return redirect('/photos')->with('success', 'Frame foto berhasil diperbarui!');
    }

    // -------------------
    // D: Delete
    // -------------------
    public function destroy($id)
    {
        $photo = Photo::findOrFail($id);

        // delete main file
        if ($photo->filename && Storage::disk('public')->exists($photo->filename)) {
            Storage::disk('public')->delete($photo->filename);
        }

        // delete thumbnail
        if ($photo->thumb_path && Storage::disk('public')->exists($photo->thumb_path)) {
            Storage::disk('public')->delete($photo->thumb_path);
        }

        // delete original (jika ada)
        if ($photo->original_filename && Storage::disk('public')->exists($photo->original_filename)) {
            Storage::disk('public')->delete($photo->original_filename);
        }

        // hapus data di database
        $photo->delete();

        return redirect('/photos')->with('success', 'Foto berhasil dihapus!');
    }

}
