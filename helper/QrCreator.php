<?php

class QrCreator
{
    public static function createQrCode($data, $filePath)
    {
        $qrCode = new QRcode();
        $qrCode::png($data, $filePath, QR_ECLEVEL_L, 10, 2);
    }

    public function createQr($id, $username){
        $uploadDir = '../public/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $filename = $uploadDir . $id . '.png';

        $tamanio = 10;
        $level = "M";
        $frameSize = 3;
        $contenido = $username;

        QRcode::png($contenido, $filename, $level, $tamanio, $frameSize);

        return $filename; // Devuelve la ruta completa del archivo guardado
    }
}




