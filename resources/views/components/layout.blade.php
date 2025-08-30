<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? 'Certificar' }}</title>

    <link href="{{ asset('css/global.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    @stack('styles')

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            margin: 0;
        }

        main.container {
            flex: 1;
            padding: 2rem 1rem;
        }
    </style>
</head>

<body>

    <x-header />

    <main class="container">
        {{ $slot }}
    </main>

    <x-footer />

    @stack('scripts')
</body>

</html>
