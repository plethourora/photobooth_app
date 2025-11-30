<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;
use App\Models\Frame;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    // show capture page
    public function create()
    {
        // only allow logged-in user to save photos
        $userId = session('user_id');

        if (!$userId) {
            return redirect('/login')->with('error', 'Silakan login/register dulu untuk mengambil foto.');
        }

        $frames = Frame::where('active', true)->get();
        return view('photos.capture', compact('frames'));
    }

    // store captured photo (expects data URI from frontend)
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

        $dataUri = $request->input('image'); // data:image/jpeg;base64,...
        // parse base64
        if (preg_match('/^data:image\/(\w+);base64,/', $dataUri, $type)) {
            $data = substr($dataUri, strpos($dataUri, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif

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

        // buat filenames
        $timestamp = time();
        $fileName = "photos/{$userId}_{$timestamp}.png"; // kita simpan png final
        $thumbName = "photos/thumbs/{$userId}_{$timestamp}.jpg";

        // simpan temporary ke storage/app/public/tmp
        $tmpPath = "tmp/{$userId}_{$timestamp}.{$type}";
        Storage::disk('public')->put($tmpPath, $data);

        // buka image via Intervention
        $image = Image::make(storage_path("app/public/{$tmpPath}"));

        // optionally resize to max (example 1280 width)
        $maxWidth = 1280;
        if ($image->width() > $maxWidth) {
            $image->resize($maxWidth, null, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        // apply frame if provided
        if ($request->frame_id) {
            $frame = Frame::find($request->frame_id);
            if ($frame && Storage::disk('public')->exists($frame->image_path)) {
                $framePath = storage_path('app/public/' . $frame->image_path);
                $overlay = Image::make($framePath);

                // resize overlay to match photo dimensions (center)
                $overlay->resize($image->width(), $image->height(), function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                // insert overlay preserving alpha
                $image->insert($overlay, 'center');
            }
        }

        // save final image to storage/public/photos
        $finalPath = $fileName;
        Storage::disk('public')->put($finalPath, (string) $image->encode('png', 90));

        // create thumbnail
        $thumbnail = $image->resize(300, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        });
        Storage::disk('public')->put($thumbName, (string) $thumbnail->encode('jpg', 85));

        // cleanup tmp
        Storage::disk('public')->delete($tmpPath);

        // save record to DB
        $photo = Photo::create([
            'user_id' => $userId,
            'filename' => $finalPath,
            'thumb_path' => $thumbName,
            'frame_id' => $request->frame_id,
            'original_filename' => null,
        ]);

        return redirect('/photos')->with('success', 'Foto berhasil disimpan!');
    }
}
