@extends('layouts.aluno')

@section('title', 'Ranking - SimplifiKathon')

@section('content')
<div class="flex-1 overflow-y-auto p-6 lg:p-10">
    <div class="max-w-4xl mx-auto">
        
        {{-- Header --}}
        <div class="mb-8 text-center">
            <h1 class="text-3xl font-bold text-slate-800 mb-2">🏆 Ranking Global</h1>
            <p class="text-slate-500">Os melhores alunos da plataforma SimplifiKathon</p>
        </div>

        {{-- Card do Usuário Atual --}}
        @auth
            @if (Auth::user()->role === 'aluno')
                <div class="mb-8">
                    <x-gamification.user-stat-card :user="Auth::user()" />
                </div>
            @endif
        @endauth

        {{-- Pódio - Top 3 --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8 mb-6">
            <h2 class="text-xl font-bold text-unifil-blue text-center mb-6 flex items-center justify-center gap-2">
                <svg class="w-6 h-6 text-gold" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/>
                </svg>
                Top 3 - Hall da Fama
            </h2>
            <x-gamification.podium :users="$ranking" />
        </div>

        {{-- Tabela - 4º em diante --}}
        @if ($ranking->count() > 3)
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-slate-700 mb-4">Demais Participantes</h2>
                <x-gamification.leaderboard-table :users="$ranking->skip(3)" :startPosition="4" />
            </div>
        @endif

        {{-- Link para voltar --}}
        <div class="text-center mt-8">
            <a href="{{ route('dashboard.aluno') }}" class="text-unifil-orange hover:text-orange-600 font-medium inline-flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Voltar ao Dashboard
            </a>
        </div>

    </div>
</div>
@endsection
