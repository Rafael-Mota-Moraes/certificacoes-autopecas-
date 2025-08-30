@auth
<form action="{{ route('user.update') }}" method="POST">
    @csrf
    @method('PATCH')
    <div>
        <label for="name">Nome:</label>
        <input type="text" id="name" name="name" required>
    </div>
    <div>
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div>
        <label for="password">Senha:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <button type="submit">Entrar</button>
</form>

<form action="{{ route('user.toggle') }}" method="POST">
    @csrf
    @method('PATCH')
    <button type="submit">
        {{ Auth::user()->active ? 'Desativar' : 'Ativar' }}
    </button>
</form>
@endauth

@guest
    <p>Você precisa estar autenticado para acessar esta página. <a href="{{ route('login') }}">Entrar</a></p>
@endguest