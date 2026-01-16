@props(['user', 'service' => null])

@php
    $service = $service ?? app(\App\Services\GamificationService::class);
    $progress = $service->getLevelProgress($user->current_xp, $user->current_level);
    $xpForNext = $service->getXpForNextLevel($user->current_level);
    $xpForCurrent = $service->getXpForLevel($user->current_level);
    $position = $service->getUserRankPosition($user);
@endphp

<div {{ $attributes->merge(['class' => 'bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden']) }}>
    {{-- Header com Gradiente --}}
    <div class="bg-gradient-to-r from-unifil-orange to-orange-400 px-6 py-5 relative overflow-hidden">
        <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full -mr-20 -mt-20"></div>
        <div class="absolute bottom-0 left-0 w-20 h-20 bg-white/5 rounded-full -ml-10 -mb-10"></div>
        
        <div class="relative z-10 flex items-center gap-4">
            {{-- Avatar --}}
            <div class="h-16 w-16 rounded-2xl bg-white/20 flex items-center justify-center text-white text-2xl font-bold backdrop-blur-sm overflow-hidden border-2 border-white/30">
                @if ($user->avatar)
                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" class="w-full h-full object-cover">
                @else
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                @endif
            </div>
            
            <div class="flex-1">
                <p class="text-white/80 text-sm font-medium">Seu Ranking</p>
                <p class="text-white text-2xl font-bold">{{ $position }}º Lugar</p>
            </div>
            
            {{-- Badge de Nível --}}
            <div class="bg-white/20 backdrop-blur-sm rounded-xl px-4 py-2 text-center border border-white/30">
                <p class="text-white/70 text-xs uppercase tracking-wide">Nível</p>
                <p class="text-white text-3xl font-bold">{{ $user->current_level }}</p>
            </div>
        </div>
    </div>
    
    {{-- Corpo --}}
    <div class="p-6">
        {{-- XP Atual --}}
        <div class="mb-6">
            <div class="flex justify-between items-center mb-2">
                <span class="text-sm font-medium text-slate-600">Experiência (XP)</span>
                <span class="text-2xl font-bold text-unifil-orange">{{ number_format($user->current_xp, 0, ',', '.') }}</span>
            </div>
            
            {{-- Barra de Progresso --}}
            <div class="relative h-4 bg-slate-100 rounded-full overflow-hidden">
                <div 
                    class="absolute inset-y-0 left-0 bg-gradient-to-r from-unifil-orange to-orange-400 rounded-full transition-all duration-500"
                    style="width: {{ $progress }}%"
                ></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <span class="text-xs font-bold text-white drop-shadow" style="text-shadow: 0 1px 2px rgba(0,0,0,0.3);">
                        {{ round($progress) }}%
                    </span>
                </div>
            </div>
            
            <div class="flex justify-between items-center mt-2 text-xs text-slate-400">
                <span>Nível {{ $user->current_level }}: {{ number_format($xpForCurrent, 0, ',', '.') }} XP</span>
                <span>Nível {{ $user->current_level + 1 }}: {{ number_format($xpForNext, 0, ',', '.') }} XP</span>
            </div>
        </div>
        
        {{-- Estatísticas Rápidas --}}
        <div class="grid grid-cols-3 gap-4">
            <div class="text-center p-3 bg-slate-50 rounded-xl">
                <svg class="w-6 h-6 mx-auto mb-1 text-unifil-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-lg font-bold text-slate-800">{{ $user->attendanceRecords()->where('status', 'approved')->count() }}</p>
                <p class="text-xs text-slate-500">Presenças</p>
            </div>
            
            <div class="text-center p-3 bg-slate-50 rounded-xl">
                <svg class="w-6 h-6 mx-auto mb-1 text-unifil-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <p class="text-lg font-bold text-slate-800">{{ $user->grupos()->count() }}</p>
                <p class="text-xs text-slate-500">Grupos</p>
            </div>
            
            <div class="text-center p-3 bg-slate-50 rounded-xl">
                <svg class="w-6 h-6 mx-auto mb-1 text-unifil-orange" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/>
                </svg>
                <p class="text-lg font-bold text-slate-800">{{ $user->current_level }}</p>
                <p class="text-xs text-slate-500">Nível</p>
            </div>
        </div>
    </div>
</div>
