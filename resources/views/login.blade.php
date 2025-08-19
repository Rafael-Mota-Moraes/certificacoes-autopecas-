<form action="{{ route('user.login') }}" method="POST">
    @csrf
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