@extends('layouts.app')

@section('title', 'Créer mon Profil de Vie – LifeStep+')

@section('content')
<div class="pt-28 pb-20 px-6">
    <div class="max-w-3xl mx-auto">
        <div class="mb-10 text-center">
            <h1 class="text-4xl font-bold text-ink">Bienvenue !</h1>
            <p class="text-muted mt-2">Dites-nous en plus sur vous pour trouver le logement idéal.</p>
        </div>

        <form action="{{ route('life_profiles.store') }}" method="POST" class="space-y-8">
            @csrf
            
            {{-- Section : Budget --}}
            <div class="bg-surface rounded-3xl p-8 border border-border shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <div class="bg-primary/10 p-2 rounded-lg text-primary">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h2 class="text-xl font-bold">Votre Budget Mensuel</h2>
                </div>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-muted font-bold">€</span>
                    <input type="number" name="budget" placeholder="Ex: 800" class="w-full pl-10 pr-4 py-4 rounded-2xl border border-border focus:border-primary focus:ring-4 focus:ring-primary/5 outline-none transition" required>
                </div>
            </div>

            {{-- Section : Composition du foyer --}}
            <div class="bg-surface rounded-3xl p-8 border border-border shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <div class="bg-primary/10 p-2 rounded-lg text-primary">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <h2 class="text-xl font-bold">Votre foyer</h2>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold mb-2">Nombre d'adultes</label>
                        <input type="number" name="adults_count" value="1" class="w-full px-4 py-4 rounded-2xl border border-border focus:border-primary outline-none">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold mb-2">Nombre d'enfants</label>
                        <input type="number" name="children_count" value="0" class="w-full px-4 py-4 rounded-2xl border border-border focus:border-primary outline-none">
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full bg-primary text-white py-5 rounded-2xl font-bold text-lg hover:bg-primary-dark shadow-lg shadow-primary/20 transition-all transform hover:-translate-y-1">
                Enregistrer mon profil
            </button>
        </form>
    </div>
</div>
@endsection