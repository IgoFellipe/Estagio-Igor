@extends('layouts.professor')

@section('title', 'Gerenciar Grupos - SimplifiKathon')
@section('header', 'Gerenciar Grupos')

@section('content')
    {{-- Estatísticas --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <x-ui.stat-card 
            icon="user-group" 
            :value="$grupos->count()" 
            label="Total de Grupos" 
            color="blue"
        />
        
        <x-ui.stat-card 
            icon="users" 
            :value="$grupos->sum(fn($g) => $g->membros->count())" 
            label="Total de Membros" 
            color="green"
        />
        
        <x-ui.stat-card 
            icon="calendar" 
            :value="$grupos->pluck('hackathon_id')->unique()->count()" 
            label="Hackathons com Grupos" 
            color="purple"
        />
    </div>

    {{-- Lista de Grupos --}}
    @if ($grupos->isEmpty())
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-12 text-center">
            <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <h3 class="text-lg font-medium text-slate-600">Nenhum grupo cadastrado</h3>
            <p class="text-slate-400 mt-1">Os grupos serão exibidos aqui quando os alunos criarem.</p>
        </div>
    @else
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Grupo</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Hackathon</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Líder</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Membros</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Imagem</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($grupos as $grupo)
                            <tr class="hover:bg-gray-50 transition-colors" x-data="{ showConfirm: false, showImageConfirm: false }">
                                {{-- Grupo --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-primary to-orange-400 flex items-center justify-center text-white font-bold text-sm overflow-hidden">
                                            @if ($grupo->imagem)
                                                <img src="{{ asset('storage/' . $grupo->imagem) }}" alt="{{ $grupo->nome }}" class="w-full h-full object-cover">
                                            @else
                                                {{ strtoupper(substr($grupo->nome, 0, 2)) }}
                                            @endif
                                        </div>
                                        <div>
                                            <p class="font-semibold text-slate-800">{{ $grupo->nome }}</p>
                                            <p class="text-xs text-slate-400 font-mono">#{{ $grupo->codigo }}</p>
                                        </div>
                                    </div>
                                </td>
                                
                                {{-- Hackathon --}}
                                <td class="px-6 py-4">
                                    <span class="text-sm text-slate-600">{{ $grupo->hackathon->nome }}</span>
                                </td>
                                
                                {{-- Líder --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="h-8 w-8 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold text-xs">
                                            {{ strtoupper(substr($grupo->lider->name, 0, 1)) }}
                                        </div>
                                        <span class="text-sm text-slate-600">{{ $grupo->lider->name }}</span>
                                    </div>
                                </td>
                                
                                {{-- Membros --}}
                                <td class="px-6 py-4 text-center">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        {{ $grupo->membros->count() }}
                                    </span>
                                </td>
                                
                                {{-- Status da Imagem --}}
                                <td class="px-6 py-4 text-center">
                                    @if ($grupo->imagem)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                                            </svg>
                                            Com imagem
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500">
                                            Sem imagem
                                        </span>
                                    @endif
                                </td>
                                
                                {{-- Ações --}}
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        {{-- Remover Imagem --}}
                                        @if ($grupo->imagem)
                                            <template x-if="!showImageConfirm">
                                                <button 
                                                    @click="showImageConfirm = true"
                                                    class="p-2 text-amber-500 hover:bg-amber-50 rounded-lg transition-colors"
                                                    title="Remover imagem"
                                                >
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </button>
                                            </template>
                                            <template x-if="showImageConfirm">
                                                <div class="flex items-center gap-1">
                                                    <form method="POST" action="{{ route('professor.grupos.removeImage', $grupo) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="p-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 transition-colors" title="Confirmar">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                    <button @click="showImageConfirm = false" class="p-2 bg-gray-200 text-slate-600 rounded-lg hover:bg-gray-300 transition-colors" title="Cancelar">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </template>
                                        @endif
                                        
                                        {{-- Excluir Grupo --}}
                                        <template x-if="!showConfirm">
                                            <button 
                                                @click="showConfirm = true"
                                                class="p-2 text-red-500 hover:bg-red-50 rounded-lg transition-colors"
                                                title="Excluir grupo"
                                            >
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </template>
                                        <template x-if="showConfirm">
                                            <div class="flex items-center gap-1">
                                                <form method="POST" action="{{ route('professor.grupos.destroy', $grupo) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="p-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors" title="Confirmar exclusão">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    </button>
                                                </form>
                                                <button @click="showConfirm = false" class="p-2 bg-gray-200 text-slate-600 rounded-lg hover:bg-gray-300 transition-colors" title="Cancelar">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </template>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endsection
