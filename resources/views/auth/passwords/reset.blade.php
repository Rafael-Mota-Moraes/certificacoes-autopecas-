<h1>Cadastre sua nova senha</h1>

<form method="POST" action="{{ route('password.update') }}">
    @csrf

    <input type="hidden" name="token" value="{{ $token }}">

    <div>
        <label for="email">E-mail</label>
        <input type="email" name="email" id="email" value="{{ $email ?? old('email') }}" required autofocus>
    </div>

    <div>
        <label for="password">Nova Senha</label>
        <input type="password" name="password" id="password" required>
    </div>

    <div>
        <label for="password_confirmation">Confirmar Nova Senha</label>
        <input type="password" name="password_confirmation" id="password_confirmation" required>
    </div>

    <div>
        <button type="submit">Redefinir Senha</button>
    </div>
</form>
