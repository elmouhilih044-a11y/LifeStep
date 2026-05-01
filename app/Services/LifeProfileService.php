<?php

namespace App\Services;

use App\Models\LifeProfile;
use Illuminate\Support\Facades\Auth;

class LifeProfileService
{
    public function createProfile(array $data)
    {
        $existingProfile = LifeProfile::where('user_id', Auth::id())->first();

        if ($existingProfile) {
            return [
                'success' => false,
                'message' => 'Vous avez déjà un profil de vie'
            ];
        }

        $data['user_id'] = Auth::id();
        LifeProfile::create($data);

        return [
            'success' => true
        ];
    }

    public function getUserProfile()
    {
        return LifeProfile::where('user_id', Auth::id())->first();
    }

    public function updateProfile(array $data)
    {
        $profil = LifeProfile::where('user_id', Auth::id())->first();

        if (!$profil) {
            return null;
        }

        $profil->update($data);

        return $profil;
    }
}