<!DOCTYPE_HTML>
<html>
<head>
    <title>Cadastro de Revenda</title>
</head>
<body>
    <form action="/reseller_insert" method="POST">
        @csrf
        <br><label for="reseller_name">*Razão Social:</label><br>
        <input type="text" id="reseller_name" name="reseller_name" required>
        <br><label for="cnpj">*CNPJ:</label><br>
        <input type="text" id="cnpj" name="cnpj" required>
        <br><label for="cep">*CEP:</label><br>
        <input type="number" id="cep" name="cep" required>
        <br><label for="city">*Cidade:</label><br>
        <input type="text" id="city" name="city" required>
        <br><label for="street">*Rua:</label><br>
        <input type="text" id="street" name="street" required>
        <br><label for="number">*Número:</label><br>
        <input type="number" id="number" name="number" required>
        <h4>Contato:</h4>
        <br><label for="phone">Celular:</label><br>
        <input type="number" id="phone" name="phone">
        <br><label for="email">Email:</label><br>
        <input type="email" id="email" name="email" @error('email')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror>

        <br>
        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>
