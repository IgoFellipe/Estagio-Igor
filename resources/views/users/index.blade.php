<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Gerenciamento de Usuários (ADM)</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" xintegrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-gray-50 font-sans p-8">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-xl shadow-2xl p-8">
            <!-- Header da Tela Principal -->
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-900 mb-4 md:mb-0">Gerenciar Usuários</h1>
                <button id="open-create-modal" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-300">
                    <i class="fas fa-plus-circle mr-2"></i>
                    Cadastrar Novo Usuário
                </button>
            </div>

            <!-- Mensagem de Sucesso -->
            @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md mb-4">
                <p>{{ session('success') }}</p>
            </div>
            @endif

            <!-- Formulário de Filtro -->
            <form method="GET" action="{{ route('users.index') }}" class="mb-6">
                <div class="flex items-center space-x-4">
                    <label for="filtro" class="text-sm font-medium text-gray-700">Filtrar por tipo:</label>
                    <select name="filtro" onchange="this.form.submit()" class="mt-1 block w-full md:w-auto px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Todos</option>
                        <option value="aluno" {{ request('filtro') == 'aluno' ? 'selected' : '' }}>Alunos</option>
                        <option value="professor" {{ request('filtro') == 'professor' ? 'selected' : '' }}>Professores</option>
                        <option value="adm" {{ request('filtro') == 'adm' ? 'selected' : '' }}>Administradores</option>
                    </select>
                </div>
            </form>

            <!-- Tabela de Usuários -->
            <div class="overflow-x-auto bg-gray-50 rounded-lg shadow-sm">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-200">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nome
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Matrícula
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tipo
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                {{ $user->id }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->name }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->matricula }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ ucfirst($user->tipo) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button onclick="openEditModal(`{{ $user->id }}`, `{{ addslashes($user->name) }}`, `{{ addslashes($user->email) }}`, `{{ addslashes($user->matricula) }}`, `{{ $user->tipo }}`)" class="text-indigo-600 hover:text-indigo-900 mr-4">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Tem certeza que deseja excluir este usuário?');">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal de Cadastro de Usuário -->
    <div id="create-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <h3 class="text-lg font-bold mb-4">Cadastrar Novo Usuário</h3>
            <form method="POST" action="{{ route('users.store') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="create_name" class="block text-sm font-medium text-gray-700">Nome:</label>
                    <input type="text" name="name" id="create_name" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="create_email" class="block text-sm font-medium text-gray-700">Email:</label>
                    <input type="email" name="email" id="create_email" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="create_tipo" class="block text-sm font-medium text-gray-700">Tipo:</label>
                    <select name="tipo" id="create_tipo" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                        <option value="aluno">Aluno</option>
                        <option value="professor">Professor</option>
                        <option value="adm">Administrador</option>
                    </select>
                </div>
                <div id="create_matricula_container">
                    <label for="create_matricula" class="block text-sm font-medium text-gray-700">Matrícula:</label>
                    <input type="text" name="matricula" id="create_matricula" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="create_password" class="block text-sm font-medium text-gray-700">Senha:</label>
                    <input type="password" name="password" id="create_password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="create_password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Senha:</label>
                    <input type="password" name="password_confirmation" id="create_password_confirmation" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="flex justify-end space-x-4 mt-4">
                    <button type="button" onclick="closeModal('create-modal')" class="py-2 px-4 bg-gray-500 text-white rounded-md hover:bg-gray-700">Cancelar</button>
                    <button type="submit" class="py-2 px-4 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de Edição de Usuário -->
    <div id="edit-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <h3 class="text-lg font-bold mb-4">Editar Usuário</h3>
            <form id="edit-form" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label for="edit_name" class="block text-sm font-medium text-gray-700">Nome:</label>
                    <input type="text" name="name" id="edit_name" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="edit_email" class="block text-sm font-medium text-gray-700">Email:</label>
                    <input type="email" name="email" id="edit_email" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="edit_tipo" class="block text-sm font-medium text-gray-700">Tipo:</label>
                    <select name="tipo" id="edit_tipo" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                        <option value="aluno">Aluno</option>
                        <option value="professor">Professor</option>
                        <option value="adm">Administrador</option>
                    </select>
                </div>
                <div id="edit_matricula_container" class="hidden">
                    <label for="edit_matricula" class="block text-sm font-medium text-gray-700">Matrícula:</label>
                    <input type="text" name="matricula" id="edit_matricula" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="edit_password" class="block text-sm font-medium text-gray-700">Nova Senha (opcional):</label>
                    <input type="password" name="password" id="edit_password" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                </div>
                <div>
                    <label for="edit_password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar nova senha:</label>
                    <input type="password" name="password_confirmation" id="edit_password_confirmation" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm">
                </div>
                <div class="flex justify-end space-x-4 mt-4">
                    <button type="button" onclick="closeModal('edit-modal')" class="py-2 px-4 bg-gray-500 text-white rounded-md hover:bg-gray-700">Cancelar</button>
                    <button type="submit" class="py-2 px-4 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Salvar alterações</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        document.getElementById('open-create-modal').addEventListener('click', function() {
            openModal('create-modal');
        });

        // Toggle do campo de matrícula para o modal de criação
        document.getElementById('create_tipo').addEventListener('change', function(e) {
            const matriculaContainer = document.getElementById('create_matricula_container');
            const matriculaInput = document.getElementById('create_matricula');
            if (e.target.value === 'aluno') {
                matriculaContainer.classList.remove('hidden');
                matriculaInput.required = true;
            } else {
                matriculaContainer.classList.add('hidden');
                matriculaInput.required = false;
            }
        });

        // Toggle do campo de matrícula para o modal de edição
        document.getElementById('edit_tipo').addEventListener('change', function(e) {
            const matriculaContainer = document.getElementById('edit_matricula_container');
            const matriculaInput = document.getElementById('edit_matricula');
            if (e.target.value === 'aluno') {
                matriculaContainer.classList.remove('hidden');
                matriculaInput.required = true;
            } else {
                matriculaContainer.classList.add('hidden');
                matriculaInput.required = false;
            }
        });

        function openEditModal(id, name, email, matricula, tipo) {
            const editModal = document.getElementById('edit-modal');
            const editForm = document.getElementById('edit-form');
            editForm.action = `/users/${id}`;

            document.getElementById('edit_name').value = name;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_matricula').value = matricula;
            document.getElementById('edit_tipo').value = tipo;

            // Ativa o evento de change para garantir que a matrícula seja exibida
            const event = new Event('change');
            document.getElementById('edit_tipo').dispatchEvent(event);

            openModal('edit-modal');
        }
    </script>
</body>

</html>