@extends('layouts.professor')

@section('title', 'Dashboard do Professor - SimplifiKathon')
@section('header', 'Painel do Professor')

@section('content')
    {{-- Card de Boas-Vindas --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden group">
        <div class="absolute right-0 top-0 h-full w-2 bg-principal"></div>
        <div class="z-10">
            <h2 class="text-3xl font-bold text-slate-800 mb-2">Olá, {{ explode(' ', $user->name)[0] }}! 👋</h2>
            <p class="text-slate-500 text-lg">Pronto para inspirar a inovação hoje?</p>
            <div class="mt-6 flex gap-3">
                <button onclick="document.getElementById('create-hackathon-modal').classList.remove('hidden')" class="px-5 py-2.5 bg-principal hover:bg-orange-600 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all transform hover:-translate-y-0.5 flex items-center">
                    <i class="fas fa-plus mr-2"></i> Novo Evento
                </button>
                <a href="{{ route('hackathons.index') }}" class="px-5 py-2.5 bg-white border border-gray-300 text-slate-700 font-semibold rounded-lg hover:bg-gray-50 hover:text-principal transition-all flex items-center">
                    <i class="fas fa-list mr-2"></i> Meus Eventos
                </a>
            </div>
        </div>
        <div class="hidden md:block opacity-80 group-hover:opacity-100 transition-opacity">
            <i class="fas fa-chalkboard-teacher text-9xl text-gray-100"></i>
        </div>
    </div>

    {{-- Grid de Estatísticas Rápidas (Placeholder) --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="h-12 w-12 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600">
                <i class="fas fa-calendar-alt text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-slate-500 font-medium">Hackathons Ativos</p>
                <p class="text-2xl font-bold text-slate-800">--</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="h-12 w-12 rounded-lg bg-green-100 flex items-center justify-center text-green-600">
                <i class="fas fa-users text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-slate-500 font-medium">Total de Alunos</p>
                <p class="text-2xl font-bold text-slate-800">--</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex items-center gap-4">
            <div class="h-12 w-12 rounded-lg bg-purple-100 flex items-center justify-center text-purple-600">
                <i class="fas fa-check-circle text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-slate-500 font-medium">Projetos Entregues</p>
                <p class="text-2xl font-bold text-slate-800">--</p>
            </div>
        </div>
    </div>
@endsection

@push('modals')
    {{-- Modal --}}
    <div id="create-hackathon-modal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        {{-- Overlay com Blur --}}
        <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity opacity-0" id="modal-overlay"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                
                {{-- Conteúdo do Modal --}}
                <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" id="modal-panel">
                    
                    {{-- Header do Modal --}}
                    <div class="bg-white px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                        <h3 class="text-xl font-bold text-slate-800 flex items-center" id="modal-title">
                            <div class="h-8 w-8 rounded-full bg-orange-100 flex items-center justify-center text-principal mr-3">
                                <i class="fas fa-rocket text-sm"></i>
                            </div>
                            Criar Novo Hackathon
                        </h3>
                        <button type="button" id="close-modal-x" class="text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full p-2 transition-colors">
                            <i class="fas fa-times text-lg"></i>
                        </button>
                    </div>

                    {{-- Formulário --}}
                    <form method="POST" action="{{ route('hackathons.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="px-6 py-6 space-y-6">
                            
                            {{-- Seção de Upload (Visual) --}}
                            <div class="flex items-start gap-6">
                                <div class="shrink-0 group relative">
                                    <label class="block w-32 h-32 rounded-xl border-2 border-dashed border-gray-300 hover:border-principal bg-gray-50 hover:bg-orange-50 cursor-pointer flex flex-col items-center justify-center transition-all">
                                        <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 group-hover:text-principal mb-2 transition-colors"></i>
                                        <span class="text-xs text-gray-500 font-medium group-hover:text-principal">Logo do Evento</span>
                                        <input type="file" name="banner" class="hidden">
                                    </label>
                                </div>

                                <div class="flex-1 space-y-4">
                                    <div>
                                        <label for="nome" class="block text-sm font-medium text-slate-700 mb-1">Nome do Evento</label>
                                        <input type="text" name="nome" id="nome" 
                                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-principal focus:ring focus:ring-principal/20 transition-all py-2.5 px-3 text-sm placeholder:text-gray-400" 
                                            placeholder="Ex: Hackathon de Inovação 2025" required>
                                    </div>
                                    <div>
                                        <label for="descricao" class="block text-sm font-medium text-slate-700 mb-1">Descrição</label>
                                        <textarea name="descricao" id="descricao" rows="3" 
                                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-principal focus:ring focus:ring-principal/20 transition-all py-2.5 px-3 text-sm placeholder:text-gray-400 resize-none" 
                                            placeholder="Descreva o propósito, tema e regras básicas..." required></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <label for="data_inicio" class="block text-sm font-medium text-slate-700 mb-1">Início</label>
                                    <input type="datetime-local" name="data_inicio" id="data_inicio" 
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-principal focus:ring focus:ring-principal/20 transition-all py-2.5 px-3 text-sm text-gray-600" required>
                                </div>
                                <div>
                                    <label for="data_fim" class="block text-sm font-medium text-slate-700 mb-1">Fim</label>
                                    <input type="datetime-local" name="data_fim" id="data_fim" 
                                        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-principal focus:ring focus:ring-principal/20 transition-all py-2.5 px-3 text-sm text-gray-600" required>
                                </div>
                            </div>
                        </div>

                        {{-- Footer do Modal --}}
                        <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse gap-3 border-t border-gray-100">
                            <button type="submit" class="inline-flex w-full justify-center rounded-lg bg-principal px-5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-orange-600 sm:w-auto transition-all hover:shadow-md">
                                Salvar Evento
                            </button>
                            <button type="button" id="cancel-button" class="inline-flex w-full justify-center rounded-lg bg-white px-5 py-2.5 text-sm font-semibold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:w-auto transition-all">
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
    {{-- Scripts do Modal com Animações --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('create-hackathon-modal');
            const overlay = document.getElementById('modal-overlay');
            const panel = document.getElementById('modal-panel');
            const openBtns = document.querySelectorAll('#open-create-modal'); // Suporta múltiplos botões
            const closeBtns = [document.getElementById('cancel-button'), document.getElementById('close-modal-x')];

            function openModal() {
                modal.classList.remove('hidden');
                // Pequeno delay para permitir que o navegador renderize o 'block' antes de aplicar a opacidade
                setTimeout(() => {
                    overlay.classList.remove('opacity-0');
                    panel.classList.remove('opacity-0', 'translate-y-4', 'sm:translate-y-0', 'sm:scale-95');
                    panel.classList.add('opacity-100', 'translate-y-0', 'sm:scale-100');
                }, 10);
            }

            function closeModal() {
                overlay.classList.add('opacity-0');
                panel.classList.add('opacity-0', 'translate-y-4', 'sm:translate-y-0', 'sm:scale-95');
                panel.classList.remove('opacity-100', 'translate-y-0', 'sm:scale-100');
                
                // Espera a transição terminar para esconder o elemento
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }

            openBtns.forEach(btn => btn.addEventListener('click', openModal));
            closeBtns.forEach(btn => btn?.addEventListener('click', closeModal));

            // Fechar ao clicar no overlay
            modal.addEventListener('click', (e) => {
                if (e.target.closest('#modal-panel') === null) {
                    closeModal();
                }
            });

            // Fechar com ESC
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                    closeModal();
                }
            });
        });
    </script>
@endpush