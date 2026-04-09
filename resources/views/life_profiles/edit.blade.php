@extends('layouts.app')

@section('title', 'Modifier mon Profil de Vie – LifeStep+')

@section('content')
<div class="pt-28 pb-20 px-6">
    <div class="max-w-3xl mx-auto">
        
        {{-- En-tête --}}
        <div class="mb-10 flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-bold text-ink tracking-tight">Modifier mon profil</h1>
                <p class="text-muted mt-2 text-lg">Ajustez vos critères pour affiner votre compatibilité.</p>
            </div>
            <a href="{{ route('life_profiles.show') }}" class="text-sm font-bold text-muted hover:text-ink transition">
                Annuler
            </a>
        </div>

        {{-- Affichage des erreurs --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-600 rounded-2xl text-sm">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('life_profiles.update') }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')
            
            {{-- 1. Type de Profil --}}
            <div class="bg-white rounded-3xl p-8 border border-border shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <div class="bg-primary/10 p-2.5 rounded-xl text-primary">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <h2 class="text-xl font-bold text-ink">Vous êtes...</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach(['etudiant' => 'Étudiant', 'couple' => 'En Couple', 'famille' => 'En Famille'] as $value => $label)
                        <label class="cursor-pointer">
                            <input type="radio" name="profile_type" value="{{ $value }}" class="peer sr-only" 
                                {{ old('profile_type', $profil->profile_type) == $value ? 'checked' : '' }}>
                            <div class="p-4 text-center border-2 border-border rounded-2xl hover:bg-surface peer-checked:border-primary peer-checked:bg-primary/5 peer-checked:text-primary transition-all">
                                <span class="font-bold">{{ $label }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- 2. Budget & Ville --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white rounded-3xl p-8 border border-border shadow-sm">
                    <h2 class="text-lg font-bold text-ink mb-6">Budget Mensuel (€)</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-muted uppercase mb-2">Minimum</label>
                            <input type="number" name="budget_min" value="{{ old('budget_min', $profil->budget_min) }}" 
                                   class="w-full bg-surface border border-border rounded-xl px-4 py-3 focus:border-primary outline-none transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-muted uppercase mb-2">Maximum</label>
                            <input type="number" name="budget_max" value="{{ old('budget_max', $profil->budget_max) }}"
                                   class="w-full bg-surface border border-border rounded-xl px-4 py-3 focus:border-primary outline-none transition">
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl p-8 border border-border shadow-sm flex flex-col justify-between">
                    <div>
                        <h2 class="text-lg font-bold text-ink mb-6">Localisation</h2>
                        <label class="block text-xs font-bold text-muted uppercase mb-2">Ville cible</label>
                        <input type="text" name="location" value="{{ old('location', $profil->location) }}" placeholder="Ex: Casablanca"
                               class="w-full bg-surface border border-border rounded-xl px-4 py-3 focus:border-primary outline-none transition">
                    </div>
                </div>
            </div>

            {{-- 3. Type de recherche --}}
            <div class="bg-white rounded-3xl p-8 border border-border shadow-sm">
                <h2 class="text-lg font-bold text-ink mb-6">Que recherchez-vous ?</h2>
                <div class="grid grid-cols-2 gap-4">
                    <label class="cursor-pointer">
                        <input type="radio" name="search_type" value="location" class="peer sr-only" 
                            {{ old('search_type', $profil->search_type) == 'location' ? 'checked' : '' }}>
                        <div class="p-4 text-center border-2 border-border rounded-2xl hover:bg-surface peer-checked:border-primary peer-checked:bg-primary/5 peer-checked:text-primary transition-all">
                            <span class="font-bold">Location</span>
                        </div>
                    </label>
                    <label class="cursor-pointer">
                        <input type="radio" name="search_type" value="achat" class="peer sr-only" 
                            {{ old('search_type', $profil->search_type) == 'achat' ? 'checked' : '' }}>
                        <div class="p-4 text-center border-2 border-border rounded-2xl hover:bg-surface peer-checked:border-primary peer-checked:bg-primary/5 peer-checked:text-primary transition-all">
                            <span class="font-bold">Achat</span>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Bouton de validation --}}
            <div class="pt-4">
                <button type="submit" class="w-full py-5 bg-primary hover:bg-primary-dark text-white rounded-2xl font-bold text-lg shadow-xl transition-all transform hover:-translate-y-1">
                    Mettre à jour mon profil
                </button>
            </div>
        </form>
    </div>
</div>
@endsection