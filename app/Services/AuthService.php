<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public function register(array $data)
    {
        $user = User::create($data);

        Auth::login($user);

        return $user;
    }

    public function login(array $data)
    {
        if (!Auth::attempt($data)) {
            return [
                'success' => false,
                'message' => 'Email ou mot de passe incorrect',
                'user' => null,
            ];
        }

        $user = Auth::user();

        if (!$user->is_active) {
            Auth::logout();

            return [
                'success' => false,
                'message' => 'Votre compte a été désactivé.',
                'user' => null,
            ];
        }

        return [
            'success' => true,
            'message' => null,
            'user' => $user,
        ];
    }

    public function redirectAfterAuth(User $user)
    {
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

    public function redirectAfterRegister(User $user)
    {
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'owner') {
            return redirect()->route('logements.index');
        }

        return redirect()->route('life_profiles.create');
    }
}