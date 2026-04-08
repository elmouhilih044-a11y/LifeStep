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

{{-- ── Hero ── --}}
<section class="hero-bg min-h-screen flex flex-col items-center justify-center text-center px-6 pt-20 relative">
  <div class="max-w-3xl mx-auto">
    <h1 class="fade-up-2 text-5xl md:text-6xl font-bold text-white leading-[1.1] tracking-tight mt-2">
      Trouvez le logement<br/>
      <span class="text-primary" style="text-shadow:0 2px 24px rgba(255,56,92,0.5)">fait pour vous</span>
    </h1>
    <p class="fade-up-3 text-white/70 mt-5 text-lg max-w-xl mx-auto leading-relaxed">
      Des milliers de biens disponibles partout en France. Louez simplement, vivez librement.
    </p>

    {{-- Search --}}
    <form action="{{ route('logements.index') }}" method="GET"
          class="fade-up-3 mt-10 flex flex-col sm:flex-row items-stretch gap-3 bg-white rounded-2xl p-2 shadow-card-hover max-w-xl mx-auto">
      <div class="flex items-center gap-2 flex-1 px-4">
        <svg class="w-5 h-5 text-muted shrink-0" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z"/>
          <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 19.5l-4.35-4.35"/>
        </svg>
        <input name="q" type="text" placeholder="Ville, quartier, type de bien…"
               class="w-full text-sm text-ink placeholder-muted outline-none py-2 bg-transparent"/>
      </div>
      <button type="submit"
              class="bg-primary hover:bg-primary-dark text-white font-semibold text-sm px-6 py-3 rounded-xl transition shrink-0">
        Rechercher
      </button>
    </form>

    <p class="fade-up-3 text-white/40 text-xs mt-4">Casablanca · Settat · Youssoufia…</p>
  </div>

  <div class="absolute bottom-8 left-1/2 -translate-x-1/2 text-white/40 animate-bounce">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
    </svg>
  </div>
</section>

{{-- ── Stats ── --}}
<section class="bg-white border-b border-border">
  <div class="max-w-5xl mx-auto px-6 py-14 grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
    <div>
      <p class="text-4xl font-bold text-ink">{{ $stats['total'] }}</p>
      <p class="text-muted text-sm mt-1">Annonces publiées</p>
    </div>
    <div>
      <p class="text-4xl font-bold text-ink">{{ $stats['dispo'] }}</p>
      <p class="text-muted text-sm mt-1">Disponibles</p>
    </div>
    <div>
      <p class="text-4xl font-bold text-ink">{{ $stats['villes'] }}</p>
      <p class="text-muted text-sm mt-1">Villes couvertes</p>
    </div>
    <div>
      <p class="text-4xl font-bold text-ink">{{ $stats['prix'] ?? '–' }}</p>
      <p class="text-muted text-sm mt-1">Prix moyen / mois</p>
    </div>
  </div>
</section>

