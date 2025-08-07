<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registro</title>

    <link rel="stylesheet" href="/css/app.css">
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
</head>
<body>
    <div id="app">
        <div class="register-box">
            <h2>Cadastro</h2>

            @if ($errors->any())
                <div class="error-message">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <input type="hidden" name="_token" :value="csrf">

                <label>Nome:</label>
                <input type="text" name="name" required>

                <label>Matrícula:</label>
                <input type="text" name="matricula" required>

                <label>Email:</label>
                <input type="email" name="email" required>

                <label>Senha:</label>
                <input type="password" name="password" required>

                <label>Confirmar Senha:</label>
                <input type="password" name="password_confirmation" required>

                <button type="submit">Registrar</button>
            </form>

            <a href="{{ route('login') }}">Já tem conta? Faça login</a>
        </div>
    </div>

    <div class="overlay"></div>

    <script>
        const { createApp } = Vue;
        createApp({
            setup() {
                const csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                return { csrf };
            }
        }).mount('#app');
    </script>
</body>
</html>
