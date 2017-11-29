<?php
// Auto loader de composer
require __DIR__ . '/vendor/autoload.php';

// Affichage des erreurs
ini_set('display_errors', '1');
error_reporting(E_ALL & ~E_NOTICE);

// Réglage nom/durée de la video finale
$date = new \DateTime();
$filename = date('YmdHis');
$tempFile = __DIR__ . '/temp1.mp4';
$fileList = 'concatlist.txt';
$duration = 2;

if ($imgPath = __DIR__ . $_GET['file']) {
    try {
        // Créer une video à partir d'une image (reglage de la durée au dessus)
        var_dump($imgPath);
        var_dump($tempFile);
        echo exec('ffmpeg -loop 1 -i ' . $imgPath . ' -c:v libx264 -t ' . $duration . ' -pix_fmt yuv720p -vf scale=1280:720 ' . $tempFile);

        // Fusionne les 2 videos temporaires
        var_dump(__DIR__ . '/videos/' . $filename . '.mp4');
        echo exec('ffmpeg -f concat -i ' . $fileList . ' -c copy ' . __DIR__ . '/videos/' . $filename . '.mp4');

        // test
        echo exec('ffmpeg -f concat -i bmw.mp4 -c copy ' . __DIR__ . '/videos/test.mp4');

        // Suppression des videos temporaires
        unlink($tempFile);
    } catch (Exception $e) {
        echo $e;
    }
} else {
    http_response_code(404);
    echo 'Il manque l\'image dans la requête';
}
