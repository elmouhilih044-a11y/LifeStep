<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $user = User::create($data);

        Auth::login($user);
        $request->session()->regenerate();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'owner') {
            return redirect()->route('logements.index');
        }

        return redirect()->route('life_profiles.create');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

   public function login(LoginRequest $request)
{
    $data = $request->validated();

    if (Auth::attempt($data)) {
        $request->session()->regenerate();
        $user = Auth::user();

      
        if (!$user->is_active) {
            Auth::logout();

            return back()->withErrors([
                'error' => 'Votre compte a été désactivé.'
            ]);
        }

    
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

     
        if ($user->role === 'owner') {
            return redirect()->route('logements.index');
        }

        if (!$user->lifeProfile) {
            return redirect()->route('life_profiles.create');
        }

        return redirect()->route('logements.index');
    }

    
    return back()->withErrors([
        'error' => 'Email ou mot de passe incorrect'
    ]);
}
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}