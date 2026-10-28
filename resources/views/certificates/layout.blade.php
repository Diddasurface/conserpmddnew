<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Verificar certificado') | ConserpMDD</title>
    <style>
        :root { color-scheme: light; font-family: system-ui, sans-serif; color: #192235; background: #f3f5f8; }
        * { box-sizing: border-box; }
        body { margin: 0; }
        a { color: #173f85; }
        header { background: white; border-bottom: 1px solid #e0e5ed; }
        nav { max-width: 1080px; margin: auto; padding: 22px 24px; display: flex; justify-content: space-between; align-items: center; gap: 20px; flex-wrap: wrap; }
        .brand { font-size: 23px; font-weight: 800; text-decoration: none; color: #192235; }
        nav div { display: flex; gap: 24px; }
        main { max-width: 1080px; margin: 48px auto; padding: 0 24px; }
        .card { background: white; border: 1px solid #e0e5ed; border-radius: 16px; padding: 32px; margin-bottom: 24px; }
        .search-card { max-width: 700px; margin: 0 auto; }
        h1 { font-size: clamp(26px, 4vw, 36px); line-height: 1.2; margin: 12px 0 20px; overflow-wrap: anywhere; }
        h2 { font-size: 23px; }
        p { line-height: 1.65; }
        .muted { color: #526079; }
        .eyebrow { font-size: 12px; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: #526079; }
        label { display: block; font-weight: 600; margin: 24px 0 8px; }
        input { width: 100%; font: inherit; padding: 14px; border: 1px solid #9aa7ba; border-radius: 8px; }
        button, .button { display: inline-block; font: inherit; font-weight: 600; color: white; background: #173f85; border: 0; border-radius: 8px; padding: 14px 22px; cursor: pointer; text-decoration: none; margin-top: 16px; }
        .status { display: inline-block; border-radius: 32px; padding: 8px 16px; font-weight: 700; background: #edf0f5; }
        .valid { color: #155d39; background: #e3f5e9; }
        .revoked { color: #9a1d2c; background: #fde8ec; }
        .expired { color: #7b450a; background: #fff0d6; }
        dl { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 24px; margin: 32px 0; }
        dt { color: #526079; font-size: 14px; margin-bottom: 6px; }
        dd { margin: 0; font-weight: 600; overflow-wrap: anywhere; }
        .code { font-family: monospace; overflow-wrap: anywhere; }
        .evidence { display: block; width: 100%; height: auto; border: 1px solid #e0e5ed; border-radius: 8px; }
        .notes { white-space: pre-line; }
        .error { color: #9a1d2c; }
        footer { text-align: center; padding: 24px; color: #526079; font-size: 14px; }
        @media (max-width: 600px) { .card { padding: 22px; } main { padding: 0 16px; margin: 28px auto; } dl { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
    <header>
        <nav aria-label="Navegación de certificados">
            <a class="brand" href="{{ route('inicio') }}">ConserpMDD</a>
            <div><a href="{{ route('inicio') }}">Inicio</a><a href="{{ route('certificates.index') }}">Verificar certificado</a></div>
        </nav>
    </header>
    <main>@yield('content')</main>
    <footer>ConserpMDD · Verificación de certificados y constancias</footer>
</body>
</html>
