<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>@yield('title', 'LifeStep+')</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet"/>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#FF385C',
            'primary-dark': '#E31C5F',
            'primary-light': '#FFF0F3',
            ink: '#222222',
            muted: '#717171',
            surface: '#F7F7F7',
            border: '#DDDDDD',
          },
          fontFamily: { body: ['Poppins', 'sans-serif'] },
          boxShadow: {
            card: '0 2px 16px 0 rgba(0,0,0,0.08)',
            'card-hover': '0 8px 32px 0 rgba(0,0,0,0.14)',
          }
        }
      }
    }
  </script>
  <style>
    /* Ajustement du padding-top selon la hauteur de la navbar responsive */
    @media (max-width: 1023px) {
      /* Sur mobile, la navbar a une barre de recherche en dessous */
      body { padding-top: 0; }
    }
  </style>
  @yield('styles')
</head>
<body class="bg-white text-ink font-body antialiased">

  <x-navbar/>

  {{-- Spacer pour compenser la navbar fixe --}}
  {{-- Sur mobile : navbar (64px) + search bar (~52px) = ~116px --}}
  {{-- Sur desktop : navbar (80px) --}}
  <div class="h-[116px] lg:h-20"></div>

  <main>
    @yield('content')
  </main>

  <x-footer/>

  @yield('scripts')
</body>
</html>