<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Photo;

class GalleryController extends Controller
{
    public function index()
    {
        $userId = session('user_id');
        if (!$userId) {
            return redirect('/login')->with('error', 'Silakan login untuk melihat galeri.');
        }

        $photos = Photo::where('user_id', $userId)->latest()->paginate(12);

        return view('photos.gallery', compact('photos'));
    }

    public function show($id)
    {
        $userId = session('user_id');
        $photo = Photo::findOrFail($id);
        if ($photo->user_id != $userId) {
            abort(403);
        }
        return view('photos.show', compact('photo'));
    }
}
