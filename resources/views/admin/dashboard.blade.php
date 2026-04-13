@extends('layouts.app')

@section('title', 'Dashboard Admin – LifeStep+')

@section('content')

{{-- ════════════════════════════════════════════
     LAYOUT PRINCIPAL — pleine largeur
════════════════════════════════════════════ --}}
<div class="pt-20 min-h-screen flex" style="background: #F2F2F2;">

  {{-- ── Sidebar fixe ── --}}
  <aside class="hidden lg:flex flex-col w-56 shrink-0 bg-white border-r border-border sticky top-20 self-start h-[calc(100vh-5rem)]">

    <nav class="flex-1 px-3 py-6 space-y-0.5">

      <p class="text-[10px] font-bold text-muted uppercase tracking-widest px-3 mb-3">Vue d'ensemble</p>

      <a href="{{ route('admin.dashboard') }}"
         class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-white' : 'text-ink hover:bg-surface' }}">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
          <rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/>
        </svg>
        Dashboard
      </a>

      <a href="{{ route('logements.index') }}"
         class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold transition-colors {{ request()->routeIs('logements.*') ? 'bg-primary text-white' : 'text-ink hover:bg-surface' }}">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path d="M3 9.5L12 3l9 6.5V20a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V9.5z"/>
        </svg>
        Logements
      </a>

      <p class="text-[10px] font-bold text-muted uppercase tracking-widest px-3 pt-5 mb-3">Gestion</p>

      <a href="#"
         class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-ink hover:bg-surface transition-colors">
        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <circle cx="12" cy="8" r="4"/><path d="M4 20c0-4 3.6-7 8-7s8 3 8 7"/>
        </svg>
        Utilisateurs
      </a>

    </nav>

    {{-- Bas sidebar --}}
    <div class="px-3 py-4 border-t border-border">
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="w-full flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-semibold text-red-500 hover:bg-red-50 transition-colors">
          <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v1"/>
          </svg>
          Déconnexion
        </button>
      </form>
    </div>

  </aside>

  {{-- ── Contenu principal ── --}}
  <div class="flex-1 min-w-0 px-8 py-8">

    {{-- En-tête page --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
      <div>
        <h1 class="text-2xl font-black text-ink leading-none">Dashboard</h1>
        <p class="text-sm text-muted mt-1">{{ now()->isoFormat('dddd D MMMM YYYY') }}</p>
      </div>
      <span class="inline-flex items-center gap-2 text-xs font-semibold px-3.5 py-2 rounded-xl bg-white border border-border text-emerald-700 self-start sm:self-auto">
        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
        Système actif
      </span>
    </div>


    {{-- ── 4 Stat Cards ── --}}
    <div class="grid grid-cols-2 xl:grid-cols-4 gap-4 mb-5">

      <div class="bg-white border border-border rounded-2xl px-6 py-5">
        <p class="text-[10px] font-bold text-muted uppercase tracking-widest mb-4">Utilisateurs</p>
        <p class="text-4xl font-black text-ink leading-none">{{ $totalUsers }}</p>
        <p class="text-xs text-muted mt-2">inscrits au total</p>
      </div>

      <div class="bg-white border border-border rounded-2xl px-6 py-5">
        <p class="text-[10px] font-bold text-muted uppercase tracking-widest mb-4">Propriétaires</p>
        <p class="text-4xl font-black text-ink leading-none">{{ $totalOwners }}</p>
        <p class="text-xs text-muted mt-2">rôle owner actif</p>
      </div>

      <div class="bg-white border border-border rounded-2xl px-6 py-5">
        <p class="text-[10px] font-bold text-muted uppercase tracking-widest mb-4">Annonces</p>
        <p class="text-4xl font-black text-ink leading-none">{{ $totalLogements }}</p>
        <p class="text-xs text-muted mt-2">publiées</p>
      </div>

      <div class="rounded-2xl px-6 py-5" style="background: #FF385C;">
        <p class="text-[10px] font-bold uppercase tracking-widest mb-4" style="color:rgba(255,255,255,.55);">Disponibles</p>
        <p class="text-4xl font-black text-white leading-none">{{ $availableLogements }}</p>
        <p class="text-xs mt-2" style="color:rgba(255,255,255,.55);">prêts à louer</p>
      </div>

    </div>


    {{-- ── Taux d'occupation ── --}}
    <div class="bg-white border border-border rounded-2xl px-7 py-6 mb-5">

      @php
        $tauxDispo  = $totalLogements > 0 ? round($availableLogements / $totalLogements * 100) : 0;
        $tauxOccupe = 100 - $tauxDispo;
        $tauxOwners = $totalUsers > 0 ? round($totalOwners / $totalUsers * 100) : 0;
      @endphp

      <p class="text-[10px] font-bold text-muted uppercase tracking-widest mb-6">Taux d'occupation</p>

      <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">

        <div>
          <div class="flex items-center justify-between mb-2.5">
            <p class="text-sm font-semibold text-ink">Disponibles</p>
            <p class="text-sm font-black text-emerald-600 tabular-nums">{{ $tauxDispo }}%</p>
          </div>
          <div class="h-1 rounded-full overflow-hidden" style="background:#EBEBEB;">
            <div class="h-1 bg-emerald-500 rounded-full" style="width:{{ $tauxDispo }}%"></div>
          </div>
          <p class="text-xs text-muted mt-2">{{ $availableLogements }} / {{ $totalLogements }} logements</p>
        </div>

        <div>
          <div class="flex items-center justify-between mb-2.5">
            <p class="text-sm font-semibold text-ink">Occupés</p>
            <p class="text-sm font-black text-muted tabular-nums">{{ $tauxOccupe }}%</p>
          </div>
          <div class="h-1 rounded-full overflow-hidden" style="background:#EBEBEB;">
            <div class="h-1 rounded-full" style="width:{{ $tauxOccupe }}%;background:#BBBBBB;"></div>
          </div>
          <p class="text-xs text-muted mt-2">{{ $totalLogements - $availableLogements }} / {{ $totalLogements }} logements</p>
        </div>

        <div>
          <div class="flex items-center justify-between mb-2.5">
            <p class="text-sm font-semibold text-ink">Propriétaires</p>
            <p class="text-sm font-black text-primary tabular-nums">{{ $tauxOwners }}%</p>
          </div>
          <div class="h-1 rounded-full overflow-hidden" style="background:#EBEBEB;">
            <div class="h-1 bg-primary rounded-full" style="width:{{ $tauxOwners }}%"></div>
          </div>
          <p class="text-xs text-muted mt-2">{{ $totalOwners }} / {{ $totalUsers }} utilisateurs</p>
        </div>

      </div>
    </div>


    {{-- ── Grille inférieure ── --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">

      {{-- Derniers logements (2/3) --}}
      <div class="xl:col-span-2 bg-white border border-border rounded-2xl overflow-hidden">

        <div class="flex items-center justify-between px-7 py-4 border-b border-border">
          <p class="text-sm font-bold text-ink">Derniers logements</p>
          <a href="{{ route('logements.index') }}" class="text-xs font-semibold text-primary hover:underline">
            Voir tout →
          </a>
        </div>

        @php
          $recentLogements = \App\Models\Logement::with('user')->latest()->take(6)->get();
          $statusLabels = [
            'available' => 'Disponible',
            'reserved'  => 'Réservé',
            'rented'    => 'Loué',
            'sold'      => 'Vendu',
          ];
          $statusStyle = [
            'available' => 'background:#ECFDF5;color:#059669;',
            'reserved'  => 'background:#FFFBEB;color:#D97706;',
            'rented'    => 'background:#F4F4F5;color:#71717A;',
            'sold'      => 'background:#FEF2F2;color:#DC2626;',
          ];
        @endphp

        @if($recentLogements->isEmpty())
          <div class="flex items-center justify-center py-16">
            <p class="text-muted text-sm">Aucun logement publié</p>
          </div>
        @else
          <div class="divide-y divide-border">
            @foreach($recentLogements as $l)
              <a href="{{ route('logements.show', $l) }}"
                 class="flex items-center gap-4 px-7 py-3.5 hover:bg-surface transition-colors group">

                <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0 text-xs font-black text-white"
                     style="background:#222;">
                  {{ strtoupper(substr($l->city, 0, 1)) }}
                </div>

                <div class="flex-1 min-w-0">
                  <p class="text-sm font-semibold text-ink truncate group-hover:text-primary transition-colors">
                    {{ $l->title }}
                  </p>
                  <p class="text-xs text-muted truncate mt-0.5">
                    {{ $l->city }} · {{ $l->user?->name ?? '–' }}
                  </p>
                </div>

                <div class="shrink-0 flex items-center gap-3">
                  <span class="text-[11px] font-bold px-2.5 py-1 rounded-lg"
                        style="{{ $statusStyle[$l->status] ?? 'background:#F7F7F7;color:#717171;' }}">
                    {{ $statusLabels[$l->status] ?? $l->status }}
                  </span>
                  <span class="text-sm font-bold text-ink whitespace-nowrap tabular-nums w-28 text-right">
                    {{ number_format($l->price, 0, ',', ' ') }}
                    <span class="text-muted font-normal text-xs">MAD</span>
                  </span>
                </div>

              </a>
            @endforeach
          </div>
        @endif
      </div>


      {{-- Derniers membres (1/3) --}}
      <div class="bg-white border border-border rounded-2xl overflow-hidden">

        <div class="px-6 py-4 border-b border-border">
          <p class="text-sm font-bold text-ink">Nouveaux membres</p>
        </div>

        @php $recentUsers = \App\Models\User::latest()->take(7)->get(); @endphp

        <div class="divide-y divide-border">
          @foreach($recentUsers as $u)
            <div class="flex items-center gap-3 px-6 py-3 hover:bg-surface transition-colors">

              <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 text-[11px] font-black text-white"
                   style="background:{{ substr(md5($u->email ?? ''), 0, 1) > '7' ? '#FF385C' : '#222222' }};">
                {{ strtoupper(substr($u->name ?? 'U', 0, 2)) }}
              </div>

              <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-ink truncate">{{ $u->name }}</p>
                <p class="text-xs text-muted truncate">{{ $u->email }}</p>
              </div>

              @if($u->role === 'owner')
                <span class="shrink-0 text-[10px] font-bold px-2 py-0.5 rounded-md"
                      style="background:#FFF0F3;color:#FF385C;">
                  Owner
                </span>
              @else
                <span class="shrink-0 text-[10px] font-bold px-2 py-0.5 rounded-md"
                      style="background:#F2F2F2;color:#888;">
                  User
                </span>
              @endif

            </div>
          @endforeach
        </div>

      </div>

    </div>
    {{-- /grille inférieure --}}

  </div>
  {{-- /contenu principal --}}

</div>
{{-- /layout --}}

@endsection