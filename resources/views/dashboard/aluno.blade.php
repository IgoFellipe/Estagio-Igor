<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard do Aluno</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/dashboard_aluno.css') }}">
</head>

<body class="font-sans" style="background-color: var(--cor-fundo);">
    <div class="flex h-screen bg-gray-100">

        <aside class="bg-sidebar text-white w-64 space-y-2 py-4 absolute inset-y-0 left-0 transform -translate-x-full lg:relative lg:translate-x-0 transition duration-200 ease-in-out z-30">
            <a href="#" class="text-white flex items-center justify-center px-6 py-4">
                <img src="{{ asset('image/Simplifi(K)athon.png') }}" alt="Logo SimplifiKathon" class="h-12">
            </a>

            <div class="px-6 py-4 border-t border-b border-gray-700">
                <div class="flex items-center">
                    <div class="h-12 w-12 rounded-full bg-principal flex items-center justify-center text-white font-bold text-xl">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-semibold">{{ $user->name }}</p>
                        <p class="text-xs text-gray-400">Aluno</p>
                    </div>
                </div>
            </div>

            <nav class="px-2">
                <a href="#" class="sidebar-link active">
                    <i class="fas fa-home"></i>
                    <span>Início</span>
                </a>
                <a href="/hackathons" class="sidebar-link">
                    <i class="fas fa-laptop-code"></i>
                    <span>Hackathons</span>
                </a>
                <a href="#" class="sidebar-link">
                    <i class="fas fa-users"></i>
                    <span>Meus Grupos</span>
                </a>
                <a href="#" class="sidebar-link">
                    <i class="fas fa-user-circle"></i>
                    <span>Meu Perfil</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="w-full text-left sidebar-link">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Sair</span>
                    </button>
                </form>
            </nav>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-principal shadow-md">
                <div class="max-w-full mx-auto px-4 py-4 sm:px-6 lg:px-8 flex justify-between items-center">
                    <button class="text-white lg:hidden">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                    <h1 class="text-2xl font-bold text-white">Dashboard</h1>
                    <div class="h-8 w-8 rounded-full bg-white flex items-center justify-center text-principal font-bold lg:hidden">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto p-6">
                <div class="hackathon-card rounded-xl p-8 text-white shadow-lg mb-8">
                    <div class="flex flex-col md:flex-row items-center justify-between">
                        <div class="md:w-1/2 mb-6 md:mb-0">
                            <h2 class="text-3xl font-bold mb-2">Participe dos nossos Hackathons</h2>
                            <p class="opacity-90 mb-8">Desafie-se, aprenda e construa projetos incríveis com outros alunos.</p>
                            <a href="/hackathons" class="btn-destaque inline-flex items-center px-8 py-4 bg-white text-blue-600 font-bold text-lg rounded-lg hover:bg-gray-100 transition duration-300 transform hover:scale-105">
                                Acesse os Hackathons
                                <i class="fas fa-arrow-right ml-3"></i>
                            </a>
                        </div>
                        <div class="md:w-2/5">
                            <img src="{{ asset('image/hackathon.png') }}" alt="Imagem do Hackathon" class="w-full h-auto object-cover rounded-lg">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800">Atividades Recentes</h3>
                        <div class="space-y-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-orange-100 flex items-center justify-center text-principal"><i class="fas fa-book"></i></div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">HealthTech Disponivel</p>
                                    <p class="text-sm text-gray-600">Novo Hackathon disponivel para inscrição</p>
                                </div>
                                <span class="ml-auto text-xs text-gray-500">2 dias atrás</span>
                            </div>
                            <div class="flex items-start">
                                <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-600"><i class="fas fa-trophy"></i></div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">Hackathon concluído</p>
                                    <p class="text-sm text-gray-600">Você terminou em 1º lugar</p>
                                </div>
                                <span class="ml-auto text-xs text-gray-500">1 semana atrás</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h3 class="text-lg font-semibold mb-4 text-gray-800">Links Rápidos</h3>
                        <ul class="space-y-3">
                            <li><a href="#" class="flex items-center text-principal hover:underline"><i class="fas fa-book-open mr-3"></i>Meus hackathons</a></li>
                            <li><a href="#" class="flex items-center text-principal hover:underline"><i class="fas fa-calendar-alt mr-3"></i>Confirmar presença</a></li>
                        </ul>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>