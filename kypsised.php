<?php
session_start();

$randomString = substr(md5(rand()), 0, 6);


$_SESSION['captchatext'] = $randomString;


$image = imagecreatetruecolor(100, 30);


$bgColor = imagecolorallocate($image, 255, 255, 255);
$textColor = imagecolorallocate($image, 0, 0, 0);


imagefilledrectangle($image, 0, 0, 100, 30, $bgColor);


imagestring($image, 5, 20, 7, $randomString, $textColor);


header('Content-Type: image/png');
imagepng($image);


imagedestroy($image);
?>
