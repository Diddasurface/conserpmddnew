<?php

namespace App\Services;

use App\Models\Certificate;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Writer\Result\ResultInterface;
use Endroid\QrCode\Writer\Result\PngResult;
use Endroid\QrCode\Writer\Result\SvgResult;
use Endroid\QrCode\Writer\SvgWriter;

class CertificateQr
{
    public function generate(Certificate $certificate, string $format = 'png'): ResultInterface
    {
        $code = new QrCode(
            data: $certificate->verification_url,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 700,
            margin: 56,
        );

        $logo = new Logo(
            path: public_path('images/images/favicon.png'),
            resizeToWidth: 110,
            resizeToHeight: 110,
            punchoutBackground: true,
        );

        $result = ($format === 'svg' ? new SvgWriter : new PngWriter)->write($code, $logo);

        if ($result instanceof PngResult) {
            // Use solid white behind the transparent logo for predictable printing.
            $source = $result->getImage();
            $canvas = imagecreatetruecolor(imagesx($source), imagesy($source));
            imagefill($canvas, 0, 0, imagecolorallocate($canvas, 255, 255, 255));
            imagecopy($canvas, $source, 0, 0, 0, 0, imagesx($source), imagesy($source));
            $result = new PngResult($result->getMatrix(), $canvas);
        }

        if ($result instanceof SvgResult) {
            // The SVG writer does not implement the logo's punchoutBackground option.
            $root = dom_import_simplexml($result->getXml());
            $image = $root->getElementsByTagName('image')->item(0);
            $background = $root->ownerDocument->createElementNS('http://www.w3.org/2000/svg', 'rect');
            foreach (['x', 'y', 'width', 'height'] as $attribute) {
                $background->setAttribute($attribute, $image->getAttribute($attribute));
            }
            $background->setAttribute('fill', '#fff');
            $root->insertBefore($background, $image);
        }

        return $result;
    }
}
