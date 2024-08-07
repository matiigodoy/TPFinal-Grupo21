<?php

include_once('vendor/phpqrcode-master/qrlib.php');

class QrCreator
{
    public static function createQrCode($data, $filePath)
    {
        $qrCode = new QRcode();
        $qrCode::png($data, $filePath, QR_ECLEVEL_L, 10, 2);
    }

    public function createQr($id, $username){
        $uploadDir = __DIR__ . '/../public/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $filename = $uploadDir . $id . '.png';

        $tamanio = 10;
        $level = "M";
        $frameSize = 3;

        $baseURL = "http://$_SERVER[HTTP_HOST]";
        $path = "/user/getUserProfile?id=";
        $url = $baseURL . $path . $id;

        $contenido = $url;

        QRcode::png($contenido, $filename, $level, $tamanio, $frameSize);

        $relativePath = '/public/' . $id . '.png';

        return $relativePath;
    }
}




