@extends('certificates.layout')
@section('content')
    <section class="card search-card">
        <span class="eyebrow">Verificación de documentos</span>
        <h1>Verifica tu certificado</h1>
        <p class="muted">Ingresa el código de verificación que aparece en tu certificado o escanea su QR para consultar el registro emitido por ConserpMDD.</p>
        <form method="GET" action="{{ route('certificates.index') }}">
            <label for="code">Código del certificado</label>
            <input id="code" name="code" type="text" value="{{ old('code', request('code')) }}"
                placeholder="CMDD-…" maxlength="40" required autocomplete="off" spellcheck="false">
            @error('code')<p class="error">Ingresa un código válido, usando solo letras, números y guiones.</p>@enderror
            <button type="submit">Verificar certificado</button>
        </form>
    </section>
@endsection
