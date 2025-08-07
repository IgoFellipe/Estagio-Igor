<h1>Cadastro de Usuário</h1>

<form method="POST" action="{{ route('users.store') }}">
    @csrf

    Nome: <input type="text" name="name" required><br>
    Email: <input type="email" name="email" required><br>

    Tipo:
    <select name="tipo" id="tipo" required>
        <option value="aluno">Aluno</option>
        <option value="professor">Professor</option>
    </select><br>

    <div id="matricula-field">
        Matrícula: <input type="text" name="matricula" id="matricula"><br>
    </div>

    Senha: <input type="password" name="password" required><br>
    Confirmar senha: <input type="password" name="password_confirmation" required><br>

    <button type="submit">Cadastrar</button>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tipo = document.getElementById('tipo');
        const matriculaDiv = document.getElementById('matricula-field');
        const matriculaInput = document.getElementById('matricula');

        function toggleMatricula() {
            if (tipo.value === 'professor') {
                matriculaDiv.style.display = 'none';
                matriculaInput.removeAttribute('required');
                matriculaInput.value = '';
            } else {
                matriculaDiv.style.display = 'block';
                matriculaInput.setAttribute('required', 'required');
            }
        }

        tipo.addEventListener('change', toggleMatricula);
        toggleMatricula();
    });
</script>