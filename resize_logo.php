<?php
$source = "public/images/sec-cultura-logo.jpg";
$dest = "public/images/sec-cultura-logo-small.jpg";

if(!file_exists($source)) {
    echo "No source file\n";
    exit;
}

$img = imagecreatefrompng($source);
$w = imagesx($img);
$h = imagesy($img);

$new_w = 400;
$new_h = floor($h * ($new_w / $w));

$new_img = imagecreatetruecolor($new_w, $new_h);
// Handle transparency nicely
imagealphablending($new_img, false);
imagesavealpha($new_img, true);
$transparent = imagecolorallocatealpha($new_img, 255, 255, 255, 127);
imagefilledrectangle($new_img, 0, 0, $new_w, $new_h, $transparent);

imagecopyresampled($new_img, $img, 0, 0, 0, 0, $new_w, $new_h, $w, $h);

imagejpeg($new_img, $dest, 80);
imagedestroy($img);
imagedestroy($new_img);

echo "Resized correctly to $dest\n";
