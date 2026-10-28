<?php

namespace App\Services;

use App\Models\Certificate;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\Result\ResultInterface;
use Endroid\QrCode\Writer\SvgWriter;

class CertificateQr
{
    public function generate(Certificate $certificate, string $format = 'png'): ResultInterface
    {
        $code = new QrCode(
            data: $certificate->verification_url,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::Medium,
            size: 700,
            margin: 32,
        );

        return ($format === 'svg' ? new SvgWriter : new PngWriter)->write($code);
    }
}
