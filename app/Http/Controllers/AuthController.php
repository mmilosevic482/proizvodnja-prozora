<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // Prikaz login forme
    public function showLogin()
    {
        return view('auth.login');
    }

    // Obrada login forme
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('/dashboard');
        }

        return back()->withErrors(['email' => 'Pogrešni podaci za prijavu.']);
    }

    // Odjava
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    // Prikaz register forme
    public function showRegister()
    {
        return view('auth.register');
    }

    // Obrada register forme
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'radnik', // Dodajemo role iz migracije
        ]);

        Auth::login($user);
        return redirect('/dashboard');
    }
}
