<?php
    session_start();
    header("Content-type:image/png");
//        private static $str = '0123456789abcdefghijklmnopqrsuvwxyz';

    $_SESSION['c2'] = random_int(10000, 99999);
    $text = $_SESSION['c2'];
    $width = 600;
    $height = 600;
    $image = imagecreate($width, $height);
    imagecolorallocate($image,255, 225, 255);
    $color = imagecolorallocate($image, 255, 0, 0);
    $font_size = 60;
    $font = 'PermanentMarker-Regular.ttf';
    imagefttext($image, $font_size, 4, 310, 70, $color, $font, $text);
    imagepng($image);