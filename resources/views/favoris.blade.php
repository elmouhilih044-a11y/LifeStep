@extends('layouts.app')
@section('title', 'Mes Favoris – LifeStep+')
@section('content')
<div class="pt-20 min-h-screen flex flex-col items-center justify-center text-center px-6">
  <div class="w-20 h-20 bg-primary-light rounded-full flex items-center justify-center mb-6">
    <svg class="w-10 h-10 text-primary" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/>
    </svg>
  </div>
  <h1 class="text-3xl font-bold text-ink">Mes Favoris</h1>
  <p class="text-muted mt-2">Cette fonctionnalité sera bientôt disponible.</p>
  <a href="{{ route('home') }}" class="mt-6 inline-flex items-center gap-2 bg-primary hover:bg-primary-dark text-white font-semibold px-6 py-3 rounded-xl transition">
    Retour à l'accueil
  </a>
</div>
@endsection