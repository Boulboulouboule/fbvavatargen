<?php
// Auto loader de composer
require __DIR__ . '/vendor/autoload.php';

// Affichage des erreurs
ini_set('display_errors', '1');
error_reporting(E_ALL & ~E_NOTICE);
$ffmpeg = FFMpeg\FFMpeg::create();

// Réglage nom/durée de la video finale
$date = new \DateTime();
$filename = date('YmdHis');
$tempFile = __DIR__ . '/temp1.mp4';
$fileList = "concatlist.txt";
$duration = 2;

if ($imgPath = __DIR__ . $_GET['file']) {
// Créer une video à partie d'une image (reglage de la durée au dessus)
    echo exec('ffmpeg -loop 1 -i ' . $imgPath . ' -c:v libx264 -t ' . $duration . ' -pix_fmt yuv720p -vf scale=1280:720 ' . $tempFile);
} else {
    http_response_code(404);
    echo 'Il manque l\'image dans la requête';
}

// Fusionne les 2 videos temporaires
echo exec('ffmpeg -f concat -i ' . $fileList . ' -c copy ./videos/' . $filename . '.mp4');

// Suppression des videos temporaires
unlink($tempFile);
