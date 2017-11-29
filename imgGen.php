<?php

if ($text = $_GET['name']) {
// Création de l'image de base, fond noir en 720p
    $jpg_image = imagecreatetruecolor(1280, 720);
    $bg = imagecolorallocate($jpg_image, 0, 0, 0);
    imagefilledrectangle($jpg_image, 0, 0, 120, 20, $bg);
    $white = imagecolorallocate($jpg_image, 255, 255, 255);

    $font_path = './fonts/RobotoCondensed-Regular.ttf';
    $imgPath = './avatars/' . $_GET['file'] . '.jpg';

// Ajout du nom en blanc sur l'image
    imagettftext($jpg_image, 25, 0, 110, 162.5, $white, $font_path, $text);
    imagejpeg($jpg_image, $imgPath, 100);
    imagedestroy($jpg_image);

    http_response_code(200);
    return $imgPath;
} else {
    http_response_code(400);
    return 'Il manque le nom';
}

