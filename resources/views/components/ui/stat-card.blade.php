@props([
    'icon' => 'chart-bar',
    'value' => '0',
    'label' => 'Métrica',
    'trend' => null,
    'trendLabel' => '',
    'color' => 'primary',
    'iconBg' => null,
])

@php
    $colors = [
        'primary' => [
            'bg' => 'bg-primary-100 dark:bg-primary-900/30',
            'text' => 'text-primary-600 dark:text-primary-400',
            'ring' => 'ring-primary-500/20',
        ],
        'blue' => [
            'bg' => 'bg-blue-100 dark:bg-blue-900/30',
            'text' => 'text-blue-600 dark:text-blue-400',
            'ring' => 'ring-blue-500/20',
        ],
        'green' => [
            'bg' => 'bg-green-100 dark:bg-green-900/30',
            'text' => 'text-green-600 dark:text-green-400',
            'ring' => 'ring-green-500/20',
        ],
        'purple' => [
            'bg' => 'bg-purple-100 dark:bg-purple-900/30',
            'text' => 'text-purple-600 dark:text-purple-400',
            'ring' => 'ring-purple-500/20',
        ],
        'yellow' => [
            'bg' => 'bg-yellow-100 dark:bg-yellow-900/30',
            'text' => 'text-yellow-600 dark:text-yellow-400',
            'ring' => 'ring-yellow-500/20',
        ],
        'red' => [
            'bg' => 'bg-red-100 dark:bg-red-900/30',
            'text' => 'text-red-600 dark:text-red-400',
            'ring' => 'ring-red-500/20',
        ],
    ];
    
    $colorConfig = $colors[$color] ?? $colors['primary'];
    
    $trendColor = $trend > 0 ? 'text-green-600' : ($trend < 0 ? 'text-red-600' : 'text-gray-500');
    $trendIcon = $trend > 0 ? 'arrow-trending-up' : ($trend < 0 ? 'arrow-trending-down' : 'minus');
@endphp

<div {{ $attributes->merge(['class' => 'bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-gray-100 dark:border-slate-700 p-6 transition-all duration-300 hover:shadow-xl group']) }}>
    <div class="flex items-start justify-between">
        {{-- Ícone --}}
        <div class="h-12 w-12 rounded-xl {{ $iconBg ?? $colorConfig['bg'] }} flex items-center justify-center ring-4 {{ $colorConfig['ring'] }} transition-transform group-hover:scale-110">
            @switch($icon)
                @case('users')
                    <svg class="w-6 h-6 {{ $colorConfig['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    @break
                @case('calendar')
                    <svg class="w-6 h-6 {{ $colorConfig['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    @break
                @case('check-circle')
                    <svg class="w-6 h-6 {{ $colorConfig['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    @break
                @case('clock')
                    <svg class="w-6 h-6 {{ $colorConfig['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    @break
                @case('user-group')
                    <svg class="w-6 h-6 {{ $colorConfig['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    @break
                @case('chart-bar')
                    <svg class="w-6 h-6 {{ $colorConfig['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    @break
                @case('fire')
                    <svg class="w-6 h-6 {{ $colorConfig['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z" />
                    </svg>
                    @break
                @default
                    <svg class="w-6 h-6 {{ $colorConfig['text'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
            @endswitch
        </div>

        {{-- Trend Badge --}}
        @if ($trend !== null)
            <div class="flex items-center gap-1 {{ $trendColor }} text-sm font-medium">
                @if ($trend > 0)
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                @elseif ($trend < 0)
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" />
                    </svg>
                @endif
                <span>{{ abs($trend) }}%</span>
            </div>
        @endif
    </div>

    {{-- Valor e Label --}}
    <div class="mt-4">
        <p class="text-3xl font-bold text-slate-800 dark:text-white tracking-tight">{{ $value }}</p>
        <p class="text-sm text-slate-500 dark:text-slate-400 font-medium mt-1">{{ $label }}</p>
        @if ($trendLabel)
            <p class="text-xs text-slate-400 dark:text-slate-500 mt-1">{{ $trendLabel }}</p>
        @endif
    </div>

    {{-- Slot para conteúdo extra --}}
    @if ($slot->isNotEmpty())
        <div class="mt-4 pt-4 border-t border-gray-100 dark:border-slate-700">
            {{ $slot }}
        </div>
    @endif
</div>
