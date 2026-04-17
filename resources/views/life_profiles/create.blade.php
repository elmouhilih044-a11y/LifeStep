@extends('layouts.app')

@section('title', 'Créer mon Profil de Vie – LifeStep+')

@section('content')
<div class="pt-28 pb-20 px-6">
    <div class="max-w-3xl mx-auto">
        
        {{-- En-tête --}}
        <div class="mb-10 text-center">
            <h1 class="text-4xl font-bold text-ink tracking-tight">Mon Profil de Vie</h1>
            <p class="text-muted mt-3 text-lg">Définissez vos critères pour trouver le bien idéal.</p>
        </div>

        {{-- Erreurs de validation --}}
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-600 rounded-2xl text-sm">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('life_profiles.store') }}" method="POST" class="space-y-8">
            @csrf
            
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
                            <input type="radio" name="profile_type" value="{{ $value }}" class="peer sr-only" {{ old('profile_type') == $value ? 'checked' : '' }} required>
                            <div class="p-4 text-center border-2 border-border rounded-2xl hover:bg-surface peer-checked:border-primary peer-checked:bg-primary/5 peer-checked:text-primary transition-all">
                                <span class="font-bold">{{ $label }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            {{-- 2. Budget (Min & Max) --}}
            <div class="bg-white rounded-3xl p-8 border border-border shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <div class="bg-primary/10 p-2.5 rounded-xl text-primary">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h2 class="text-xl font-bold text-ink">Votre budget</h2>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-muted ml-1">Budget Minimum (€)</label>
                        <input type="number" name="budget_min" value="{{ old('budget_min', 0) }}" placeholder="Ex: 400" 
                               class="w-full p-4 bg-surface rounded-2xl border border-transparent focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/5 outline-none transition">
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-muted ml-1">Budget Maximum (€)</label>
                        <input type="number" name="budget_max" value="{{ old('budget_max') }}" placeholder="Ex: 1200" required
                               class="w-full p-4 bg-surface rounded-2xl border border-transparent focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/5 outline-none transition">
                    </div>
                </div>
            </div>

            {{-- 3. Localisation et Type de recherche (Achat/Location) --}}
            <div class="bg-white rounded-3xl p-8 border border-border shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <div class="bg-primary/10 p-2.5 rounded-xl text-primary">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                    <h2 class="text-xl font-bold text-ink">Préférences</h2>
                </div>
                
                <div class="space-y-6">
                    <div class="space-y-2">
                        <label class="text-sm font-bold text-muted ml-1">Dans quelle ville cherchez-vous ?</label>
                        <input type="text" name="location" value="{{ old('location') }}" placeholder="Ex: Casablanca, Paris..." required
                               class="w-full p-4 bg-surface rounded-2xl border border-transparent focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/5 outline-none transition">
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-bold text-muted ml-1">Que recherchez-vous ?</label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="cursor-pointer">
                                <input type="radio" name="search_type" value="location" class="peer sr-only" {{ old('search_type', 'location') == 'location' ? 'checked' : '' }} required>
                                <div class="p-4 text-center border-2 border-border rounded-2xl hover:bg-surface peer-checked:border-primary peer-checked:bg-primary/5 peer-checked:text-primary transition-all">
                                    <span class="font-bold">Location</span>
                                </div>
                            </label>
                            <label class="cursor-pointer">
                                <input type="radio" name="search_type" value="achat" class="peer sr-only" {{ old('search_type') == 'achat' ? 'checked' : '' }}>
                                <div class="p-4 text-center border-2 border-border rounded-2xl hover:bg-surface peer-checked:border-primary peer-checked:bg-primary/5 peer-checked:text-primary transition-all">
                                    <span class="font-bold">Achat</span>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

           {{-- Validation --}}
            <div class="pt-4">
                <button type="submit" class="w-full py-5 bg-primary hover:bg-primary-dark text-white rounded-2xl font-bold text-lg shadow-xl transition-all transform hover:-translate-y-1">
                    Enregistrer mon profil
                </button>
            </div>
        </form>
        <div class="text-center mt-4">
    <form action="{{ route('life_profiles.skip') }}" method="POST">
        @csrf
        <button type="submit" class="text-sm text-gray-500 hover:underline">
            Passer pour le moment
        </button>
    </form>
</div>
    </div>
</div>
@endsection