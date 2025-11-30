<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // login (session)
        session()->put('user_id', $user->id);
        session()->put('user_name', $user->name);

        return redirect('/capture')->with('success', 'Register berhasil. Selamat datang!');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $v = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v)->withInput();
        }

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return redirect()->back()->withErrors(['email' => 'Email atau password salah'])->withInput();
        }

        session()->put('user_id', $user->id);
        session()->put('user_name', $user->name);

        return redirect('/capture')->with('success', 'Login berhasil');
    }

    public function logout()
    {
        session()->forget('user_id');
        session()->forget('user_name');
        return redirect('/')->with('success', 'Logged out');
    }

    // helper to get current user (optional)
    public static function user()
    {
        if (session()->has('user_id')) {
            return User::find(session('user_id'));
        }
        return null;
    }
}
