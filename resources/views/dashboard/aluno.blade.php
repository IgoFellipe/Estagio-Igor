@extends('layouts.aluno')

@section('title', 'Dashboard do Aluno')

@section('content')
    <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-20 px-6 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-slate-800">Dashboard</h1>
        <div class="lg:hidden">
            <button class="text-slate-500 hover:text-principal">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>
    </header>

    <div class="flex-1 overflow-x-hidden overflow-y-auto p-6 bg-gray-50">
        
        {{-- Banner Principal --}}
        <div class="rounded-2xl p-8 text-white shadow-lg mb-8 relative overflow-hidden bg-gradient-to-r from-blue-600 to-indigo-700">
            <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="md:w-1/2">
                    <h2 class="text-3xl font-bold mb-3">Participe dos Hackathons!</h2>
                    <p class="opacity-90 mb-6 text-blue-50 text-lg">Desafie-se, aprenda novas tecnologias e construa projetos incríveis em equipe.</p>
                    
                    <a href="{{ route('aluno.hackathons.index') }}" class="inline-flex items-center px-6 py-3 bg-white text-blue-700 font-bold text-lg rounded-lg hover:bg-blue-50 transition duration-300 shadow-md transform hover:-translate-y-0.5">
                        Ver Hackathons Disponíveis
                        <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                <div class="md:w-2/5 flex justify-center">
                    <i class="fas fa-rocket text-9xl text-white/20 transform -rotate-12"></i>
                </div>
            </div>
            <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-principal/20 rounded-full blur-2xl"></div>
        </div>

        {{-- Hackathons Abertos (Preview) --}}
        <div class="mb-8">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-slate-800 flex items-center">
                    <i class="fas fa-fire text-principal mr-2"></i> Destaques
                </h3>
                <a href="{{ route('aluno.hackathons.index') }}" class="text-sm font-medium text-principal hover:text-orange-700 hover:underline">Ver todos</a>
            </div>

            @if($hackathons->isEmpty())
                <div class="bg-white rounded-xl shadow-sm p-8 text-center border border-gray-200">
                    <i class="fas fa-calendar-day text-4xl text-gray-300 mb-3"></i>
                    <p class="text-gray-500">Nenhum hackathon disponível no momento.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($hackathons->take(3) as $hackathon)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all duration-300 flex flex-col">
                            <div class="p-5 flex-1 flex flex-col">
                                <div class="flex justify-between items-start mb-2">
                                    <h4 class="font-bold text-lg text-slate-800 line-clamp-1">{{ $hackathon->nome }}</h4>
                                    <span class="bg-blue-50 text-blue-700 text-xs font-semibold px-2.5 py-0.5 rounded border border-blue-100">Novo</span>
                                </div>
                                <p class="text-slate-500 text-sm mb-4 line-clamp-2">{{ $hackathon->descricao }}</p>
                                <div class="mt-auto pt-3 border-t border-gray-50">
                                    <a href="{{ route('aluno.hackathons.index') }}" class="text-principal font-medium text-sm hover:underline">Saiba mais</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection