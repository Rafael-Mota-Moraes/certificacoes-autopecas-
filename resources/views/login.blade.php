<form action="{{ route('user.auth') }}" method="POST">
    @csrf
    <div>
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div>
        <label for="password">Senha:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <div>
        <label for="forgot-password">
            <a href="{{ route('password.request') }}">Esqueceu sua senha?</a>
        </label>
    </div>
    <button type="submit">Entrar</button>
</form>
