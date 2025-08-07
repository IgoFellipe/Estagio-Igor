<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>

    <link rel="stylesheet" href="/css/app.css">
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
</head>
<body>
    <div id="app">
        <div class="login-box">
            <h2>Login</h2>

            @if ($errors->any())
                <div class="error-message">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
    @csrf

    <input type="hidden" name="_token" :value="csrf">

    <label>Email:</label>
    <input type="email" name="email" required>

    <label>Senha:</label>
    <input type="password" name="password" required>

    <label>Tipo:</label>
    <select name="tipo" v-model="tipo" required>
        <option value="aluno">Aluno</option>
        <option value="professor">Professor</option>
    </select>

    <div v-if="tipo === 'aluno'">
        <label>Matrícula:</label>
        <input type="text" name="matricula" v-model="matricula">
    </div>

    <button type="submit">Entrar</button>
</form>

            <a href="{{ route('register') }}">Não tem conta? Cadastre-se</a>
        </div>
    </div>

    <div class="overlay"></div>

<script>
    const { createApp, ref } = Vue;

    createApp({
        setup() {
            const tipo = ref('aluno');
            const matricula = ref('');
            const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            return { tipo, matricula, csrf };
        }
    }).mount('#app');
</script>

</body>
</html>
