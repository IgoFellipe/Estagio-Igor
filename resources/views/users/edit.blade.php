<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Editar Usuário</title>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
</head>

<body>
    <div id="app">
        <h1>Editar Usuário</h1>

        <form method="POST" action="{{ route('users.update', $user->id) }}">
            @csrf
            @method('PUT')

            <label>Nome:</label>
            <input type="text" name="name" value="{{ $user->name }}" required><br>

            <label>Email:</label>
            <input type="email" name="email" value="{{ $user->email }}" required><br>

            <label>Tipo:</label>
            <select name="tipo" v-model="tipo" required>
                <option value="aluno">Aluno</option>
                <option value="professor">Professor</option>
            </select><br>

            <div v-if="tipo === 'aluno'">
                <label>Matrícula:</label>
                <input type="text" name="matricula" value="{{ $user->matricula }}" required><br>
            </div>

            <label>Nova Senha (opcional):</label>
            <input type="password" name="password"><br>

            <label>Confirmar nova senha:</label>
            <input type="password" name="password_confirmation"><br>

            <button type="submit">Salvar alterações</button>
        </form>
    </div>

    <script>
        const {
            createApp,
            ref
        } = Vue;
        createApp({
            setup() {
                const tipo = ref('{{ old(',
                    tipo, ', $user->tipo) }}');
                return {
                    tipo
                };
            }
        }).mount('#app');
    </script>
</body>

</html>