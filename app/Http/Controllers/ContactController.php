<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        // Simpan ke database
        Contact::create($request->all());

        // Kembali dengan pesan sukses
        return back()->with('success', 'Pesan Anda telah tersampaikan!');
    }
}