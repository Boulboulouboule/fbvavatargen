<?php
// Auto loader de composer
require __DIR__ . '/vendor/autoload.php';

// Affichage des erreurs
ini_set('display_errors', '1');
error_reporting(E_ALL & ~E_NOTICE);
try {
    $ffmpeg = FFMpeg\FFMpeg::create();

// Réglage nom/durée de la video finale
    $date = new \DateTime();
    $filename = $_GET['file'] ?? $date->getTimestamp();
    $duration = 2;

    if ($imgPath = $_GET['file']) {
// Créer une video à partie d'une image (reglage de la durée au dessus)
        echo exec('ffmpeg -loop 1 -i ' . $imgPath . ' -c:v libx264 -t ' . $duration . ' -pix_fmt yuv720p -vf scale=1280:720 temp1.mp4');
    } else {
        http_response_code(404);
        echo 'Il manque l\'image dans la requête';
    }

    $bmwVideo = $ffmpeg->open('./videos/bmw.mp4');
    $bmwVideo
        ->filters()
        ->resize(new FFMpeg\Coordinate\Dimension(1280, 720))
        ->synchronize();

    $bmwVideo
        ->save(new FFMpeg\Format\Video\X264(), 'temp2.mp4');

// Fusionne les 2 videos temporaires
    echo exec('ffmpeg -f concat -i temp*.mp4 -c copy ./videos/' . $filename . '.mp4');

// Suppression des videos temporaires
    unlink('temp1.mp4');
    unlink('temp2.mp4');
} catch(Exception $e) {
    echo $e->getMessage();
    echo $e->getTrace();
}
