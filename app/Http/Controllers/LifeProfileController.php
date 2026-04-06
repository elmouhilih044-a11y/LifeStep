<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLifeProfileRequest;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLifeProfileRequest $request)
    {
        $data=$request->validated();
          $existingProfile=LifeProfile::where('user_id', Auth::id())->first();
        if($existingProfile){
            return back()->withErrors([
       'error'=>'Vous avez déjà un profil de vie'
            ]);
        }
        $data['user_id']=Auth::id();
        LifeProfile::create($data);
        return redirect()->route('logements.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
