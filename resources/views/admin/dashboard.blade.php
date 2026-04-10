@extends('layouts.app')

@section('title', 'Dashboard Admin – LifeStep+')

@push('styles')
<style>
  @keyframes countUp {
    from { opacity: 0; transform: translateY(8px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  .stat-card { animation: countUp 0.4s ease both; }
  .stat-card:nth-child(1) { animation-delay: 0.05s; }
  .stat-card:nth-child(2) { animation-delay: 0.10s; }
  .stat-card:nth-child(3) { animation-delay: 0.15s; }
  .stat-card:nth-child(4) { animation-delay: 0.20s; }
</style>
@endpush

@section('content')

<div class="pt-20 min-h-screen bg-surface">
  <div class="max-w-7xl mx-auto px-6 py-10">

    {{-- ── En-tête ── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-10">
      <div>
        <p class="text-xs font-bold text-primary uppercase tracking-widest mb-1">Administration</p>
        <h1 class="text-3xl font-bold text-ink">Dashboard</h1>
        <p class="text-muted text-sm mt-1">Vue d'ensemble de la plateforme LifeStep+</p>
      </div>
      <div class="flex items-center gap-2">
        <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-3 py-1.5 bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full">
          <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
          Système actif
        </span>
        <span class="text-xs text-muted">{{ now()->format('d/m/Y · H:i') }}</span>
      </div>
    </div>


    {{-- ── 4 Stat Cards ── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-10">

      {{-- Utilisateurs --}}
      <div class="stat-card bg-white border border-border rounded-2xl p-5 flex flex-col justify-between min-h-[130px]">
        <div class="flex items-center justify-between mb-4">
          <p class="text-[10px] font-black text-muted uppercase tracking-widest">Utilisateurs</p>
          <div class="w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center">
            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0"/>
            </svg>
          </div>
        </div>
        <div>
          <p class="text-4xl font-black text-ink leading-none">{{ number_format($totalUsers) }}</p>
          <p class="text-xs text-muted mt-1.5">inscrits au total</p>
        </div>
      </div>

      {{-- Propriétaires --}}
      <div class="stat-card bg-white border border-border rounded-2xl p-5 flex flex-col justify-between min-h-[130px]">
        <div class="flex items-center justify-between mb-4">
          <p class="text-[10px] font-black text-muted uppercase tracking-widest">Propriétaires</p>
          <div class="w-8 h-8 rounded-lg bg-primary-light flex items-center justify-center">
            <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955a1.5 1.5 0 012.092 0L22.25 12M4.5 9.75v10.125A1.125 1.125 0 005.625 21h4.5a1.125 1.125 0 001.125-1.125V15a1.125 1.125 0 011.125-1.125h2.25A1.125 1.125 0 0115.75 15v4.875A1.125 1.125 0 0016.875 21h4.5a1.125 1.125 0 001.125-1.125V9.75"/>
            </svg>
          </div>
        </div>
        <div>
          <p class="text-4xl font-black text-ink leading-none">{{ number_format($totalOwners) }}</p>
          <p class="text-xs text-muted mt-1.5">avec rôle owner</p>
        </div>
      </div>

      {{-- Total logements --}}
      <div class="stat-card bg-white border border-border rounded-2xl p-5 flex flex-col justify-between min-h-[130px]">
        <div class="flex items-center justify-between mb-4">
          <p class="text-[10px] font-black text-muted uppercase tracking-widest">Annonces</p>
          <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center">
            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25z"/>
            </svg>
          </div>
        </div>
        <div>
          <p class="text-4xl font-black text-ink leading-none">{{ number_format($totalLogements) }}</p>
          <p class="text-xs text-muted mt-1.5">annonces publiées</p>
        </div>
      </div>

      {{-- Disponibles --}}
      <div class="stat-card bg-ink border border-ink rounded-2xl p-5 flex flex-col justify-between min-h-[130px]">
        <div class="flex items-center justify-between mb-4">
          <p class="text-[10px] font-black text-white/40 uppercase tracking-widest">Disponibles</p>
          <div class="w-8 h-8 rounded-lg bg-white/10 flex items-center justify-center">
            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
          </div>
        </div>
        <div>
          <p class="text-4xl font-black text-white leading-none">{{ number_format($availableLogements) }}</p>
          <p class="text-xs text-white/40 mt-1.5">prêts à louer</p>
        </div>
      </div>
    </div>


    {{-- ── Grille inférieure ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

      {{-- Logements récents --}}
      <div class="lg:col-span-2 bg-white border border-border rounded-2xl overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-border">
          <p class="text-sm font-bold text-ink">Derniers logements</p>
          <a href="{{ route('logements.index') }}" class="text-xs font-semibold text-primary hover:underline">Voir tout →</a>
        </div>

        @php $recentLogements = \App\Models\Logement::with('user')->latest()->take(6)->get(); @endphp

        @if($recentLogements->isEmpty())
          <div class="flex flex-col items-center justify-center py-16 text-center">
            <svg class="w-10 h-10 text-border mb-3" fill="none" stroke="currentColor" stroke-width="1.2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955a1.5 1.5 0 012.092 0L22.25 12M4.5 9.75v10.125A1.125 1.125 0 005.625 21"/>
            </svg>
            <p class="text-muted text-sm">Aucun logement publié</p>
          </div>
        @else
          <div class="divide-y divide-border">
            @foreach($recentLogements as $l)
              @php
                $statusColors = [
                  'available' => ['dot' => 'bg-emerald-500', 'text' => 'text-emerald-700', 'bg' => 'bg-emerald-50'],
                  'reserved'  => ['dot' => 'bg-amber-500',   'text' => 'text-amber-700',   'bg' => 'bg-amber-50'],
                  'rented'    => ['dot' => 'bg-slate-400',   'text' => 'text-slate-600',   'bg' => 'bg-slate-100'],
                  'sold'      => ['dot' => 'bg-red-500',     'text' => 'text-red-700',     'bg' => 'bg-red-50'],
                ];
                $sc = $statusColors[$l->status] ?? $statusColors['rented'];
                $statusLabels = ['available' => 'Disponible', 'reserved' => 'Réservé', 'rented' => 'Loué', 'sold' => 'Vendu'];
              @endphp
              <div class="flex items-center gap-4 px-6 py-3.5 hover:bg-surface transition-colors">
                <div class="w-9 h-9 rounded-xl bg-surface border border-border flex items-center justify-center shrink-0">
                  <svg class="w-4 h-4 text-muted" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955a1.5 1.5 0 012.092 0L22.25 12M4.5 9.75v10.125A1.125 1.125 0 005.625 21h4.5a1.125 1.125 0 001.125-1.125V15a1.125 1.125 0 011.125-1.125h2.25A1.125 1.125 0 0115.75 15v4.875A1.125 1.125 0 0016.875 21h4.5a1.125 1.125 0 001.125-1.125V9.75"/>
                  </svg>
                </div>
                <div class="flex-1 min-w-0">
                  <p class="text-sm font-semibold text-ink truncate">{{ $l->title }}</p>
                  <p class="text-xs text-muted truncate">{{ $l->city }} · {{ $l->user?->name ?? '–' }}</p>
                </div>
                <div class="shrink-0 flex items-center gap-3">
                  <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2 py-0.5 rounded-full {{ $sc['bg'] }} {{ $sc['text'] }}">
                    <span class="w-1 h-1 rounded-full {{ $sc['dot'] }}"></span>
                    {{ $statusLabels[$l->status] ?? $l->status }}
                  </span>
                  <span class="text-sm font-bold text-ink whitespace-nowrap">{{ number_format($l->price, 0, ',', ' ') }} <span class="text-muted font-normal text-xs">MAD</span></span>
                </div>
              </div>
            @endforeach
          </div>
        @endif
      </div>


      {{-- Panneau droit : utilisateurs récents + taux --}}
      <div class="space-y-4">

        {{-- Taux occupation --}}
        <div class="bg-white border border-border rounded-2xl p-5">
          <p class="text-[10px] font-bold text-muted uppercase tracking-widest mb-4">Taux d'occupation</p>
          @php
            $tauxDispo   = $totalLogements > 0 ? round($availableLogements / $totalLogements * 100) : 0;
            $tauxOccupe  = 100 - $tauxDispo;
          @endphp
          <div class="space-y-3">
            <div>
              <div class="flex justify-between text-xs mb-1">
                <span class="font-semibold text-ink">Disponibles</span>
                <span class="font-bold text-emerald-600">{{ $tauxDispo }}%</span>
              </div>
              <div class="h-2 bg-surface rounded-full overflow-hidden">
                <div class="h-2 bg-emerald-500 rounded-full" style="width: {{ $tauxDispo }}%"></div>
              </div>
            </div>
            <div>
              <div class="flex justify-between text-xs mb-1">
                <span class="font-semibold text-ink">Occupés / Loués</span>
                <span class="font-bold text-muted">{{ $tauxOccupe }}%</span>
              </div>
              <div class="h-2 bg-surface rounded-full overflow-hidden">
                <div class="h-2 bg-slate-400 rounded-full" style="width: {{ $tauxOccupe }}%"></div>
              </div>
            </div>
            <div>
              <div class="flex justify-between text-xs mb-1">
                <span class="font-semibold text-ink">Propriétaires / Utilisateurs</span>
                @php $tauxOwners = $totalUsers > 0 ? round($totalOwners / $totalUsers * 100) : 0; @endphp
                <span class="font-bold text-primary">{{ $tauxOwners }}%</span>
              </div>
              <div class="h-2 bg-surface rounded-full overflow-hidden">
                <div class="h-2 bg-primary rounded-full" style="width: {{ $tauxOwners }}%"></div>
              </div>
            </div>
          </div>
        </div>

        {{-- Derniers utilisateurs inscrits --}}
        <div class="bg-white border border-border rounded-2xl overflow-hidden">
          <div class="flex items-center justify-between px-5 py-4 border-b border-border">
            <p class="text-sm font-bold text-ink">Nouveaux membres</p>
          </div>
          @php $recentUsers = \App\Models\User::latest()->take(5)->get(); @endphp
          <div class="divide-y divide-border">
            @foreach($recentUsers as $u)
              <div class="flex items-center gap-3 px-5 py-3 hover:bg-surface transition-colors">
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
</div>

@endsection