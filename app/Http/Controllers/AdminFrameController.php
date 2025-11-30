<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Frame;
use Illuminate\Support\Facades\Storage;

class AdminFrameController extends Controller
{
    // halaman admin index (list frames + upload)
    public function index()
    {
        $frames = Frame::all();
        return view('admin.frames.index', compact('frames'));
    }

    // proses upload frame
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'image' => 'required|image|mimes:png,jpg,jpeg'
        ]);

        $path = $request->file('image')->store('frames', 'public');

        Frame::create([
            'name' => $request->name,
            'image_path' => $path,
            'active' => true,
        ]);

        return redirect('/admin')->with('success', 'Frame berhasil ditambahkan!');
    }

    // delete frame
    public function destroy($id)
    {
        $frame = Frame::findOrFail($id);

        // hapus file fisik
        if (Storage::disk('public')->exists($frame->image_path)) {
            Storage::disk('public')->delete($frame->image_path);
        }

        // hapus database
        $frame->delete();

        return redirect('/admin')->with('success', 'Frame berhasil dihapus!');
    }
}
