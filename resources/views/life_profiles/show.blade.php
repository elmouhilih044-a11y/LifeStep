<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    {{-- Budget --}}
    <div class="bg-surface p-6 rounded-2xl border border-border">
        <p class="text-muted text-xs font-bold uppercase mb-2">Budget</p>
        <p class="text-xl font-bold text-ink">
            {{ $profil->budget_min ?? 0 }}€ - {{ $profil->budget_max }}€
        </p>
    </div>

    {{-- Ville --}}
    <div class="bg-surface p-6 rounded-2xl border border-border">
        <p class="text-muted text-xs font-bold uppercase mb-2">Localisation</p>
        <p class="text-xl font-bold text-ink">{{ ucfirst($profil->location) }}</p>
    </div>

    {{-- Profil --}}
    <div class="bg-surface p-6 rounded-2xl border border-border">
        <p class="text-muted text-xs font-bold uppercase mb-2">Type de profil</p>
        <p class="text-xl font-bold text-primary">{{ ucfirst($profil->profile_type) }}</p>
    </div>
</div>