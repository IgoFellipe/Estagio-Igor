<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard do Aluno</title>
    <style>
        body {
            font-family: sans-serif;
            padding: 20px;
            background-color: #f4f4f4;
        }

        .dashboard-container {
            max-width: 800px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .logout-btn {
            background-color: #f44336;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
    </style>
</head>

<body>

    <div class="dashboard-container">
        <h1>Olá, {{ $user->name }}!</h1>

        <p>Bem-vindo ao seu painel.</p>

        <h3>Suas Informações:</h3>
        <ul>
            <li><strong>Nome:</strong> {{ $user->name }}</li>
            <li><strong>Email:</strong> {{ $user->email }}</li>
            <li><strong>Matrícula:</strong> {{ $user->matricula }}</li>
        </ul>

        <hr style="margin: 20px 0;">

        {{-- Formulário de Logout --}}
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">Sair</button>
        </form>
    </div>

</body>

</html>