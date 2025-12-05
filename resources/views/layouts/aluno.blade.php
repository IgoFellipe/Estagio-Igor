<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SimplifiKathon - Aluno')</title>
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
    @stack('styles')
</head>

<body class="bg-gray-50 text-slate-800 font-sans h-screen flex overflow-hidden">

    {{-- Sidebar do Aluno --}}
    <aside class="w-64 bg-sidebar text-white flex flex-col shadow-lg flex-shrink-0 transition-all duration-300">
        <div class="flex items-center justify-center p-6 border-b border-gray-700">
            <img src="{{ asset('image/Simplifi(K)athon.png') }}" alt="SimplifiKathon" class="h-10 w-auto">
        </div>

        <div class="px-6 py-6 border-b border-gray-700">
            <div class="flex items-center gap-4">
                <div class="h-10 w-10 rounded-full bg-principal flex items-center justify-center text-white font-bold text-lg shadow-md overflow-hidden">
                    @if(Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="h-full w-full object-cover">
                    @else
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    @endif
                </div>
                <div class="overflow-hidden">
                    <p class="font-semibold text-white truncate text-sm" title="{{ Auth::user()->name }}">
                        {{ explode(' ', Auth::user()->name)[0] }}
                    </p>
                    <p class="text-xs text-gray-400 font-medium tracking-wide">ALUNO</p>
                </div>
            </div>
        </div>

        <nav class="flex-1 px-3 py-6 space-y-1 overflow-y-auto">
            <a href="{{ route('dashboard.aluno') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('dashboard.aluno') ? 'bg-sidebar-hover text-white border-l-4 border-principal' : 'text-gray-300 hover:bg-sidebar-hover hover:text-white' }} transition-all group">
                <i class="fas fa-home w-6 text-center mr-3 {{ request()->routeIs('dashboard.aluno') ? 'text-principal' : 'group-hover:scale-110 transition-transform' }}"></i>
                <span class="ml-3">Início</span>
            </a>
            
            <a href="{{ route('aluno.hackathons.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('aluno.hackathons.index') ? 'bg-sidebar-hover text-white border-l-4 border-principal' : 'text-gray-300 hover:bg-sidebar-hover hover:text-white' }} transition-all group">
                <i class="fas fa-laptop-code w-6 text-center mr-3 {{ request()->routeIs('aluno.hackathons.index') ? 'text-principal' : 'group-hover:scale-110 transition-transform' }}"></i>
                <span>Hackathons</span>
            </a>

            <a href="{{ route('grupos.index') }}" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg {{ request()->routeIs('grupos.index') ? 'bg-sidebar-hover text-white border-l-4 border-principal' : 'text-gray-300 hover:bg-sidebar-hover hover:text-white' }} transition-all group">
                <i class="fas fa-users w-6 text-center mr-3 {{ request()->routeIs('grupos.index') ? 'text-principal' : 'group-hover:scale-110 transition-transform' }}"></i>
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
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>
