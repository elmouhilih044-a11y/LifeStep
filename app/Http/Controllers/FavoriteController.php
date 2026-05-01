<?php

namespace App\Http\Controllers;

use App\Services\FavoriteService;

class FavoriteController extends Controller
{
    protected $favoriteService;

    public function __construct(FavoriteService $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }

    public function index()
    {
        $favorites = $this->favoriteService->getUserFavorites();

        return view('favorites.index', compact('favorites'));
    }

    public function store($logementId)
    {
        $this->favoriteService->addToFavorites($logementId);

        return back()->with('success', 'Ajouté aux favoris');
    }

    public function destroy($logementId)
    {
        $this->favoriteService->removeFromFavorites($logementId);

        return back()->with('success', 'Supprimé des favoris');
    }
}