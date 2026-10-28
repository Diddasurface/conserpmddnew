<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Services\CertificateQr;
use Filament\Facades\Filament;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CertificateController extends Controller
{
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), ['code' => ['nullable', 'string', 'max:40', 'regex:/^[A-Za-z0-9-]+$/']]);
        if ($validator->fails()) {
            return redirect()->route('certificates.index')->withErrors($validator)->withInput();
        }
        $data = $validator->validated();
        if (!empty($data['code'])) {
            return redirect()->route('certificates.show', ['code' => strtoupper($data['code'])]);
        }

        return response()->view('certificates.index')->header('Cache-Control', 'no-store');
    }

    public function show(string $code)
    {
        $certificate = Certificate::publiclyVisible()->where('code', strtoupper($code))->first();

        return response()->view('certificates.show', compact('certificate'), $certificate ? 200 : 404)
            ->header('Cache-Control', 'no-store, private')
            ->header('X-Robots-Tag', 'noindex, nofollow');
    }

    public function evidence(Request $request, string $code)
    {
        $certificate = Certificate::publiclyVisible()->where('code', strtoupper($code))->firstOrFail();

        return $this->documentResponse($certificate, $request->boolean('download'));
    }

    public function adminEvidence(Request $request, Certificate $certificate)
    {
        $this->authorizeAdmin($request);

        return $this->documentResponse($certificate, $request->boolean('download'));
    }

    public function qr(Request $request, Certificate $certificate, string $format, CertificateQr $qr)
    {
        $this->authorizeAdmin($request);
        abort_unless(in_array($format, ['png', 'svg'], true), 404);
        $result = $qr->generate($certificate, $format);

        return response($result->getString())
            ->header('Content-Type', $result->getMimeType())
            ->header('Content-Disposition', ($request->boolean('preview') ? 'inline' : 'attachment').'; filename="QR-'.$certificate->code.'.'.$format.'"')
            ->header('Cache-Control', 'no-store, private');
    }

    private function authorizeAdmin(Request $request): void
    {
        $user = $request->user();
        abort_unless($user && ($user instanceof FilamentUser
            ? $user->canAccessPanel(Filament::getPanel('admin'))
            : config('app.env') === 'local'), 403);
    }

    private function documentResponse(Certificate $certificate, bool $download = false)
    {
        $disk = Storage::disk('local');
        $path = $certificate->evidence_image;
        abort_unless(str_starts_with($path, 'certificates/evidence/') && !str_contains($path, '..') && $disk->exists($path), 404);
        $mimeType = $disk->mimeType($path);
        abort_unless(in_array($mimeType, Certificate::EVIDENCE_MIME_TYPES, true), 404);
        $extension = match ($mimeType) {
            'application/pdf' => 'pdf', 'image/png' => 'png', 'image/webp' => 'webp', default => 'jpg',
        };

        return $disk->response($path, 'comprobante-'.$certificate->code.'.'.$extension, [
            'Cache-Control' => 'no-store, private',
            'X-Content-Type-Options' => 'nosniff',
            'X-Robots-Tag' => 'noindex, nofollow',
        ], $download ? 'attachment' : 'inline');
    }
}
