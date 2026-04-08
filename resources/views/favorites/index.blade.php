@extends('layouts.app')

@section('title', 'Mes Favoris – LifeStep+')

@section('content')

<div class="pt-20">
    {{-- Page Header --}}
    <div class="bg-surface border-b border-border px-6 py-10">
        <div class="max-w-7xl mx-auto">
            <h1 class="text-4xl font-bold text-ink">Mes Favoris</h1>
            <p class="text-muted mt-1">Retrouvez ici les logements que vous avez mis de côté.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-10">
        @if($favorites->isEmpty())
            <div class="text-center py-20 bg-surface rounded-3xl border border-dashed border-border">
                <div class="bg-primary/10 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-ink">Aucun favori pour le moment</h3>
                <p class="text-muted mt-2">Explorez les annonces et cliquez sur le cœur pour les enregistrer.</p>
                <a href="{{ route('logements.index') }}" class="inline-block mt-6 bg-primary text-white px-6 py-3 rounded-xl font-semibold hover:bg-primary-dark transition">
                    Voir les logements
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($favorites as $logement)
                    <div class="bg-surface rounded-3xl border border-border overflow-hidden hover:shadow-xl transition-shadow group">
                        {{-- Image --}}
                        <div class="relative aspect-[4/3] overflow-hidden">
                            @if($logement->pictures->isNotEmpty())
                                <img src="{{ asset('storage/' . $logement->pictures->first()->path) }}" 
                                     alt="{{ $logement->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full bg-border flex items-center justify-center">
                                    <span class="text-muted">Aucune photo</span>
                                </div>
                            @endif

                            {{-- Bouton Supprimer des favoris --}}
                            <form action="{{ route('favorites.destroy', $logement->id) }}" method="POST" class="absolute top-4 right-4">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-white/90 backdrop-blur-sm p-2 rounded-full text-red-500 hover:bg-red-50 transition">
                                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                        <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3c1.54 0 2.93.646 3.91 1.676a5.11 5.11 0 013.912-1.676c2.974 0 5.438 2.322 5.438 5.25 0 3.924-2.438 7.11-4.73 9.271a25.177 25.177 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001z" />
                                    </svg>
                                </button>
                            </form>
                        </div>

                        {{-- Contenu --}}
                        <div class="p-6">
                            <div class="flex justify-between items-start mb-2">
                                <h3 class="text-xl font-bold text-ink truncate flex-1">
                                    <a href="{{ route('logements.show', $logement) }}" class="hover:text-primary transition">
                                        {{ $logement->title }}
                                    </a>
                                </h3>
                                <span class="text-primary font-bold">{{ number_format($logement->price, 0, ',', ' ') }}€</span>
                            </div>

                            <p class="text-muted text-sm flex items-center gap-1 mb-4">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ $logement->city }}
                            </p>

                            <div class="flex items-center gap-4 text-xs text-muted border-t border-border pt-4">
                                <span class="flex items-center gap-1">
                                    <strong>{{ $logement->rooms }}</strong> ch.
                                </span>
                                <span class="flex items-center gap-1">
                                    <strong>{{ $logement->beds }}</strong> lits
                                </span>
                                <a href="{{ route('logements.show', $logement) }}" class="ml-auto text-primary font-semibold hover:underline">
                                    Détails →
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>

@endsection