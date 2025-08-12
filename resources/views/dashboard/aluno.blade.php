<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard do Aluno</title>
    <!-- Incluindo Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Incluindo Font Awesome via CDN para os ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" xintegrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .hackathon-card {
            background: linear-gradient(135deg, #00aeffff 0%, #0d02e3ff 100%);
            transition: all 0.3s ease;
        }

        .hackathon-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .user-card {
            transition: all 0.3s ease;
        }

        .user-card:hover {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
    </style>
</head>

<body class="bg-gray-50 font-sans">
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 py-4 sm:px-6 lg:px-8 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900">Dashboard do Aluno</h1>
            <div class="flex items-center space-x-4">
                <span class="text-gray-600 hidden md:inline">Bem-vindo, {{ $user->name }}</span>
                <div class="h-8 w-8 rounded-full bg-indigo-500 flex items-center justify-center text-white font-bold">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 py-8 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2">
                <div class="hackathon-card rounded-xl p-6 text-white shadow-lg">
                    <div class="flex flex-col md:flex-row items-center">
                        <div class="w-full md:w-1/2 mb-6 md:mb-0 md:pr-6">
                            <h2 class="text-2xl font-bold mb-2">Participe dos nossos Hackathons</h2>
                            <p class="text-indigo-100 mb-6">Desafie-se, aprenda e construa projetos incríveis com outros alunos.</p>
                            <a href="/hackathons" class="inline-flex items-center px-6 py-3 bg-white text-indigo-600 font-medium rounded-lg hover:bg-gray-100 transition duration-300">
                                Acesse os Hackathons
                                <i class="fas fa-arrow-right ml-2"></i>
                            </a>
                        </div>
                        <div class="w-full md:w-1/2">
                            <img src="/image/hackathon.png" alt="Imagem do Hackathon" class="w-full h-auto object-cover rounded-lg">
                        </div>
                    </div>
                </div>

                <div class="mt-8 bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Atividades Recentes</h3>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                <i class="fas fa-book"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">HealthTech Disponivel</p>
                                <p class="text-sm text-gray-500">Novo Hackathon disponivel para inscrição</p>
                            </div>
                            <span class="ml-auto text-xs text-gray-500">2 dias atrás</span>
                        </div>
                        <div class="flex items-start">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 flex items-center justify-center text-green-600">
                                <i class="fas fa-trophy"></i>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-900">Hackathon concluído</p>
                                <p class="text-sm text-gray-500">Você terminou em 1º lugar</p>
                            </div>
                            <span class="ml-auto text-xs text-gray-500">1 semana atrás</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-1">
                <div class="user-card bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center mb-6">
                            <div class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600 text-2xl font-bold">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div class="ml-4">
                                <h3 class="text-lg font-semibold text-gray-900">{{ $user->name }}</h3>
                                <p class="text-sm text-gray-500">Aluno</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Email</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $user->email }}</p>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider">Matrícula</label>
                                <p class="mt-1 text-sm text-gray-900">{{ $user->matricula }}</p>
                            </div>
                        </div>

                        <div class="mt-8 pt-5 border-t border-gray-200">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-300">
                                    <i class="fas fa-sign-out-alt mr-2"></i>
                                    Sair
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="mt-6 bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Links Rápidos</h3>
                    <ul class="space-y-3">
                        <li>
                            <a href="#" class="flex items-center text-indigo-600 hover:text-indigo-800">
                                <i class="fas fa-book-open mr-3"></i>
                                Meus hackathons
                            </a>
                        </li>
                        <li>
                            <a href="#" class="flex items-center text-indigo-600 hover:text-indigo-800">
                                <i class="fas fa-calendar-alt mr-3"></i>
                                Confirmar presença
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </main>

    <div class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200">
        <div class="flex justify-around">
            <a href="#" class="flex flex-col items-center justify-center p-3 text-indigo-600">
                <i class="fas fa-home"></i>
                <span class="text-xs mt-1">Início</span>
            </a>
            <a href="#" class="flex flex-col items-center justify-center p-3 text-gray-500">
                <i class="fas fa-book"></i>
                <span class="text-xs mt-1">Cursos</span>
            </a>
            <a href="/hackathons" class="flex flex-col items-center justify-center p-3 text-gray-500">
                <i class="fas fa-laptop-code"></i>
                <span class="text-xs mt-1">Hackathons</span>
            </a>
            <a href="#" class="flex flex-col items-center justify-center p-3 text-gray-500">
                <i class="fas fa-user"></i>
                <span class="text-xs mt-1">Perfil</span>
            </a>
        </div>
    </div>
</body>

</html>