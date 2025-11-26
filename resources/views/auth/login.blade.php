<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            background: url('/img/img_fundo.webp') no-repeat center center fixed;
            background-size: cover;
        }
    </style>
</head>

<body class="flex items-center justify-center min-h-screen font-sans text-gray-800">
    <div id="app" class="bg-white bg-opacity-90 backdrop-filter backdrop-blur-lg rounded-xl shadow-2xl p-8 max-w-sm w-full mx-4">
        <h2 class="text-3xl font-bold text-center text-gray-900 mb-6">Login</h2>

        @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md mb-4">
            <p>{{ session('error') }}</p>
        </div>
        @endif

        @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md mb-4">
            @foreach ($errors->all() as $error)
            <p class="text-sm">{{ $error }}</p>
            @endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="_token" :value="csrf">

            <div>
                <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo:</label>
                <select name="tipo" id="tipo" v-model="tipo" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="aluno">Aluno</option>
                    <option value="professor">Professor</option>
                    <option value="adm">Administrador</option>
                </select>
            </div>

            <div v-if="tipo === 'aluno' || tipo === 'professor'">
                <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
                <input type="email" name="email" id="email" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div v-if="tipo === 'adm'">
                <label for="name" class="block text-sm font-medium text-gray-700">Nome:</label>
                <input type="text" name="name" id="name" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Senha:</label>
                <input type="password" name="password" id="password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div v-if="tipo === 'aluno'">
                <label for="matricula" class="block text-sm font-medium text-gray-700">Matrícula:</label>
                <input type="text" name="matricula" id="matricula" v-model="matricula" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-300">
                Entrar
            </button>
        </form>

        <p class="mt-4 text-center text-sm">
            Não tem conta? <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Cadastre-se</a>
        </p>
    </div>

    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script>
        const {
            createApp,
            ref
        } = Vue;

        createApp({
            setup() {
                const tipo = ref('aluno');
                const matricula = ref('');
                const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                return {
                    tipo,
                    matricula,
                    csrf
                };
            }
        }).mount('#app');
    </script>
</body>

</html>