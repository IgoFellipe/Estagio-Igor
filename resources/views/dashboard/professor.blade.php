<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard do Professor - SimplifiKathon</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/dashboard_professor.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>

<body class="font-sans">
    <div class="flex h-screen">

        {{-- Barra Lateral --}}
        <aside class="sidebar w-72 flex-shrink-0 flex flex-col">
            <div class="flex items-center justify-center p-6 border-b border-slate-700">
                <img src="{{ asset('image/Simplifi(K)athon.png') }}" alt="Logo SimplifiKathon" class="h-14">
            </div>

            <div class="px-6 py-5 border-b border-slate-700">
                <div class="flex items-center">
                    <div class="h-12 w-12 rounded-full bg-principal flex items-center justify-center text-white font-bold text-xl ring-2 ring-offset-2 ring-offset-sidebar-bg ring-principal">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="ml-4">
                        <p class="text-md font-semibold text-white">{{ $user->name }}</p>
                        <p class="text-sm text-slate-400">Professor</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 px-4 py-4 space-y-2">
                <a href="{{ route('dashboard.professor') }}" class="sidebar-link active">
                    <i class="fas fa-home"></i>
                    <span>Início</span>
                </a>
                <button id="open-create-modal" class="w-full text-left sidebar-link">
                    <i class="fas fa-plus-circle"></i>
                    <span>Criar Hackathon</span>
                </button>
                <a href="{{ route('hackathons.index') }}" class="sidebar-link">
                    <i class="fas fa-laptop-code"></i>
                    <span>Ver Hackathons</span>
                </a>
                <a href="#" class="sidebar-link opacity-50 cursor-not-allowed" title="Em breve">
                    <i class="fas fa-user-check"></i>
                    <span>Aprovar Alunos</span>
                </a>
            </nav>

            <div class="px-4 py-4 border-t border-slate-700">
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="w-full text-left sidebar-link">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Sair</span>
                    </button>
                </form>
            </div>
        </aside>

        {{-- Conteúdo Principal --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white shadow-sm header-main">
                <div class="max-w-full mx-auto px-6 py-5">
                    <h1 class="text-2xl font-bold text-texto-escuro">Painel do Professor</h1>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto p-6 lg:p-8">
                {{-- Alertas de Feedback --}}
                @if (session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md mb-6 shadow-md" role="alert">
                        <p class="font-bold">Sucesso!</p>
                        <p>{{ session('success') }}</p>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md mb-6 shadow-md" role="alert">
                        <p class="font-bold">Ocorreu um erro!</p>
                        <ul class="mt-1 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                
                {{-- Card de Boas-Vindas --}}
                <div class="card p-8">
                    <h2 class="text-xl font-bold text-gray-800">Bem-vindo(a) de volta, {{ explode(' ', $user->name)[0] }}!</h2>
                    <p class="text-gray-600 mt-2">Este é o seu centro de controle. Utilize o menu à esquerda para começar a gerenciar seus eventos e alunos.</p>
                </div>
            </main>
        </div>
    </div>

    {{-- Modal de Cadastro de Hackathon --}}
    <div id="create-hackathon-modal" class="fixed inset-0 bg-gray-900 bg-opacity-60 backdrop-blur-sm flex items-center justify-center hidden z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-2xl w-full mx-4 transform transition-all">
            <h2 class="text-2xl font-bold text-gray-900 mb-6">Criar Novo Hackathon</h2>
            
            <form method="POST" action="{{ route('hackathons.store') }}" class="space-y-6">
                @csrf
                <div class="flex items-center space-x-6">
                    <div class="flex-shrink-0">
                        <label for="imagem-upload" class="w-32 h-32 border-2 border-dashed rounded-lg flex items-center justify-center text-gray-400 hover:bg-gray-50 hover:border-principal cursor-pointer transition-colors">
                            <i class="fas fa-upload text-3xl"></i>
                            <input type="file" id="imagem-upload" name="imagem" class="hidden">
                        </label>
                    </div>
                    <div class="flex-1 space-y-4">
                        <div>
                            <label for="nome" class="block text-sm font-medium text-gray-700">Nome do Hackathon</label>
                            <input type="text" name="nome" id="nome" placeholder="Ex: Hacka-Saúde 2025" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-principal focus:border-principal">
                        </div>
                        <div>
                            <label for="descricao" class="block text-sm font-medium text-gray-700">Descrição</label>
                            <textarea name="descricao" id="descricao" rows="3" placeholder="Descreva o objetivo do evento..." required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-principal focus:border-principal"></textarea>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="data_inicio" class="block text-sm font-medium text-gray-700">Data e Hora de Início</label>
                        <input type="datetime-local" name="data_inicio" id="data_inicio" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-principal focus:border-principal">
                    </div>
                    <div>
                        <label for="data_fim" class="block text-sm font-medium text-gray-700">Data e Hora de Fim</label>
                        <input type="datetime-local" name="data_fim" id="data_fim" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-principal focus:border-principal">
                    </div>
                </div>

                <div class="flex justify-end space-x-4 pt-4">
                    <button type="button" id="cancel-button" class="px-6 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-100 focus:outline-none transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" class="px-6 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-principal hover:bg-orange-600 focus:outline-none transition-colors">
                        Salvar Hackathon
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const openModalBtn = document.getElementById('open-create-modal');
            const closeModalBtn = document.getElementById('cancel-button');
            const modal = document.getElementById('create-hackathon-modal');

            function showModal() {
                modal.classList.remove('hidden');
            }

            function hideModal() {
                modal.classList.add('hidden');
            }

            openModalBtn.addEventListener('click', showModal);
            closeModalBtn.addEventListener('click', hideModal);

            modal.addEventListener('click', (event) => {
                if (event.target === modal) {
                    hideModal();
                }
            });
            
            // Fecha o modal com a tecla Esc
            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
                    hideModal();
                }
            });
        });
    </script>
</body>
</html>