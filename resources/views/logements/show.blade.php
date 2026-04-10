@extends('layouts.app')

@section('title', $logement->title . ' – LifeStep+')

@section('content')

<div class="pt-20">

  {{-- ══════════════════════════════════
       PAGE HEADER / BREADCRUMB
  ══════════════════════════════════ --}}
  <div class="bg-surface border-b border-border px-6 py-5">
    <div class="max-w-6xl mx-auto flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

      <nav class="flex items-center gap-2 text-sm min-w-0">
        <a href="{{ route('logements.index') }}" class="text-primary font-semibold hover:underline whitespace-nowrap">Annonces</a>
        <svg class="w-3.5 h-3.5 text-border shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
        </svg>
        <span class="text-ink font-medium truncate">{{ $logement->title }}</span>
      </nav>

      <div class="flex items-center gap-2 shrink-0">
        @auth
          @php $isFav = Auth::user()->favorites->contains($logement->id); @endphp
          @if($isFav)
            <form action="{{ route('favorites.destroy', $logement->id) }}" method="POST">
              @csrf @method('DELETE')
              <button type="submit" class="inline-flex items-center gap-2 border border-border text-muted text-sm font-semibold px-4 py-2 rounded-xl hover:border-red-300 hover:text-red-500 transition-all">
                <svg class="w-4 h-4 fill-red-500 text-red-500" viewBox="0 0 24 24"><path d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/></svg>
                Retirer des favoris
              </button>
            </form>
          @else
            <form action="{{ route('favorites.store', $logement->id) }}" method="POST">
              @csrf
              <button type="submit" class="inline-flex items-center gap-2 border border-border text-muted text-sm font-semibold px-4 py-2 rounded-xl hover:border-primary hover:text-primary transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/></svg>
                Ajouter aux favoris
              </button>
            </form>
          @endif
        @endauth
        @can('update', $logement)
          <a href="{{ route('logements.edit', $logement) }}" class="inline-flex items-center gap-2 border border-border text-ink text-sm font-semibold px-4 py-2 rounded-xl hover:border-primary hover:text-primary transition-all">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/></svg>
            Modifier
          </a>
        @endcan
        @can('delete', $logement)
          <form action="{{ route('logements.destroy', $logement) }}" method="POST" onsubmit="return confirm('Supprimer définitivement ce logement ?')">
            @csrf @method('DELETE')
            <button type="submit" class="inline-flex items-center gap-2 bg-red-50 border border-red-200 text-red-600 text-sm font-semibold px-4 py-2 rounded-xl hover:bg-red-100 transition-all">
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
              Supprimer
            </button>
          </form>
        @endcan
      </div>
    </div>
  </div>


  <div class="max-w-6xl mx-auto px-6 py-8">

    @php
      $statusMap = [
        'available' => ['label' => 'Disponible', 'text' => 'text-emerald-700', 'bg' => 'bg-emerald-50', 'dot' => 'bg-emerald-500'],
        'reserved'  => ['label' => 'Réservé',    'text' => 'text-amber-700',   'bg' => 'bg-amber-50',   'dot' => 'bg-amber-500'],
        'rented'    => ['label' => 'Loué',       'text' => 'text-slate-600',   'bg' => 'bg-slate-100',  'dot' => 'bg-slate-400'],
        'sold'      => ['label' => 'Vendu',      'text' => 'text-red-700',     'bg' => 'bg-red-50',     'dot' => 'bg-red-500'],
      ];
      $s      = $statusMap[$logement->status] ?? ['label' => ucfirst($logement->status), 'text' => 'text-muted', 'bg' => 'bg-surface', 'dot' => 'bg-muted'];
      $photos = $logement->pictures->sortBy('order');
    @endphp


    {{-- ══════════════════════════════════
         TITRE + LOCALISATION
    ══════════════════════════════════ --}}
    <div class="mb-6">
      <div class="flex flex-wrap items-center gap-2 mb-3">
        <span class="inline-flex items-center gap-1.5 text-xs font-bold px-3 py-1 rounded-full {{ $s['bg'] }} {{ $s['text'] }}">
          <span class="w-1.5 h-1.5 rounded-full {{ $s['dot'] }}"></span>
          {{ $s['label'] }}
        </span>
        <span class="text-xs font-medium text-muted px-3 py-1 rounded-full bg-surface border border-border">
          {{ ucfirst($logement->type) }}
        </span>
      </div>
      <h1 class="text-3xl md:text-4xl font-bold text-ink leading-tight mb-2">{{ $logement->title }}</h1>
      <p class="flex items-center gap-1.5 text-muted text-sm">
        <svg class="w-4 h-4 shrink-0 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/>
          <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/>
        </svg>
        {{ $logement->address }}, {{ $logement->city }}
      </p>
    </div>


    {{-- ══════════════════════════════════
         GALERIE
    ══════════════════════════════════ --}}
    <div class="mb-8">
      @if($photos->count() > 0)
        <div class="grid gap-2 rounded-2xl overflow-hidden"
             style="grid-template-columns: {{ $photos->count() >= 2 ? '2fr 1fr' : '1fr' }}; max-height: 420px;">
          <div class="{{ $photos->count() >= 2 ? 'row-span-2' : '' }} overflow-hidden cursor-pointer" onclick="openGallery(0)">
            <img src="{{ asset('storage/' . $photos->first()->path) }}" alt="{{ $logement->title }}"
                 class="w-full h-full object-cover hover:scale-[1.02] transition-transform duration-300" style="max-height: 420px;">
          </div>
          @foreach($photos->skip(1)->take(2) as $i => $pic)
            <div class="overflow-hidden cursor-pointer" onclick="openGallery({{ $i + 1 }})">
              <img src="{{ asset('storage/' . $pic->path) }}" alt="Photo {{ $i + 2 }}"
                   class="w-full h-full object-cover hover:scale-[1.02] transition-transform duration-300" style="max-height: 208px;">
            </div>
          @endforeach
        </div>
        @if($photos->count() > 3)
          <div class="flex gap-2 mt-2 overflow-x-auto pb-1">
            @foreach($photos->skip(3) as $i => $pic)
              <div class="w-16 h-16 shrink-0 rounded-xl overflow-hidden cursor-pointer border-2 border-transparent hover:border-primary transition-colors" onclick="openGallery({{ $i + 3 }})">
                <img src="{{ asset('storage/' . $pic->path) }}" alt="" class="w-full h-full object-cover">
              </div>
            @endforeach
          </div>
        @endif
      @else
        <div class="h-52 bg-surface rounded-2xl border border-border flex flex-col items-center justify-center gap-3">
          <svg class="w-10 h-10 text-border" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
          </svg>
          <p class="text-muted text-sm">Aucune photo disponible</p>
        </div>
      @endif
    </div>


    {{-- ══════════════════════════════════
         LAYOUT 2 COLONNES
    ══════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

      {{-- ── Colonne gauche ── --}}
      <div class="lg:col-span-2 space-y-5">

        {{-- COMPATIBILITÉ – élément principal --}}
        @auth
          @php
            $profile  = Auth::user()->lifeProfile;
            $hasProf  = !is_null($profile);

            if ($hasProf && isset($logement->score)) {
              $budgetPts = 0;
              if ($profile->budget_min && $profile->budget_max) {
                if ($logement->price >= $profile->budget_min && $logement->price <= $profile->budget_max) $budgetPts = 40;
                elseif ($logement->price <= $profile->budget_max * 1.1 && $logement->price >= $profile->budget_min * 0.9) $budgetPts = 20;
              }
              $cityPts  = ($profile->location && $logement->city && strtolower($profile->location) === strtolower($logement->city)) ? 25 : 0;
              $availPts = ($logement->status === 'available') ? 10 : 0;
              $typePts  = max(0, $logement->score - $budgetPts - $cityPts - $availPts);

              $level = match(true) {
                $logement->score >= 80 => ['color' => '#10b981', 'light' => '#ecfdf5', 'border' => '#6ee7b7', 'label_text' => 'text-emerald-700', 'bar' => 'bg-emerald-500', 'ring' => 'ring-emerald-200'],
                $logement->score >= 60 => ['color' => '#3b82f6', 'light' => '#eff6ff', 'border' => '#93c5fd', 'label_text' => 'text-blue-700',    'bar' => 'bg-blue-500',    'ring' => 'ring-blue-200'],
                $logement->score >= 40 => ['color' => '#f59e0b', 'light' => '#fffbeb', 'border' => '#fcd34d', 'label_text' => 'text-amber-700',   'bar' => 'bg-amber-400',   'ring' => 'ring-amber-200'],
                default                => ['color' => '#94a3b8', 'light' => '#f8fafc', 'border' => '#cbd5e1', 'label_text' => 'text-slate-600',   'bar' => 'bg-slate-400',   'ring' => 'ring-slate-200'],
              };

              $criteria = [
                ['label' => 'Budget',         'pts' => $budgetPts, 'max' => 40,
                 'icon'  => 'M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75'],
                ['label' => 'Ville',          'pts' => $cityPts,   'max' => 25,
                 'icon'  => 'M15 10.5a3 3 0 11-6 0 3 3 0 016 0zM19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z'],
                ['label' => 'Type de profil', 'pts' => $typePts,   'max' => 25,
                 'icon'  => 'M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z'],
                ['label' => 'Disponibilité',  'pts' => $availPts,  'max' => 10,
                 'icon'  => 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
              ];
            }
          @endphp

          @if($hasProf && isset($logement->score))
            <div class="rounded-2xl border overflow-hidden" style="border-color: {{ $level['border'] }}; background: {{ $level['light'] }};">

              {{-- En-tête score --}}
              <div class="px-6 pt-5 pb-4 flex items-center gap-5">

                {{-- Cercle SVG score --}}
                <div class="shrink-0 relative w-20 h-20">
                  <svg viewBox="0 0 80 80" class="w-20 h-20 -rotate-90">
                    <circle cx="40" cy="40" r="32" fill="none" stroke="#e2e8f0" stroke-width="7"/>
                    <circle cx="40" cy="40" r="32" fill="none"
                            stroke="{{ $level['color'] }}" stroke-width="7"
                            stroke-linecap="round"
                            stroke-dasharray="{{ round(201.1 * $logement->score / 100, 1) }} 201.1"/>
                  </svg>
                  <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span class="text-2xl font-black leading-none" style="color: {{ $level['color'] }}">{{ $logement->score }}</span>
                    <span class="text-[10px] font-bold text-muted">/100</span>
                  </div>
                </div>

                {{-- Texte --}}
                <div class="flex-1 min-w-0">
                  <p class="text-[10px] font-bold uppercase tracking-widest text-muted mb-1">Compatibilité avec votre profil</p>
                  <p class="text-xl font-black text-ink leading-tight">{{ $logement->label }}</p>
                  <a href="{{ route('life_profiles.edit') }}" class="text-xs font-semibold mt-1 inline-block hover:underline" style="color: {{ $level['color'] }}">
                    Modifier mon profil →
                  </a>
                </div>
              </div>

              {{-- Barre globale --}}
              <div class="px-6 pb-4">
                <div class="w-full h-1.5 bg-black/5 rounded-full overflow-hidden">
                  <div class="{{ $level['bar'] }} h-1.5 rounded-full" style="width: {{ $logement->score }}%"></div>
                </div>
              </div>

              {{-- Critères en ligne --}}
              <div class="grid grid-cols-2 sm:grid-cols-4 divide-x divide-y sm:divide-y-0 border-t" style="border-color: {{ $level['border'] }}; divide-color: {{ $level['border'] }};">
                @foreach($criteria as $c)
                  <div class="px-4 py-3 flex items-center gap-3">
                    {{-- Mini barre verticale --}}
                    <div class="shrink-0 flex flex-col items-center gap-0.5">
                      <div class="w-1 rounded-full {{ $level['bar'] }}" style="height: {{ $c['max'] > 0 ? round(28 * $c['pts'] / $c['max']) : 0 }}px; min-height: 3px;"></div>
                      <div class="w-1 h-1 rounded-full bg-black/10"></div>
                    </div>
                    <div class="min-w-0">
                      <p class="text-[10px] font-bold text-muted uppercase tracking-wide truncate">{{ $c['label'] }}</p>
                      <p class="text-sm font-black text-ink">{{ $c['pts'] }}<span class="text-muted font-normal text-xs">/{{ $c['max'] }}</span></p>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>

          @else
            {{-- Pas de profil --}}
            <div class="rounded-2xl border-2 border-dashed border-primary/25 bg-primary-light p-6 flex flex-col sm:flex-row items-start sm:items-center gap-5">
              <div class="w-12 h-12 rounded-xl bg-white border border-primary/20 flex items-center justify-center shrink-0">
                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                </svg>
              </div>
              <div class="flex-1 min-w-0">
                <p class="font-bold text-ink text-base">Calculez votre score de compatibilité</p>
                <p class="text-muted text-sm mt-0.5">Créez votre profil de vie pour voir si ce logement correspond à vos critères.</p>
              </div>
              <a href="{{ route('life_profiles.create') }}" class="shrink-0 inline-flex items-center gap-2 bg-primary hover:bg-primary-dark text-white font-semibold px-5 py-2.5 rounded-xl transition text-sm">
                Créer mon profil
              </a>
            </div>
          @endif
        @endauth

        {{-- Description --}}
        @if($logement->description)
          <div class="border border-border rounded-2xl p-6 bg-white">
            <p class="text-xs font-bold text-muted uppercase tracking-widest mb-3">Description</p>
            <p class="text-ink text-sm leading-relaxed">{{ $logement->description }}</p>
          </div>
        @endif

        {{-- Caractéristiques --}}
        <div class="border border-border rounded-2xl p-6 bg-white">
          <p class="text-xs font-bold text-muted uppercase tracking-widest mb-4">Caractéristiques</p>
          <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
            @php
              $items = [
                ['label' => 'Type',     'val' => ucfirst($logement->type),          'icon' => 'M2.25 12l8.954-8.955a1.5 1.5 0 012.092 0L22.25 12M4.5 9.75v10.125A1.125 1.125 0 005.625 21'],
                ['label' => 'Chambres', 'val' => $logement->bedrooms . ' ch.',      'icon' => 'M3.75 5.25h16.5M3.75 12h16.5M3.75 18.75h16.5'],
                ['label' => 'Sdb',      'val' => $logement->bathrooms . ' sdb',     'icon' => 'M12 6v12m-3-2.818l.879.659c1.171.879 3.07.879 4.242 0'],
              ];
              if ($logement->surface)
                $items[] = ['label' => 'Surface', 'val' => $logement->surface . ' m²', 'icon' => 'M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15'];
              if ($logement->floor !== null)
                $items[] = ['label' => 'Étage', 'val' => $logement->floor === 0 ? 'RDC' : $logement->floor . 'ème', 'icon' => 'M4.5 10.5L12 3m0 0l7.5 7.5M12 3v18'];
            @endphp
            @foreach($items as $item)
              <div class="flex items-center gap-3 p-3.5 bg-surface rounded-xl">
                <div class="w-8 h-8 bg-white border border-border rounded-lg flex items-center justify-center shrink-0">
                  <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/>
                  </svg>
                </div>
                <div>
                  <p class="text-[10px] font-bold text-muted uppercase tracking-wide">{{ $item['label'] }}</p>
                  <p class="text-sm font-bold text-ink">{{ $item['val'] }}</p>
                </div>
              </div>
            @endforeach
          </div>
        </div>

        {{-- Tags --}}
        @if($logement->tags->isNotEmpty())
          <div class="border border-border rounded-2xl p-6 bg-white">
            <p class="text-xs font-bold text-muted uppercase tracking-widest mb-4">Style de vie · Tags</p>
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
          <div class="border border-border rounded-2xl p-6 bg-white">
            <p class="text-xs font-bold text-muted uppercase tracking-widest mb-4">Avantages</p>
            <div class="flex flex-wrap gap-2">
              @foreach($logement->badges as $badge)
                <span class="inline-flex items-center gap-1.5 text-sm font-semibold px-4 py-1.5 rounded-full bg-amber-50 text-amber-700 border border-amber-200">
                  {{ $badge->name }}
                </span>
              @endforeach
            </div>
          </div>
        @endif

      </div>


      {{-- ── Sidebar droite ── --}}
      <div class="space-y-3">

        {{-- Prix compact --}}
        <div class="border border-border rounded-2xl p-5 bg-white">
          <p class="text-[10px] font-bold text-muted uppercase tracking-widest mb-1.5">Loyer mensuel</p>
          <div class="flex items-baseline gap-1.5">
            <span class="text-3xl font-black text-ink tracking-tight">{{ number_format($logement->price, 0, ',', ' ') }}</span>
            <span class="text-sm font-semibold text-muted">MAD / mois</span>
          </div>
          <p class="text-[11px] text-muted mt-2">Charges selon contrat</p>
        </div>

        {{-- Disponibilité --}}
        <div class="border border-border rounded-2xl p-5 bg-white">
          <p class="text-[10px] font-bold text-muted uppercase tracking-widest mb-3">Disponibilité</p>
          <span class="inline-flex items-center gap-1.5 text-sm font-bold px-3 py-1 rounded-full {{ $s['bg'] }} {{ $s['text'] }}">
            <span class="w-1.5 h-1.5 rounded-full {{ $s['dot'] }}"></span>
            {{ $s['label'] }}
          </span>
          <p class="text-xs text-muted mt-2">Publié le {{ $logement->created_at->format('d/m/Y') }}</p>
        </div>

        {{-- Propriétaire --}}
        @if($logement->user)
          <div class="border border-border rounded-2xl p-5 bg-white">
            <p class="text-[10px] font-bold text-muted uppercase tracking-widest mb-3">Propriétaire</p>
            <div class="flex items-center gap-3">
              <div class="w-9 h-9 rounded-full bg-surface border border-border flex items-center justify-center shrink-0">
                <span class="text-ink font-black text-xs">{{ strtoupper(substr($logement->user->name ?? 'U', 0, 2)) }}</span>
              </div>
              <div class="min-w-0">
                <p class="font-bold text-ink text-sm truncate">{{ $logement->user->name }}</p>
                <p class="text-xs text-muted truncate">{{ $logement->user->email }}</p>
              </div>
            </div>
          </div>
        @endif

        {{-- CTA Téléphone --}}
        <a href="tel:{{ $logement->phone }}"
           class="flex items-center justify-center gap-2.5 w-full bg-ink hover:opacity-90 text-white font-bold text-sm py-3.5 rounded-2xl transition-opacity">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
          </svg>
          {{ $logement->phone }}
        </a>

        {{-- Modifier --}}
        @can('update', $logement)
          <a href="{{ route('logements.edit', $logement) }}"
             class="flex items-center justify-center gap-2 w-full border border-border text-ink font-semibold text-sm py-3 rounded-2xl hover:border-primary hover:text-primary transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
            </svg>
            Modifier ce logement
          </a>
        @endcan

        {{-- Retour --}}
        <a href="{{ route('logements.index') }}"
           class="flex items-center justify-center gap-2 w-full border border-border text-muted font-semibold text-sm py-3 rounded-2xl hover:border-ink hover:text-ink transition-colors">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
          </svg>
          Retour aux annonces
        </a>

      </div>
    </div>
  </div>
</div>


{{-- LIGHTBOX --}}
@if($photos->count() > 0)
  <div id="lightbox" class="fixed inset-0 z-[300] bg-black/90 hidden items-center justify-center p-4" onclick="closeLightbox(event)">
    <button onclick="changePhoto(-1)" class="absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center transition-colors">
      <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"/></svg>
    </button>
    <img id="lightbox-img" src="" alt="" class="max-w-full max-h-[85vh] rounded-xl object-contain">
    <button onclick="changePhoto(1)" class="absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center transition-colors">
      <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
    </button>
    <button onclick="document.getElementById('lightbox').classList.add('hidden'); document.getElementById('lightbox').style.display=''; document.body.style.overflow='';" class="absolute top-4 right-4 w-9 h-9 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center">
      <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
    </button>
    <p id="lightbox-counter" class="absolute bottom-5 left-1/2 -translate-x-1/2 text-white/50 text-sm"></p>
  </div>
@endif

@endsection

@section('scripts')
<script>
  const photos = @json($photos->values()->map(fn($p) => asset('storage/' . $p->path)));
  let current = 0;
  function openGallery(i) { if (!photos.length) return; current = i; updateLightbox(); const lb = document.getElementById('lightbox'); lb.classList.remove('hidden'); lb.style.display = 'flex'; document.body.style.overflow = 'hidden'; }
  function closeLightbox(e) { if (e && e.target !== document.getElementById('lightbox')) return; const lb = document.getElementById('lightbox'); lb.classList.add('hidden'); lb.style.display = ''; document.body.style.overflow = ''; }
  function changePhoto(d) { current = (current + d + photos.length) % photos.length; updateLightbox(); }
  function updateLightbox() { document.getElementById('lightbox-img').src = photos[current]; document.getElementById('lightbox-counter').textContent = (current + 1) + ' / ' + photos.length; }
  document.addEventListener('keydown', e => { const lb = document.getElementById('lightbox'); if (!lb || lb.classList.contains('hidden')) return; if (e.key === 'ArrowLeft') changePhoto(-1); if (e.key === 'ArrowRight') changePhoto(1); if (e.key === 'Escape') { lb.classList.add('hidden'); lb.style.display = ''; document.body.style.overflow = ''; } });
</script>
@endsection