{{-- ── How it works ── --}}
<section class="bg-surface py-20 px-6">
  <div class="max-w-5xl mx-auto">
    <p class="text-primary text-xs font-bold tracking-widest uppercase text-center mb-3">Comment ça marche</p>
    <h2 class="text-3xl font-bold text-center text-ink mb-12">Simple. Rapide. Efficace.</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

      @foreach([
        ['step'=>'01','title'=>'Recherchez','desc'=>'Parcourez les annonces et filtrez selon vos critères : ville, prix, chambres.','icon'=>'M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z'],
        ['step'=>'02','title'=>'Découvrez','desc'=>'Consultez les photos, les détails et la disponibilité de chaque bien.','icon'=>'M2.25 12l8.954-8.955a1.5 1.5 0 012.092 0L22.25 12M4.5 9.75v10.125A1.125 1.125 0 005.625 21h4.5a1.125 1.125 0 001.125-1.125V15a1.125 1.125 0 011.125-1.125h2.25A1.125 1.125 0 0115.75 15v4.875A1.125 1.125 0 0016.875 21h4.5a1.125 1.125 0 001.125-1.125V9.75'],
        ['step'=>'03','title'=>'Louez','desc'=>'Contactez le propriétaire et finalisez votre location en toute sérénité.','icon'=>'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
      ] as $item)
      <div class="bg-white rounded-2xl p-8 shadow-card hover:shadow-card-hover transition-shadow group">
        <div class="w-14 h-14 bg-primary-light rounded-2xl flex items-center justify-center mb-5 group-hover:bg-primary transition-colors">
          <svg class="w-7 h-7 text-primary group-hover:text-white transition-colors" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/>
          </svg>
        </div>
        <span class="text-xs font-bold text-primary tracking-widest uppercase">Étape {{ $item['step'] }}</span>
        <h3 class="font-bold text-lg mt-2 mb-2">{{ $item['title'] }}</h3>
        <p class="text-muted text-sm leading-relaxed">{{ $item['desc'] }}</p>
      </div>
      @endforeach

    </div>
  </div>
</section>

{{-- ── Recent Listings ── --}}
<section class="max-w-7xl mx-auto px-6 py-20">
  <div class="flex items-end justify-between mb-8">
    <div>
      <p class="text-primary text-xs font-bold tracking-widest uppercase mb-2">Nouveautés</p>
      <h2 class="text-3xl font-bold text-ink">Derniers logements ajoutés</h2>
    </div>
    <a href="{{ route('logements.index') }}" class="hidden sm:flex items-center gap-1 text-sm font-semibold text-primary hover:text-primary-dark transition">
      Voir tout
      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
      </svg>
    </a>
  </div>

  @if($recent->isEmpty())
    <div class="flex flex-col items-center justify-center py-20 text-center">
      <div class="w-20 h-20 bg-primary-light rounded-full flex items-center justify-center mb-5">
        <svg class="w-9 h-9 text-primary" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955a1.5 1.5 0 012.092 0L22.25 12M4.5 9.75v10.125A1.125 1.125 0 005.625 21h4.5a1.125 1.125 0 001.125-1.125V15a1.125 1.125 0 011.125-1.125h2.25A1.125 1.125 0 0115.75 15v4.875A1.125 1.125 0 0016.875 21h4.5a1.125 1.125 0 001.125-1.125V9.75"/>
        </svg>
      </div>
      <p class="text-ink font-semibold text-lg">Aucun logement pour l'instant</p>
      <p class="text-muted text-sm mt-1">Soyez le premier à publier une annonce.</p>
      <a href="{{ route('logements.index') }}" class="mt-6 inline-flex items-center gap-2 bg-primary hover:bg-primary-dark text-white font-semibold px-6 py-3 rounded-xl transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
        </svg>
        Publier un logement
      </a>
    </div>
  @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach($recent as $logement)
        <a href="{{ route('logements.index') }}" class="group block rounded-2xl overflow-hidden shadow-card hover:shadow-card-hover transition-all duration-300">
          <div class="relative overflow-hidden">
            @if(!empty($logement['photo']))
              <img src="{{ $logement['photo'] }}" alt="{{ $logement['titre'] }}"
                   class="w-full h-52 object-cover group-hover:scale-105 transition-transform duration-500"/>
            @else
              <div class="w-full h-52 bg-surface flex items-center justify-center">
                <svg class="w-12 h-12 text-border" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955a1.5 1.5 0 012.092 0L22.25 12M4.5 9.75v10.125A1.125 1.125 0 005.625 21h4.5a1.125 1.125 0 001.125-1.125V15a1.125 1.125 0 011.125-1.125h2.25A1.125 1.125 0 0115.75 15v4.875A1.125 1.125 0 0016.875 21h4.5a1.125 1.125 0 001.125-1.125V9.75"/>
                </svg>
              </div>
            @endif
            <span class="absolute top-3 left-3 bg-white text-xs font-bold px-2.5 py-1 rounded-full shadow-sm {{ $logement['disponible'] ? 'text-primary' : 'text-muted' }}">
              {{ $logement['disponible'] ? 'Disponible' : 'Indisponible' }}
            </span>
          </div>
          <div class="p-5 bg-white">
            <div class="flex items-start justify-between gap-2">
              <p class="font-semibold text-ink truncate">{{ $logement['titre'] }}</p>
              <p class="text-primary font-bold shrink-0">{{ $logement['prix'] }} €<span class="text-muted font-normal text-xs">/mois</span></p>
            </div>
            <p class="text-muted text-sm mt-1">{{ $logement['ville'] }}</p>
            <div class="flex items-center gap-3 mt-3 text-xs text-muted border-t border-border pt-3">
              <span>{{ $logement['chambres'] }} ch.</span>
              <span class="text-border">·</span>
              <span>{{ $logement['lits'] }} lits</span>
              <span class="text-border">·</span>
              <span>{{ $logement['bains'] }} sdb</span>
            </div>
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
    <a href="{{ route('logements.index') }}"
       class="inline-flex items-center gap-2 mt-8 bg-primary hover:bg-primary-dark text-white font-semibold px-8 py-4 rounded-xl text-base shadow-lg hover:shadow-xl transition-all">
      Commencer maintenant
      <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
      </svg>
    </a>
  </div>
</section>

@endsection