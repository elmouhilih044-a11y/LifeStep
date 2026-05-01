<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Logement;
use App\Http\Requests\StoreLogementRequest;
use App\Http\Requests\UpdateLogementRequest;
use App\Services\CompatibilityService;
use App\Services\LogementService;
use Illuminate\Support\Facades\Auth;

class LogementController extends Controller
{
    protected $logementService;

    public function __construct(LogementService $logementService)
    {
        $this->logementService = $logementService;
    }

    public function index(CompatibilityService $compatibilityService, Request $request)
    {
        $logements = $this->logementService->getAll($request, $compatibilityService);

        return view('logements.index', compact('logements'));
    }

    public function create()
    {
        $this->authorize('create', Logement::class);

        return view('logements.create');
    }

    public function store(StoreLogementRequest $request)
    {
        $this->authorize('create', Logement::class);

        $this->logementService->create($request);

        return redirect()->route('logements.index')
            ->with('success', 'Logement créé avec succès');
    }

    public function show(Logement $logement, CompatibilityService $compatibilityService)
    {
        $logement = $this->logementService->show($logement, $compatibilityService);

        return view('logements.show', compact('logement'));
    }

    public function edit(Logement $logement)
    {
        $this->authorize('update', $logement);

        return view('logements.edit', compact('logement'));
    }

    public function update(UpdateLogementRequest $request, Logement $logement)
    {
        $this->authorize('update', $logement);

        $this->logementService->update($request, $logement);

        return redirect()->route('logements.index')
            ->with('success', 'Logement modifié avec succès');
    }

    public function destroy(Logement $logement)
    {
        $this->authorize('delete', $logement);

        $this->logementService->delete($logement);

        return redirect()->route('logements.index')
            ->with('success', 'Logement supprimé');
    }

    public function mine()
    {
        if (Auth::user()->role !== 'owner') {
            abort(403);
        }

        $logements = $this->logementService->mine();

        return view('logements.mine', compact('logements'));
    }

    public function recommended(CompatibilityService $compatibilityService)
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'user') {
            abort(403);
        }

        if (!$user->lifeProfile) {
            return redirect()->route('life_profiles.create');
        }

        $logements = $this->logementService->recommended($compatibilityService);

        return view('logements.recommended', compact('logements'));
    }
}