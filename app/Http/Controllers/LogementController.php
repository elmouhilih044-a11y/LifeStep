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
    public function index(CompatibilityService $compatibilityService)
    {
        $profile = Auth::user()->lifeProfile;
        $logements = Logement::with('tags', 'badges', 'pictures')->where('status', 'available')->get();

        foreach ($logements as $logement) {
            $result = $compatibilityService->calculate($profile, $logement);
            $logement->score = $result['score'];
            $logement->label = $result['label'];
        }
$logements = $logements->sortByDesc('score')->values();
        return view('logements.index', compact('logements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create',Logement::class);
        return view('logements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLogementRequest $request)
    {
          $this->authorize('create', Logement::class);
        $logement = Logement::create($request->validated());

        if ($request->has('tags')) {
            $logement->tags()->sync($request->tags);
        }


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
    public function show(Logement $logement)
    {
        $logement->load('tags', 'badges', 'pictures');

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

        if ($request->has('tags')) {
            $logement->tags()->sync($request->tags);
        }


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
        $logement->tags()->detach();
        $logement->badges()->detach();

        foreach ($logement->pictures as $picture) {
            $picture->delete();
        }

        $logement->delete();


        return redirect()->route('logements.index')
            ->with('success', 'Logement supprimé');
    }
}
