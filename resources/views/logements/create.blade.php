@extends('layouts.app')

@section('title', 'Publier un logement – LifeStep+')

@section('content')

<div class="pt-20">

  {{-- ══════════════════════════════════
       PAGE HEADER
  ══════════════════════════════════ --}}
  <div class="bg-surface border-b border-border px-6 py-8">
    <div class="max-w-3xl mx-auto flex items-start justify-between gap-4">
      <div>
        <nav class="flex items-center gap-2 text-sm mb-2">
          <a href="{{ route('logements.index') }}" class="text-primary font-semibold hover:underline">Annonces</a>
          <svg class="w-3.5 h-3.5 text-border" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
          </svg>
          <span class="text-ink font-medium">Nouveau logement</span>
        </nav>
        <h1 class="text-3xl font-bold text-ink">Publier un logement</h1>
        <p class="text-muted text-sm mt-1">Remplissez les informations pour mettre votre bien en ligne</p>
      </div>
      <a href="{{ route('logements.index') }}"
         class="flex items-center gap-1.5 text-sm text-muted hover:text-ink transition-colors font-medium whitespace-nowrap mt-1">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
        </svg>
        Retour
      </a>
    </div>
  </div>


  <div class="max-w-3xl mx-auto px-6 py-10">

    {{-- Erreurs de validation --}}
    @if($errors->any())
      <div class="mb-6 bg-red-50 border border-red-200 rounded-2xl p-5">
        <div class="flex items-start gap-3">
          <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/>
          </svg>
          <div>
            <p class="text-sm font-bold text-red-700 mb-2">Veuillez corriger les erreurs :</p>
            <ul class="space-y-1">
              @foreach($errors->all() as $error)
                <li class="text-sm text-red-600 flex items-center gap-1.5">
                  <span class="w-1 h-1 rounded-full bg-red-400 shrink-0"></span>
                  {{ $error }}
                </li>
              @endforeach
            </ul>
          </div>
        </div>
      </div>
    @endif


    <form method="POST" action="{{ route('logements.store') }}"
          enctype="multipart/form-data" class="space-y-5" novalidate>
      @csrf

      {{-- ── Section 1 : Informations essentielles ── --}}
      <div class="border border-border rounded-2xl p-6 bg-white shadow-card">
        <div class="flex items-center gap-3 mb-6">
          <div class="w-7 h-7 bg-primary-light rounded-lg flex items-center justify-center">
            <span class="text-primary text-xs font-black">1</span>
          </div>
          <h2 class="font-bold text-ink text-sm uppercase tracking-wider">Informations essentielles</h2>
          <div class="flex-1 h-px bg-border"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

          {{-- Titre --}}
          <div class="md:col-span-2">
            <label class="block text-sm font-semibold text-ink mb-1.5">
              Titre <span class="text-red-500">*</span>
            </label>
            <input type="text" name="title" value="{{ old('title') }}"
                   placeholder="Ex: Appartement lumineux 3 pièces à Casablanca"
                   class="w-full border rounded-xl px-4 py-2.5 text-sm text-ink bg-white
                          focus:outline-none focus:border-primary transition
                          @error('title') border-red-400 bg-red-50 @else border-border @enderror">
            @error('title')
              <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
            @enderror
          </div>

          {{-- Type --}}
          <div>
            <label class="block text-sm font-semibold text-ink mb-1.5">
              Type de bien <span class="text-red-500">*</span>
            </label>
            <div class="relative">
              <select name="type"
                      class="w-full border rounded-xl px-4 py-2.5 text-sm text-ink bg-white
                             focus:outline-none focus:border-primary appearance-none transition
                             @error('type') border-red-400 bg-red-50 @else border-border @enderror">
                <option value="">Sélectionner…</option>
                @foreach(['Appartement','Studio','Villa','Duplex','Maison','Bureau','Riad'] as $t)
                  <option value="{{ $t }}" {{ old('type') === $t ? 'selected' : '' }}>{{ $t }}</option>
                @endforeach
              </select>
              <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-muted pointer-events-none"
                   fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
              </svg>
            </div>
            @error('type')
              <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
            @enderror
          </div>

          {{-- Statut --}}
          <div>
            <label class="block text-sm font-semibold text-ink mb-1.5">
              Statut <span class="text-red-500">*</span>
            </label>
            <div class="relative">
              <select name="status"
                      class="w-full border rounded-xl px-4 py-2.5 text-sm text-ink bg-white
                             focus:outline-none focus:border-primary appearance-none transition
                             @error('status') border-red-400 bg-red-50 @else border-border @enderror">
                <option value="available" {{ old('status','available') === 'available' ? 'selected' : '' }}>Disponible</option>
                <option value="reserved"  {{ old('status') === 'reserved'  ? 'selected' : '' }}>Réservé</option>
                <option value="rented"    {{ old('status') === 'rented'    ? 'selected' : '' }}>Loué</option>
                <option value="sold"      {{ old('status') === 'sold'      ? 'selected' : '' }}>Vendu</option>
              </select>
              <svg class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-muted pointer-events-none"
                   fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
              </svg>
            </div>
            @error('status')
              <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
            @enderror
          </div>

          {{-- Prix --}}
          <div>
            <label class="block text-sm font-semibold text-ink mb-1.5">
              Prix / mois (MAD) <span class="text-red-500">*</span>
            </label>
            <div class="relative">
              <input type="number" name="price" value="{{ old('price') }}" min="0" step="100"
                     placeholder="ex. 8500"
                     class="w-full border rounded-xl px-4 pr-14 py-2.5 text-sm text-ink bg-white
                            focus:outline-none focus:border-primary transition
                            @error('price') border-red-400 bg-red-50 @else border-border @enderror">
              <span class="absolute right-4 top-1/2 -translate-y-1/2 text-[11px] font-bold text-muted pointer-events-none">MAD</span>
            </div>
            @error('price')
              <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
            @enderror
          </div>

          {{-- Téléphone --}}
          <div>
            <label class="block text-sm font-semibold text-ink mb-1.5">
              Téléphone <span class="text-red-500">*</span>
            </label>
            <input type="tel" name="phone" value="{{ old('phone') }}"
                   placeholder="+212 6 XX XX XX XX"
                   class="w-full border rounded-xl px-4 py-2.5 text-sm text-ink bg-white
                          focus:outline-none focus:border-primary transition
                          @error('phone') border-red-400 bg-red-50 @else border-border @enderror">
            @error('phone')
              <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
            @enderror
          </div>

        </div>

        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
      </div>


      {{-- ── Section 2 : Localisation ── --}}
      <div class="border border-border rounded-2xl p-6 bg-white shadow-card">
        <div class="flex items-center gap-3 mb-6">
          <div class="w-7 h-7 bg-primary-light rounded-lg flex items-center justify-center">
            <span class="text-primary text-xs font-black">2</span>
          </div>
          <h2 class="font-bold text-ink text-sm uppercase tracking-wider">Localisation</h2>
          <div class="flex-1 h-px bg-border"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

          <div class="md:col-span-2">
            <label class="block text-sm font-semibold text-ink mb-1.5">
              Adresse complète <span class="text-red-500">*</span>
            </label>
            <input type="text" name="address" value="{{ old('address') }}"
                   placeholder="ex. 15 Rue des Fleurs, Maarif"
                   class="w-full border rounded-xl px-4 py-2.5 text-sm text-ink bg-white
                          focus:outline-none focus:border-primary transition
                          @error('address') border-red-400 bg-red-50 @else border-border @enderror">
            @error('address')
              <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label class="block text-sm font-semibold text-ink mb-1.5">
              Ville <span class="text-red-500">*</span>
            </label>
            <input type="text" name="city" value="{{ old('city') }}"
                   placeholder="ex. Casablanca"
                   class="w-full border rounded-xl px-4 py-2.5 text-sm text-ink bg-white
                          focus:outline-none focus:border-primary transition
                          @error('city') border-red-400 bg-red-50 @else border-border @enderror">
            @error('city')
              <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label class="block text-sm font-semibold text-ink mb-1.5">
              Étage <span class="text-muted text-xs font-normal">(optionnel)</span>
            </label>
            <input type="number" name="floor" value="{{ old('floor') }}" min="0"
                   placeholder="0 = RDC"
                   class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-ink bg-white
                          focus:outline-none focus:border-primary transition">
          </div>

        </div>
      </div>


      {{-- ── Section 3 : Caractéristiques ── --}}
      <div class="border border-border rounded-2xl p-6 bg-white shadow-card">
        <div class="flex items-center gap-3 mb-6">
          <div class="w-7 h-7 bg-primary-light rounded-lg flex items-center justify-center">
            <span class="text-primary text-xs font-black">3</span>
          </div>
          <h2 class="font-bold text-ink text-sm uppercase tracking-wider">Caractéristiques</h2>
          <div class="flex-1 h-px bg-border"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-4">

          <div>
            <label class="block text-sm font-semibold text-ink mb-1.5">
              Chambres <span class="text-red-500">*</span>
            </label>
            <input type="number" name="bedrooms" value="{{ old('bedrooms', 1) }}" min="0"
                   class="w-full border rounded-xl px-4 py-2.5 text-sm text-ink bg-white
                          focus:outline-none focus:border-primary transition
                          @error('bedrooms') border-red-400 bg-red-50 @else border-border @enderror">
            @error('bedrooms')
              <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label class="block text-sm font-semibold text-ink mb-1.5">
              Salles de bain <span class="text-red-500">*</span>
            </label>
            <input type="number" name="bathrooms" value="{{ old('bathrooms', 1) }}" min="0"
                   class="w-full border rounded-xl px-4 py-2.5 text-sm text-ink bg-white
                          focus:outline-none focus:border-primary transition
                          @error('bathrooms') border-red-400 bg-red-50 @else border-border @enderror">
            @error('bathrooms')
              <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label class="block text-sm font-semibold text-ink mb-1.5">Surface (m²)</label>
            <input type="number" name="surface" value="{{ old('surface') }}" min="0" step="0.5"
                   placeholder="ex. 95"
                   class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-ink bg-white
                          focus:outline-none focus:border-primary transition">
          </div>

        </div>

        <div>
          <label class="block text-sm font-semibold text-ink mb-1.5">
            Description <span class="text-muted text-xs font-normal">(optionnelle)</span>
          </label>
          <textarea name="description" rows="4"
                    placeholder="Décrivez le logement : atouts, ambiance, équipements, quartier…"
                    class="w-full border border-border rounded-xl px-4 py-2.5 text-sm text-ink bg-white
                           focus:outline-none focus:border-primary transition resize-none">{{ old('description') }}</textarea>
        </div>
      </div>


      {{-- ── Section 4 : Photos ── --}}
      <div class="border border-border rounded-2xl p-6 bg-white shadow-card">
        <div class="flex items-center gap-3 mb-6">
          <div class="w-7 h-7 bg-primary-light rounded-lg flex items-center justify-center">
            <span class="text-primary text-xs font-black">4</span>
          </div>
          <h2 class="font-bold text-ink text-sm uppercase tracking-wider">Photos du logement</h2>
          <div class="flex-1 h-px bg-border"></div>
        </div>

        <label for="pictures-input"
               class="group flex flex-col items-center justify-center w-full py-12 px-6
                      border-2 border-dashed border-border rounded-2xl bg-surface
                      cursor-pointer hover:border-primary hover:bg-primary-light/30 transition-all duration-200">
          <div class="w-12 h-12 bg-white border border-border rounded-xl flex items-center justify-center mb-3
                      group-hover:border-primary transition-all">
            <svg class="w-5 h-5 text-muted group-hover:text-primary transition-colors"
                 fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round"
                    d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
            </svg>
          </div>
          <p class="text-sm font-semibold text-ink mb-1">
            <span class="text-primary">Cliquez pour ajouter</span> ou glissez vos photos
          </p>
          <p class="text-xs text-muted">JPG, PNG, WEBP · Max 10 Mo · Plusieurs fichiers acceptés</p>
          <input id="pictures-input" type="file" name="pictures[]"
                 multiple accept="image/*" class="hidden">
        </label>

        <div id="photo-preview" class="grid grid-cols-4 sm:grid-cols-6 gap-2 mt-4 hidden"></div>
      </div>


      {{-- ── Submit ── --}}
      <div class="flex items-center gap-4 pt-2 pb-10">
        <button type="submit"
                class="inline-flex items-center gap-2.5 bg-primary hover:bg-primary-dark text-white font-bold text-sm
                       px-8 py-3.5 rounded-2xl transition shadow-card">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          Publier l'annonce
        </button>
        <a href="{{ route('logements.index') }}"
           class="text-sm font-semibold text-muted hover:text-ink transition-colors">
          Annuler
        </a>
      </div>

    </form>
  </div>
</div>

@endsection

@section('scripts')
<script>
  document.getElementById('pictures-input').addEventListener('change', function () {
    const preview = document.getElementById('photo-preview');
    preview.innerHTML = '';
    if (!this.files.length) { preview.classList.add('hidden'); return; }
    preview.classList.remove('hidden');
    Array.from(this.files).forEach((file, i) => {
      if (!file.type.startsWith('image/')) return;
      const reader = new FileReader();
      reader.onload = e => {
        const wrap = document.createElement('div');
        wrap.className = 'relative rounded-xl overflow-hidden bg-surface border border-border';
        wrap.style.aspectRatio = '1';
        const img = document.createElement('img');
        img.src = e.target.result;
        img.className = 'w-full h-full object-cover';
        const badge = document.createElement('span');
        badge.className = 'absolute bottom-1 left-1 text-[9px] font-bold bg-black/50 text-white rounded px-1 py-0.5';
        badge.textContent = i === 0 ? 'Principale' : '#' + (i + 1);
        wrap.appendChild(img); wrap.appendChild(badge);
        preview.appendChild(wrap);
      };
      reader.readAsDataURL(file);
    });
  });
</script>
@endsection