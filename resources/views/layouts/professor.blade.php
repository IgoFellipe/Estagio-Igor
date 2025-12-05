<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Painel do Professor - SimplifiKathon')</title>
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
    @stack('styles')
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
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <p class="font-semibold text-white truncate max-w-[140px]" title="{{ Auth::user()->name }}">
                        {{ explode(' ', Auth::user()->name)[0] }}
                    </p>
                    <p class="text-xs text-slate-400 font-medium tracking-wide">PROFESSOR</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <a href="{{ route('dashboard.professor') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('dashboard.professor') ? 'bg-sidebar-hover text-white border-l-4 border-principal' : 'text-slate-300 hover:bg-sidebar-hover hover:text-white border-l-4 border-transparent hover:border-principal' }} transition-all shadow-sm group">
                <i class="fas fa-home w-6 text-center {{ request()->routeIs('dashboard.professor') ? 'text-principal' : 'group-hover:text-principal' }} transition-colors"></i>
                <span class="ml-3">Início</span>
            </a>
            
            {{-- Botão Criar Hackathon (Apenas no Dashboard ou Global?) --}}
            {{-- Vamos manter global se possível, ou condicional --}}
            @if(request()->routeIs('dashboard.professor'))
            <button id="open-create-modal" class="w-full flex items-center px-4 py-3 text-sm font-medium rounded-lg text-slate-300 hover:bg-sidebar-hover hover:text-white border-l-4 border-transparent hover:border-principal transition-all group">
                <i class="fas fa-plus-circle w-6 text-center group-hover:text-principal transition-colors"></i>
                <span class="ml-3">Criar Hackathon</span>
            </button>
            @endif

            <a href="{{ route('hackathons.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('hackathons.index') ? 'bg-sidebar-hover text-white border-l-4 border-principal' : 'text-slate-300 hover:bg-sidebar-hover hover:text-white border-l-4 border-transparent hover:border-principal' }} transition-all group">
                <i class="fas fa-laptop-code w-6 text-center {{ request()->routeIs('hackathons.index') ? 'text-principal' : 'group-hover:text-principal' }} transition-colors"></i>
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
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">@yield('header', 'Painel do Professor')</h1>
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

                @yield('content')

            </div>
        </div>
    </main>

    @stack('modals')
    @stack('scripts')
</body>
</html>
