@extends('layouts.professor')

@section('title', 'Dashboard do Professor - SimplifiKathon')
@section('header', 'Painel do Professor')

@php
    use App\Enums\AttendanceStatus;
    use App\Models\User;
    use App\Models\Hackathon;
    use App\Models\Grupo;
    use App\Models\AttendanceRecord;
    
    // KPIs
    $totalAlunos = User::where('tipo', 'aluno')->count();
    $totalGrupos = Grupo::count();
    $hackathonsAtivos = Hackathon::where('data_fim', '>=', now())->count();
    $presencasPendentes = AttendanceRecord::where('status', AttendanceStatus::PENDING)->count();
    
    // Últimas presenças pendentes
    $ultimasPresencas = AttendanceRecord::where('status', AttendanceStatus::PENDING)
        ->with(['user', 'hackathon'])
        ->latest()
        ->take(6)
        ->get();
@endphp

@section('content')
    {{-- Card de Boas-Vindas Modernizado --}}
    <div class="bg-gradient-to-r from-secondary-900 via-slate-800 to-secondary-900 rounded-2xl p-8 text-white shadow-xl relative overflow-hidden mb-8">
        {{-- Padrão de fundo --}}
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.03\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>
        <div class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-primary/10 rounded-full blur-3xl"></div>
        
        <div class="relative z-10 flex flex-col lg:flex-row items-center justify-between gap-6">
            <div>
                <p class="text-slate-300 font-medium mb-1">👋 Bem-vindo de volta!</p>
                <h2 class="text-3xl lg:text-4xl font-bold mb-2">Olá, {{ explode(' ', $user->name)[0] }}!</h2>
                <p class="text-slate-300 text-lg">Pronto para inspirar a inovação hoje?</p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <button onclick="document.getElementById('create-hackathon-modal').classList.remove('hidden')" class="px-5 py-2.5 bg-primary hover:bg-orange-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Novo Hackathon
                    </button>
                    <a href="{{ route('professor.presenca.hackathons') }}" class="px-5 py-2.5 bg-white/10 hover:bg-white/20 text-white font-semibold rounded-xl backdrop-blur-sm border border-white/20 transition-all flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Validar Presenças
                        @if ($presencasPendentes > 0)
                            <span class="ml-2 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full animate-pulse">{{ $presencasPendentes }}</span>
                        @endif
                    </a>
                </div>
            </div>
            <div class="hidden lg:block">
                <svg class="w-32 h-32 text-white/10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                </svg>
            </div>
        </div>
    </div>

    {{-- Grid de KPIs --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-ui.stat-card 
            icon="users" 
            :value="$totalAlunos" 
            label="Total de Alunos" 
            color="blue"
        />
        
        <x-ui.stat-card 
            icon="user-group" 
            :value="$totalGrupos" 
            label="Grupos Formados" 
            color="green"
        />
        
        <x-ui.stat-card 
            icon="clock" 
            :value="$presencasPendentes" 
            label="Presenças Pendentes" 
            color="yellow"
        />
        
        <x-ui.stat-card 
            icon="calendar" 
            :value="$hackathonsAtivos" 
            label="Hackathons Ativos" 
            color="purple"
        />
    </div>

    {{-- Grid de Validações Pendentes --}}
    @if ($ultimasPresencas->count() > 0)
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Validações Pendentes
                </h3>
                <a href="{{ route('professor.presenca.hackathons') }}" class="text-sm font-medium text-primary hover:text-orange-700 flex items-center gap-1">
                    Ver todas
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($ultimasPresencas as $presenca)
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300 group">
                        {{-- Foto --}}
                        <div class="relative h-48 bg-gray-100">
                            <img 
                                src="{{ route('professor.presenca.foto', $presenca) }}" 
                                alt="Foto de {{ $presenca->user->name }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                            >
                            {{-- Overlay com info --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
                            <div class="absolute bottom-0 left-0 right-0 p-4">
                                <p class="text-white font-semibold">{{ $presenca->user->name }}</p>
                                <p class="text-white/70 text-sm">{{ $presenca->hackathon->nome }}</p>
                            </div>
                        </div>

                        {{-- Ações --}}
                        <div class="p-4 flex gap-3">
                            <form action="{{ route('professor.presenca.update', $presenca) }}" method="POST" class="flex-1">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" class="w-full px-4 py-2.5 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Aprovar
                                </button>
                            </form>
                            <form action="{{ route('professor.presenca.update', $presenca) }}" method="POST" class="flex-1">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="w-full px-4 py-2.5 bg-red-500 hover:bg-red-600 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Rejeitar
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Hackathons Recentes --}}
    <div>
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-xl font-bold text-slate-800 flex items-center gap-2">
                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Seus Hackathons
            </h3>
            <a href="{{ route('hackathons.index') }}" class="text-sm font-medium text-primary hover:text-orange-700 flex items-center gap-1">
                Ver todos
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </div>

        @php
            $hackathons = Hackathon::latest()->take(3)->get();
        @endphp

        @if ($hackathons->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($hackathons as $hackathon)
                    <x-ui.card :hover="true" :padding="false">
                        {{-- Banner --}}
                        <div class="h-32 bg-gradient-to-br from-primary-400 to-purple-500 relative overflow-hidden">
                            @if ($hackathon->banner)
                                <img src="{{ asset('storage/' . $hackathon->banner) }}" alt="{{ $hackathon->nome }}" class="w-full h-full object-cover">
                            @else
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-white/20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            @if (\Carbon\Carbon::parse($hackathon->data_fim)->isPast())
                                <div class="absolute top-3 right-3 bg-gray-600 text-white text-xs font-bold px-3 py-1 rounded-full">Encerrado</div>
                            @elseif (\Carbon\Carbon::parse($hackathon->data_inicio)->isFuture())
                                <div class="absolute top-3 right-3 bg-blue-500 text-white text-xs font-bold px-3 py-1 rounded-full">Em Breve</div>
                            @else
                                <div class="absolute top-3 right-3 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full animate-pulse">Ativo</div>
                            @endif
                        </div>
                        <div class="p-5">
                            <h4 class="font-bold text-lg text-slate-800 line-clamp-1">{{ $hackathon->nome }}</h4>
                            <p class="text-slate-500 text-sm mt-1 line-clamp-2">{{ $hackathon->descricao }}</p>
                            <div class="flex items-center gap-2 mt-4 text-sm text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ \Carbon\Carbon::parse($hackathon->data_inicio)->format('d/m/Y') }}
                            </div>
                        </div>
                    </x-ui.card>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-lg p-12 text-center border border-gray-100">
                <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-slate-600">Nenhum hackathon criado</h3>
                <p class="text-slate-400 mt-1">Clique em "Novo Hackathon" para começar!</p>
            </div>
        @endif
    </div>
@endsection

@push('modals')
    {{-- Modal Criar Hackathon --}}
    <div id="create-hackathon-modal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" id="modal-overlay"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl" id="modal-panel">
                    
                    {{-- Header --}}
                    <div class="bg-gradient-to-r from-primary to-orange-500 px-6 py-5 flex justify-between items-center">
                        <h3 class="text-xl font-bold text-white flex items-center gap-3" id="modal-title">
                            <div class="h-10 w-10 rounded-full bg-white/20 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                            Criar Novo Hackathon
                        </h3>
                        <button type="button" id="close-modal-x" class="text-white/80 hover:text-white hover:bg-white/10 rounded-full p-2 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    {{-- Formulário --}}
                    <form method="POST" action="{{ route('hackathons.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="px-6 py-6 space-y-6">
                            
                            <div class="flex items-start gap-6">
                                {{-- Upload Banner --}}
                                <div class="shrink-0 group relative" x-data="{ preview: null }">
                                    <label class="block w-32 h-32 rounded-xl border-2 border-dashed border-gray-300 hover:border-primary bg-gray-50 hover:bg-orange-50 cursor-pointer flex flex-col items-center justify-center transition-all overflow-hidden">
                                        <template x-if="!preview">
                                            <div class="flex flex-col items-center">
                                                <svg class="w-8 h-8 text-gray-400 group-hover:text-primary mb-2 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span class="text-xs text-gray-500 font-medium group-hover:text-primary text-center px-2">Banner do Evento</span>
                                            </div>
                                        </template>
                                        <template x-if="preview">
                                            <img :src="preview" class="w-full h-full object-cover">
                                        </template>
                                        <input type="file" name="banner" class="hidden" accept="image/*" @change="preview = URL.createObjectURL($event.target.files[0])">
                                    </label>
                                </div>

                                <div class="flex-1 space-y-4">
                                    <div>
                                        <label for="nome" class="block text-sm font-medium text-slate-700 mb-1">Nome do Evento</label>
                                        <input type="text" name="nome" id="nome" 
                                            class="w-full rounded-xl border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/20 transition-all py-3 px-4 text-sm" 
                                            placeholder="Ex: Hackathon de Inovação 2026" required>
                                    </div>
                                    <div>
                                        <label for="descricao" class="block text-sm font-medium text-slate-700 mb-1">Descrição</label>
                                        <textarea name="descricao" id="descricao" rows="3" 
                                            class="w-full rounded-xl border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/20 transition-all py-3 px-4 text-sm resize-none" 
                                            placeholder="Descreva o propósito, tema e regras básicas..." required></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label for="data_inicio" class="block text-sm font-medium text-slate-700 mb-1">Data de Início</label>
                                    <input type="datetime-local" name="data_inicio" id="data_inicio" 
                                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/20 transition-all py-3 px-4 text-sm" required>
                                </div>
                                <div>
                                    <label for="data_fim" class="block text-sm font-medium text-slate-700 mb-1">Data de Término</label>
                                    <input type="datetime-local" name="data_fim" id="data_fim" 
                                        class="w-full rounded-xl border-gray-300 shadow-sm focus:border-primary focus:ring focus:ring-primary/20 transition-all py-3 px-4 text-sm" required>
                                </div>
                            </div>
                        </div>

                        {{-- Footer --}}
                        <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse gap-3 border-t border-gray-100">
                            <button type="submit" class="inline-flex justify-center rounded-xl bg-primary px-6 py-3 text-sm font-semibold text-white shadow-lg hover:bg-orange-600 hover:shadow-xl transition-all">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                Criar Hackathon
                            </button>
                            <button type="button" id="cancel-button" class="inline-flex justify-center rounded-xl bg-white px-6 py-3 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-all">
                                Cancelar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('create-hackathon-modal');
        const overlay = document.getElementById('modal-overlay');
        const openBtns = document.querySelectorAll('#open-create-modal, [onclick*="create-hackathon-modal"]');
        const closeBtns = [document.getElementById('cancel-button'), document.getElementById('close-modal-x')];

        function openModal() {
            modal.classList.remove('hidden');
        }

        function closeModal() {
            modal.classList.add('hidden');
        }

        closeBtns.forEach(btn => btn?.addEventListener('click', closeModal));
        overlay?.addEventListener('click', closeModal);

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                closeModal();
            }
        });
    });
</script>
@endpush