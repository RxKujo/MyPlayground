<?php
// captcha.php
session_start();

$shape = $_GET['shape'] ?? '';

$width = 80;
$height = 80;

header("Content-Type: image/png");
$image = imagecreatetruecolor($width, $height);

// Couleurs
$white = imagecolorallocate($image, 255, 255, 255);
$black = imagecolorallocate($image, 0, 0, 0);
$blue = imagecolorallocate($image, 50, 50, 255);

imagefill($image, 0, 0, $white);

switch ($shape) {
    case 'cercle':
        imagefilledellipse($image, $width / 2, $height / 2, 60, 60, $blue);
        break;
    case 'carré':
        imagefilledrectangle($image, 10, 10, 70, 70, $blue);
        break;
    case 'rectangle':
        imagefilledrectangle($image, 10, 25, 70, 55, $blue);
        break;
    case 'triangle':
        $points = [
            $width / 2, 10,
            10, 70,
            70, 70
        ];
        imagefilledpolygon($image, $points, 3, $blue);
        break;
    default:
        // image vide
        break;
}

imagepng($image);
imagedestroy($image);
