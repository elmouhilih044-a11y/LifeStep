@extends('layouts.app')

@section('title', $logement->title . ' – LifeStep+')

@section('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
@endsection

@section('content')

<div class="pt-20">

  {{-- ══════════════════════════════════
       PAGE HEADER / BREADCRUMB
  ══════════════════════════════════ --}}
  <div class="bg-surface border-b border-border px-6 py-8">
    <div class="max-w-6xl mx-auto flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

      {{-- Breadcrumb --}}
      <nav class="flex items-center gap-2 text-sm min-w-0">
        <a href="{{ route('logements.index') }}"
           class="text-primary font-semibold hover:underline whitespace-nowrap">
          Annonces
        </a>
        <svg class="w-3.5 h-3.5 text-border shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
        </svg>
        <span class="text-ink font-medium truncate">{{ $logement->title }}</span>
      </nav>

      {{-- Actions selon autorisation --}}
      <div class="flex items-center gap-2 shrink-0">

        {{-- Favori : tout utilisateur connecté --}}
        @auth
          @php $isFav = Auth::user()->favorites->contains($logement->id); @endphp
          @if($isFav)
            <form action="{{ route('favorites.destroy', $logement->id) }}" method="POST">
              @csrf @method('DELETE')
              <button type="submit"
                      class="inline-flex items-center gap-2 border border-border text-muted text-sm font-semibold
                             px-4 py-2 rounded-xl hover:border-red-300 hover:text-red-500 transition-all">
                <svg class="w-4 h-4 fill-red-500 text-red-500" viewBox="0 0 24 24">
                  <path d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                </svg>
                Retirer des favoris
              </button>
            </form>
          @else
            <form action="{{ route('favorites.store', $logement->id) }}" method="POST">
              @csrf
              <button type="submit"
                      class="inline-flex items-center gap-2 border border-border text-muted text-sm font-semibold
                             px-4 py-2 rounded-xl hover:border-primary hover:text-primary transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
                </svg>
                Ajouter aux favoris
              </button>
            </form>
          @endif
        @endauth

        {{-- Modifier : owner ou admin --}}
        @can('update', $logement)
          <a href="{{ route('logements.edit', $logement) }}"
             class="inline-flex items-center gap-2 border border-border text-ink text-sm font-semibold
                    px-4 py-2 rounded-xl hover:border-primary hover:text-primary transition-all">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
            </svg>
            Modifier
          </a>
        @endcan

        {{-- Supprimer : owner ou admin --}}
        @can('delete', $logement)
          <form action="{{ route('logements.destroy', $logement) }}" method="POST"
                onsubmit="return confirm('Supprimer définitivement ce logement ?')">
            @csrf @method('DELETE')
            <button type="submit"
                    class="inline-flex items-center gap-2 bg-red-50 border border-red-200 text-red-600 text-sm font-semibold
                           px-4 py-2 rounded-xl hover:bg-red-100 transition-all">
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
              </svg>
              Supprimer
            </button>
          </form>
        @endcan

      </div>
    </div>
  </div>


  <div class="max-w-6xl mx-auto px-6 py-10">

    @php
      $statusMap = [
        'available' => ['label' => 'Disponible', 'text' => 'text-primary',   'bg' => 'bg-primary-light'],
        'reserved'  => ['label' => 'Réservé',    'text' => 'text-amber-600', 'bg' => 'bg-amber-50'],
        'rented'    => ['label' => 'Loué',       'text' => 'text-muted',     'bg' => 'bg-surface'],
        'sold'      => ['label' => 'Vendu',      'text' => 'text-red-600',   'bg' => 'bg-red-50'],
      ];
      $s      = $statusMap[$logement->status] ?? ['label' => ucfirst($logement->status), 'text' => 'text-muted', 'bg' => 'bg-surface'];
      $photos = $logement->pictures->sortBy('order');

      // ── Réservation ──
      $currentUser     = Auth::user();
      $myReservation   = null;
      $alreadyReserved = false;
      if ($currentUser) {
          $myReservation = \App\Models\Reservation::where('logement_id', $logement->id)
                              ->where('user_id', $currentUser->id)
                              ->whereIn('status', ['pending', 'paid'])
                              ->latest()->first();
          $alreadyReserved = !$myReservation && \App\Models\Reservation::where('logement_id', $logement->id)
                              ->whereIn('status', ['pending', 'paid'])->exists();
      }
      $depositAmount = round($logement->price * 0.10);
    @endphp


    {{-- ══════════════════════════════════
         TITRE + STATUT
    ══════════════════════════════════ --}}
    <div class="mb-8">
      <div class="flex flex-wrap items-center gap-2 mb-3">
        <span class="inline-flex items-center text-xs font-bold px-3 py-1 rounded-full {{ $s['bg'] }} {{ $s['text'] }}">
          {{ $s['label'] }}
        </span>

      </div>
      <h1 class="text-3xl md:text-4xl font-bold text-ink leading-tight mb-2">
        {{ $logement->title }}
      </h1>
      <p class="flex items-center gap-1.5 text-muted text-sm">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
          <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
        </svg>
        {{ $logement->address }}, {{ $logement->city }}
      </p>
    </div>


    {{-- ══════════════════════════════════
         GALERIE
    ══════════════════════════════════ --}}
    <div class="mb-10">
      @if($photos->count() > 0)
        <div class="grid gap-2 rounded-2xl overflow-hidden"
             style="grid-template-columns: {{ $photos->count() >= 2 ? '2fr 1fr' : '1fr' }}; max-height: 440px;">

          <div class="{{ $photos->count() >= 2 ? 'row-span-2' : '' }} overflow-hidden cursor-pointer"
               onclick="openGallery(0)">
            <img src="{{ asset('storage/' . $photos->first()->path) }}"
                 alt="{{ $logement->title }}"
                 class="w-full h-full object-cover hover:scale-[1.02] transition-transform duration-300"
                 style="max-height: 440px;">
          </div>

          @foreach($photos->skip(1)->take(2) as $i => $pic)
            <div class="overflow-hidden cursor-pointer" onclick="openGallery({{ $i + 1 }})">
              <img src="{{ asset('storage/' . $pic->path) }}"
                   alt="Photo {{ $i + 2 }}"
                   class="w-full h-full object-cover hover:scale-[1.02] transition-transform duration-300"
                   style="max-height: 218px;">
            </div>
          @endforeach
        </div>

        @if($photos->count() > 3)
          <div class="flex gap-2 mt-2 overflow-x-auto pb-1">
            @foreach($photos->skip(3) as $i => $pic)
              <div class="w-20 h-20 shrink-0 rounded-xl overflow-hidden cursor-pointer
                           border-2 border-transparent hover:border-primary transition-colors"
                   onclick="openGallery({{ $i + 3 }})">
                <img src="{{ asset('storage/' . $pic->path) }}" alt="" class="w-full h-full object-cover">
              </div>
            @endforeach
          </div>
        @endif

      @else
        <div class="h-60 bg-surface rounded-2xl border border-border flex flex-col items-center justify-center gap-3">
          <svg class="w-14 h-14 text-border" fill="none" stroke="currentColor" stroke-width="0.8" viewBox="0 0 24 24">
            <rect x="3" y="3" width="18" height="18" rx="2"/>
            <circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/>
          </svg>
          <p class="text-muted text-sm font-medium">Aucune photo disponible</p>
        </div>
      @endif
    </div>

    {{-- ══════════════════════════════════
         SECTION COMPATIBILITÉ HERO
    ══════════════════════════════════ --}}
    @if(!Auth::user()?->is_admin)
    @auth
      @php
        $profile = Auth::user()->lifeProfile;
        $hasProfile = !is_null($profile);

        if ($hasProfile && isset($logement->score)) {
          $sc = match(true) {
            $logement->score >= 80 => [
              'gradient'   => 'from-emerald-500 to-teal-400',
              'glow'       => 'rgba(16,185,129,0.35)',
              'bar'        => 'bg-white/90',
              'label_bg'   => 'bg-emerald-100',
              'label_text' => 'text-emerald-700',
              'icon_color' => '#10b981',
              'sub'        => 'Ce logement correspond parfaitement à votre profil de vie.',
            ],
            $logement->score >= 60 => [
              'gradient'   => 'from-primary to-rose-400',
              'glow'       => 'rgba(255,56,92,0.30)',
              'bar'        => 'bg-white/90',
              'label_bg'   => 'bg-primary-light',
              'label_text' => 'text-primary',
              'icon_color' => '#ff385c',
              'sub'        => 'Ce logement correspond bien à vos critères de recherche.',
            ],
            $logement->score >= 40 => [
              'gradient'   => 'from-amber-400 to-orange-400',
              'glow'       => 'rgba(251,191,36,0.30)',
              'bar'        => 'bg-white/90',
              'label_bg'   => 'bg-amber-100',
              'label_text' => 'text-amber-700',
              'icon_color' => '#f59e0b',
              'sub'        => 'Ce logement correspond partiellement à votre profil.',
            ],
            default => [
              'gradient'   => 'from-slate-400 to-slate-500',
              'glow'       => 'rgba(100,116,139,0.20)',
              'bar'        => 'bg-white/70',
              'label_bg'   => 'bg-slate-100',
              'label_text' => 'text-slate-600',
              'icon_color' => '#64748b',
              'sub'        => 'Ce logement ne correspond pas encore à votre profil.',
            ],
          };

          $budgetPts = 0;
          if ($profile->budget_min && $profile->budget_max) {
            if ($logement->price >= $profile->budget_min && $logement->price <= $profile->budget_max) $budgetPts = 40;
            elseif ($logement->price <= $profile->budget_max * 1.1 && $logement->price >= $profile->budget_min * 0.9) $budgetPts = 20;
          }
          $cityPts = ($profile->location && $logement->city && strtolower($profile->location) === strtolower($logement->city)) ? 25 : 0;
          $availPts = ($logement->status === 'available') ? 10 : 0;
          $typePts  = $logement->score - $budgetPts - $cityPts - $availPts;

          $criteria = [
            ['label' => 'Budget',        'pts' => $budgetPts, 'max' => 40, 'icon' => 'M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75'],
            ['label' => 'Ville',         'pts' => $cityPts,   'max' => 25, 'icon' => 'M15 10.5a3 3 0 11-6 0 3 3 0 016 0zM19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z'],
            ['label' => 'Type de profil','pts' => $typePts,   'max' => 25, 'icon' => 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0'],
            ['label' => 'Disponibilité', 'pts' => $availPts,  'max' => 10, 'icon' => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
          ];
        }
      @endphp

      @if($hasProfile && isset($logement->score))
        <div class="mb-10 rounded-3xl overflow-hidden relative"
             style="box-shadow: 0 8px 40px {{ $sc['glow'] }};">

          <div class="bg-gradient-to-br {{ $sc['gradient'] }} px-8 pt-8 pb-6 relative overflow-hidden">
            <div class="absolute -top-10 -right-10 w-48 h-48 bg-white/10 rounded-full pointer-events-none"></div>
            <div class="absolute -bottom-8 -left-8 w-32 h-32 bg-black/5 rounded-full pointer-events-none"></div>

            <div class="relative z-10 flex flex-col md:flex-row md:items-center gap-6">

              <div class="shrink-0 flex items-center justify-center">
                <div class="relative w-28 h-28">
                  <svg viewBox="0 0 100 100" class="w-28 h-28 -rotate-90">
                    <circle cx="50" cy="50" r="40" fill="none" stroke="rgba(255,255,255,0.20)" stroke-width="10"/>
                    <circle cx="50" cy="50" r="40" fill="none" stroke="white" stroke-width="10"
                            stroke-linecap="round"
                            stroke-dasharray="{{ round(251.2 * $logement->score / 100, 1) }} 251.2"
                            style="filter: drop-shadow(0 0 6px rgba(255,255,255,0.5))"/>
                  </svg>
                  <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="text-3xl font-black text-white leading-none">{{ $logement->score }}</span>
                    <span class="text-white/70 text-xs font-bold">/ 100</span>
                  </div>
                </div>
              </div>

              <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 mb-1">
                  <h3 class="text-2xl font-black text-white leading-tight">{{ $logement->label }}</h3>
                </div>
                <p class="text-white/75 text-sm leading-relaxed max-w-md">{{ $sc['sub'] }}</p>
              </div>

              <div class="shrink-0 grid grid-cols-2 gap-2">
                @foreach($criteria as $c)
                  <div class="bg-white/15 backdrop-blur-sm rounded-2xl px-3 py-2.5 text-center min-w-[90px]">
                    <svg class="w-4 h-4 text-white/80 mx-auto mb-1" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" d="{{ $c['icon'] }}"/>
                    </svg>
                    <p class="text-[10px] text-white/60 font-semibold uppercase tracking-wide leading-tight">{{ $c['label'] }}</p>
                    <p class="text-white font-black text-sm mt-0.5">+{{ $c['pts'] }}<span class="text-white/50 text-[10px] font-normal"> /{{ $c['max'] }}</span></p>
                  </div>
                @endforeach
              </div>

            </div>
          </div>

          <div class="bg-white/20 h-1.5">
            <div class="{{ $sc['bar'] }} h-1.5 transition-all duration-1000 ease-out"
                 style="width: {{ $logement->score }}%"></div>
          </div>

          <div class="bg-white/10 backdrop-blur-sm px-8 py-3 flex items-center justify-between gap-4 flex-wrap">
            <p class="text-white/70 text-xs font-medium">
              Score calculé selon votre profil de vie LifeStep+
            </p>
            <a href="{{ route('life_profiles.edit') }}"
               class="text-white text-xs font-bold hover:underline opacity-80 hover:opacity-100 transition-opacity">
              Modifier mon profil →
            </a>
          </div>
        </div>

      @else
        <div class="mb-10 rounded-3xl border-2 border-dashed border-primary/30 bg-primary-light px-8 py-8 flex flex-col sm:flex-row items-center gap-6">
          <div class="w-16 h-16 rounded-2xl bg-primary/10 flex items-center justify-center shrink-0">
            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
            </svg>
          </div>
          <div class="flex-1 text-center sm:text-left">
            <h3 class="font-black text-ink text-lg">Découvrez votre score de compatibilité</h3>
            <p class="text-muted text-sm mt-1 max-w-md">Créez votre profil de vie pour voir à quel point ce logement vous correspond — budget, ville, type de logement et disponibilité.</p>
          </div>
          <a href="{{ route('life_profiles.create') }}"
             class="shrink-0 inline-flex items-center gap-2 bg-primary hover:bg-primary-dark text-white font-bold px-6 py-3 rounded-xl transition-colors text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Créer mon profil
          </a>
        </div>
      @endif
    @endauth
    @endif

    {{-- Description (pleine largeur, avant la grille) --}}
    @if($logement->description)
      <div class="border border-border rounded-2xl p-6 bg-white shadow-card mb-7">
        <p class="text-xs font-bold text-muted uppercase tracking-widest mb-3">Description</p>
        <p class="text-ink text-[15px] leading-relaxed">{{ $logement->description }}</p>
      </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-7">

      {{-- ── Colonne gauche ── --}}
      <div class="lg:col-span-2 space-y-5">

        {{-- Caractéristiques --}}
        <div class="border border-border rounded-2xl p-6 bg-white shadow-card">
          <p class="text-xs font-bold text-muted uppercase tracking-widest mb-5">Caractéristiques</p>
          <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
            @php
              $items = [
                ['icon' => 'M2.25 12l8.954-8.955a1.5 1.5 0 012.092 0L22.25 12M4.5 9.75v10.125A1.125 1.125 0 005.625 21', 'label' => 'Type',     'val' => $logement->type],
                ['icon' => 'M3.75 5.25h16.5M3.75 12h16.5M3.75 18.75h16.5', 'label' => 'Chambres', 'val' => $logement->bedrooms . ' ch.'],
                ['icon' => 'M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0', 'label' => 'Sdb', 'val' => $logement->bathrooms . ' sdb'],
              ];
              if ($logement->surface)
                $items[] = ['icon' => 'M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15', 'label' => 'Surface', 'val' => $logement->surface . ' m²'];
              if ($logement->floor !== null)
                $items[] = ['icon' => 'M4.5 10.5L12 3m0 0l7.5 7.5M12 3v18', 'label' => 'Étage', 'val' => $logement->floor === 0 ? 'RDC' : $logement->floor . 'ème'];
            @endphp

            @foreach($items as $item)
              <div class="flex items-start gap-3 p-4 bg-surface rounded-xl">
                <div class="w-8 h-8 bg-white border border-border rounded-lg flex items-center justify-center shrink-0">
                  <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/>
                  </svg>
                </div>
                <div>
                  <p class="text-[10px] font-bold text-muted uppercase tracking-wider">{{ $item['label'] }}</p>
                  <p class="text-sm font-bold text-ink mt-0.5">{{ $item['val'] }}</p>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        {{-- Tags --}}
        @if($logement->tags->isNotEmpty())
          <div class="border border-border rounded-2xl p-6 bg-white shadow-card">
            <p class="text-xs font-bold text-muted uppercase tracking-widest mb-4">Tags · Style de vie</p>
            <div class="flex flex-wrap gap-2">
              @foreach($logement->tags as $tag)
                <span class="text-sm font-semibold px-4 py-1.5 rounded-full bg-primary-light text-primary border border-primary/10">
                  {{ $tag->name }}
                </span>
              @endforeach
            </div>
          </div>
        @endif

        {{-- Badges --}}
        @if($logement->badges->isNotEmpty())
          <div class="border border-border rounded-2xl p-6 bg-white shadow-card">
            <p class="text-xs font-bold text-muted uppercase tracking-widest mb-4">Avantages · Badges</p>
            <div class="flex flex-wrap gap-2">
              @foreach($logement->badges as $badge)
                <span class="inline-flex items-center gap-1.5 text-sm font-bold px-4 py-1.5 rounded-full bg-red-50 text-red-500 border border-red-100">
                  ✦ {{ $badge->name }}
                </span>
              @endforeach
            </div>
          </div>
        @endif

        {{-- ── Carte Leaflet ── --}}
        @if(!is_null($logement->latitude) && !is_null($logement->longitude))
          <div class="border border-border rounded-2xl overflow-hidden bg-white shadow-card">
            <p class="text-xs font-bold text-muted uppercase tracking-widest px-6 pt-5 pb-3">Localisation</p>
            <div id="logement-map" style="height: 300px; width: 100%;"></div>
          </div>
        @endif

        {{-- Disponibilité + Propriétaire --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

          <div class="border border-border rounded-2xl p-5 bg-white shadow-card flex flex-col justify-between">
            <p class="text-xs font-bold text-muted uppercase tracking-widest mb-3">Disponibilité</p>
            <span class="inline-flex items-center text-sm font-bold px-3 py-1 rounded-full w-fit {{ $s['bg'] }} {{ $s['text'] }}">
              {{ $s['label'] }}
            </span>
            <p class="text-xs text-muted mt-2">
              Mis en ligne le {{ $logement->created_at->format('d/m/Y') }}
            </p>
          </div>

          @if($logement->user)
            <div class="border border-border rounded-2xl p-5 bg-white shadow-card flex flex-col justify-between">
              <p class="text-xs font-bold text-muted uppercase tracking-widest mb-3">Propriétaire</p>
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-primary-light flex items-center justify-center shrink-0">
                  <span class="text-primary font-black text-sm">
                    {{ strtoupper(substr($logement->user->name ?? 'U', 0, 2)) }}
                  </span>
                </div>
                <div class="min-w-0">
                  <p class="font-bold text-ink text-sm truncate">{{ $logement->user->name }}</p>
                  <p class="text-xs text-muted truncate">{{ $logement->user->email }}</p>
                </div>
              </div>
            </div>
          @endif

        </div>

      </div>

      {{-- ── Sidebar droite ── --}}
      <div class="space-y-4">

        @if(session('success'))
          <div class="flex items-start gap-3 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-medium px-4 py-3 rounded-xl">
            <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            {{ session('success') }}
          </div>
        @endif

        @if(session('error'))
          <div class="flex items-start gap-3 bg-red-50 border border-red-200 text-red-600 text-sm font-medium px-4 py-3 rounded-xl">
            <svg class="w-4 h-4 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126z"/>
            </svg>
            {{ session('error') }}
          </div>
        @endif

        <div class="bg-[#d1d5db] rounded-2xl p-6 text-gray-800 shadow-card">
          <p class="text-[10px] font-black opacity-60 uppercase tracking-widest mb-2">Loyer mensuel</p>
          <p class="text-5xl font-black tracking-tight leading-none">
            {{ number_format($logement->price, 0, ',', ' ') }}
          </p>
          <p class="text-sm font-semibold opacity-70 mt-1">MAD / mois</p>
          <div class="mt-5 pt-4 border-t border-black/10 flex items-center justify-between">
            <p class="text-[11px] opacity-50">Charges selon contrat</p>
            <p class="text-[11px] font-bold opacity-60">
              Acompte · {{ number_format($depositAmount, 0, ',', ' ') }} MAD
            </p>
          </div>
        </div>

        @auth
          @if(!$currentUser->is_admin && !$currentUser->role === 'owner')
          @endif

          @if($currentUser->is_admin)
            @php
              $pendingRes = \App\Models\Reservation::where('logement_id', $logement->id)
                                ->where('status', 'pending')->latest()->first();
            @endphp
            @if($pendingRes)
              <div class="border border-amber-200 bg-amber-50 rounded-2xl p-5">
                <p class="text-[10px] font-bold text-amber-700 uppercase tracking-widest mb-3">Paiement en attente</p>
                <div class="flex items-center gap-3 mb-4">
                  <div class="w-9 h-9 rounded-full bg-amber-100 flex items-center justify-center shrink-0">
                    <span class="text-amber-700 font-black text-xs">
                      {{ strtoupper(substr($pendingRes->user->name ?? 'U', 0, 2)) }}
                    </span>
                  </div>
                  <div class="min-w-0">
                    <p class="text-sm font-bold text-ink truncate">{{ $pendingRes->user->name ?? '–' }}</p>
                    <p class="text-xs text-muted">Réservé le {{ $pendingRes->created_at->format('d/m/Y') }}</p>
                  </div>
                </div>
                <div class="bg-white rounded-xl p-3 mb-4 border border-amber-100">
                  <div class="flex justify-between text-xs text-muted mb-1">
                    <span>Acompte à vérifier</span>
                    <span class="font-bold text-ink">{{ number_format($pendingRes->deposit_amount, 0, ',', ' ') }} MAD</span>
                  </div>
                  <div class="flex justify-between text-xs text-muted">
                    <span>Loyer total</span>
                    <span class="font-bold text-ink">{{ number_format($pendingRes->total_price, 0, ',', ' ') }} MAD</span>
                  </div>
                </div>
                <form action="{{ route('reservations.confirmPayment', $pendingRes) }}" method="POST">
                  @csrf @method('PATCH')
                  <button type="submit"
                          class="w-full flex items-center justify-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm py-3 rounded-xl transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Confirmer le paiement
                  </button>
                </form>
              </div>
            @else
              <div class="border border-border rounded-2xl p-4 bg-surface text-center">
                <p class="text-xs text-muted font-medium">Aucun paiement en attente</p>
              </div>
            @endif

          @elseif($myReservation)

            @if($myReservation->status === 'paid')
              <div class="border border-emerald-200 bg-emerald-50 rounded-2xl p-5">
                <div class="flex items-center gap-2 mb-4">
                  <div class="w-7 h-7 rounded-full bg-emerald-500 flex items-center justify-center shrink-0">
                    <svg class="w-3.5 h-3.5 text-white" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
                    </svg>
                  </div>
                  <p class="text-sm font-bold text-emerald-700">Réservation confirmée</p>
                </div>
                <div class="space-y-2 text-xs mb-4">
                  <div class="flex justify-between">
                    <span class="text-muted">Acompte versé</span>
                    <span class="font-bold text-ink">{{ number_format($myReservation->deposit_amount, 0, ',', ' ') }} MAD</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-muted">Loyer mensuel</span>
                    <span class="font-bold text-ink">{{ number_format($myReservation->total_price, 0, ',', ' ') }} MAD</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-muted">Confirmé le</span>
                    <span class="font-bold text-ink">{{ $myReservation->updated_at->format('d/m/Y') }}</span>
                  </div>
                </div>
                @php $hoursElapsed = now()->diffInHours($myReservation->created_at); @endphp
                <form action="{{ route('reservations.cancel', $myReservation) }}" method="POST"
                      onsubmit="return confirm('Annuler cette réservation ? Aucun remboursement possible après 24h.')">
                  @csrf
                  <button type="submit"
                          class="w-full flex items-center justify-center gap-2 border border-red-200 text-red-500 hover:bg-red-50 font-semibold text-xs py-2.5 rounded-xl transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    @if($hoursElapsed < 24)
                      Annuler (remboursement possible)
                    @else
                      Annuler (sans remboursement)
                    @endif
                  </button>
                </form>
              </div>

            @else
              <div class="border border-border bg-white rounded-2xl p-5 shadow-card">
                <div class="flex items-center gap-2 mb-4">
                  <div class="w-7 h-7 rounded-full bg-amber-100 flex items-center justify-center shrink-0">
                    <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                  </div>
                  <p class="text-sm font-bold text-ink">En attente de confirmation</p>
                </div>

                <p class="text-xs text-muted leading-relaxed mb-4">
                  Votre réservation est enregistrée. L'admin va vérifier votre acompte et confirmer sous peu.
                </p>

                <div class="bg-surface rounded-xl p-4 mb-4 border border-border space-y-3">
                  <p class="text-[10px] font-bold text-muted uppercase tracking-widest">Instructions de paiement</p>
                  <div class="flex justify-between text-sm">
                    <span class="text-muted">Acompte à verser</span>
                    <span class="font-black text-ink">{{ number_format($myReservation->deposit_amount, 0, ',', ' ') }} MAD</span>
                  </div>
                  <div class="border-t border-border pt-3 space-y-1.5 text-xs text-muted">
                    <p class="flex items-start gap-2">
                      <svg class="w-3.5 h-3.5 text-primary shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                      </svg>
                      Virement bancaire ou espèces au propriétaire
                    </p>
                    <p class="flex items-start gap-2">
                      <svg class="w-3.5 h-3.5 text-primary shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                      </svg>
                      Envoyez le justificatif à l'admin
                    </p>
                  </div>
                </div>

                <form action="{{ route('reservations.cancel', $myReservation) }}" method="POST"
                      onsubmit="return confirm('Annuler cette réservation ?')">
                  @csrf
                  <button type="submit"
                          class="w-full flex items-center justify-center gap-2 border border-border text-muted hover:border-red-300 hover:text-red-500 font-semibold text-xs py-2.5 rounded-xl transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Annuler ma réservation
                  </button>
                </form>
              </div>
            @endif

          @elseif($alreadyReserved)
            <div class="border border-border bg-surface rounded-2xl p-5 text-center">
              <div class="w-10 h-10 bg-white border border-border rounded-full flex items-center justify-center mx-auto mb-3">
                <svg class="w-5 h-5 text-muted" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                </svg>
              </div>
              <p class="text-sm font-bold text-ink mb-1">Logement non disponible</p>
              <p class="text-xs text-muted">Ce logement est en cours de réservation.</p>
            </div>

          @elseif($logement->status === 'available')
            <div class="border border-border bg-white rounded-2xl p-5 shadow-card">
              <p class="text-[10px] font-bold text-muted uppercase tracking-widest mb-4">Réserver ce logement</p>

              <div class="bg-surface rounded-xl p-4 mb-4 border border-border">
                <div class="flex items-center justify-between mb-2">
                  <span class="text-xs text-muted">Loyer mensuel</span>
                  <span class="text-sm font-bold text-ink">{{ number_format($logement->price, 0, ',', ' ') }} MAD</span>
                </div>
                <div class="flex items-center justify-between pt-2 border-t border-border">
                  <span class="text-xs font-bold text-ink">Acompte (10%)</span>
                  <span class="text-sm font-black text-primary">{{ number_format($depositAmount, 0, ',', ' ') }} MAD</span>
                </div>
              </div>

              <p class="text-[11px] text-muted leading-relaxed mb-4">
                L'acompte sera à régler manuellement. Votre réservation sera confirmée après vérification par l'admin.
              </p>

              <form action="{{ route('reservations.store', $logement->id) }}" method="POST"
                    onsubmit="if(!confirm('Are you sure you want to reserve this property?')) return false; this.querySelector('button').disabled=true;">
                @csrf

                <button type="submit"
                        class="bg-primary hover:bg-primary-dark text-white font-semibold px-6 py-3 rounded-xl">
                  Réserver maintenant
                </button>
              </form>
            </div>

          @else
            <div class="border border-border bg-surface rounded-2xl p-5 text-center">
              <p class="text-sm font-bold text-muted">{{ $s['label'] }}</p>
              <p class="text-xs text-muted mt-1">Ce logement n'est plus disponible à la réservation.</p>
            </div>
          @endif

        @else
          <div class="border border-border bg-white rounded-2xl p-5 shadow-card text-center">
            <p class="text-sm font-bold text-ink mb-1">Connectez-vous pour réserver</p>
            <p class="text-xs text-muted mb-4">Un compte est requis pour effectuer une réservation.</p>
            <a href="{{ route('login') }}"
               class="inline-flex items-center justify-center gap-2 w-full bg-primary hover:bg-primary-dark text-white font-bold text-sm py-3 rounded-xl transition-colors">
              Se connecter
            </a>
          </div>
        @endauth

        <a href="tel:{{ $logement->phone }}"
           class="flex items-center justify-center gap-2.5 w-full bg-ink text-white font-bold text-sm
                  py-4 rounded-2xl hover:opacity-90 transition-opacity">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
          </svg>
          {{ $logement->phone }}
        </a>

        <a href="{{ route('logements.index') }}"
           class="flex items-center justify-center gap-2 w-full border border-border text-muted font-semibold text-sm
                  py-4 rounded-2xl hover:border-ink hover:text-ink transition-colors bg-white shadow-card">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
          </svg>
          Retour aux annonces
        </a>

        @can('update', $logement)
          <a href="{{ route('logements.edit', $logement) }}"
             class="flex items-center justify-center gap-2 w-full border border-border text-ink font-semibold text-sm
                    py-3 rounded-2xl hover:border-primary hover:text-primary transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
            </svg>
            Modifier ce logement
          </a>
        @endcan

      </div>
    </div>

    {{-- LIGHTBOX --}}
    @if($photos->count() > 0)
      <div id="lightbox"
           class="fixed inset-0 z-[300] bg-black/90 hidden items-center justify-center p-4"
           onclick="closeLightbox(event)">
        <button onclick="changePhoto(-1)"
                class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center transition-colors">
          <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/>
          </svg>
        </button>
        <img id="lightbox-img" src="" alt="" class="max-w-full max-h-[85vh] rounded-xl object-contain">
        <button onclick="changePhoto(1)"
                class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center transition-colors">
          <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
          </svg>
        </button>
        <button onclick="document.getElementById('lightbox').classList.add('hidden'); document.getElementById('lightbox').style.display=''; document.body.style.overflow='';"
                class="absolute top-4 right-4 w-9 h-9 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center">
          <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
        <p id="lightbox-counter" class="absolute bottom-5 left-1/2 -translate-x-1/2 text-white/50 text-sm"></p>
      </div>
    @endif

  </div>
</div>

@endsection

@section('scripts')
<script>
  const photos = @json($photos->values()->map(fn($p) => asset('storage/' . $p->path)));
  let current = 0;

  function openGallery(i) {
    if (!photos.length) return;
    current = i;
    updateLightbox();
    const lb = document.getElementById('lightbox');
    lb.classList.remove('hidden');
    lb.style.display = 'flex';
    document.body.style.overflow = 'hidden';
  }

  function closeLightbox(e) {
    if (e && e.target !== document.getElementById('lightbox')) return;
    const lb = document.getElementById('lightbox');
    lb.classList.add('hidden'); lb.style.display = ''; document.body.style.overflow = '';
  }

  function changePhoto(d) {
    current = (current + d + photos.length) % photos.length;
    updateLightbox();
  }

  function updateLightbox() {
    document.getElementById('lightbox-img').src = photos[current];
    document.getElementById('lightbox-counter').textContent = (current + 1) + ' / ' + photos.length;
  }

  document.addEventListener('keydown', e => {
    const lb = document.getElementById('lightbox');
    if (!lb || lb.classList.contains('hidden')) return;
    if (e.key === 'ArrowLeft')  changePhoto(-1);
    if (e.key === 'ArrowRight') changePhoto(1);
    if (e.key === 'Escape') { lb.classList.add('hidden'); lb.style.display = ''; document.body.style.overflow = ''; }
  });

  document.addEventListener('click', function(e) {
    document.querySelectorAll('[data-menu]').forEach(function(menu) {
      const trigger = document.querySelector('[data-menu-trigger="' + menu.dataset.menu + '"]');
      if (!menu.contains(e.target) && (!trigger || !trigger.contains(e.target))) {
        menu.classList.add('hidden');
      }
    });
  });
</script>

@if(!is_null($logement->latitude) && !is_null($logement->longitude))
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
  (function () {
    var lat = {{ $logement->latitude }};
    var lng = {{ $logement->longitude }};

    var map = L.map('logement-map').setView([lat, lng], 15);

    setTimeout(() => {
      map.invalidateSize();
    }, 100);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>',
      maxZoom: 19,
    }).addTo(map);

    var icon = L.divIcon({
      className: '',
      html: '<div style="width:36px;height:36px;background:#FF385C;border:3px solid #fff;border-radius:50% 50% 50% 0;transform:rotate(-45deg);box-shadow:0 2px 8px rgba(0,0,0,0.25);"></div>',
      iconSize: [36, 36],
      iconAnchor: [18, 36],
      popupAnchor: [0, -38],
    });

    var marker = L.marker([lat, lng], {
      icon: icon,
      draggable: true
    }).addTo(map);

    marker
      .bindPopup('<strong>{{ addslashes($logement->title) }}</strong><br>{{ addslashes($logement->city) }}')
      .openPopup();

    map.on('click', function (e) {
      marker.setLatLng(e.latlng);
    });

    marker.on('dragend', function () {
      var position = marker.getLatLng();
      console.log('Latitude:', position.lat, 'Longitude:', position.lng);
    });
  })();
</script>
@endif
@endsection