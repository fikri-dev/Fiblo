<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        return view('login.index');
    }

    public function authenticate()
    {
        $credentials = request()->validate([
            'email' => 'required|email:dns',
            'password' => 'required|min:8',
        ]);

        if (Auth::attempt($credentials)) {
            request()->session()->regenerate();
            return redirect()->intended('/dashboard');
        }

        return back()->with(['message' => 'Maaf, data yang kamu masukin ngga cocok', 'type' => 'danger']);
    }

    public function logout()
    {
        Auth::logout();

        // agar masa sessionnya habis, jadi ngga bisa digunakan lagi 
        request()->session()->invalidate();

        // buat token session baru lagi 
        request()->session()->regenerateToken();

        return redirect('/login');
    }
}