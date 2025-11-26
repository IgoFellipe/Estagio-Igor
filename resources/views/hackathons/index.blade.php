<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Hackathons</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/dashboard_professor.css') }}">
    <link rel="stylesheet" href="{{ asset('css/hackathon_list.css') }}">
</head>
<body class="font-sans">
    <div class="flex h-screen bg-gray-100">
        {{-- A mesma sidebar do dashboard do professor --}}
        <aside class="sidebar text-white w-72 flex flex-col">
             <div class="text-white flex items-center justify-center p-6 border-b border-gray-700">
                <img src="{{ asset('image/Simplifi(K)athon.png') }}" alt="Logo SimplifiKathon" class="h-14">
            </div>

            <div class="px-6 py-5 border-b border-gray-700">
                <div class="flex items-center">
                    <div class="h-12 w-12 rounded-full bg-principal flex items-center justify-center text-white font-bold text-xl">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="ml-4">
                        <p class="text-md font-semibold">{{ $user->name }}</p>
                        <p class="text-sm text-gray-400">Professor</p>
                    </div>
                </div>
            </div>

            <nav class="flex-1 px-4 py-4 space-y-2">
                <a href="{{ route('dashboard.professor') }}" class="sidebar-link">
                    <i class="fas fa-home"></i>
                    <span>Início</span>
                </a>
                <a href="{{ route('hackathons.index') }}" class="sidebar-link active">
                    <i class="fas fa-laptop-code"></i>
                    <span>Ver Hackathons</span>
                </a>
                <a href="#" class="sidebar-link">
                    <i class="fas fa-user-check"></i>
                    <span>Aprovar Alunos</span>
                </a>
            </nav>

            <div class="px-4 py-4 border-t border-gray-700">
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
            <header class="bg-white shadow-md">
                <div class="max-w-full mx-auto px-6 py-5">
                    <h1 class="text-2xl font-bold text-gray-800">Seus Hackathons</h1>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto p-6">
                @if($hackathons->isEmpty())
                    <div class="text-center py-12 bg-white rounded-lg shadow-sm">
                        <i class="fas fa-box-open text-4xl text-gray-400 mb-4"></i>
                        <h3 class="text-lg font-semibold text-gray-600">Nenhum hackathon encontrado</h3>
                        <p class="text-gray-500">Que tal criar o primeiro? Volte ao início para começar.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        {{-- Loop para exibir cada hackathon como um card --}}
                        @foreach($hackathons as $hackathon)
                        <div class="hackathon-card bg-white rounded-xl shadow-md overflow-hidden">
                            <div class="p-6">
                                <div class="flex justify-between items-start">
                                    <h4 class="font-bold text-xl text-gray-800 mb-2">{{ $hackathon->nome }}</h4>
                                    <div class="flex items-center space-x-2">
                                        <span class="status-dot {{ now() > $hackathon->data_fim ? 'inactive' : 'active' }}" title="{{ now() > $hackathon->data_fim ? 'Finalizado' : 'Ativo' }}"></span>
                                    </div>
                                </div>
                                <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $hackathon->descricao }}</p>
                                <div class="text-sm text-gray-500 space-y-2">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-alt mr-2"></i>
                                        <span>Início: {{ \Carbon\Carbon::parse($hackathon->data_inicio)->format('d/m/Y H:i') }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar-check mr-2"></i>
                                        <span>Fim: {{ \Carbon\Carbon::parse($hackathon->data_fim)->format('d/m/Y H:i') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-gray-50 px-6 py-3 flex justify-end space-x-3">
                                <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-800">Ver Detalhes</a>
                                <a href="#" class="text-sm font-medium text-red-600 hover:text-red-800">Excluir</a>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </main>
        </div>
    </div>
</body>
</html>