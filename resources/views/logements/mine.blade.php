@extends('layouts.app')

@section('title', 'Mes logements')

@section('content')
<div class="pt-28 pb-20 px-6">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold text-ink mb-6">Mes logements</h1>

        @if($logements->isEmpty())
            <div class="bg-white border border-border rounded-2xl p-6">
                <p class="text-muted">Vous n’avez encore publié aucun logement.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($logements as $logement)
                    <a href="{{ route('logements.show', $logement) }}"
                       class="block bg-white border border-border rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition">
                        @if($logement->pictures->isNotEmpty())
                            <img src="{{ asset('storage/' . $logement->pictures->first()->path) }}"
                                 class="w-full h-48 object-cover" alt="{{ $logement->title }}">
                        @endif

                        <div class="p-4">
                            <h2 class="font-bold text-ink">{{ $logement->title }}</h2>
                            <p class="text-sm text-muted mt-1">{{ $logement->city }}</p>
                            <p class="text-primary font-bold mt-3">{{ number_format($logement->price, 0, ',', ' ') }} MAD</p>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection