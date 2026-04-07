@extends('layouts.app')

@section('title', 'Connexion – LifeStep+')

@push('styles')
<style>
  .auth-bg {
    background-image:
      linear-gradient(to bottom right, rgba(0,0,0,0.55) 0%, rgba(0,0,0,0.30) 60%, rgba(255,56,92,0.18) 100%),
      url('https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=1600&q=80');
    background-size: cover;
    background-position: center;
  }
  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(24px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  .fade-up { animation: fadeUp 0.6s 0.1s ease both; }
</style>
@endpush

@section('content')
<div class="min-h-screen flex pt-20">

  {{-- Left panel – decorative --}}
  <div class="hidden lg:flex lg:w-1/2 auth-bg flex-col justify-center p-14">
    <div>
      <h2 class="text-4xl font-bold text-white leading-tight">
        Des milliers de logements<br/>
        <span class="text-primary">vous attendent.</span>
      </h2>
      <p class="text-white/60 mt-4 text-base max-w-sm leading-relaxed">
        Connectez-vous pour accéder à vos favoris, suivre vos demandes et découvrir les nouvelles annonces.
      </p>
    </div>
  </div>

  {{-- Right panel – form --}}
  <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-16 bg-white">
    <div class="fade-up w-full max-w-md">

      <div class="mb-8">
        <p class="text-primary text-xs font-bold tracking-widest uppercase mb-2">Bienvenue</p>
        <h1 class="text-3xl font-bold text-ink">Connexion</h1>
        <p class="text-muted text-sm mt-2">Pas encore de compte ?
          <a href="{{ route('register') }}" class="text-primary font-semibold hover:text-primary-dark transition">Créer un compte</a>
        </p>
      </div>

      <form action="#" method="POST" class="space-y-5">
        @csrf

        {{-- Email --}}
        <div>
          <label class="block text-sm font-semibold text-ink mb-1.5">Adresse e-mail</label>
          <div class="relative">
            <span class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
              <svg class="w-4 h-4 text-muted" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25H4.5a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5H4.5a2.25 2.25 0 00-2.25 2.25m19.5 0l-9.75 6.75L2.25 6.75"/>
              </svg>
            </span>
            <input type="email" name="email" placeholder="vous@exemple.com" required
                   class="w-full pl-11 pr-4 py-3 border border-border rounded-xl text-sm text-ink placeholder-muted outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition"/>
          </div>
        </div>

        {{-- Password --}}
        <div>
          <div class="flex items-center justify-between mb-1.5">
            <label class="block text-sm font-semibold text-ink">Mot de passe</label>
            <a href="#" class="text-xs text-primary font-semibold hover:text-primary-dark transition">Mot de passe oublié ?</a>
          </div>
          <div class="relative">
            <span class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
              <svg class="w-4 h-4 text-muted" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
              </svg>
            </span>
            <input type="password" name="password" placeholder="••••••••" required
                   class="w-full pl-11 pr-4 py-3 border border-border rounded-xl text-sm text-ink placeholder-muted outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition"/>
          </div>
        </div>

        {{-- Remember me --}}
        <div class="flex items-center gap-2">
          <input type="checkbox" id="remember" name="remember"
                 class="w-4 h-4 rounded border-border accent-primary cursor-pointer"/>
          <label for="remember" class="text-sm text-muted cursor-pointer">Se souvenir de moi</label>
        </div>

        {{-- Submit --}}
        <button type="submit"
                class="w-full bg-primary hover:bg-primary-dark text-white font-semibold py-3.5 rounded-xl transition-colors shadow-sm hover:shadow-md text-sm">
          Se connecter
        </button>

      </form>

      {{-- Divider --}}
      <div class="flex items-center gap-4 my-6">
        <span class="flex-1 h-px bg-border"></span>
        <span class="text-xs text-muted font-medium">ou continuer avec</span>
        <span class="flex-1 h-px bg-border"></span>
      </div>

      {{-- Social --}}
      <div class="grid grid-cols-2 gap-3">
        <button class="flex items-center justify-center gap-2 border border-border rounded-xl py-3 text-sm font-semibold text-ink hover:bg-surface transition">
          <svg class="w-4 h-4" viewBox="0 0 24 24">
            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"/>
            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
          </svg>
          Google
        </button>
        <button class="flex items-center justify-center gap-2 border border-border rounded-xl py-3 text-sm font-semibold text-ink hover:bg-surface transition">
          <svg class="w-4 h-4 text-[#1877F2]" fill="currentColor" viewBox="0 0 24 24">
            <path d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073C0 18.1 4.388 23.094 10.125 24v-8.437H7.078v-3.49h3.047V9.41c0-3.025 1.792-4.697 4.533-4.697 1.312 0 2.686.236 2.686.236v2.97h-1.513c-1.491 0-1.956.93-1.956 1.886v2.267h3.328l-.532 3.49h-2.796V24C19.612 23.094 24 18.1 24 12.073z"/>
          </svg>
          Facebook
        </button>
      </div>

    </div>
  </div>

</div>
@endsection