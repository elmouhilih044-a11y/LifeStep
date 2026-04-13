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
}
