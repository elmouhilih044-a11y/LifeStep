<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Logement;
use App\Http\Requests\StoreLogementRequest;
use App\Http\Requests\UpdateLogementRequest;
use App\Services\CompatibilityService;
use Illuminate\Support\Facades\Auth;

class LogementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CompatibilityService $compatibilityService, Request $request)
    {
        $query = Logement::with('badges', 'pictures')->whereIn('status', ['available', 'reserved', 'rented']);
        if ($request->filled('q')) {
            $search = $request->q;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('type', 'like', "%{$search}%");
            });
        }
        $logements = $query->latest()->get();

        $user = Auth::user();
       $profile = $user?->role === 'admin' ? null : $user?->lifeProfile;
        foreach ($logements as $logement) {
            $result = $compatibilityService->calculate($profile, $logement);
            $logement->score = $result['score'];
            $logement->label = $result['label'];
        }
        if (!$request->filled('q')) {
            $logements = $logements->sortByDesc('score')->values();
        }
        return view('logements.index', compact('logements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         $this->authorize('create', \App\Models\Logement::class);
        return view('logements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLogementRequest $request)
    {
        $this->authorize('create', Logement::class);
        $logement = Logement::create($request->validated());

      
        if ($request->has('badges')) {
            $logement->badges()->sync($request->badges);
        }

        if ($request->hasFile('pictures')) {
            foreach ($request->file('pictures') as $index => $file) {
                $path = $file->store('logements', 'public');
                $logement->pictures()->create([
                    'path' => $path,
                    'order' => $index
                ]);
            }
        }

        return redirect()->route('logements.index')
            ->with('success', 'Logement créé avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Logement $logement, CompatibilityService $compatibilityService)
    {
        $logement->load('badges', 'pictures');
        $user = Auth::user();
     $profile = $user?->role === 'admin' ? null : $user?->lifeProfile;
        $result = $compatibilityService->calculate($profile, $logement);
        $logement->score = $result['score'];
        $logement->label = $result['label'];

        return view('logements.show', compact('logement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Logement $logement)
    {
        $this->authorize('update', $logement);
        return view('logements.edit', compact('logement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLogementRequest $request, Logement $logement)
    {
        $this->authorize('update', $logement);
        $logement->update($request->validated());

        if ($request->has('badges')) {
            $logement->badges()->sync($request->badges);
        }

        if ($request->hasFile('pictures')) {
            foreach ($request->file('pictures') as $index => $file) {

                $path = $file->store('logements', 'public');

                $logement->pictures()->create([
                    'path' => $path,
                    'order' => $index
                ]);
            }
        }


        return redirect()->route('logements.index')
            ->with('success', 'Logement modifié avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Logement $logement)
    {
        $this->authorize('delete', $logement);
        $logement->badges()->detach();

        foreach ($logement->pictures as $picture) {
            $picture->delete();
        }

        $logement->delete();


        return redirect()->route('logements.index')
            ->with('success', 'Logement supprimé');
    }

    public function mine()
{
   
    if (Auth::user()->role !== 'owner') {
        abort(403);
    }

    $logements = \App\Models\Logement::where('user_id', Auth::id())
        ->latest()
        ->get();

    return view('logements.mine', compact('logements'));
}
public function recommended(CompatibilityService $compatibilityService)
{
    $user = Auth::user();

    if (!$user || $user->role !== 'user') {
        abort(403);
    }

    $lifeProfile = $user->lifeProfile;

    if (!$lifeProfile) {
        return redirect()->route('life_profiles.create');
    }
    $logements = Logement::with('badges', 'pictures')
        ->where('status', 'available')
        ->latest()
        ->get();

    $logements = $logements->map(function ($logement) use ($compatibilityService, $lifeProfile) {

            $compatibilityResult = $compatibilityService->calculate($lifeProfile, $logement);

            $logement->score = $compatibilityResult['score'];
            $logement->label = $compatibilityResult['label'];

            return $logement;
        })
     
        ->filter(function ($logement) {
            return $logement->score >= 50;
        })

        ->sortByDesc('score')
        ->values();

    return view('logements.recommended', compact('logements'));
}

}
