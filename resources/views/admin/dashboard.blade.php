@extends('layouts.app')

@section('title', 'Dashboard Admin – LifeStep+')

@section('content')

<div class="pt-20 min-h-screen bg-surface">
  <div class="max-w-5xl mx-auto px-6 py-10">

    {{-- ── En-tête ── --}}
    <div class="border-b border-border pb-6 mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
      <div>
        <p class="text-[10px] font-bold text-primary uppercase tracking-widest mb-1">Administration</p>
        <h1 class="text-2xl font-bold text-ink">Dashboard</h1>
        <p class="text-muted text-sm mt-0.5">Vue d'ensemble · {{ now()->format('d/m/Y') }}</p>
      </div>
      <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full self-start sm:self-auto">
        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
        Système actif
      </span>
    </div>


    {{-- ── 4 Stat Cards ── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

      <div class="bg-white border border-border rounded-2xl p-5">
        <p class="text-[10px] font-bold text-muted uppercase tracking-widest mb-4">Utilisateurs</p>
        <p class="text-4xl font-black text-ink leading-none">{{ $totalUsers }}</p>
        <p class="text-xs text-muted mt-2">inscrits</p>
      </div>

      <div class="bg-white border border-border rounded-2xl p-5">
        <p class="text-[10px] font-bold text-muted uppercase tracking-widest mb-4">Propriétaires</p>
        <p class="text-4xl font-black text-ink leading-none">{{ $totalOwners }}</p>
        <p class="text-xs text-muted mt-2">avec rôle owner</p>
      </div>

      <div class="bg-white border border-border rounded-2xl p-5">
        <p class="text-[10px] font-bold text-muted uppercase tracking-widest mb-4">Annonces</p>
        <p class="text-4xl font-black text-ink leading-none">{{ $totalLogements }}</p>
        <p class="text-xs text-muted mt-2">publiées</p>
      </div>

      <div class="bg-ink border border-ink rounded-2xl p-5">
        <p class="text-[10px] font-bold text-white/40 uppercase tracking-widest mb-4">Disponibles</p>
        <p class="text-4xl font-black text-white leading-none">{{ $availableLogements }}</p>
        <p class="text-xs text-white/40 mt-2">prêts à louer</p>
      </div>

    </div>


    {{-- ── Taux d'occupation ── --}}
    <div class="bg-white border border-border rounded-2xl p-6 mb-6">
      <p class="text-[10px] font-bold text-muted uppercase tracking-widest mb-5">Taux d'occupation</p>
      <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">

        @php
          $tauxDispo  = $totalLogements > 0 ? round($availableLogements / $totalLogements * 100) : 0;
          $tauxOccupe = 100 - $tauxDispo;
          $tauxOwners = $totalUsers > 0 ? round($totalOwners / $totalUsers * 100) : 0;
        @endphp

        <div>
          <div class="flex items-center justify-between mb-2">
            <p class="text-sm font-semibold text-ink">Disponibles</p>
            <p class="text-sm font-black text-emerald-600">{{ $tauxDispo }}%</p>
          </div>
          <div class="h-2 bg-surface rounded-full overflow-hidden">
            <div class="h-2 bg-emerald-500 rounded-full transition-all" style="width: {{ $tauxDispo }}%"></div>
          </div>
          <p class="text-xs text-muted mt-1.5">{{ $availableLogements }} / {{ $totalLogements }} logements</p>
        </div>

        <div>
          <div class="flex items-center justify-between mb-2">
            <p class="text-sm font-semibold text-ink">Occupés</p>
            <p class="text-sm font-black text-muted">{{ $tauxOccupe }}%</p>
          </div>
          <div class="h-2 bg-surface rounded-full overflow-hidden">
            <div class="h-2 bg-slate-400 rounded-full transition-all" style="width: {{ $tauxOccupe }}%"></div>
          </div>
          <p class="text-xs text-muted mt-1.5">{{ $totalLogements - $availableLogements }} / {{ $totalLogements }} logements</p>
        </div>

        <div>
          <div class="flex items-center justify-between mb-2">
            <p class="text-sm font-semibold text-ink">Propriétaires</p>
            <p class="text-sm font-black text-primary">{{ $tauxOwners }}%</p>
          </div>
          <div class="h-2 bg-surface rounded-full overflow-hidden">
            <div class="h-2 bg-primary rounded-full transition-all" style="width: {{ $tauxOwners }}%"></div>
          </div>
          <p class="text-xs text-muted mt-1.5">{{ $totalOwners }} / {{ $totalUsers }} utilisateurs</p>
        </div>

      </div>
    </div>


    {{-- ── Grille inférieure ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

      {{-- Derniers logements --}}
      <div class="lg:col-span-3 bg-white border border-border rounded-2xl overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-border">
          <p class="text-sm font-bold text-ink">Derniers logements</p>
          <a href="{{ route('logements.index') }}" class="text-xs font-semibold text-primary hover:underline">Voir tout →</a>
        </div>

        @php
          $recentLogements = \App\Models\Logement::with('user')->latest()->take(5)->get();
          $statusLabels = ['available' => 'Disponible', 'reserved' => 'Réservé', 'rented' => 'Loué', 'sold' => 'Vendu'];
          $statusStyle  = [
            'available' => 'bg-emerald-50 text-emerald-700',
            'reserved'  => 'bg-amber-50 text-amber-700',
            'rented'    => 'bg-slate-100 text-slate-600',
            'sold'      => 'bg-red-50 text-red-700',
          ];
        @endphp

        @if($recentLogements->isEmpty())
          <div class="flex items-center justify-center py-12">
            <p class="text-muted text-sm">Aucun logement publié</p>
          </div>
        @else
          <div class="divide-y divide-border">
            @foreach($recentLogements as $l)
              <a href="{{ route('logements.show', $l) }}" class="flex items-center gap-4 px-6 py-3.5 hover:bg-surface transition-colors">
                <div class="flex-1 min-w-0">
                  <p class="text-sm font-semibold text-ink truncate">{{ $l->title }}</p>
                  <p class="text-xs text-muted truncate">{{ $l->city }} · {{ $l->user?->name ?? '–' }}</p>
                </div>
                <div class="shrink-0 flex items-center gap-3">
                  <span class="text-[11px] font-bold px-2.5 py-0.5 rounded-full {{ $statusStyle[$l->status] ?? 'bg-surface text-muted' }}">
                    {{ $statusLabels[$l->status] ?? $l->status }}
                  </span>
                  <span class="text-sm font-bold text-ink whitespace-nowrap">
                    {{ number_format($l->price, 0, ',', ' ') }} <span class="text-muted font-normal text-xs">MAD</span>
                  </span>
                </div>
              </a>
            @endforeach
          </div>
        @endif
      </div>


      {{-- Derniers utilisateurs --}}
      <div class="lg:col-span-2 bg-white border border-border rounded-2xl overflow-hidden">
        <div class="px-5 py-4 border-b border-border">
          <p class="text-sm font-bold text-ink">Nouveaux membres</p>
        </div>

        @php $recentUsers = \App\Models\User::latest()->take(6)->get(); @endphp

        <div class="divide-y divide-border">
          @foreach($recentUsers as $u)
            <div class="flex items-center gap-3 px-5 py-3.5 hover:bg-surface transition-colors">
              <div class="w-8 h-8 rounded-full bg-surface border border-border flex items-center justify-center shrink-0">
                <span class="text-ink font-black text-xs">{{ strtoupper(substr($u->name ?? 'U', 0, 2)) }}</span>
              </div>
              <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-ink truncate">{{ $u->name }}</p>
                <p class="text-xs text-muted truncate">{{ $u->email }}</p>
              </div>
              <span class="shrink-0 text-[10px] font-bold px-2 py-0.5 rounded-full {{ $u->role === 'owner' ? 'bg-primary-light text-primary' : 'bg-surface text-muted border border-border' }}">
                {{ $u->role === 'owner' ? 'Owner' : 'User' }}
              </span>
            </div>
          @endforeach
        </div>
      </div>

    </div>
  </div>
</div>

@endsection