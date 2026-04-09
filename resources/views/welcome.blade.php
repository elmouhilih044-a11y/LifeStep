@extends('layouts.app')

@section('title', 'LifeStep+ – Trouvez votre logement idéal')

@push('styles')
<style>
  html { scroll-behavior: smooth; }
  .hero-bg {
    background-image:
      linear-gradient(to bottom right, rgba(0,0,0,0.50) 0%, rgba(0,0,0,0.25) 60%, rgba(255,56,92,0.18) 100%),
      url('https://images.unsplash.com/photo-1560448204-e02f11c3d0e2?w=1600&q=80');
    background-size: cover;
    background-position: center;
  }
  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(28px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  .fade-up-1 { animation: fadeUp 0.7s 0.1s ease both; }
  .fade-up-2 { animation: fadeUp 0.7s 0.25s ease both; }
  .fade-up-3 { animation: fadeUp 0.7s 0.4s ease both; }
</style>
@endpush

@section('content')

{{-- ── Hero Section ── --}}
<section class="hero-bg min-h-screen flex flex-col items-center justify-center text-center px-6 pt-20 relative">
  <div class="relative z-10 max-w-3xl mx-auto">
    
    <h1 class="text-4xl md:text-6xl font-extrabold text-white leading-tight fade-up-1">
      Trouvez le logement qui <br/>
      <span class="text-primary">correspond à votre vie.</span>
    </h1>
    
    <p class="mt-6 text-lg md:text-xl text-white/90 font-medium max-w-2xl mx-auto fade-up-2">
      LifeStep+ analyse votre profil pour calculer la compatibilité avec chaque annonce. 
      Simplifiez votre recherche immobilière dès aujourd'hui.
    </p>

    {{-- Groupe de Boutons Login & Register --}}
    <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4 fade-up-3">
      @auth
        {{-- Si l'utilisateur est déjà connecté --}}
        <a href="{{ route('logements.index') }}" 
           class="bg-primary hover:bg-primary-dark text-white font-bold px-10 py-4 rounded-2xl shadow-lg transition-all transform hover:-translate-y-1 w-full sm:w-auto">
          Explorer les logements
        </a>
      @else
        {{-- Bouton Connexion (Blanc) --}}
        <a href="{{ route('login') }}" 
           class="bg-white hover:bg-surface text-ink font-bold px-10 py-4 rounded-2xl shadow-lg transition-all transform hover:-translate-y-1 w-full sm:w-auto">
          Se connecter
        </a>

        {{-- Bouton Inscription (Rouge Primary) --}}
        <a href="{{ route('register') }}" 
           class="bg-primary hover:bg-primary-dark text-white font-bold px-10 py-4 rounded-2xl shadow-lg transition-all transform hover:-translate-y-1 w-full sm:w-auto">
          Créer un compte
        </a>
      @endauth
    </div>
  </div>

  {{-- Barre de Statistiques --}}
  <div class="absolute bottom-0 left-0 w-full bg-white/10 backdrop-blur-md border-t border-white/20 py-6 hidden md:block">
    <div class="max-w-6xl mx-auto flex justify-around text-white">
      <div>
        <p class="text-2xl font-bold">{{ $stats['total'] }}</p>
        <p class="text-xs uppercase tracking-widest text-white/60">Annonces</p>
      </div>
      <div class="w-px h-10 bg-white/20"></div>
      <div>
        <p class="text-2xl font-bold">{{ $stats['villes'] }}</p>
        <p class="text-xs uppercase tracking-widest text-white/60">Villes</p>
      </div>
      <div class="w-px h-10 bg-white/20"></div>
      <div>
        <p class="text-2xl font-bold">{{ $stats['prix'] }}€</p>
        <p class="text-xs uppercase tracking-widest text-white/60">Prix Moyen</p>
      </div>
    </div>
  </div>
</section>

{{-- ── Dernières Annonces ── --}}
<section class="py-20 px-6 max-w-7xl mx-auto">
  <div class="flex items-end justify-between mb-12">
    <div>
      <h2 class="text-3xl font-bold text-ink">Nouveautés</h2>
      <p class="text-muted mt-2">Les derniers logements publiés sur la plateforme.</p>
    </div>
    <a href="{{ route('logements.index') }}" class="text-primary font-bold hover:underline flex items-center gap-1">
      Voir tout
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
    </a>
  </div>

  @if($recent->isEmpty())
    <div class="bg-surface rounded-3xl p-12 text-center border-2 border-dashed border-border">
      <p class="text-muted italic">Aucun logement récent pour le moment.</p>
    </div>
  @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
      @foreach($recent as $logement)
        <a href="{{ route('logements.show', $logement['id']) }}" class="group">
          <div class="relative aspect-square rounded-2xl overflow-hidden mb-4 shadow-sm group-hover:shadow-card transition-all">
            <img src="{{ $logement['image'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
          </div>
          <div class="space-y-1">
            <div class="flex justify-between items-start">
              <h3 class="font-bold text-ink truncate">{{ $logement['title'] }}</h3>
              <span class="text-primary font-bold">{{ $logement['price'] }}€</span>
            </div>
            <p class="text-muted text-sm">{{ $logement['city'] }}</p>
          </div>
        </a>
      @endforeach
    </div>
  @endif
</section>

{{-- ── CTA Banner ── --}}
<section class="relative overflow-hidden bg-ink px-8 py-20 text-center">
  <div class="absolute -top-16 -left-16 w-64 h-64 bg-primary/20 rounded-full blur-3xl pointer-events-none"></div>
  <div class="relative z-10 max-w-xl mx-auto">
    <p class="text-primary text-xs font-bold tracking-widest uppercase mb-3">Propriétaires</p>
    <h2 class="text-3xl md:text-4xl font-bold text-white leading-tight">Vous avez un bien à louer ?</h2>
    <p class="mt-3 text-white/60 text-base">Rejoignez LifeStep+ et publiez votre annonce gratuitement en moins de 2 minutes.</p>
    <a href="{{ route('logements.create') }}"
       class="inline-flex items-center gap-2 mt-8 bg-primary hover:bg-primary-dark text-white font-semibold px-8 py-4 rounded-xl text-base shadow-lg hover:shadow-xl transition-all">
      Publier mon annonce
    </a>
  </div>
</section>

@endsection