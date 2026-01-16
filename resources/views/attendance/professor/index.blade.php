@extends('layouts.professor')

@section('title', 'Presenças - {{ $hackathon->nome }}')
@section('header', 'Presenças: ' . $hackathon->nome)

@section('content')
<div class="space-y-6">
    
    {{-- Breadcrumb / Voltar --}}
    <div class="flex items-center gap-4">
        <a 
            href="{{ route('professor.presenca.hackathons') }}"
            class="flex items-center gap-2 text-slate-500 hover:text-principal transition-colors"
        >
            <i class="fas fa-arrow-left"></i>
            <span>Voltar aos Hackathons</span>
        </a>
    </div>

    {{-- Stats Cards --}}
    @php
        $pendentes = $presencas->where('status', \App\Enums\AttendanceStatus::PENDING)->count();
        $aprovadas = $presencas->where('status', \App\Enums\AttendanceStatus::APPROVED)->count();
        $rejeitadas = $presencas->where('status', \App\Enums\AttendanceStatus::REJECTED)->count();
    @endphp
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-4 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-yellow-500 flex items-center justify-center">
                <i class="fas fa-clock text-white text-xl"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-yellow-700">{{ $pendentes }}</p>
                <p class="text-sm text-yellow-600">Pendentes</p>
            </div>
        </div>
        <div class="bg-green-50 border border-green-200 rounded-xl p-4 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-green-500 flex items-center justify-center">
                <i class="fas fa-check text-white text-xl"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-green-700">{{ $aprovadas }}</p>
                <p class="text-sm text-green-600">Aprovadas</p>
            </div>
        </div>
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-red-500 flex items-center justify-center">
                <i class="fas fa-times text-white text-xl"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-red-700">{{ $rejeitadas }}</p>
                <p class="text-sm text-red-600">Rejeitadas</p>
            </div>
        </div>
    </div>

    {{-- Lista de Presenças --}}
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 bg-slate-800 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-white flex items-center gap-2">
                <i class="fas fa-users"></i>
                Registros de Presença
            </h2>
            <span class="text-sm text-slate-300">{{ $presencas->count() }} registro(s)</span>
        </div>

        @if ($presencas->count() > 0)
            <div class="divide-y divide-gray-100">
                @foreach ($presencas as $presenca)
                    <div class="p-6 hover:bg-gray-50 transition-colors" x-data="{ showModal: false, showRejectModal: false }">
                        <div class="flex flex-col lg:flex-row lg:items-center gap-6">
                            
                            {{-- Info do Aluno --}}
                            <div class="flex items-center gap-4 flex-1">
                                <div class="w-12 h-12 rounded-full bg-principal flex items-center justify-center text-white font-bold text-lg shadow-md">
                                    {{ strtoupper(substr($presenca->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-semibold text-slate-800">{{ $presenca->user->name }}</p>
                                    <p class="text-sm text-slate-400">{{ $presenca->user->email }}</p>
                                    <p class="text-xs text-slate-400 mt-1">
                                        <i class="fas fa-clock mr-1"></i>
                                        Enviado em {{ $presenca->created_at->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                            </div>

                            {{-- Preview da Foto --}}
                            <div class="flex-shrink-0">
                                <img 
                                    src="{{ route('professor.presenca.foto', $presenca) }}"
                                    alt="Foto de {{ $presenca->user->name }}"
                                    class="w-32 h-24 object-cover rounded-lg border-2 border-gray-200 cursor-pointer hover:border-principal transition-colors shadow-md"
                                    @click="showModal = true"
                                >
                            </div>

                            {{-- Status e Ações --}}
                            <div class="flex items-center gap-3">
                                @if ($presenca->status === \App\Enums\AttendanceStatus::PENDING)
                                    {{-- Botões de Ação --}}
                                    <form action="{{ route('professor.presenca.update', $presenca) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="approved">
                                        <button 
                                            type="submit"
                                            class="px-5 py-2.5 bg-green-500 hover:bg-green-600 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all flex items-center gap-2"
                                        >
                                            <i class="fas fa-check"></i>
                                            Aprovar
                                        </button>
                                    </form>
                                    
                                    <button 
                                        @click="showRejectModal = true"
                                        class="px-5 py-2.5 bg-red-500 hover:bg-red-600 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition-all flex items-center gap-2"
                                    >
                                        <i class="fas fa-times"></i>
                                        Rejeitar
                                    </button>
                                @else
                                    {{-- Badge de Status --}}
                                    @php
                                        $statusColors = [
                                            'approved' => 'bg-green-100 text-green-800 border-green-200',
                                            'rejected' => 'bg-red-100 text-red-800 border-red-200',
                                        ];
                                    @endphp
                                    <span class="px-4 py-2 rounded-lg text-sm font-medium border {{ $statusColors[$presenca->status->value] ?? '' }}">
                                        <i class="fas fa-{{ $presenca->status === \App\Enums\AttendanceStatus::APPROVED ? 'check-circle' : 'times-circle' }} mr-1"></i>
                                        {{ $presenca->status->label() }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Nota do Admin --}}
                        @if ($presenca->admin_note)
                            <div class="mt-4 p-3 bg-slate-50 rounded-lg border border-slate-200">
                                <p class="text-sm text-slate-600">
                                    <i class="fas fa-comment-alt text-slate-400 mr-2"></i>
                                    <strong>Observação:</strong> {{ $presenca->admin_note }}
                                </p>
                            </div>
                        @endif

                        {{-- Modal de Visualização da Foto --}}
                        <div 
                            x-show="showModal" 
                            x-transition
                            class="fixed inset-0 bg-black/80 flex items-center justify-center z-50 p-4"
                            @click.self="showModal = false"
                            style="display: none;"
                        >
                            <div class="relative max-w-4xl max-h-[90vh]">
                                <img 
                                    src="{{ route('professor.presenca.foto', $presenca) }}"
                                    alt="Foto de {{ $presenca->user->name }}"
                                    class="max-w-full max-h-[85vh] object-contain rounded-lg shadow-2xl"
                                >
                                <button 
                                    @click="showModal = false"
                                    class="absolute -top-3 -right-3 bg-white text-slate-800 w-10 h-10 rounded-full shadow-lg hover:bg-red-500 hover:text-white transition-colors flex items-center justify-center"
                                >
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>

                        {{-- Modal de Rejeição --}}
                        <div 
                            x-show="showRejectModal" 
                            x-transition
                            class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4"
                            @click.self="showRejectModal = false"
                            style="display: none;"
                        >
                            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden" @click.stop>
                                <div class="bg-red-500 px-6 py-4">
                                    <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                                        <i class="fas fa-times-circle"></i>
                                        Rejeitar Presença
                                    </h3>
                                </div>
                                <form action="{{ route('professor.presenca.update', $presenca) }}" method="POST" class="p-6">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="rejected">
                                    
                                    <p class="text-slate-600 mb-4">
                                        Você está rejeitando a presença de <strong>{{ $presenca->user->name }}</strong>.
                                    </p>
                                    
                                    <label class="block text-sm font-medium text-slate-700 mb-2">
                                        Motivo da rejeição (opcional)
                                    </label>
                                    <textarea 
                                        name="admin_note"
                                        rows="3"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all"
                                        placeholder="Ex: Foto ilegível, não é possível identificar o aluno..."
                                    ></textarea>

                                    <div class="flex gap-3 mt-6">
                                        <button 
                                            type="button"
                                            @click="showRejectModal = false"
                                            class="flex-1 px-4 py-3 border border-gray-300 text-slate-700 font-medium rounded-xl hover:bg-gray-50 transition-colors"
                                        >
                                            Cancelar
                                        </button>
                                        <button 
                                            type="submit"
                                            class="flex-1 px-4 py-3 bg-red-500 hover:bg-red-600 text-white font-medium rounded-xl shadow-md transition-colors"
                                        >
                                            Confirmar Rejeição
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="p-12 text-center">
                <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                    <i class="fas fa-inbox text-4xl text-gray-300"></i>
                </div>
                <h3 class="text-lg font-medium text-slate-600">Nenhuma presença registrada</h3>
                <p class="text-slate-400 mt-1">Nenhum aluno enviou foto de presença para este hackathon ainda.</p>
            </div>
        @endif
    </div>

</div>
@endsection

@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush
