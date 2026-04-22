@extends('layouts.app')

@section('title', 'Mon Profil de Vie – LifeStep+')

@section('content')
<div class="pt-28 pb-20 px-6">
    <div class="max-w-5xl mx-auto">
        
        {{-- En-tête du profil --}}
        <div class="flex flex-col md:flex-row items-center justify-between gap-6 mb-10">
            <div class="flex items-center gap-5">
                <div class="w-20 h-20 bg-primary text-white text-3xl font-bold rounded-2xl flex items-center justify-center shadow-lg shadow-primary/20">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-ink">{{ Auth::user()->name }}</h1>
                    <p class="text-muted">Profil de Vie complété le {{ $profil->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                <a href="{{ route('life_profiles.edit') }}" class="flex items-center gap-2 px-6 py-3 border border-border rounded-xl font-semibold hover:bg-surface transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    Modifier mes critères
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Colonne de Gauche : Détails du Profil --}}
            <div class="lg:col-span-2 space-y-6">
                
                <div class="bg-white rounded-3xl border border-border p-8 shadow-sm">
                    <h2 class="text-xl font-bold text-ink mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Mes critères de recherche
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Type de profil --}}
                        <div class="p-5 bg-surface rounded-2xl border border-border/50">
                            <p class="text-xs font-bold text-muted uppercase tracking-wider mb-1">Situation</p>
                            <p class="text-lg font-bold text-ink">
                                @if($profil->profile_type == 'etudiant') Étudiant(e)
                                @elseif($profil->profile_type == 'couple') En couple
                                @else Famille
                                @endif
                            </p>
                        </div>

                        {{-- Budget --}}
                        <div class="p-5 bg-surface rounded-2xl border border-border/50">
                            <p class="text-xs font-bold text-muted uppercase tracking-wider mb-1">Fourchette Budget</p>
                            <p class="text-lg font-bold text-primary">
                                {{ number_format($profil->budget_min, 0, ',', ' ') }}€ - {{ number_format($profil->budget_max, 0, ',', ' ') }}€
                            </p>
                        </div>

                        {{-- Localisation --}}
                        <div class="p-5 bg-surface rounded-2xl border border-border/50">
                            <p class="text-xs font-bold text-muted uppercase tracking-wider mb-1">Ville ciblée</p>
                            <p class="text-lg font-bold text-ink">{{ ucfirst($profil->location) }}</p>
                        </div>


                    </div>
                </div>

                {{-- Note d'information --}}
                <div class="bg-primary-light rounded-2xl p-6 border border-primary/10 flex gap-4">
                    <div class="bg-white p-2 rounded-lg h-fit text-primary shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-primary">Comment ça marche ?</h4>
                        <p class="text-sm text-primary/80 leading-relaxed mt-1">
                            Grâce à ces données, notre algorithme calcule un score de compatibilité en temps réel pour chaque logement. Les annonces affichées en premier sont celles qui correspondent le mieux à votre budget et à votre situation.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Colonne de Droite : Actions rapides --}}
            <div class="space-y-6">
                <div class="bg-ink rounded-3xl p-8 text-white shadow-xl">
                    <h3 class="text-xl font-bold mb-4">Prêt à trouver ?</h3>
                    <p class="text-white/70 text-sm mb-6 leading-relaxed">
                        Parcourez les logements triés par pertinence selon votre profil actuel.
                    </p>
                    <a href="{{ route('logements.index') }}" class="block w-full py-4 bg-primary hover:bg-primary-dark text-white text-center rounded-xl font-bold transition shadow-lg shadow-primary/40">
                        Voir les logements
                    </a>
                </div>

                <div class="bg-white rounded-3xl border border-border p-8 shadow-sm">
                    <h3 class="font-bold text-ink mb-4">Mes Favoris</h3>
                    <p class="text-sm text-muted mb-6">Vous avez enregistré des biens ? Retrouvez-les ici.</p>
                    <a href="{{ route('favorites.index') }}" class="text-sm font-bold text-primary hover:underline flex items-center gap-1">
                        Accéder à mes favoris
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection