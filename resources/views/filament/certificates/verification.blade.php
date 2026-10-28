<div style="display: grid; gap: 16px;">
    <p>Código: <strong>{{ $certificate->code }}</strong></p>
    <label for="certificate-public-link">Enlace público para compartir</label>
    <input id="certificate-public-link" type="text" readonly value="{{ $certificate->verification_url }}"
        onclick="this.select()" style="width: 100%; border-radius: 8px; padding: 12px; color: #111827; background: #f3f4f6;">
    <img src="{{ route('admin.certificates.qr', ['certificate' => $certificate, 'format' => 'png', 'preview' => 1]) }}"
        alt="QR de verificación del certificado {{ $certificate->code }}" width="240" height="240" style="background: white;">
    <div style="display: flex; flex-wrap: wrap; gap: 16px;">
        <x-filament::button tag="a" :href="route('admin.certificates.qr', ['certificate' => $certificate, 'format' => 'png'])">Descargar PNG</x-filament::button>
        <x-filament::button tag="a" color="gray" :href="route('admin.certificates.qr', ['certificate' => $certificate, 'format' => 'svg'])">Descargar SVG para impresión</x-filament::button>
    </div>
    <p>El QR apunta a {{ config('certificates.public_url') }}. La verificación estará disponible allí cuando publiques la aplicación en ese dominio.</p>
    @if ($certificate->status === 'draft')
        <p>Este certificado es un borrador. Cambia el estado a Válido y guarda para habilitar su verificación pública.</p>
    @endif
</div>
