<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hackathons Disponíveis - Aluno</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        principal: '#f58220',
                        sidebar: '#343a40', 
                        'sidebar-hover': '#495057',
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>

<body class="bg-gray-50 text-slate-800 font-sans h-screen flex overflow-hidden">

    {{-- Sidebar do Aluno --}}
    <aside class="w-64 bg-sidebar text-white flex flex-col shadow-lg flex-shrink-0 transition-all duration-300">
        <div class="flex items-center justify-center p-6 border-b border-gray-700">
            <img src="{{ asset('image/Simplifi(K)athon.png') }}" alt="SimplifiKathon" class="h-10 w-auto">
        </div>

        <div class="px-6 py-6 border-b border-gray-700">
            <div class="flex items-center gap-4">
                <div class="h-10 w-10 rounded-full bg-principal flex items-center justify-center text-white font-bold text-lg shadow-md">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="overflow-hidden">
                    <p class="font-semibold text-white truncate text-sm" title="{{ $user->name }}">
                        {{ explode(' ', $user->name)[0] }}
                    </p>
                    <p class="text-xs text-gray-400 font-medium tracking-wide">ALUNO</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 px-3 py-6 space-y-1 overflow-y-auto">
            <a href="{{ route('dashboard.aluno') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-300 hover:bg-sidebar-hover hover:text-white transition-all group">
                <i class="fas fa-home w-6 text-center mr-3 group-hover:scale-110 transition-transform"></i>
                <span>Início</span>
            </a>
            
            {{-- Link Ativo --}}
            <a href="{{ route('aluno.hackathons.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg bg-sidebar-hover text-white border-l-4 border-principal transition-all shadow-sm group">
                <i class="fas fa-laptop-code w-6 text-center mr-3 text-principal"></i>
                <span>Hackathons</span>
            </a>

            <a href="#" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-300 hover:bg-sidebar-hover hover:text-white transition-all group">
                <i class="fas fa-users w-6 text-center mr-3 group-hover:scale-110 transition-transform"></i>
                <span>Meus Grupos</span>
            </a>

            <a href="#" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-gray-300 hover:bg-sidebar-hover hover:text-white transition-all group">
                <i class="fas fa-user-circle w-6 text-center mr-3 group-hover:scale-110 transition-transform"></i>
                <span>Meu Perfil</span>
            </a>
        </nav>

        <div class="p-4 border-t border-gray-700 bg-black/20">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center px-4 py-2 text-sm font-medium text-red-400 hover:bg-red-500/10 hover:text-red-300 rounded-lg transition-all duration-200">
                    <i class="fas fa-sign-out-alt mr-2"></i>
                    Sair
                </button>
            </form>
        </div>
    </aside>

    {{-- Conteúdo Principal --}}
    <main class="flex-1 flex flex-col min-w-0 overflow-hidden bg-gray-50">
        <header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-20 px-6 py-4 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Hackathons Disponíveis</h1>
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard.aluno') }}" class="text-sm text-principal hover:text-orange-600 font-medium flex items-center">
                    <i class="fas fa-arrow-left mr-2"></i> Voltar ao Dashboard
                </a>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-6 lg:p-10 scroll-smooth">
            <div class="max-w-7xl mx-auto">
                
                @if($hackathons->isEmpty())
                    <div class="flex flex-col items-center justify-center py-20 bg-white rounded-2xl shadow-sm border border-gray-100 text-center">
                        <div class="bg-blue-50 p-4 rounded-full mb-4">
                            <i class="fas fa-calendar-times text-4xl text-blue-400"></i>
                        </div>
                        <h3 class="text-xl font-bold text-slate-800 mb-2">Sem eventos no momento</h3>
                        <p class="text-slate-500 mb-6 max-w-md mx-auto">Não há hackathons abertos para inscrição agora. Fique de olho, novidades em breve!</p>
                        <a href="{{ route('dashboard.aluno') }}" class="px-6 py-2.5 bg-gray-100 hover:bg-gray-200 text-slate-700 font-semibold rounded-lg shadow-sm transition-all">
                            Voltar
                        </a>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($hackathons as $hackathon)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group flex flex-col h-full">
                            {{-- Banner do Card --}}
                            <div class="h-32 bg-gradient-to-r from-blue-500 to-indigo-600 flex items-center justify-center text-white relative overflow-hidden">
                                <i class="fas fa-rocket text-4xl transform group-hover:scale-110 transition-transform duration-500"></i>
                                <div class="absolute top-3 right-3">
                                    @if(now() < $hackathon->data_inicio)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-400 text-white shadow-sm">
                                            Em Breve
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-white/20 backdrop-blur-md text-white border border-white/30 shadow-sm animate-pulse">
                                            Aberto
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="p-6 flex-1 flex flex-col">
                                <h4 class="font-bold text-lg text-slate-800 mb-2 line-clamp-1" title="{{ $hackathon->nome }}">{{ $hackathon->nome }}</h4>
                                <p class="text-slate-500 text-sm mb-4 line-clamp-2 flex-1">{{ $hackathon->descricao }}</p>
                                
                                <div class="space-y-2 mb-6 border-t border-gray-100 pt-4">
                                    <div class="flex items-center text-xs text-slate-500">
                                        <i class="far fa-calendar-alt w-5 text-center mr-2 text-blue-500"></i>
                                        <span>Início: <span class="font-medium text-slate-700">{{ \Carbon\Carbon::parse($hackathon->data_inicio)->format('d/m/Y H:i') }}</span></span>
                                    </div>
                                    <div class="flex items-center text-xs text-slate-500">
                                        <i class="fas fa-flag-checkered w-5 text-center mr-2 text-red-500"></i>
                                        <span>Fim: <span class="font-medium text-slate-700">{{ \Carbon\Carbon::parse($hackathon->data_fim)->format('d/m/Y H:i') }}</span></span>
                                    </div>
                                </div>

                                <button class="w-full mt-auto bg-principal hover:bg-orange-600 text-white font-semibold py-2.5 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center gap-2 shadow-sm hover:shadow">
                                    <span>Ver Detalhes</span>
                                    <i class="fas fa-arrow-right text-xs"></i>
                                </button>
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