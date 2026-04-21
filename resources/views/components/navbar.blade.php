<nav class="bg-white border-b border-border fixed top-0 w-full z-50">
  <div class="max-w-[120rem] mx-auto px-6 h-20 flex items-center justify-between gap-4">

    {{-- Logo --}}
    <a href="{{ route('home') }}" class="select-none shrink-0">
      <span class="text-2xl font-bold tracking-tight text-ink">LifeStep<span class="text-primary">+</span></span>
    </a>

    @auth
      {{-- ══════════════════════════════
           CONNECTÉ — navbar complète
      ══════════════════════════════ --}}

      {{-- Barre de recherche --}}
      <form action="{{ route('logements.index') }}" method="GET"
            class="hidden md:flex items-center border border-border rounded-full shadow-sm hover:shadow-md transition-shadow text-sm font-semibold">
        <span class="px-5 py-3 text-ink border-r border-border">Partout</span>
        <span class="px-5 py-3 text-ink border-r border-border">N'importe quand</span>
        <div class="flex items-center gap-3 pl-5 pr-2 py-2">
          <input name="q" type="text" value="{{ request('q') }}" placeholder="Ville, titre…"
                 class="text-sm font-normal text-ink bg-transparent outline-none w-40"/>
          <button type="submit" class="bg-primary hover:bg-primary-dark text-white rounded-full p-2.5 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
              <path d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
            </svg>
          </button>
        </div>
      </form>

      {{-- Bloc droite --}}
      <div class="flex items-center gap-2 shrink-0">

        {{-- Liens directs desktop --}}
        <div class="hidden lg:flex items-center gap-1 mr-2">
          <a href="{{ route('home') }}"
             class="text-sm font-semibold px-4 py-2.5 rounded-full transition {{ request()->routeIs('home') ? 'text-primary bg-primary/10' : 'text-ink hover:bg-surface' }}">
            Accueil
          </a>
          <a href="{{ route('logements.index') }}"
             class="text-sm font-semibold px-4 py-2.5 rounded-full transition {{ request()->routeIs('logements.index') ? 'text-primary bg-primary/10' : 'text-ink hover:bg-surface' }}">
            Logements
          </a>
        </div>

        {{-- Dropdown profil --}}
        <div class="relative" id="nav-profile-wrapper">
          <button id="nav-profile-btn" onclick="toggleNavMenu()"
                  class="flex items-center gap-3 border border-border rounded-full pl-3 pr-1.5 py-1.5 hover:shadow-md transition bg-white">
            <svg class="w-5 h-5 text-ink" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
              <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
            </svg>
            <div class="w-8 h-8 bg-muted rounded-full flex items-center justify-center overflow-hidden">
              <span class="text-xs font-bold text-white">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
            </div>
          </button>

          <div id="nav-profile-menu"
               class="hidden absolute right-0 mt-3 w-64 bg-white rounded-2xl border border-border shadow-xl py-2 z-50">

            <div class="px-6 py-3 border-b border-border">
              <p class="text-xs text-muted uppercase font-bold tracking-wider">Mon compte</p>
              <p class="text-sm font-bold text-ink truncate">{{ Auth::user()->name }}</p>
            </div>

          @can('view', App\Models\LifeProfile::class)
    <a href="{{ route('life_profiles.show') }}"
       class="block px-6 py-3 text-sm font-semibold hover:bg-surface {{ request()->routeIs('life_profiles.*') ? 'text-primary' : '' }}">
      Mon Profil de Vie
    </a>
@endcan


@auth
    @if(Auth::user()->role === 'owner')
        <a href="{{ route('logements.mine') }}"
           class="block px-6 py-3 text-sm font-semibold hover:bg-surface {{ request()->routeIs('logements.mine') ? 'text-primary' : '' }}">
            Mes logements
        </a>
    @endif
@endauth

            <a href="{{ route('favorites.index') }}"
               class="block px-6 py-3 text-sm font-semibold hover:bg-surface {{ request()->routeIs('favorites.*') ? 'text-primary' : '' }}">
              Mes Favoris
            </a>

            @can('create', App\Models\Logement::class)
              <a href="{{ route('logements.create') }}"
                 class="block px-6 py-3 text-sm font-semibold hover:bg-surface border-t border-border">
                Publier un logement
              </a>
            @endcan

         @if(Auth::user()->role === 'admin')
              <a href="{{ route('admin.dashboard') }}"
                 class="block px-6 py-3 text-sm font-semibold hover:bg-surface border-t border-border text-primary">
                Dashboard Admin
              </a>
            @endif

            <div class="border-t border-border mt-2 pt-2">
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full text-left px-6 py-3 text-sm font-semibold text-red-500 hover:bg-red-50">
                  Déconnexion
                </button>
              </form>
            </div>
          </div>
        </div>
      </div>

    @else
    
      {{-- ══════════════════════════════
           NON CONNECTÉ — navbar simple
      ══════════════════════════════ --}}
      <div class="flex items-center gap-2">
        <a href="{{ route('login') }}"
           class="text-sm font-semibold px-5 py-2.5 rounded-full border border-border text-ink hover:bg-surface transition">
          Connexion
        </a>
        <a href="{{ route('register') }}"
           class="text-sm font-semibold px-5 py-2.5 rounded-full bg-primary hover:bg-primary-dark text-white transition">
          Inscription
        </a>
      </div>
    @endauth

  </div>
</nav>

<script>
  function toggleNavMenu() {
    document.getElementById('nav-profile-menu').classList.toggle('hidden');
  }
  document.addEventListener('click', function(e) {
    var wrapper = document.getElementById('nav-profile-wrapper');
    var menu    = document.getElementById('nav-profile-menu');
    if (wrapper && menu && !wrapper.contains(e.target)) {
      menu.classList.add('hidden');
    }
  });
</script>