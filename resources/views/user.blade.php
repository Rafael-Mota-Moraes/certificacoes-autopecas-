<form action="{{ route('user.register') }}" method="POST">
    @csrf
    <div>
        <label for="name">Nome:</label>
        <input type="text" id="name" name="name" required>
    </div>
    <div>
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div>
        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" required maxlength="14">
    </div>
    <div>
        <label for="password">Senha:</label>
        <input type="password" id="password" name="password" required>
    </div>
    <button type="submit">Cadastrar</button>
</form>