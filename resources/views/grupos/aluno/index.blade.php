@extends('layouts.aluno')

@section('title', 'Meus Grupos - Aluno')

@section('content')
    <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-20 px-6 py-4 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Meus Grupos</h1>
        <div class="flex items-center gap-4">
            <a href="{{ route('dashboard.aluno') }}" class="text-sm text-principal hover:text-orange-600 font-medium flex items-center">
                <i class="fas fa-arrow-left mr-2"></i> Voltar ao Dashboard
            </a>
        </div>
    </header>

    <div class="flex-1 overflow-y-auto p-6 lg:p-10 scroll-smooth">
        <div class="max-w-7xl mx-auto">
            
            @if($grupos->isEmpty())
                <div class="flex flex-col items-center justify-center py-20 bg-white rounded-2xl shadow-sm border border-gray-100 text-center">
                    <div class="bg-orange-50 p-4 rounded-full mb-4">
                        <i class="fas fa-users-slash text-4xl text-principal"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Você não participa de nenhum grupo</h3>
                    <p class="text-slate-500 mb-6 max-w-md mx-auto">Inscreva-se em um Hackathon para criar ou entrar em um grupo.</p>
                    <a href="{{ route('aluno.hackathons.index') }}" class="px-6 py-2.5 bg-principal hover:bg-orange-600 text-white font-semibold rounded-lg shadow-sm transition-all">
                        Ver Hackathons
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($grupos as $grupo)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all duration-300 flex flex-col">
                        <div class="p-6 flex-1 flex flex-col">
                            <div class="flex items-center justify-between mb-4">
                                <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-lg">
                                    {{ strtoupper(substr($grupo->nome, 0, 1)) }}
                                </div>
                                <span class="bg-gray-100 text-gray-600 text-xs font-mono font-medium px-2.5 py-1 rounded border border-gray-200" title="Código do Grupo">
                                    <i class="fas fa-hashtag mr-1 text-gray-400"></i>{{ $grupo->codigo }}
                                </span>
                            </div>

                            <h4 class="font-bold text-lg text-slate-800 mb-1 line-clamp-1">{{ $grupo->nome }}</h4>
                            
                            <div class="mt-2 mb-4">
                                <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold mb-1">Hackathon</p>
                                <p class="text-sm text-slate-700 font-medium flex items-center">
                                    <i class="fas fa-laptop-code text-principal mr-2"></i>
                                    {{ $grupo->hackathon->nome }}
                                </p>
                            </div>

                            <div class="mt-auto pt-4 border-t border-gray-50 flex justify-between items-center">
                                <span class="text-xs text-gray-500">
                                    <i class="fas fa-user-friends mr-1"></i> {{ $grupo->membros->count() }} Membro(s)
                                </span>
                                @if($grupo->lider_id == Auth::id())
                                    <span class="text-xs font-semibold text-principal bg-orange-50 px-2 py-0.5 rounded">Líder</span>
                                @else
                                    <span class="text-xs font-semibold text-gray-500 bg-gray-100 px-2 py-0.5 rounded">Membro</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
