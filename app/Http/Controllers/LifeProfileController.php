<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLifeProfileRequest;
use App\Http\Requests\UpdateLifeProfileRequest;
use App\Models\LifeProfile;
use App\Services\LifeProfileService;

class LifeProfileController extends Controller
{
    protected $lifeProfileService;

    public function __construct(LifeProfileService $lifeProfileService)
    {
        $this->lifeProfileService = $lifeProfileService;
    }

    public function create()
    {
        $this->authorize('create', LifeProfile::class);

        return view('life_profiles.create');
    }

    public function store(StoreLifeProfileRequest $request)
    {
        $this->authorize('create', LifeProfile::class);

        $result = $this->lifeProfileService->createProfile($request->validated());

        if (!$result['success']) {
            return back()->withErrors([
                'error' => $result['message']
            ]);
        }

        return redirect()->route('logements.index');
    }

    public function show()
    {
        $this->authorize('view', LifeProfile::class);

        $profil = $this->lifeProfileService->getUserProfile();

        if (!$profil) {
            return redirect()->route('life_profiles.create');
        }

        return view('life_profiles.show', compact('profil'));
    }

    public function edit()
    {
        $this->authorize('update', LifeProfile::class);

        $profil = $this->lifeProfileService->getUserProfile();

        if (!$profil) {
            return redirect()->route('life_profiles.create');
        }

        return view('life_profiles.edit', compact('profil'));
    }

    public function update(UpdateLifeProfileRequest $request)
    {
        $this->authorize('update', LifeProfile::class);

        $profil = $this->lifeProfileService->updateProfile($request->validated());

        if (!$profil) {
            return redirect()->route('life_profiles.create');
        }

        return redirect()->route('life_profiles.show');
    }

    public function skip()
    {
        return redirect()->route('logements.index');
    }
}