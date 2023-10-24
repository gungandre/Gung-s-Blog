<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login.index', ['title' => 'Login', 'active' => 'login']);
    }

    public function authenticate(Request $request)
    {

        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required'
        ]);



        //! proses authentikasi login menggunakan Auth

        if (Auth::attempt($credentials)) {

            // ! setelah berhasil login kita regenerate sesision
            $request->session()->regenerate();
            // ! lalu kita menggunakan method intended untuk menjalankan middlewarenya, kita menggunakan redirect biasa tidak menjalankan midleware
            return redirect()->intended('/dashboard');
        }


        // ! with sama dengan session()
        return back()->with('loginError', 'Login Failed!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
