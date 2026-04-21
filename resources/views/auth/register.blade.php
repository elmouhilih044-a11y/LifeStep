@extends('layouts.app')

@section('title', 'Créer un compte – LifeStep+')

@section('styles')
<style>
  .auth-bg {
    background-image:
      linear-gradient(to bottom right, rgba(0,0,0,0.55) 0%, rgba(0,0,0,0.30) 60%, rgba(255,56,92,0.18) 100%),
     url('assets/image.jpeg');
    background-size: cover;
    background-position: center;
  }
  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(24px); }
    to   { opacity: 1; transform: translateY(0); }
  }
  .fade-up { animation: fadeUp 0.6s 0.1s ease both; }
</style>
@endsection

@section('content')
<div class="min-h-screen flex pt-20">

  {{-- Left panel – decorative --}}
  <div class="hidden lg:flex lg:w-1/2 auth-bg flex-col justify-center p-14">
    <div>
      <p class="text-white/40 text-xs font-bold tracking-widest uppercase mb-4">Rejoignez-nous</p>
      <h2 class="text-4xl font-bold text-white leading-tight">
        Votre prochain logement<br/>
        <span class="text-primary">commence ici.</span>
      </h2>
      <p class="text-white/60 mt-4 text-base max-w-sm leading-relaxed">
        Créez votre compte gratuitement et accédez à des milliers d'annonces partout au Maroc.
      </p>
      <div class="flex items-center gap-6 mt-8">
        @foreach([['Annonces vérifiées', 'M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z'], ['100% gratuit', 'M21 12a9 9 0 11-18 0 9 9 0 0118 0z'], ['Support 7j/7', 'M21 12a9 9 0 11-18 0 9 9 0 0118 0z']] as [$label, $icon])
        <div class="flex items-center gap-2">
          <svg class="w-4 h-4 text-primary shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}"/>
          </svg>
          <span class="text-white/70 text-sm">{{ $label }}</span>
        </div>
        @endforeach
      </div>
    </div>
  </div>

  {{-- Right panel – form --}}
  <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-16 bg-white overflow-y-auto">
    <div class="fade-up w-full max-w-md">

      <div class="mb-8">
        <p class="text-primary text-xs font-bold tracking-widest uppercase mb-2">Inscription</p>
        <h1 class="text-3xl font-bold text-ink">Créer un compte</h1>
        <p class="text-muted text-sm mt-2">Déjà inscrit ?
          <a href="{{ route('login') }}" class="text-primary font-semibold hover:text-primary-dark transition">Se connecter</a>
        </p>
      </div>

      {{-- Erreurs de validation --}}
      @if ($errors->any())
        <div class="mb-5 px-4 py-3 rounded-xl bg-red-50 border border-red-200 text-red-600 text-sm space-y-1">
          @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
          @endforeach
        </div>
      @endif

      <form action="{{ route('register.post') }}" method="POST" class="space-y-5">
        @csrf

        {{-- Champ name caché – combiné automatiquement depuis prenom + nom --}}
        <input type="hidden" name="name" id="name" value="{{ old('name', trim(old('prenom') . ' ' . old('nom'))) }}"/>

        {{-- Name row --}}
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-semibold text-ink mb-1.5">Prénom</label>
            <input type="text" id="prenom" name="prenom" value="{{ old('prenom') }}" placeholder="Hajar" required
                   class="w-full px-4 py-3 border border-border rounded-xl text-sm text-ink placeholder-muted outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition"/>
          </div>
          <div>
            <label class="block text-sm font-semibold text-ink mb-1.5">Nom</label>
            <input type="text" id="nom" name="nom" value="{{ old('nom') }}" placeholder="Dupont" required
                   class="w-full px-4 py-3 border border-border rounded-xl text-sm text-ink placeholder-muted outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition"/>
          </div>
        </div>

        {{-- Email --}}
        <div>
          <label class="block text-sm font-semibold text-ink mb-1.5">Adresse e-mail</label>
          <div class="relative">
            <span class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
              <svg class="w-4 h-4 text-muted" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25H4.5a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5H4.5a2.25 2.25 0 00-2.25 2.25m19.5 0l-9.75 6.75L2.25 6.75"/>
              </svg>
            </span>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="vous@exemple.com" required
                   class="w-full pl-11 pr-4 py-3 border border-border rounded-xl text-sm text-ink placeholder-muted outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition"/>
          </div>
        </div>

        {{-- Phone --}}
        <div>
          <label class="block text-sm font-semibold text-ink mb-1.5">Téléphone <span class="text-muted font-normal">(optionnel)</span></label>
          <div class="relative">
            <span class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
              <svg class="w-4 h-4 text-muted" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
              </svg>
            </span>
            <input type="tel" name="telephone" value="{{ old('telephone') }}" placeholder="+212 6 00 00 00 00"
                   class="w-full pl-11 pr-4 py-3 border border-border rounded-xl text-sm text-ink placeholder-muted outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition"/>
          </div>
        </div>

        {{-- Role --}}
        <div>
          <label class="block text-sm font-semibold text-ink mb-2">Je suis</label>
          <div class="grid grid-cols-2 gap-3">
            <label class="flex items-center gap-3 border border-border rounded-xl px-4 py-3 cursor-pointer hover:border-primary transition has-[:checked]:border-primary has-[:checked]:bg-primary-light">
              <input type="radio" name="role" value="user" {{ old('role', 'user') === 'user' ? 'checked' : '' }} class="accent-primary"/>
              <div>
                <p class="text-sm font-semibold text-ink">Locataire</p>
                <p class="text-xs text-muted">Je cherche un logement</p>
              </div>
            </label>
            <label class="flex items-center gap-3 border border-border rounded-xl px-4 py-3 cursor-pointer hover:border-primary transition has-[:checked]:border-primary has-[:checked]:bg-primary-light">
              <input type="radio" name="role" value="owner" {{ old('role') === 'owner' ? 'checked' : '' }} class="accent-primary"/>
              <div>
                <p class="text-sm font-semibold text-ink">Propriétaire</p>
                <p class="text-xs text-muted">Je publie des annonces</p>
              </div>
            </label>
          </div>
        </div>

        {{-- Password --}}
        <div>
          <label class="block text-sm font-semibold text-ink mb-1.5">Mot de passe</label>
          <div class="relative">
            <span class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
              <svg class="w-4 h-4 text-muted" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
              </svg>
            </span>
            <input type="password" name="password" placeholder="Min. 8 caractères" required
                   class="w-full pl-11 pr-4 py-3 border border-border rounded-xl text-sm text-ink placeholder-muted outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition"/>
          </div>
        </div>

        {{-- Confirm Password --}}
        <div>
          <label class="block text-sm font-semibold text-ink mb-1.5">Confirmer le mot de passe</label>
          <div class="relative">
            <span class="absolute inset-y-0 left-4 flex items-center pointer-events-none">
              <svg class="w-4 h-4 text-muted" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
              </svg>
            </span>
            <input type="password" name="password_confirmation" placeholder="••••••••" required
                   class="w-full pl-11 pr-4 py-3 border border-border rounded-xl text-sm text-ink placeholder-muted outline-none focus:border-primary focus:ring-2 focus:ring-primary/20 transition"/>
          </div>
        </div>

        {{-- Terms --}}
        <div class="flex items-start gap-2">
          <input type="checkbox" id="terms" name="terms" required
                 class="w-4 h-4 mt-0.5 rounded border-border accent-primary cursor-pointer"/>
          <label for="terms" class="text-sm text-muted cursor-pointer leading-relaxed">
            J'accepte les <a href="#" class="text-primary font-semibold hover:text-primary-dark transition">conditions d'utilisation</a>
            et la <a href="#" class="text-primary font-semibold hover:text-primary-dark transition">politique de confidentialité</a>
          </label>
        </div>

        {{-- Submit --}}
        <button type="submit"
                class="w-full bg-primary hover:bg-primary-dark text-white font-semibold py-3.5 rounded-xl transition-colors shadow-sm hover:shadow-md text-sm">
          Créer mon compte
        </button>

      </form>

      {{-- Divider --}}
      <div class="flex items-center gap-4 my-6">
        <span class="flex-1 h-px bg-border"></span>
        <span class="text-xs text-muted font-medium">ou continuer avec</span>
        <span class="flex-1 h-px bg-border"></span>
      </div>

      {{-- Social --}}
      <div class="grid grid-cols-2 gap-3">
        <button class="flex items-center justify-center gap-2 border border-border rounded-xl py-3 text-sm font-semibold text-ink hover:bg-surface transition">
          <svg class="w-4 h-4" viewBox="0 0 24 24">
            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"/>
            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
          </svg>
          Google
        </button>
        <button class="flex items-center justify-center gap-2 border border-border rounded-xl py-3 text-sm font-semibold text-ink hover:bg-surface transition">
          <svg class="w-4 h-4 text-[#1877F2]" fill="currentColor" viewBox="0 0 24 24">
            <path d="M24 12.073C24 5.405 18.627 0 12 0S0 5.405 0 12.073C0 18.1 4.388 23.094 10.125 24v-8.437H7.078v-3.49h3.047V9.41c0-3.025 1.792-4.697 4.533-4.697 1.312 0 2.686.236 2.686.236v2.97h-1.513c-1.491 0-1.956.93-1.956 1.886v2.267h3.328l-.532 3.49h-2.796V24C19.612 23.094 24 18.1 24 12.073z"/>
          </svg>
          Facebook
        </button>
      </div>

    </div>
  </div>

</div>

<script>
  (function () {
    var prenom = document.getElementById('prenom');
    var nom    = document.getElementById('nom');
    var name   = document.getElementById('name');

    function updateName() {
      name.value = (prenom.value.trim() + ' ' + nom.value.trim()).trim();
    }

    prenom.addEventListener('input', updateName);
    nom.addEventListener('input', updateName);

    // Init on page load (handles old() values)
    updateName();
  })();
</script>
@endsection