<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

public function register(RegisterRequest $request){
    $data=$request->validated();
    $user=User::create($data);
    Auth::login($user);
    $request->session()->regenerate();
    return redirect()->route('logements.index');
} 

public function showLogin(){
    return view('auth.login');
}

public function login(LoginRequest $request){
$data=$request->validated();

if(Auth::attempt($data)){
    $request->session()->regenerate();
   return redirect()->route('logements.index');
}
else{
    return back()->withErrors([
        'error'=>'Email ou mot de passe incorrect'
    ]);
}
}

}
