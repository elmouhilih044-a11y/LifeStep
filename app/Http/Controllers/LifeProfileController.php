<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLifeProfileRequest;
use App\Http\Requests\UpdateLifeProfileRequest;
use App\Models\LifeProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LifeProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('life_profiles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLifeProfileRequest $request)
    {
        $data = $request->validated();
        $existingProfile = LifeProfile::where('user_id', Auth::id())->first();
        if ($existingProfile) {
            return back()->withErrors([
                'error' => 'Vous avez déjà un profil de vie'
            ]);
        }
        $data['user_id'] = Auth::id();
        LifeProfile::create($data);
        return redirect()->route('logements.index');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $profil = LifeProfile::where('user_id', Auth::id())->first();
        if (!$profil) {
            return redirect()->route('life_profiles.create');
        }

        return view('life_profiles.show', compact('profil'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $profil = LifeProfile::where('user_id', Auth::id())->first();

        if (!$profil) {
            return redirect()->route('life_profiles.create');
        }

        return view('life_profiles.edit', compact('profil'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLifeProfileRequest $request)
    {

        $profil = LifeProfile::where('user_id', Auth::id())->first();


        if (!$profil) {
            return redirect()->route('life_profiles.create');
        }


        $data = $request->validated();
        $profil->update($data);
        return redirect()->route('life_profiles.show');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
