<form action="{{ route('life_profiles.store') }}" method="POST" class="space-y-6">
    @csrf
    
    {{-- Type de Profil --}}
    <div class="bg-white p-6 rounded-2xl border border-border">
        <label class="block text-sm font-bold mb-4">Vous êtes :</label>
        <div class="grid grid-cols-3 gap-3">
            @foreach(['etudiant' => 'Étudiant', 'couple' => 'En couple', 'famille' => 'Famille'] as $value => $label)
                <label class="relative">
                    <input type="radio" name="profile_type" value="{{ $value }}" class="peer sr-only" required>
                    <div class="p-4 text-center border border-border rounded-xl cursor-pointer hover:bg-surface peer-checked:border-primary peer-checked:bg-primary/5 peer-checked:text-primary transition">
                        <span class="text-sm font-semibold">{{ $label }}</span>
                    </div>
                </label>
            @endforeach
        </div>
    </div>

    {{-- Budget Range (Important pour le CompatibilityService) --}}
    <div class="bg-white p-6 rounded-2xl border border-border">
        <label class="block text-sm font-bold mb-4">Votre fourchette de budget mensuel</label>
        <div class="flex items-center gap-4">
            <div class="flex-1">
                <input type="number" name="budget_min" placeholder="Min (€)" class="w-full p-4 rounded-xl border border-border outline-none focus:border-primary">
            </div>
            <span class="text-muted">à</span>
            <div class="flex-1">
                <input type="number" name="budget_max" placeholder="Max (€)" class="w-full p-4 rounded-xl border border-border outline-none focus:border-primary" required>
            </div>
        </div>
    </div>

    {{-- Ville & Type de recherche --}}
    <div class="bg-white p-6 rounded-2xl border border-border grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block text-sm font-bold mb-2">Ville souhaitée</label>
            <input type="text" name="location" placeholder="Ex: Paris" class="w-full p-4 rounded-xl border border-border outline-none focus:border-primary" required>
        </div>
        <div>
            <label class="block text-sm font-bold mb-2">Type de logement</label>
            <select name="search_type" class="w-full p-4 rounded-xl border border-border outline-none focus:border-primary appearance-none bg-white">
                <option value="location">Location classique</option>
                <option value="colocation">Colocation</option>
                <option value="court_sejour">Court séjour</option>
            </select>
        </div>
    </div>

    <button type="submit" class="w-full bg-primary text-white py-4 rounded-xl font-bold hover:bg-primary-dark transition shadow-lg shadow-primary/20">
        Calculer ma compatibilité
    </button>
</form>