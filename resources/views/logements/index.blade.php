@extends('layouts.app')

@section('title', 'Logements disponibles – LifeStep+')

@section('content')

<div class="pt-20">

  {{-- ── Page Header ── --}}
  <div class="bg-surface border-b border-border px-6 py-10">
    <div class="max-w-7xl mx-auto flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
      <div>
        <h1 class="text-4xl font-bold text-ink">Logements disponibles</h1>
        @if(!Auth::user()?->is_admin)
       <p class="text-muted mt-1">Trouvez le bien adapté à votre profil de vie</p>
@endif
     
      </div>
      <div class="flex items-center gap-3">
        <span class="text-muted text-sm">{{ $logements->count() }} résultat{{ $logements->count() > 1 ? 's' : '' }}</span>
        @can('create', App\Models\Logement::class)
<a href="{{ route('logements.create') }}"
   class="flex items-center gap-2 bg-primary hover:bg-primary-dark text-white font-semibold px-5 py-2.5 rounded-xl transition">
  <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
  </svg>
  Publier un logement
</a>
@endcan
      </div>
    </div>
  </div>

  <div class="max-w-7xl mx-auto px-6 py-10">

    {{-- Flash success --}}
    @if(session('success'))
      <div class="mb-6 flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 text-sm font-medium px-5 py-3 rounded-xl">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
      </div>
    @endif

    {{-- ── Stats Cards ── --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
      <div class="border border-border rounded-2xl p-5 bg-white shadow-card">
        <p class="text-xs font-bold text-primary uppercase tracking-wide">Total Annonces</p>
        <p class="text-3xl font-bold mt-2 text-ink">{{ $logements->count() }}</p>
        <p class="text-muted text-sm mt-1">publiées</p>
      </div>
      <div class="border border-border rounded-2xl p-5 bg-white shadow-card">
        <p class="text-xs font-bold text-primary uppercase tracking-wide">Disponibles</p>
        <p class="text-3xl font-bold mt-2 text-ink">{{ $logements->where('status', 'available')->count() }}</p>
        <p class="text-muted text-sm mt-1">prêts à louer</p>
      </div>
      <div class="border border-border rounded-2xl p-5 bg-white shadow-card">
        <p class="text-xs font-bold text-primary uppercase tracking-wide">Avec Photos</p>
        <p class="text-3xl font-bold mt-2 text-ink">{{ $logements->filter(fn($l) => $l->pictures->isNotEmpty())->count() }}</p>
        <p class="text-muted text-sm mt-1">illustrés</p>
      </div>
      <div class="border border-border rounded-2xl p-5 bg-white shadow-card">
        <p class="text-xs font-bold text-primary uppercase tracking-wide">Prix Moyen</p>
        <p class="text-3xl font-bold mt-2 text-ink">
          {{ $logements->avg('price') ? number_format($logements->avg('price'), 0, ',', ' ') . ' €' : '–' }}
        </p>
        <p class="text-muted text-sm mt-1">par mois</p>
      </div>
    </div>

    {{-- ── Listings Grid ── --}}
    @if($logements->isEmpty())
      @if(request()->filled('q'))
        {{-- ── Aucun résultat pour cette recherche ── --}}
        <div class="flex flex-col items-center justify-center py-24 text-center">
          <div class="w-20 h-20 bg-surface rounded-full flex items-center justify-center mb-6">
            <svg class="w-10 h-10 text-muted" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
            </svg>
          </div>
          <h2 class="text-2xl font-bold text-ink">Aucun résultat trouvé</h2>
          <p class="text-muted mt-2 max-w-xs text-sm">
            Aucun logement ne correspond à <span class="font-semibold text-ink">« {{ request('q') }} »</span>.
          </p>
          <a href="{{ route('logements.index') }}"
             class="mt-8 inline-flex items-center gap-2 border border-border text-ink font-semibold px-6 py-3 rounded-xl hover:bg-surface transition">
            Réinitialiser la recherche
          </a>
        </div>
      @else
        {{-- ── Aucun logement du tout ── --}}
        <div class="flex flex-col items-center justify-center py-24 text-center">
          <div class="w-20 h-20 bg-primary-light rounded-full flex items-center justify-center mb-6">
            <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955a1.5 1.5 0 012.092 0L22.25 12M4.5 9.75v10.125A1.125 1.125 0 005.625 21h4.5a1.125 1.125 0 001.125-1.125V15a1.125 1.125 0 011.125-1.125h2.25A1.125 1.125 0 0115.75 15v4.875A1.125 1.125 0 0016.875 21h4.5a1.125 1.125 0 001.125-1.125V9.75"/>
            </svg>
          </div>
          <h2 class="text-2xl font-bold text-ink">Aucun logement disponible</h2>
          <p class="text-muted mt-2 max-w-xs text-sm">Commencez par ajouter votre premier bien immobilier.</p>
          <a href="{{ route('logements.create') }}"
             class="mt-8 inline-flex items-center gap-2 bg-primary hover:bg-primary-dark text-white font-semibold px-6 py-3 rounded-xl transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Ajouter un logement
          </a>
        </div>
      @endif
    @else
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($logements as $logement)
          <div class="group rounded-2xl overflow-hidden border border-border shadow-card hover:shadow-card-hover transition-all duration-300">
            <div class="relative overflow-hidden">

              {{-- Photo --}}
              @if($logement->pictures->isNotEmpty())
                <img src="{{ asset('storage/' . $logement->pictures->sortBy('order')->first()->path) }}"
                     alt="{{ $logement->title }}"
                     class="w-full h-52 object-cover group-hover:scale-105 transition-transform duration-500"/>
              @else
                <div class="w-full h-52 bg-surface flex items-center justify-center">
                  <svg class="w-14 h-14 text-border" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955a1.5 1.5 0 012.092 0L22.25 12M4.5 9.75v10.125A1.125 1.125 0 005.625 21h4.5a1.125 1.125 0 001.125-1.125V15a1.125 1.125 0 011.125-1.125h2.25A1.125 1.125 0 0115.75 15v4.875A1.125 1.125 0 0016.875 21h4.5a1.125 1.125 0 001.125-1.125V9.75"/>
                  </svg>
                </div>
              @endif

              {{-- Badge disponibilité --}}
              <span class="absolute top-3 left-3 bg-white text-xs font-bold px-2.5 py-1 rounded-full shadow-sm {{ $logement->status === 'available' ? 'text-primary' : 'text-muted' }}">
                {{ $logement->status === 'available' ? 'Disponible' : 'Indisponible' }}
              </span>

              {{-- Score de compatibilité --}}
              @if(isset($logement->score))
                <span class="absolute top-3 right-3 bg-white text-xs font-bold px-2.5 py-1 rounded-full shadow-sm text-ink">
                  {{ $logement->label ?? $logement->score . '%' }}
                </span>
              @endif

              {{-- Actions (hover) --}}
              <div class="absolute bottom-3 right-3 flex gap-2 opacity-0 group-hover:opacity-100 transition">
                <a href="{{ route('logements.edit', $logement) }}"
                   class="bg-white rounded-full p-1.5 shadow hover:bg-surface transition">
                  <svg class="w-4 h-4 text-ink" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 7.125L18 10.5"/>
                  </svg>
                </a>
                <form action="{{ route('logements.destroy', $logement) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit"
                          class="bg-white rounded-full p-1.5 shadow hover:bg-red-50 transition"
                          onclick="return confirm('Supprimer ce logement ?')">
                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                  </button>
                </form>
              </div>
            </div>

            {{-- Infos --}}
            <a href="{{ route('logements.show', $logement) }}" class="block p-5 bg-white">
              <div class="flex items-start justify-between gap-2">
                <h3 class="font-semibold text-ink truncate">{{ $logement->title }}</h3>
                <p class="text-primary font-bold shrink-0">
                  {{ number_format($logement->price, 0, ',', ' ') }} €<span class="text-muted font-normal text-xs">/mois</span>
                </p>
              </div>
              <p class="text-muted text-sm mt-1 flex items-center gap-1">
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z"/>
                  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 19.5l-4.35-4.35"/>
                </svg>
                {{ $logement->city }}
              </p>

              {{-- Tags --}}
              @if($logement->tags->isNotEmpty())
                <div class="flex flex-wrap gap-1 mt-3">
                  @foreach($logement->tags->take(3) as $tag)
                    <span class="text-xs bg-primary-light text-primary font-medium px-2 py-0.5 rounded-full">
                      {{ $tag->name }}
                    </span>
                  @endforeach
                </div>
              @endif

              <div class="flex items-center gap-3 mt-3 text-xs text-muted border-t border-border pt-3">
                <span>{{ $logement->rooms }} ch.</span>
                <span class="text-border">·</span>
                <span>{{ $logement->beds }} lits</span>
                <span class="text-border">·</span>
                <span>{{ $logement->bathrooms }} sdb</span>
              </div>
            </a>
          </div>
        @endforeach
      </div>
    @endif

  </div>
</div>

@endsection