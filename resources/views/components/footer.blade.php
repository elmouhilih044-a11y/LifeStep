<footer class="bg-ink relative overflow-hidden px-5 sm:px-8 py-10 sm:py-12">
  <div class="absolute -bottom-16 -right-16 w-64 h-64 bg-primary/20 rounded-full blur-3xl pointer-events-none"></div>
  <div class="max-w-7xl mx-auto">

    <div class="grid grid-cols-2 sm:grid-cols-4 gap-8 sm:gap-10 pb-8 sm:pb-10 border-b border-white/10">

      {{-- Brand --}}
      <div class="col-span-2 sm:col-span-1">
        <a href="{{ route('home') }}" class="select-none">
          <span class="text-2xl font-bold text-white">LifeStep<span class="text-primary">+</span></span>
        </a>
        <p class="text-muted text-sm mt-3 leading-relaxed max-w-xs">
          La plateforme de location immobilière simple, rapide et efficace.
        </p>
        {{-- Social icons on mobile --}}
        <div class="flex items-center gap-3 mt-4 sm:hidden">
          <a href="#" class="w-8 h-8 rounded-full bg-white/10 hover:bg-primary transition flex items-center justify-center">
            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.56v14.91A4.54 4.54 0 0 1 19.46 24H4.54A4.54 4.54 0 0 1 0 19.47V4.54A4.54 4.54 0 0 1 4.54 0h14.92A4.54 4.54 0 0 1 24 4.56zM8 19V9H5v10h3zm-1.5-11.4a1.74 1.74 0 1 0 0-3.48 1.74 1.74 0 0 0 0 3.48zM19 19v-5.5c0-2.67-1.44-3.91-3.36-3.91A2.9 2.9 0 0 0 13 11.1V9h-3v10h3v-5.29a1.73 1.73 0 0 1 1.56-1.87c.87 0 1.44.58 1.44 1.87V19h3z"/></svg>
          </a>
          <a href="#" class="w-8 h-8 rounded-full bg-white/10 hover:bg-primary transition flex items-center justify-center">
            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.334 3.608 1.308.975.975 1.246 2.242 1.308 3.608.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.062 1.366-.334 2.633-1.308 3.608-.975.975-2.242 1.246-3.608 1.308-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.334-3.608-1.308-.975-.975-1.246-2.242-1.308-3.608C2.175 15.584 2.163 15.204 2.163 12s.012-3.584.07-4.85c.062-1.366.334-2.633 1.308-3.608.975-.975 2.242-1.246 3.608-1.308C8.416 2.175 8.796 2.163 12 2.163zm0-2.163C8.741 0 8.332.014 7.052.072 5.197.157 3.355.673 2.014 2.014.673 3.355.157 5.197.072 7.052.014 8.332 0 8.741 0 12c0 3.259.014 3.668.072 4.948.085 1.855.601 3.697 1.942 5.038 1.341 1.341 3.183 1.857 5.038 1.942C8.332 23.986 8.741 24 12 24s3.668-.014 4.948-.072c1.855-.085 3.697-.601 5.038-1.942 1.341-1.341 1.857-3.183 1.942-5.038.058-1.28.072-1.689.072-4.948s-.014-3.668-.072-4.948c-.085-1.855-.601-3.697-1.942-5.038C20.645.673 18.803.157 16.948.072 15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zm0 10.162a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/></svg>
          </a>
        </div>
      </div>

      {{-- Navigation --}}
      <div>
        <p class="text-white text-xs font-bold uppercase tracking-widest mb-3 sm:mb-4">Navigation</p>
        <ul class="space-y-2 text-sm text-muted">
          <li><a href="{{ route('home') }}" class="hover:text-white transition">Accueil</a></li>
          <li><a href="{{ route('logements.index') }}" class="hover:text-white transition">Logements</a></li>
          <li><a href="#" class="hover:text-white transition">Favoris</a></li>
          <li><a href="#" class="hover:text-white transition">Profil</a></li>
        </ul>
      </div>

      {{-- Propriétaires --}}
      <div>
        <p class="text-white text-xs font-bold uppercase tracking-widest mb-3 sm:mb-4">Propriétaires</p>
        <ul class="space-y-2 text-sm text-muted">
          <li><a href="{{ route('logements.create') }}" class="hover:text-white transition">Publier un logement</a></li>
          <li><a href="#" class="hover:text-white transition">Gérer mes annonces</a></li>
          <li><a href="#" class="hover:text-white transition">Conseils de location</a></li>
        </ul>
      </div>

      {{-- Contact --}}
      <div class="hidden sm:block">
        <p class="text-white text-xs font-bold uppercase tracking-widest mb-4">Contact</p>
        <ul class="space-y-2 text-sm text-muted">
          <li>contact@lifestep.ma</li>
          <li class="flex items-center gap-3 pt-2">
            <a href="#" class="w-8 h-8 rounded-full bg-white/10 hover:bg-primary transition flex items-center justify-center">
              <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.56v14.91A4.54 4.54 0 0 1 19.46 24H4.54A4.54 4.54 0 0 1 0 19.47V4.54A4.54 4.54 0 0 1 4.54 0h14.92A4.54 4.54 0 0 1 24 4.56zM8 19V9H5v10h3zm-1.5-11.4a1.74 1.74 0 1 0 0-3.48 1.74 1.74 0 0 0 0 3.48zM19 19v-5.5c0-2.67-1.44-3.91-3.36-3.91A2.9 2.9 0 0 0 13 11.1V9h-3v10h3v-5.29a1.73 1.73 0 0 1 1.56-1.87c.87 0 1.44.58 1.44 1.87V19h3z"/></svg>
            </a>
            <a href="#" class="w-8 h-8 rounded-full bg-white/10 hover:bg-primary transition flex items-center justify-center">
              <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 1.366.062 2.633.334 3.608 1.308.975.975 1.246 2.242 1.308 3.608.058 1.266.07 1.646.07 4.85s-.012 3.584-.07 4.85c-.062 1.366-.334 2.633-1.308 3.608-.975.975-2.242 1.246-3.608 1.308-1.266.058-1.646.07-4.85.07s-3.584-.012-4.85-.07c-1.366-.062-2.633-.334-3.608-1.308-.975-.975-1.246-2.242-1.308-3.608C2.175 15.584 2.163 15.204 2.163 12s.012-3.584.07-4.85c.062-1.366.334-2.633 1.308-3.608.975-.975 2.242-1.246 3.608-1.308C8.416 2.175 8.796 2.163 12 2.163zm0-2.163C8.741 0 8.332.014 7.052.072 5.197.157 3.355.673 2.014 2.014.673 3.355.157 5.197.072 7.052.014 8.332 0 8.741 0 12c0 3.259.014 3.668.072 4.948.085 1.855.601 3.697 1.942 5.038 1.341 1.341 3.183 1.857 5.038 1.942C8.332 23.986 8.741 24 12 24s3.668-.014 4.948-.072c1.855-.085 3.697-.601 5.038-1.942 1.341-1.341 1.857-3.183 1.942-5.038.058-1.28.072-1.689.072-4.948s-.014-3.668-.072-4.948c-.085-1.855-.601-3.697-1.942-5.038C20.645.673 18.803.157 16.948.072 15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 1 0 0 12.324 6.162 6.162 0 0 0 0-12.324zm0 10.162a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm6.406-11.845a1.44 1.44 0 1 0 0 2.881 1.44 1.44 0 0 0 0-2.881z"/></svg>
            </a>
          </li>
        </ul>
      </div>

    </div>

    <div class="pt-5 sm:pt-6 flex flex-col sm:flex-row items-center justify-between gap-2 sm:gap-3 text-xs sm:text-sm text-muted text-center sm:text-left">
      <p>© {{ date('Y') }} LifeStep+. Tous droits réservés.</p>
    </div>

  </div>
</footer>