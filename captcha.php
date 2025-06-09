<?php
session_start();

$length = 6;
$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
$captcha = substr(str_shuffle($characters), 0, $length);


$width = 100;
$height = 30;

$image = imagecreatetruecolor($width, $height);
$bgColor = imagecolorallocate($image, 200, 200, 200);
$textColor = imagecolorallocate($image, 0, 0, 0);
$lineColor = imagecolorallocate($image, 0, 0, 0);

imagefilledrectangle($image, 0, 0, $width, $height, $bgColor);


imagestring($image, 5, 20, 12, $captcha, $textColor);

for($i = 0; $i < 5; $i++) {
  imageline($image, mt_rand(0, $width), mt_rand(0, $height), mt_rand(0, $width), mt_rand(0, $height), $lineColor);
}


header("Content-type: image/png");
imagepng($image);
imagedestroy($image);


?>