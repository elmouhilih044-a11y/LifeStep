@extends('layouts.app')

@section('title', 'Modifier mon Profil de Vie – LifeStep+')

@section('content')
<div class="pt-28 pb-20 px-6">
    <div class="max-w-3xl mx-auto">
        
        {{-- En-tête --}}
        <div class="mb-10 text-center">
            <h1 class="text-4xl font-bold text-ink tracking-tight">Modifier mon Profil</h1>
            <p class="text-muted mt-3 text-lg">Ajustez vos critères pour obtenir de meilleurs scores de compatibilité.</p>
        </div>

        {{-- Affichage des erreurs de validation --}}
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
                    <h2 class="text-xl font-bold text-ink">Quelle est votre situation ?</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach(['etudiant' => 'Étudiant', 'couple' => 'En couple', 'famille' => 'Famille'] as $value => $label)
                        <label class="cursor-pointer">
                            <input type="radio" name="profile_type" value="{{ $value }}" class="peer sr-only" 
                                {{ old('profile_type', $profil->profile_type) == $value ? 'checked' : '' }} required>
                            <div class="p-4 text-center border-2 border-border rounded-2xl hover:bg-surface peer-checked:border-primary peer-checked:bg-primary/5 peer-checked:text-primary transition-all">
                                <span class="font-bold">{{ $label }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- 2. Budget (Séparé en deux colonnes) --}}
            <div class="bg-white rounded-3xl p-8 border border-border shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <div class="bg-primary/10 p-2.5 rounded-xl text-primary">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h2 class="text-xl font-bold text-ink">Votre budget mensuel</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-muted ml-1">Budget Minimum (€)</label>
                        <input type="number" name="budget_min" value="{{ old('budget_min', $profil->budget_min) }}" 
                               class="w-full p-4 bg-surface rounded-2xl border border-transparent focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/5 outline-none transition">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-muted ml-1">Budget Maximum (€)</label>
                        <input type="number" name="budget_max" value="{{ old('budget_max', $profil->budget_max) }}" required
                               class="w-full p-4 bg-surface rounded-2xl border border-transparent focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/5 outline-none transition">
                    </div>
                </div>
            </div>

            {{-- 3. Localisation --}}
            <div class="bg-white rounded-3xl p-8 border border-border shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <div class="bg-primary/10 p-2.5 rounded-xl text-primary">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <h2 class="text-xl font-bold text-ink">Préférences</h2>
                </div>
                
                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-muted ml-1">Dans quelle ville cherchez-vous ?</label>
                        <input type="text" name="location" value="{{ old('location', $profil->location) }}" required
                               class="w-full p-4 bg-surface rounded-2xl border border-transparent focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/5 outline-none transition">
                    </div>
                </div>
            </div>

            {{-- Validation --}}
            <div class="pt-4">
                <button type="submit" class="w-full py-5 bg-primary hover:bg-primary-dark text-white rounded-2xl font-bold text-lg shadow-xl transition-all transform hover:-translate-y-1">
                    Enregistrer les modifications
                </button>
                <div class="text-center mt-4">
                    <a href="{{ route('life_profiles.show') }}" class="text-sm font-bold text-muted hover:text-ink transition">
                        Annuler et revenir au profil
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection