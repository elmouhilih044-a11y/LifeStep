<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'LifeStep+')</title>
    @vite('resources/js/app.js')
</head>
<body class="bg-white text-[#1A1A1A] min-h-screen antialiased">
    @yield('content')
    @stack('scripts')
</body>
</html>