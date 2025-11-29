<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Hackathons - SimplifiKathon</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    
    {{-- Configuração do Tailwind (Mesma do dashboard) --}}
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

    {{-- Barra Lateral (Idêntica ao Dashboard) --}}
    <aside class="w-72 bg-sidebar text-slate-200 flex flex-col shadow-lg flex-shrink-0 transition-all duration-300">
        <div class="flex items-center justify-center p-6 border-b border-slate-700">
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
            <a href="{{ route('dashboard.professor') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-slate-300 hover:bg-sidebar-hover hover:text-white border-l-4 border-transparent hover:border-principal transition-all group">
                <i class="fas fa-home w-6 text-center group-hover:text-principal transition-colors"></i>
                <span class="ml-3">Início</span>
            </a>
            
            {{-- Botão Criar (pode abrir modal ou levar de volta ao dashboard se o modal estiver lá) --}}
            <a href="{{ route('dashboard.professor') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-slate-300 hover:bg-sidebar-hover hover:text-white border-l-4 border-transparent hover:border-principal transition-all group">
                <i class="fas fa-plus-circle w-6 text-center group-hover:text-principal transition-colors"></i>
                <span class="ml-3">Criar Hackathon</span>
            </a>

            <a href="{{ route('hackathons.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg bg-sidebar-hover text-white border-l-4 border-principal transition-all shadow-sm group">
                <i class="fas fa-laptop-code w-6 text-center text-principal group-hover:scale-110 transition-transform"></i>
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
        <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-20 px-6 py-4 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Seus Hackathons</h1>
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard.professor') }}" class="text-sm text-principal hover:text-orange-600 font-medium flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Voltar
                </a>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-6 lg:p-10 scroll-smooth">
            <div class="max-w-7xl mx-auto">
                
                @if($hackathons->isEmpty())
                    <div class="flex flex-col items-center justify-center py-20 bg-white rounded-2xl shadow-sm border border-gray-100 text-center">
                        <div class="bg-orange-50 p-4 rounded-full mb-4">
                            <i class="fas fa-box-open text-4xl text-principal"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 mb-2">Nenhum hackathon encontrado</h3>
                        <p class="text-slate-500 mb-6 max-w-md mx-auto">Você ainda não criou nenhum evento. Volte ao início para criar o seu primeiro Hackathon.</p>
                        <a href="{{ route('dashboard.professor') }}" class="px-6 py-2.5 bg-principal hover:bg-orange-600 text-white font-semibold rounded-lg shadow-md transition-all">
                            Criar Agora
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($hackathons as $hackathon)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group flex flex-col h-full">
                            {{-- Placeholder de Imagem (pode ser substituído pela imagem real se houver) --}}
                            <div class="h-32 bg-slate-100 flex items-center justify-center text-slate-300 relative overflow-hidden">
                                <i class="fas fa-code text-4xl"></i>
                                <div class="absolute top-3 right-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ now() > $hackathon->data_fim ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                        {{ now() > $hackathon->data_fim ? 'Encerrado' : 'Ativo' }}
                                    </span>
                                </div>
                            </div>
                            
                            <div class="p-6 flex-1 flex flex-col">
                                <h4 class="font-bold text-lg text-slate-800 mb-2 line-clamp-1" title="{{ $hackathon->nome }}">{{ $hackathon->nome }}</h4>
                                <p class="text-slate-500 text-sm mb-4 line-clamp-2 flex-1">{{ $hackathon->descricao }}</p>
                                
                                <div class="space-y-2 mb-6 border-t border-gray-100 pt-4">
                                    <div class="flex items-center text-xs text-slate-500">
                                        <i class="fas fa-calendar-alt w-5 text-center mr-2 text-principal"></i>
                                        <span>Início: <span class="font-medium text-slate-700">{{ \Carbon\Carbon::parse($hackathon->data_inicio)->format('d/m/Y H:i') }}</span></span>
                                    </div>
                                    <div class="flex items-center text-xs text-slate-500">
                                        <i class="fas fa-calendar-check w-5 text-center mr-2 text-principal"></i>
                                        <span>Fim: <span class="font-medium text-slate-700">{{ \Carbon\Carbon::parse($hackathon->data_fim)->format('d/m/Y H:i') }}</span></span>
                                    </div>
                                </div>

                                <div class="flex items-center justify-between gap-3 pt-2">
                                    <a href="#" class="flex-1 text-center px-4 py-2 bg-white border border-slate-200 text-slate-600 text-sm font-medium rounded-lg hover:bg-slate-50 hover:text-principal transition-colors">
                                        Detalhes
                                    </a>
                                    <button class="p-2 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Excluir">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </main>
</body>
</html>