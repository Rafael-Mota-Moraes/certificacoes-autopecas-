<header class="main-header">
    <div class="container">
        <a href="/" class="logo">Minha Aplicação</a>
        <nav>
            <ul>
                <li><a href="/">Home</a></li>
                @auth
                    <li><a href="{{ route('user.update') }}">Meu Perfil</a></li>
                    <li>
                        {{-- <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">Sair</button>
                        </form> --}}
                    </li>
                @else
                    <li><a href="{{ route('login') }}">Entrar</a></li>
                    <li><a href="{{ route('user.register') }}">Cadastrar</a></li>
                @endauth
            </ul>
        </nav>
    </div>
</header>

@once
    @push('styles')
        <style>
            .main-header {
                background-color: --var(--primary-red);
                padding: 1rem 0;
                border-bottom: 1px solid #e7e7e7;
            }

            .main-header .container {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            .main-header .logo {
                font-weight: bold;
                text-decoration: none;
                color: #333;
            }

            .main-header nav ul {
                list-style: none;
                margin: 0;
                padding: 0;
                display: flex;
                gap: 1rem;
            }
        </style>
    @endpush
@endonce
