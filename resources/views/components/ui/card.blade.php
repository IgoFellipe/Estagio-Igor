@props([
    'glass' => false,
    'hover' => false,
    'padding' => true,
    'rounded' => 'xl',
])

@php
    $baseClasses = 'bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700 overflow-hidden';
    
    $roundedClasses = match($rounded) {
        'none' => '',
        'sm' => 'rounded-sm',
        'md' => 'rounded-md',
        'lg' => 'rounded-lg',
        'xl' => 'rounded-xl',
        '2xl' => 'rounded-2xl',
        '3xl' => 'rounded-3xl',
        'full' => 'rounded-full',
        default => 'rounded-xl',
    };
    
    $glassClasses = $glass 
        ? 'bg-white/80 dark:bg-slate-800/80 backdrop-blur-md border-white/20 dark:border-slate-700/50' 
        : '';
    
    $hoverClasses = $hover 
        ? 'transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl cursor-pointer' 
        : 'shadow-lg';
    
    $paddingClasses = $padding ? '' : 'p-0';
@endphp

<div {{ $attributes->merge(['class' => "$baseClasses $roundedClasses $glassClasses $hoverClasses $paddingClasses"]) }}>
    {{-- Header Slot --}}
    @if (isset($header))
        <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 {{ $header->attributes->get('class', '') }}">
            {{ $header }}
        </div>
    @endif

    {{-- Body/Default Slot --}}
    @if ($padding)
        <div class="p-6">
            {{ $slot }}
        </div>
    @else
        {{ $slot }}
    @endif

    {{-- Actions Slot (Inline buttons) --}}
    @if (isset($actions))
        <div class="px-6 py-4 border-t border-gray-100 dark:border-slate-700 flex items-center gap-3 {{ $actions->attributes->get('class', '') }}">
            {{ $actions }}
        </div>
    @endif

    {{-- Footer Slot --}}
    @if (isset($footer))
        <div class="px-6 py-4 bg-gray-50 dark:bg-slate-900/50 border-t border-gray-100 dark:border-slate-700 {{ $footer->attributes->get('class', '') }}">
            {{ $footer }}
        </div>
    @endif
</div>
