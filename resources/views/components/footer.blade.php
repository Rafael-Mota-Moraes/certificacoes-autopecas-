<footer class="main-footer">
    <div class="container">
        <p>&copy; {{ date('Y') }} Minha Aplicação. Todos os direitos reservados.</p>
    </div>
</footer>

@once
    @push('styles')
    <style>
        .main-footer {
            background-color: #343a40;
            color: white;
            padding: 1.5rem 0;
            text-align: center;
            margin-top: auto; 
        }
    </style>
    @endpush
@endonce