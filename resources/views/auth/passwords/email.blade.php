<h1>Esqueceu sua senha?</h1>
<p>Sem problemas. Informe seu e-mail e enviaremos um link para você cadastrar uma nova senha.</p>

@if (session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf
    <div>
        <label for="email">E-mail</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus>
    </div>
    <div>
        <button type="submit">Enviar Link de Redefinição</button>
    </div>
</form>
