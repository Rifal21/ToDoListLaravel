<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Menampilkan halaman login.
     */
    public function index()
    {
        return view('login');
    }

    /**
     * Menangani proses login.
     */
    public function authenticate(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);


        if (Auth::attempt($request->only('email', 'password'))) {

            $request->session()->regenerate();


            return redirect()->intended('/home')->with('success', 'Login berhasil!');
        }


        return back()->withErrors([
            'email' => 'email tidak sesuai.',
            'password' => 'password salah.',
        ])->onlyInput('email');
    }


    public function logout(Request $request)
    {
        Auth::logout();


        $request->session()->invalidate();
        $request->session()->regenerateToken();


        return redirect('/')->with('success', 'Logout berhasil!');
    }
}
