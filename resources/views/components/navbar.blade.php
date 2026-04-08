<nav class="bg-white border-b border-border fixed top-0 w-full z-50">
  <div class="max-w-[120rem] mx-auto px-6 h-20 flex items-center justify-between gap-4">

    {{-- Logo --}}
    <a href="{{ route('home') }}" class="select-none shrink-0">
      <span class="text-2xl font-bold tracking-tight text-ink">LifeStep<span class="text-primary">+</span></span>
    </a>

    {{-- Search pill --}}
    <form action="{{ route('logements.index') }}" method="GET"
          class="hidden md:flex items-center border border-border rounded-full shadow-sm hover:shadow-md transition-shadow text-sm font-semibold">
      <span class="px-5 py-3 text-ink">Partout</span>
      <span class="w-px h-5 bg-border"></span>
      <span class="px-5 py-3 text-ink">N'importe quand</span>
      <span class="w-px h-5 bg-border"></span>
      <div class="flex items-center gap-3 pl-5 pr-2 py-2">
        <input name="q" type="text" value="{{ request('q') }}"
               placeholder="Ville, titre…"
               class="text-sm font-normal text-ink bg-transparent outline-none w-40 placeholder:text-muted"/>
        <button type="submit" class="bg-primary hover:bg-primary-dark text-white rounded-full p-2.5 transition-colors">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
          </svg>
        </button>
      </div>
    </form>

    {{-- Right --}}
    <div class="flex items-center gap-1 shrink-0">
      <div class="hidden md:flex items-center gap-1 mr-2">
        <a href="{{ route('home') }}"
           class="text-sm font-semibold px-4 py-2.5 rounded-full transition {{ request()->routeIs('home') ? 'text-primary bg-primary-light' : 'text-ink hover:bg-surface' }}">
          Accueil
        </a>
        <a href="{{ route('logements.index') }}"
           class="text-sm font-semibold px-4 py-2.5 rounded-full transition {{ request()->routeIs('logements*') ? 'text-primary bg-primary-light' : 'text-ink hover:bg-surface' }}">
          Logements
        </a>
        <a href="#"
           class="text-sm font-semibold px-4 py-2.5 rounded-full transition text-ink hover:bg-surface">
          Favoris
        </a>
      </div>

      <a href="{{ route('logements.index') }}"
         class="hidden md:block text-sm font-semibold text-ink hover:bg-surface px-4 py-2.5 rounded-full transition whitespace-nowrap">
        Publier un logement
      </a>

      <button class="p-2.5 rounded-full hover:bg-surface transition">
        <svg class="w-5 h-5 text-ink" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
          <circle cx="12" cy="12" r="10"/>
          <path stroke-linecap="round" stroke-linejoin="round" d="M2 12h20M12 2a15.3 15.3 0 0 1 0 20M12 2a15.3 15.3 0 0 0 0 20"/>
        </svg>
      </button>

      <button class="flex items-center gap-2 border border-border rounded-full px-3 py-2 hover:shadow-md transition-shadow">
        <svg class="w-5 h-5 text-ink" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
        </svg>
        <div class="w-8 h-8 bg-muted rounded-full flex items-center justify-center">
          <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
            <path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/>
          </svg>
        </div>
      </button>
    </div>

  </div>
</nav>