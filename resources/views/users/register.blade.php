<h1>Cadastro de Aluno</h1>
<form method="POST" action="{{ route('register') }}">
    @csrf
    Nome: <input type="text" name="name" required><br>
    Email: <input type="email" name="email" required><br>
    Senha: <input type="password" name="password" required><br>
    Confirmar senha: <input type="password" name="password_confirmation" required><br>
    <input type="hidden" name="tipo" value="aluno">
    <button type="submit">Cadastrar</button>
</form>