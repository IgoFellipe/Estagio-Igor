<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard do Professor - SimplifiKathon</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    
    {{-- Configuração do Tailwind para usar suas cores personalizadas --}}
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        principal: '#f58220',
                        sidebar: '#1e293b',
                        'sidebar-hover': '#334155',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="bg-gray-50 text-slate-800 font-sans h-screen flex overflow-hidden">

    {{-- Barra Lateral --}}
    <aside class="w-72 bg-sidebar text-slate-200 flex flex-col shadow-lg flex-shrink-0 transition-all duration-300">
        <div class="flex items-center justify-center p-6 border-b border-slate-700">
            {{-- Substitua pelo caminho correto da sua logo --}}
            <img src="{{ asset('image/Simplifi(K)athon.png') }}" alt="SimplifiKathon" class="h-12 w-auto">
        </div>

        <div class="px-6 py-6 border-b border-slate-700">
            <div class="flex items-center gap-4">
                <div class="h-12 w-12 rounded-full bg-principal flex items-center justify-center text-white font-bold text-xl ring-2 ring-offset-2 ring-offset-sidebar ring-principal shadow-md">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div>
                    <p class="font-semibold text-white truncate max-w-[140px]" title="{{ $user->name }}">
                        {{ explode(' ', $user->name)[0] }}
                    </p>
                    <p class="text-xs text-slate-400 font-medium tracking-wide">PROFESSOR</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <a href="{{ route('dashboard.professor') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg bg-sidebar-hover text-white border-l-4 border-principal transition-all shadow-sm group">
                <i class="fas fa-home w-6 text-center text-principal group-hover:scale-110 transition-transform"></i>
                <span class="ml-3">Início</span>
            </a>
            
            <button id="open-create-modal" class="w-full flex items-center px-4 py-3 text-sm font-medium rounded-lg text-slate-300 hover:bg-sidebar-hover hover:text-white border-l-4 border-transparent hover:border-principal transition-all group">
                <i class="fas fa-plus-circle w-6 text-center group-hover:text-principal transition-colors"></i>
                <span class="ml-3">Criar Hackathon</span>
            </button>

            <a href="{{ route('hackathons.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-slate-300 hover:bg-sidebar-hover hover:text-white border-l-4 border-transparent hover:border-principal transition-all group">
                <i class="fas fa-laptop-code w-6 text-center group-hover:text-principal transition-colors"></i>
                <span class="ml-3">Ver Hackathons</span>
            </a>

            <div class="pt-4 mt-4 border-t border-slate-700">
                <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Gestão</p>
                <a href="#" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-slate-500 hover:bg-sidebar-hover hover:text-slate-300 cursor-not-allowed border-l-4 border-transparent transition-all group">
                    <i class="fas fa-user-check w-6 text-center"></i>
                    <span class="ml-3">Aprovar Alunos <span class="ml-2 text-[10px] bg-slate-700 px-1.5 py-0.5 rounded text-slate-400">Em breve</span></span>
                </a>
            </div>
        </nav>

        <div class="p-4 border-t border-slate-700 bg-slate-900/30">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center px-4 py-2 text-sm font-medium text-red-400 bg-red-400/10 hover:bg-red-500 hover:text-white rounded-lg transition-all duration-200">
                    <i class="fas fa-sign-out-alt mr-2"></i>
                    Sair
                </button>
            </form>
        </div>
    </aside>

    {{-- Conteúdo Principal --}}
    <main class="flex-1 flex flex-col min-w-0 overflow-hidden bg-gray-50">
        {{-- Header Mobile/Desktop --}}
        <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-20 px-6 py-4 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Painel do Professor</h1>
            <div class="flex items-center gap-4">
                <button class="p-2 text-gray-400 hover:text-principal transition-colors relative">
                    <i class="fas fa-bell text-xl"></i>
                    <span class="absolute top-1 right-1 h-2.5 w-2.5 bg-red-500 rounded-full border-2 border-white"></span>
                </button>
            </div>
        </header>

        {{-- Área de Scroll --}}
        <div class="flex-1 overflow-y-auto p-6 lg:p-10 scroll-smooth">
            <div class="max-w-7xl mx-auto space-y-8">
                
                {{-- Alertas --}}
                @if (session('success'))
                    <div class="flex items-center p-4 mb-6 text-sm text-green-800 border border-green-200 rounded-lg bg-green-50 animate-fade-in-down" role="alert">
                        <i class="fas fa-check-circle text-lg mr-3"></i>
                        <div>
                            <span class="font-bold block">Sucesso!</span>
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="flex p-4 mb-6 text-sm text-red-800 border border-red-200 rounded-lg bg-red-50 animate-fade-in-down" role="alert">
                        <i class="fas fa-exclamation-circle text-lg mr-3 mt-0.5"></i>
                        <div>
                            <span class="font-bold block mb-1">Por favor, corrija os seguintes erros:</span>
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

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

            </div>
        </div>
    </main>

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
                    <form method="POST" action="{{ route('hackathons.store') }}">
                        @csrf
                        <div class="px-6 py-6 space-y-6">
                            
                            {{-- Seção de Upload (Visual) --}}
                            <div class="flex items-start gap-6">
                                <div class="shrink-0 group relative">
                                    <label class="block w-32 h-32 rounded-xl border-2 border-dashed border-gray-300 hover:border-principal bg-gray-50 hover:bg-orange-50 cursor-pointer flex flex-col items-center justify-center transition-all">
                                        <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 group-hover:text-principal mb-2 transition-colors"></i>
                                        <span class="text-xs text-gray-500 font-medium group-hover:text-principal">Logo do Evento</span>
                                        <input type="file" name="imagem" class="hidden">
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
</body>
</html>