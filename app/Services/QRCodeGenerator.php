<?php
/**
 * Author: Xavier Au
 * Date: 11/8/2017
 * Time: 1:52 PM
 */

namespace App\Services;


use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\QrCode;

class QRCodeGenerator
{
    public function create(string $message, string $label) {

        $size = 400;
        $logoSize = 250;

        $qrCode = $this->setQrCode($message, $label, $size, $logoSize);

        return $qrCode;
    }

    private function setQrCode(string $message, string $label, int $size, int $logoSize) {

        $qrCode = new QrCode($message);

        $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::HIGH)->setSize($size)->setForegroundColor([
            'r' => 0,
            'g' => 0,
            'b' => 0
        ])->setBackgroundColor([
            'r' => 255,
            'g' => 255,
            'b' => 255
        ])->setLabel($label, 24, public_path("fonts/brandontext_regular-webfont.ttf"), LabelAlignment::CENTER)
               ->setLogoPath(public_path("files/logo.jpg"))->setLogoWidth($logoSize)->setValidateResult(true);

        return $qrCode;
    }
}