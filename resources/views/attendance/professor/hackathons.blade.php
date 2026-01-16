@extends('layouts.professor')

@section('title', 'Validar Presenças - SimplifiKathon')
@section('header', 'Validar Presenças')

@section('content')
<div class="space-y-6">
    
    {{-- Título --}}
    <div>
        <h2 class="text-xl font-semibold text-slate-800">Selecione um Hackathon</h2>
        <p class="text-slate-500 mt-1">Escolha um hackathon para visualizar as presenças pendentes de validação.</p>
    </div>

    {{-- Grid de Hackathons --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($hackathons as $hackathon)
            <a 
                href="{{ route('professor.presenca.index', $hackathon) }}"
                class="group relative bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden hover:shadow-xl hover:border-principal/30 transition-all duration-300"
            >
                {{-- Banner --}}
                <div class="h-32 bg-gradient-to-br from-principal to-orange-400 relative overflow-hidden">
                    @if ($hackathon->banner)
                        <img 
                            src="{{ asset('storage/' . $hackathon->banner) }}" 
                            alt="{{ $hackathon->nome }}"
                            class="w-full h-full object-cover opacity-80 group-hover:scale-105 transition-transform duration-300"
                        >
                    @else
                        <div class="absolute inset-0 flex items-center justify-center">
                            <i class="fas fa-laptop-code text-6xl text-white/30"></i>
                        </div>
                    @endif
                    
                    {{-- Badge de Pendentes --}}
                    @if ($hackathon->pendentes_count > 0)
                        <div class="absolute top-3 right-3 bg-red-500 text-white text-sm font-bold px-3 py-1 rounded-full shadow-lg animate-pulse">
                            {{ $hackathon->pendentes_count }} pendente{{ $hackathon->pendentes_count > 1 ? 's' : '' }}
                        </div>
                    @else
                        <div class="absolute top-3 right-3 bg-green-500 text-white text-sm font-medium px-3 py-1 rounded-full shadow-lg">
                            <i class="fas fa-check mr-1"></i> OK
                        </div>
                    @endif
                </div>

                {{-- Info --}}
                <div class="p-5">
                    <h3 class="font-semibold text-lg text-slate-800 group-hover:text-principal transition-colors">
                        {{ $hackathon->nome }}
                    </h3>
                    <p class="text-sm text-slate-400 mt-1">
                        <i class="fas fa-calendar-alt mr-1"></i>
                        {{ \Carbon\Carbon::parse($hackathon->data_inicio)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($hackathon->data_fim)->format('d/m/Y') }}
                    </p>
                    
                    <div class="mt-4 flex items-center text-principal font-medium text-sm">
                        Ver presenças
                        <i class="fas fa-arrow-right ml-2 group-hover:translate-x-1 transition-transform"></i>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-span-full">
                <div class="bg-gray-50 rounded-2xl p-12 text-center border-2 border-dashed border-gray-200">
                    <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                        <i class="fas fa-calendar-times text-4xl text-gray-300"></i>
                    </div>
                    <h3 class="text-lg font-medium text-slate-600">Nenhum hackathon encontrado</h3>
                    <p class="text-slate-400 mt-1">Crie um hackathon primeiro para validar presenças.</p>
                </div>
            </div>
        @endforelse
    </div>

</div>
@endsection
