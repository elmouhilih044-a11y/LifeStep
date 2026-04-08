<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Favorite;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user=Auth::user();
        $favorites=$user->favorites;
        return view('favorites.index',compact('favorites'));
    }

  
    /**
     * Store a newly created resource in storage.
     */
    public function store($logementId)
    {
        $user=Auth::user();
        $user->favorites()->syncWithoutDetaching([$logementId]);
        return back()->with('success', 'Ajouté aux favoris');
    }

 

 

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($logementId)
    {
        $user=Auth::user();
       $user->favorites()->detach($logementId);
        return back()->with('success', 'Supprimé des favoris');
    }
}
