@extends('layouts.app')

@section('title', 'Mes logements')

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@400;500&display=swap" rel="stylesheet"/>
<style>
  .mine-font { font-family: 'DM Sans', sans-serif; }
  .mine-serif { font-family: 'DM Serif Display', serif; }
</style>
@endsection

@section('content')
<div class="mine-font py-6 sm:py-10 px-4 sm:px-6">
  <div class="max-w-6xl mx-auto">

    {{-- ── Header ── --}}
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-6 sm:mb-8">
      <div>
        <h1 class="mine-serif text-3xl sm:text-4xl font-normal text-ink leading-tight">Mes logements</h1>
        <p class="text-muted text-sm mt-1">Gérez vos biens publiés sur LifeStep+</p>
      </div>
      @can('create', App\Models\Logement::class)
        <a href="{{ route('logements.create') }}"
           class="inline-flex items-center justify-center gap-2 bg-primary hover:bg-primary-dark text-white font-medium text-sm px-5 py-2.5 rounded-xl transition shrink-0 w-full sm:w-auto">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
          </svg>
          Publier un logement
        </a>
      @endcan
    </div>

    @if($logements->isEmpty())

      {{-- ── Empty state ── --}}
      <div class="border border-border rounded-2xl p-10 sm:p-16 text-center">
        <div class="w-14 h-14 bg-primary-light rounded-full flex items-center justify-center mx-auto mb-5">
          <svg class="w-7 h-7 text-primary" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955a1.5 1.5 0 012.092 0L22.25 12M4.5 9.75v10.125A1.125 1.125 0 005.625 21h4.5a1.125 1.125 0 001.125-1.125V15a1.125 1.125 0 011.125-1.125h2.25A1.125 1.125 0 0115.75 15v4.875A1.125 1.125 0 0016.875 21h4.5a1.125 1.125 0 001.125-1.125V9.75"/>
          </svg>
        </div>
        <p class="font-medium text-ink text-base mb-1">Aucun logement publié</p>
        <p class="text-muted text-sm">Commencez par ajouter votre premier bien immobilier.</p>
        @can('create', App\Models\Logement::class)
          <a href="{{ route('logements.create') }}"
             class="mt-6 inline-flex items-center gap-2 bg-primary hover:bg-primary-dark text-white font-medium text-sm px-5 py-2.5 rounded-xl transition">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
            </svg>
            Ajouter un logement
          </a>
        @endcan
      </div>

    @else

      {{-- ── Stats bar ── --}}
      <div class="grid grid-cols-3 gap-2 sm:gap-3 mb-6 sm:mb-8">
        <div class="bg-surface rounded-xl px-3 sm:px-4 py-3">
          <p class="text-xs font-medium text-muted uppercase tracking-wide">Total</p>
          <p class="text-xl sm:text-2xl font-medium text-ink mt-1">{{ $logements->count() }}</p>
        </div>
        <div class="bg-surface rounded-xl px-3 sm:px-4 py-3">
          <p class="text-xs font-medium text-muted uppercase tracking-wide">Disponibles</p>
          <p class="text-xl sm:text-2xl font-medium text-primary mt-1">{{ $logements->where('status', 'available')->count() }}</p>
        </div>
        <div class="bg-surface rounded-xl px-3 sm:px-4 py-3">
          <p class="text-xs font-medium text-muted uppercase tracking-wide">Prix moy.</p>
          <p class="text-xl sm:text-2xl font-medium text-ink mt-1">
            {{ $logements->avg('price') ? number_format($logements->avg('price'), 0, ',', ' ') : '–' }}
            <span class="text-xs font-normal text-muted">MAD</span>
          </p>
        </div>
      </div>

      {{-- ── Grid ── --}}
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-5">
        @foreach($logements as $logement)
          <div class="group bg-white border border-border rounded-2xl overflow-hidden transition-all duration-200 hover:border-gray-300 {{ $logement->status !== 'available' ? 'opacity-75' : '' }}">

            {{-- Image --}}
            <div class="relative overflow-hidden">
              @if($logement->pictures->isNotEmpty())
                <img src="{{ asset('storage/' . $logement->pictures->sortBy('order')->first()->path) }}"
                     alt="{{ $logement->title }}"
                     class="w-full h-44 sm:h-48 object-cover group-hover:scale-105 transition-transform duration-500"/>
              @else
                <div class="w-full h-44 sm:h-48 bg-surface flex items-center justify-center">
                  <svg class="w-12 h-12 text-border" fill="none" stroke="currentColor" stroke-width="1" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955a1.5 1.5 0 012.092 0L22.25 12M4.5 9.75v10.125A1.125 1.125 0 005.625 21h4.5a1.125 1.125 0 001.125-1.125V15a1.125 1.125 0 011.125-1.125h2.25A1.125 1.125 0 0115.75 15v4.875A1.125 1.125 0 0016.875 21h4.5a1.125 1.125 0 001.125-1.125V9.75"/>
                  </svg>
                </div>
              @endif

              <span class="absolute top-3 left-3 text-xs font-medium px-2.5 py-1 rounded-full
                {{ $logement->status === 'available'
                   ? 'bg-white/90 text-emerald-600'
                   : 'bg-white/80 text-muted' }}">
                {{ $logement->status === 'available' ? '● Disponible' : '○ Indisponible' }}
              </span>
            </div>

            {{-- Body --}}
            <div class="p-4">
              <a href="{{ route('logements.show', $logement) }}" class="block mb-3">
                <h2 class="font-medium text-ink truncate">{{ $logement->title }}</h2>
                <p class="text-sm text-muted mt-0.5 flex items-center gap-1">
                  <svg class="w-3 h-3 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5"/>
                  </svg>
                  {{ $logement->city }}
                </p>
              </a>

              {{-- Footer --}}
              <div class="flex items-center justify-between pt-3 border-t border-border">
                <p class="text-primary font-medium text-sm">
                  {{ number_format($logement->price, 0, ',', ' ') }} MAD
                  <span class="text-muted font-normal text-xs">/ mois</span>
                </p>

                <div class="flex items-center gap-1.5">
                  @can('update', $logement)
                    <a href="{{ route('logements.edit', $logement) }}"
                       class="w-8 h-8 flex items-center justify-center rounded-lg bg-surface border border-border hover:bg-gray-100 transition"
                       title="Modifier">
                      <svg class="w-3.5 h-3.5 text-muted" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931z"/>
                      </svg>
                    </a>
                  @endcan

                  @can('delete', $logement)
                    <form action="{{ route('logements.destroy', $logement) }}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit"
                              title="Supprimer"
                              onclick="return confirm('Supprimer ce logement ?')"
                              class="w-8 h-8 flex items-center justify-center rounded-lg bg-surface border border-border hover:bg-red-50 hover:border-red-200 transition group/del">
                        <svg class="w-3.5 h-3.5 text-muted group-hover/del:text-primary transition-colors" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"/>
                        </svg>
                      </button>
                    </form>
                  @endcan
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>

    @endif
  </div>
</div>
@endsection