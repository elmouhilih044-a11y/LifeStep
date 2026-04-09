@extends('layouts.app')

@section('title', 'Mon Profil de Vie – LifeStep+')

@section('content')
<div class="pt-28 pb-20 px-6">
    <div class="max-w-4xl mx-auto">
        <div class="flex flex-col md:flex-row gap-8">
            
            {{-- Carte Latérale --}}
            <div class="md:w-1/3">
                <div class="bg-surface rounded-3xl p-8 border border-border text-center sticky top-28">
                    <div class="w-24 h-24 bg-primary text-white text-3xl font-bold rounded-full flex items-center justify-center mx-auto mb-4">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <h2 class="text-2xl font-bold text-ink">{{ Auth::user()->name }}</h2>
                    <p class="text-muted text-sm mb-6">Membre depuis {{ Auth::user()->created_at->format('M Y') }}</p>
                    
                    <a href="{{ route('life_profiles.edit') }}" class="block w-full py-3 border border-border rounded-xl font-semibold hover:bg-white transition">
                        Modifier le profil
                    </a>
                </div>
            </div>

            {{-- Contenu Principal --}}
            <div class="md:w-2/3 space-y-6">
                <h3 class="text-2xl font-bold text-ink">Mes critères de recherche</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- Item Budget --}}
                    <div class="bg-white border border-border p-6 rounded-2xl shadow-sm">
                        <p class="text-muted text-xs uppercase font-bold tracking-wider mb-1">Budget Max</p>
                        <p class="text-2xl font-black text-primary">{{ number_format($profil->budget, 0, ',', ' ') }} €</p>
                    </div>

                    {{-- Item Foyer --}}
                    <div class="bg-white border border-border p-6 rounded-2xl shadow-sm">
                        <p class="text-muted text-xs uppercase font-bold tracking-wider mb-1">Composition</p>
                        <p class="text-2xl font-black text-ink">
                            {{ $profil->adults_count + $profil->children_count }} Pers.
                        </p>
                    </div>
                </div>

                {{-- Message d'info --}}
                <div class="bg-primary-light p-6 rounded-2xl border border-primary/20">
                    <p class="text-primary font-medium text-sm leading-relaxed">
                        Ces informations nous permettent de calculer votre score de compatibilité avec les logements disponibles.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection