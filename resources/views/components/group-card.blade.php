@props(['group'])

@php
    $isLeader = $group->lider_id == Auth::id();
    $members = $group->membros;
    $maxAvatars = 4;
@endphp

<div 
    @click="$dispatch('open-group-modal', { group: {{ $group->load(['hackathon', 'lider', 'membros'])->toJson() }} })"
    class="group relative cursor-pointer"
>
    {{-- Card Principal com Glassmorphism --}}
    <div class="relative bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 overflow-hidden transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl hover:shadow-indigo-500/20 hover:border-white/40">
        
        {{-- Gradiente de fundo animado --}}
        <div class="absolute inset-0 bg-gradient-to-br from-violet-600/10 via-transparent to-fuchsia-600/10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
        
        {{-- Efeito de brilho no canto --}}
        <div class="absolute -top-20 -right-20 w-40 h-40 bg-gradient-to-br from-primary/30 to-purple-500/30 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-700"></div>
        
        {{-- Elemento decorativo pulsante --}}
        <div class="absolute top-4 right-4 w-2 h-2 rounded-full bg-green-400 animate-pulse shadow-lg shadow-green-400/50"></div>
        
        {{-- Conteúdo --}}
        <div class="relative z-10 p-6">
            {{-- Header com Banner/Ícone --}}
            <div class="flex items-start justify-between mb-4">
                <div class="h-14 w-14 rounded-xl bg-gradient-to-br from-violet-500 to-fuchsia-500 flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-violet-500/30 group-hover:scale-110 transition-transform duration-300">
                    @if ($group->hackathon->banner)
                        <img src="{{ asset('storage/' . $group->hackathon->banner) }}" alt="" class="w-full h-full object-cover rounded-xl">
                    @else
                        {{ strtoupper(substr($group->nome, 0, 2)) }}
                    @endif
                </div>
                
                {{-- Badge de Líder --}}
                @if ($isLeader)
                    <span class="px-3 py-1 bg-gradient-to-r from-primary to-orange-400 text-white text-xs font-bold rounded-full shadow-lg shadow-orange-500/30 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z" clip-rule="evenodd" />
                        </svg>
                        Líder
                    </span>
                @else
                    <span class="px-3 py-1 bg-white/10 text-white/70 text-xs font-medium rounded-full border border-white/20">
                        Membro
                    </span>
                @endif
            </div>

            {{-- Nome do Grupo --}}
            <h3 class="text-xl font-bold text-white mb-1 line-clamp-1 group-hover:text-transparent group-hover:bg-clip-text group-hover:bg-gradient-to-r group-hover:from-violet-400 group-hover:to-fuchsia-400 transition-all duration-300">
                {{ $group->nome }}
            </h3>

            {{-- Hackathon --}}
            <p class="text-sm text-white/60 mb-4 flex items-center gap-2">
                <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <span class="truncate">{{ $group->hackathon->nome }}</span>
            </p>

            {{-- Código do Grupo --}}
            <div class="mb-4 p-3 bg-white/5 rounded-xl border border-white/10">
                <p class="text-xs text-white/40 uppercase tracking-wider mb-1">Código</p>
                <p class="text-lg font-mono font-bold text-white flex items-center gap-2">
                    <span class="text-primary">#</span>{{ $group->codigo }}
                </p>
            </div>

            {{-- Avatar Stack dos Membros --}}
            <div class="flex items-center justify-between">
                <div class="flex -space-x-3">
                    @foreach ($members->take($maxAvatars) as $member)
                        <div class="relative h-10 w-10 rounded-full ring-2 ring-slate-900 bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white text-sm font-bold overflow-hidden transition-transform hover:scale-110 hover:z-10" title="{{ $member->name }}">
                            @if ($member->avatar)
                                <img src="{{ asset('storage/' . $member->avatar) }}" alt="{{ $member->name }}" class="w-full h-full object-cover">
                            @else
                                {{ strtoupper(substr($member->name, 0, 1)) }}
                            @endif
                            {{-- Indicador de líder --}}
                            @if ($member->id === $group->lider_id)
                                <div class="absolute -bottom-0.5 -right-0.5 w-4 h-4 bg-primary rounded-full flex items-center justify-center ring-2 ring-slate-900">
                                    <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                    @endforeach
                    
                    @if ($members->count() > $maxAvatars)
                        <div class="h-10 w-10 rounded-full ring-2 ring-slate-900 bg-white/10 backdrop-blur-sm flex items-center justify-center text-white text-xs font-bold">
                            +{{ $members->count() - $maxAvatars }}
                        </div>
                    @endif
                </div>

                {{-- Seta de ação --}}
                <div class="h-10 w-10 rounded-full bg-white/5 flex items-center justify-center text-white/40 group-hover:bg-gradient-to-r group-hover:from-violet-500 group-hover:to-fuchsia-500 group-hover:text-white transition-all duration-300">
                    <svg class="w-5 h-5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Borda gradiente na parte inferior --}}
        <div class="absolute bottom-0 left-0 right-0 h-1 bg-gradient-to-r from-violet-500 via-fuchsia-500 to-primary opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
    </div>
</div>
