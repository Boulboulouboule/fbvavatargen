<?php
$jpg_image = imagecreatetruecolor(350, 350);
$bg = imagecolorallocate ( $jpg_image, 0, 0, 0 );
imagefilledrectangle($jpg_image,0,0,120,20,$bg);
$white = imagecolorallocate($jpg_image, 255, 255, 255);

$font_path = './RobotoCondensed-Regular.ttf';
$text = $_GET['name'];

imagettftext($jpg_image, 25, 0, 110, 162.5, $white, $font_path, $text);
imagejpeg($jpg_image,'./avatars/' . $_GET['file'] . '.jpg',100);
imagedestroy($jpg_image);

