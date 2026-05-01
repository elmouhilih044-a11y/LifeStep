<?php

namespace App\Services;

use App\Models\Logement;
use App\Models\User;
class AdminService
{
   public function getDashboardStats()
    {
        return [
            'totalUsers' => User::count(),
            'totalOwners' => User::where('role', 'owner')->count(),
            'totalLogements' => Logement::count(),
            'availableLogements' => Logement::where('status', 'available')->count(),
        ];
    }

    public function toggleBan(User $user)
    {
        if ($user->role === 'admin') {
            return [
                'success' => false,
                'message' => 'Impossible de bannir un administrateur.',
            ];
        }

        $user->is_active = !$user->is_active;
        $user->save();

        return [
            'success' => true,
            'message' => $user->is_active
                ? 'Utilisateur débanni avec succès.'
                : 'Utilisateur banni avec succès.',
        ];
    }
}
