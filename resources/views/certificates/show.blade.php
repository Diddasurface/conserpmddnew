@extends('certificates.layout')
@section('title', $certificate ? 'Certificado '.$certificate->code : 'Certificado no encontrado')
@section('content')
    @if ($certificate)
        <section class="card certificate-summary">
            <div class="certificate-heading">
                <div>
                    <span class="eyebrow">Verificación de certificado</span>
                    <h1>{{ $certificate->training_title }}</h1>
                </div>
                <span class="status {{ $certificate->verification_status }}">{{ $certificate->status_label }}</span>
            </div>
            @if ($certificate->verification_status === 'valid')
                <p>Este certificado está registrado como válido por ConserpMDD.</p>
            @elseif ($certificate->verification_status === 'revoked')
                <p class="error"><strong>Este certificado fue revocado por ConserpMDD y ya no es válido.</strong></p>
            @else
                <p><strong>Este certificado ha superado su fecha de vencimiento.</strong></p>
            @endif
            <dl>
                <div><dt>Código de verificación</dt><dd class="code">{{ $certificate->code }}</dd></div>
                <div><dt>Fecha de emisión</dt><dd>{{ $certificate->issued_at->format('d/m/Y') }}</dd></div>
                <div><dt>Fecha de vencimiento</dt><dd>{{ $certificate->expires_at?->format('d/m/Y') ?? 'Sin vencimiento registrado' }}</dd></div>
                @if ($certificate->hours !== null)
                    <div><dt>Duración</dt><dd>{{ number_format($certificate->hours, 2, ',', '.') }} horas</dd></div>
                @endif
                <div><dt>Entidad emisora</dt><dd>ConserpMDD</dd></div>
            </dl>
            @if ($certificate->public_notes)
                <div class="observations"><h2>Observaciones</h2><p class="notes">{{ $certificate->public_notes }}</p></div>
            @endif
        </section>
        <section class="card">
            <h2>Documento de respaldo</h2>
            <p class="muted">Consulta el documento y su lista de participantes para comprobar la participación en esta capacitación.</p>
            @if ($certificate->evidence_is_pdf)
                <div class="document-actions">
                    <a class="button" href="{{ route('certificates.evidence', ['code' => $certificate->code]) }}" target="_blank" rel="noopener">Abrir PDF</a>
                    <a href="{{ route('certificates.evidence', ['code' => $certificate->code, 'download' => 1]) }}">Descargar PDF</a>
                </div>
                <div class="pdf-viewer" data-certificate-pdf
                    data-source="{{ route('certificates.evidence', ['code' => $certificate->code]) }}"
                    data-library-url="{{ asset('vendor/pdfjs/pdf.min.mjs') }}"
                    data-worker-url="{{ asset('vendor/pdfjs/pdf.worker.min.mjs') }}"
                    data-cmap-url="{{ asset('vendor/pdfjs/cmaps') }}/"
                    data-font-url="{{ asset('vendor/pdfjs/standard_fonts') }}/"
                    data-wasm-url="{{ asset('vendor/pdfjs/wasm') }}/" aria-busy="true">
                    <div class="pdf-toolbar" role="group" aria-label="Controles del documento PDF">
                        <button type="button" data-pdf-previous disabled>Anterior</button>
                        <span data-pdf-counter aria-live="polite">PDF</span>
                        <button type="button" data-pdf-next disabled>Siguiente</button>
                        <button type="button" data-pdf-zoom-out aria-label="Reducir zoom" disabled>−</button>
                        <button type="button" data-pdf-zoom-in aria-label="Ampliar zoom" disabled>+</button>
                        <button type="button" data-pdf-fit disabled>Ajustar</button>
                    </div>
                    <p class="pdf-status" data-pdf-status role="status">Cargando documento…</p>
                    <div class="pdf-viewport" data-pdf-viewport>
                        <canvas hidden role="img" aria-label="Documento de respaldo de la capacitación {{ $certificate->training_title }}"></canvas>
                    </div>
                    <noscript><p>Activa JavaScript para ver el documento aquí o utiliza Abrir PDF.</p></noscript>
                </div>
                @push('scripts')
                    <script type="module" src="{{ asset('js/certificate-pdf.js') }}?v=1"></script>
                @endpush
            @else
                <a href="{{ route('certificates.evidence', ['code' => $certificate->code]) }}" target="_blank" rel="noopener">
                    <img class="evidence" src="{{ route('certificates.evidence', ['code' => $certificate->code]) }}"
                        alt="Documento de respaldo del certificado {{ $certificate->code }}" loading="lazy">
                </a>
            @endif
        </section>
    @else
        <section class="card search-card">
            <span class="eyebrow">Verificación de documentos</span>
            <h1>Certificado no encontrado</h1>
            <p>No hay un certificado publicado con este código. Comprueba el código impreso o comunícate con ConserpMDD.</p>
            <a class="button" href="{{ route('certificates.index') }}">Consultar otro código</a>
            <p><a href="{{ route('contactanos') }}">Contactar con ConserpMDD</a></p>
        </section>
    @endif
@endsection
