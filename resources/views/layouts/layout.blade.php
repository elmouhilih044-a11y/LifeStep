<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LifeStep+ — @yield('title', 'Trouvez votre logement idéal')</title>

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">

    {{-- Vite : Tailwind compilé --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-white text-coal min-h-screen">

    {{-- ─── NAVIGATION ─── --}}
    <nav class="sticky top-0 z-50 bg-white border-b border-gray-100 h-16 flex items-center justify-between px-10">

        {{-- Logo --}}
        <a href="{{ route('logements.index') }}"
           class="font-display font-extrabold text-xl tracking-tight text-coal no-underline">
            Life<span class="text-brand">Step</span>+
        </a>

        {{-- Links --}}
        <div class="flex items-center gap-2">
            <a href="{{ route('logements.index') }}"
               class="text-sm font-medium text-gray-500 hover:text-coal hover:bg-snow px-4 py-2 rounded-lg btn-t">
                Logements
            </a>
            <a href="{{ route('logements.create') }}"
               class="flex items-center gap-2 bg-brand text-white text-sm font-medium px-4 py-2 rounded-xl hover:opacity-90 btn-t">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path d="M12 5v14M5 12h14"/>
                </svg>
                Publier
            </a>
        </div>
    </nav>

    {{-- ─── MAIN ─── --}}
    <main class="max-w-6xl mx-auto px-10 py-12 pb-24">

        {{-- Message succès --}}
        @if(session('success'))
            <div class="bg-green-50 text-green-700 border border-green-200 rounded-xl px-5 py-3 text-sm mb-6">
                {{ session('success') }}
            </div>
        @endif

        {{-- Erreurs --}}
        @if($errors->any())
            <div class="bg-red-50 text-coral border border-red-200 rounded-xl px-5 py-3 text-sm mb-6">
                <ul class="list-disc list-inside space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')

    </main>

</body>
</html>