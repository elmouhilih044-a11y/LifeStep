<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

class FavoriteService
{
    public function getUserFavorites()
    {
        $user = Auth::user();
        return $user->favorites;
    }

    public function addToFavorites($logementId)
    {
        $user = Auth::user();
        $user->favorites()->syncWithoutDetaching([$logementId]);
    }

    public function removeFromFavorites($logementId)
    {
        $user = Auth::user();
        $user->favorites()->detach($logementId);
    }
}