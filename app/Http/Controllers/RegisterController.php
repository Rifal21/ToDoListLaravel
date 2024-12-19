<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class RegisterController extends Controller
{
    /**
     * Show the registration form.
     */
    public function index()
    {
        return view('register');
    }

    /**
     * Handle registration request.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|min:6|confirmed',
        ]);



        $validated['password'] = Hash::make($validated['password']);


        User::create($validated);


        return redirect('/')->with('success', 'Registration successful!');
    }
}
