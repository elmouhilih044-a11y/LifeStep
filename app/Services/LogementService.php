<?php

namespace App\Services;

use App\Models\Logement;
use Illuminate\Support\Facades\Auth;

class LogementService
{
    public function getAll($request, $compatibilityService)
    {
        $query = Logement::with('pictures')
            ->whereIn('status', ['available', 'reserved', 'rented']);

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

        return $logements;
    }

    public function create($request)
    {
        $logement = Logement::create($request->validated());

        if ($request->hasFile('pictures')) {
            foreach ($request->file('pictures') as $index => $file) {
                $path = $file->store('logements', 'public');

                $logement->pictures()->create([
                    'path' => $path,
                    'order' => $index
                ]);
            }
        }

        return $logement;
    }

    public function update($request, Logement $logement)
    {
        $logement->update($request->validated());

        if ($request->hasFile('pictures')) {
            foreach ($request->file('pictures') as $index => $file) {
                $path = $file->store('logements', 'public');

                $logement->pictures()->create([
                    'path' => $path,
                    'order' => $index
                ]);
            }
        }
    }

    public function delete(Logement $logement)
    {
        foreach ($logement->pictures as $picture) {
            $picture->delete();
        }

        $logement->delete();
    }

    public function show(Logement $logement, $compatibilityService)
    {
        $logement->load('pictures');

        $user = Auth::user();
        $profile = $user?->role === 'admin' ? null : $user?->lifeProfile;

        $result = $compatibilityService->calculate($profile, $logement);

        $logement->score = $result['score'];
        $logement->label = $result['label'];

        return $logement;
    }

    public function mine()
    {
        return Logement::where('user_id', Auth::id())
            ->latest()
            ->get();
    }

    public function recommended($compatibilityService)
    {
        $user = Auth::user();
        $lifeProfile = $user->lifeProfile;

        $logements = Logement::with('pictures')
            ->where('status', 'available')
            ->latest()
            ->get();

        return $logements->map(function ($logement) use ($compatibilityService, $lifeProfile) {

                $result = $compatibilityService->calculate($lifeProfile, $logement);

                $logement->score = $result['score'];
                $logement->label = $result['label'];

                return $logement;
            })
            ->filter(function ($logement) {
                return $logement->score >= 50;
            })
            ->sortByDesc('score')
            ->values();
    }
}