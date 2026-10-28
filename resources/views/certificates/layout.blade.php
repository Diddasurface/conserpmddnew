<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Verificar certificado') | ConserpMDD</title>
    <link rel="icon" type="image/png" href="{{ asset('images/images/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/euclid-circulara.css') }}">
    <link rel="stylesheet" href="{{ asset('css/certificates.css') }}?v=2">
</head>
<body>
    <header>
        <nav aria-label="Navegación de certificados">
            <a class="brand" href="{{ route('inicio') }}"><img src="{{ asset('images/images/favicon.png') }}" alt="" width="32" height="32">ConserpMDD</a>
            <div><a href="{{ route('inicio') }}">Inicio</a><a href="{{ route('certificates.index') }}">Verificar certificado</a></div>
        </nav>
    </header>
    <main>@yield('content')</main>
    <footer>ConserpMDD · Verificación de certificados y constancias</footer>
</body>
</html>
