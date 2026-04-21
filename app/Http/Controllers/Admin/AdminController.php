<?php

namespace App\Http\Controllers\Admin;

use App\Models\Logement;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class AdminController extends Controller
{
   public function index()
    {
        $totalUsers = User::count();
        $totalOwners = User::where('role', 'owner')->count();
        $totalLogements = Logement::count();
        $availableLogements = Logement::where('status', 'available')->count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalOwners',
            'totalLogements',
            'availableLogements'
        ));
    }
    public function toggleBan(User $user)
{
    if ($user->role === 'admin') {
        return back()->with('error', 'Impossible de bannir un administrateur.');
    }

    $user->is_active = !$user->is_active;
    $user->save();

    return back()->with('success', $user->is_active ? 'Utilisateur débanni avec succès.' : 'Utilisateur banni avec succès.');
}
}
