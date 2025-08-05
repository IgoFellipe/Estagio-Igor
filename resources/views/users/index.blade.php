<h1>Lista de Alunos e Professores</h1>
<a href="{{ route('users.create') }}">Novo Cadastro</a>
<form method="GET" action="{{ route('users.index') }}">
    <label for="filtro">Filtrar por tipo:</label>
    <select name="filtro" onchange="this.form.submit()">
        <option value="">Todos</option>
        <option value="aluno" {{ request('filtro') == 'aluno' ? 'selected' : '' }}>Alunos</option>
        <option value="professor" {{ request('filtro') == 'professor' ? 'selected' : '' }}>Professores</option>
    </select>
</form>
@if (session('success'))
    <p>{{ session('success') }}</p>
@endif
<ul>
    @foreach ($users as $user)
        <li>
            #{{ $user->id }} - {{ $user->name }} ({{ $user->email }} / {{ $user->matricula }} / <strong>{{ ucfirst($user->tipo) }}</strong>)
            <a href="{{ route('users.edit', $user) }}">Editar</a>
            <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit">Excluir</button>
            </form>
        </li>
    @endforeach