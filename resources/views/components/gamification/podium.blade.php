@props(['users'])

@php
    $top3 = $users->take(3);
    $first = $top3->get(0);
    $second = $top3->get(1);
    $third = $top3->get(2);
@endphp

<div class="grid grid-cols-3 gap-4 items-end mb-8">
    {{-- 2º Lugar (Prata) --}}
    <div class="flex flex-col items-center animate-fade-in-up" style="animation-delay: 0.1s;">
        @if ($second)
            <div class="relative">
                {{-- Avatar --}}
                <div class="h-20 w-20 rounded-full bg-gradient-to-br from-slate-300 to-slate-500 flex items-center justify-center text-white text-2xl font-bold shadow-podium-silver border-4 border-silver overflow-hidden">
                    @if ($second->avatar)
                        <img src="{{ asset('storage/' . $second->avatar) }}" alt="{{ $second->name }}" class="w-full h-full object-cover">
                    @else
                        {{ strtoupper(substr($second->name, 0, 1)) }}
                    @endif
                </div>
                {{-- Badge de Posição --}}
                <div class="absolute -bottom-2 left-1/2 -translate-x-1/2 bg-silver text-slate-800 text-sm font-bold w-8 h-8 rounded-full flex items-center justify-center shadow-lg border-2 border-white">
                    2
                </div>
            </div>
            <p class="mt-4 font-bold text-slate-700 text-center truncate max-w-[120px]">{{ $second->name }}</p>
            <p class="text-sm text-slate-500">Nível {{ $second->current_level }}</p>
            <p class="text-lg font-bold text-unifil-blue">{{ number_format($second->current_xp, 0, ',', '.') }} XP</p>
            
            {{-- Pedestal --}}
            <div class="w-full h-16 bg-gradient-to-t from-slate-300 to-slate-200 rounded-t-lg mt-3 flex items-center justify-center shadow-inner">
                <span class="text-slate-500 text-3xl font-bold">2º</span>
            </div>
        @else
            <div class="h-20 w-20 rounded-full bg-slate-200 flex items-center justify-center">
                <span class="text-slate-400 text-2xl">-</span>
            </div>
            <div class="w-full h-16 bg-slate-100 rounded-t-lg mt-3"></div>
        @endif
    </div>

    {{-- 1º Lugar (Ouro) --}}
    <div class="flex flex-col items-center animate-fade-in-up">
        @if ($first)
            <div class="relative">
                {{-- Coroa --}}
                <div class="absolute -top-8 left-1/2 -translate-x-1/2 animate-float">
                    <svg class="w-10 h-10 text-gold drop-shadow-lg" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M5 16L3 5l5.5 5L12 4l3.5 6L21 5l-2 11H5z"/>
                        <path d="M5 19h14v2H5z"/>
                    </svg>
                </div>
                
                {{-- Avatar --}}
                <div class="h-28 w-28 rounded-full bg-gradient-to-br from-yellow-300 via-gold to-yellow-500 flex items-center justify-center text-white text-3xl font-bold shadow-podium border-4 border-unifil-orange overflow-hidden ring-4 ring-unifil-orange/30">
                    @if ($first->avatar)
                        <img src="{{ asset('storage/' . $first->avatar) }}" alt="{{ $first->name }}" class="w-full h-full object-cover">
                    @else
                        {{ strtoupper(substr($first->name, 0, 1)) }}
                    @endif
                </div>
                {{-- Badge de Posição --}}
                <div class="absolute -bottom-2 left-1/2 -translate-x-1/2 bg-unifil-orange text-white text-sm font-bold w-10 h-10 rounded-full flex items-center justify-center shadow-lg border-2 border-white">
                    1
                </div>
            </div>
            <p class="mt-5 font-bold text-slate-800 text-lg text-center truncate max-w-[140px]">{{ $first->name }}</p>
            <p class="text-sm text-slate-500">Nível {{ $first->current_level }}</p>
            <p class="text-2xl font-bold text-unifil-orange">{{ number_format($first->current_xp, 0, ',', '.') }} XP</p>
            
            {{-- Pedestal --}}
            <div class="w-full h-24 bg-gradient-to-t from-unifil-orange to-orange-300 rounded-t-lg mt-3 flex items-center justify-center shadow-lg">
                <span class="text-white text-4xl font-bold drop-shadow">1º</span>
            </div>
        @else
            <div class="h-28 w-28 rounded-full bg-slate-200 flex items-center justify-center">
                <span class="text-slate-400 text-3xl">-</span>
            </div>
            <div class="w-full h-24 bg-slate-100 rounded-t-lg mt-3"></div>
        @endif
    </div>

    {{-- 3º Lugar (Bronze) --}}
    <div class="flex flex-col items-center animate-fade-in-up" style="animation-delay: 0.2s;">
        @if ($third)
            <div class="relative">
                {{-- Avatar --}}
                <div class="h-20 w-20 rounded-full bg-gradient-to-br from-orange-400 to-bronze flex items-center justify-center text-white text-2xl font-bold shadow-podium-bronze border-4 border-bronze overflow-hidden">
                    @if ($third->avatar)
                        <img src="{{ asset('storage/' . $third->avatar) }}" alt="{{ $third->name }}" class="w-full h-full object-cover">
                    @else
                        {{ strtoupper(substr($third->name, 0, 1)) }}
                    @endif
                </div>
                {{-- Badge de Posição --}}
                <div class="absolute -bottom-2 left-1/2 -translate-x-1/2 bg-bronze text-white text-sm font-bold w-8 h-8 rounded-full flex items-center justify-center shadow-lg border-2 border-white">
                    3
                </div>
            </div>
            <p class="mt-4 font-bold text-slate-700 text-center truncate max-w-[120px]">{{ $third->name }}</p>
            <p class="text-sm text-slate-500">Nível {{ $third->current_level }}</p>
            <p class="text-lg font-bold text-unifil-blue">{{ number_format($third->current_xp, 0, ',', '.') }} XP</p>
            
            {{-- Pedestal --}}
            <div class="w-full h-12 bg-gradient-to-t from-bronze to-orange-300 rounded-t-lg mt-3 flex items-center justify-center shadow-inner">
                <span class="text-white text-2xl font-bold">3º</span>
            </div>
        @else
            <div class="h-20 w-20 rounded-full bg-slate-200 flex items-center justify-center">
                <span class="text-slate-400 text-2xl">-</span>
            </div>
            <div class="w-full h-12 bg-slate-100 rounded-t-lg mt-3"></div>
        @endif
    </div>
</div>
