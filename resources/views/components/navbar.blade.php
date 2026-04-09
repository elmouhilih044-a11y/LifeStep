<nav class="bg-white border-b border-border fixed top-0 w-full z-50">
    <div class="max-w-[120rem] mx-auto px-6 h-20 flex items-center justify-between gap-4">

        {{-- 1. Logo --}}
        <a href="{{ route('home') }}" class="select-none shrink-0">
            <span class="text-2xl font-bold tracking-tight text-ink">LifeStep<span class="text-primary">+</span></span>
        </a>

        @if(request()->routeIs('home') && !Auth::check())
            {{-- 2. Affichage Spécifique pour la Home Page (Non connecté) --}}
            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}" class="text-sm font-bold text-ink hover:text-primary transition">
                    Connexion
                </a>
                <a href="{{ route('register') }}" class="bg-primary hover:bg-primary-dark text-white font-bold px-6 py-2.5 rounded-xl transition shadow-sm">
                    Inscription
                </a>
            </div>
        @else
            {{-- 3. Barre de recherche (Visible sur les autres pages ou si connecté) --}}
            <form action="{{ route('logements.index') }}" method="GET"
                class="hidden md:flex items-center border border-border rounded-full shadow-sm hover:shadow-md transition-shadow text-sm font-semibold">
                <span class="px-5 py-3 text-ink">Partout</span>
                <span class="w-px h-5 bg-border"></span>
                <span class="px-5 py-3 text-ink">N'importe quand</span>
                <span class="w-px h-5 bg-border"></span>
                <div class="flex items-center gap-3 pl-5 pr-2 py-2">
                    <input name="q" type="text" value="{{ request('q') }}" placeholder="Ville, titre…"
                        class="text-sm font-normal text-ink bg-transparent outline-none w-40 placeholder:text-muted" />
                    <button type="submit" class="bg-primary hover:bg-primary-dark text-white rounded-full p-2.5 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z" />
                        </svg>
                    </button>
                </div>
            </form>

            {{-- 4. Menu Utilisateur Classique --}}
            <div class="flex items-center gap-2">
                <div class="relative">
                    <button id="userMenuBtn" class="flex items-center gap-3 border border-border rounded-full pl-3 pr-1.5 py-1.5 hover:shadow-md transition-shadow bg-white outline-none">
                        <svg class="w-5 h-5 text-ink" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                        </svg>
                        <div class="w-8 h-8 bg-primary rounded-full flex items-center justify-center overflow-hidden">
                            @auth
                                <span class="text-xs font-bold text-white">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            @else
                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z" />
                                </svg>
                            @endauth
                        </div>
                    </button>

                    {{-- Dropdown --}}
                    <div id="userDropdown" class="hidden absolute right-0 mt-2 w-64 bg-white rounded-2xl border border-border shadow-xl py-2 z-50">
                        @auth
                            <a href="{{ route('life_profiles.show') }}" class="block px-6 py-3 text-sm font-semibold hover:bg-surface">Mon Profil</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-6 py-3 text-sm font-semibold text-red-500 hover:bg-red-50">Déconnexion</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="block px-6 py-3 text-sm font-semibold hover:bg-surface">Connexion</a>
                            <a href="{{ route('register') }}" class="block px-6 py-3 text-sm font-semibold hover:bg-surface">Inscription</a>
                        @endauth
                    </div>
                </div>
            </div>
        @endif
    </div>
</nav>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const btn = document.getElementById('userMenuBtn');
        const dropdown = document.getElementById('userDropdown');
        if (btn && dropdown) {
            btn.addEventListener('click', (e) => { e.stopPropagation(); dropdown.classList.toggle('hidden'); });
            document.addEventListener('click', (e) => { if (!btn.contains(e.target)) dropdown.classList.add('hidden'); });
        }
    });
</script>