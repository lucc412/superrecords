<?php
ob_start();
session_start();
$chars = array("0","1","2","3","4","5","6","7","8","9");

$textstr = '';
for ($i = 0, $length = 6; $i < $length; $i++)
   $textstr .= $chars[rand(0, count($chars) - 1)];

$hashtext = md5($textstr);
@setcookie('strSec', $hashtext, 0, '/');
$_SESSION['captchaval'] = $textstr;

ob_end_flush();


function produceCaptchaImage($text) {
    // constant values
    $backgroundSizeX = 500;
    $backgroundSizeY = 150;
    $sizeX = 200;
    $sizeY = 50;
    $fontFile = "captcha/verdana.ttf";
    $textLength = strlen($text);

    // generate random security values
    $backgroundOffsetX = 100;
    $backgroundOffsetY = 100;
    $angle = 5;
    $fontColorR = rand(0, 127);
    $fontColorG = rand(0, 127);
    $fontColorB = rand(0, 127);

    $fontSize = 18;
    //$textX = rand(0, (int)($sizeX - 0.9 * $textLength * $fontSize)); // these coefficients are empiric
   // $textY = rand((int)(1.25 * $fontSize), (int)($sizeY - 0.2 * $fontSize)); // don't try to learn how they were taken out

    $gdInfoArray = gd_info();
    if (! $gdInfoArray['PNG Support'])
        return IMAGE_ERROR_GD_TYPE_NOT_SUPPORTED;

    // create image with background
    @$src_im = imagecreatefrompng( "captcha/background.png");

    if (function_exists('imagecreatetruecolor')) {
        // this is more qualitative function, but it doesn't exist in old GD
        @$dst_im = imagecreatetruecolor(130, 40);
        @$resizeResult = imagecopyresampled($dst_im, $src_im, 0, 0, $backgroundOffsetX, $backgroundOffsetY, $sizeX, $sizeY, $sizeX, $sizeY);
    } else {
        // this is for old GD versions
        @$dst_im = imagecreate( $sizeX, $sizeY );
        @$resizeResult = imagecopyresized($dst_im, $src_im, 0, 0, $backgroundOffsetX, $backgroundOffsetY, $sizeX, $sizeY, $sizeX, $sizeY);
    }

    if (! $resizeResult)
        return IMAGE_ERROR_GD_RESIZE_ERROR;
$factor = 18;
$x = ($factor * ($i + 1)) - 6;
$y = 24;
    // write text on image
    if (! function_exists('imagettftext'))
        return IMAGE_ERROR_GD_TTF_NOT_SUPPORTED;
    @$color = imagecolorallocate($dst_im, 44, 89, 55);
    imagettftext($dst_im, $fontSize, -$angle, $x, $y, $color, $fontFile, $text);

    // output header
    header("Content-Type: image/png");

    // output image
    imagepng($dst_im);

    // free memory
    imagedestroy($src_im);
    imagedestroy($dst_im);

    return IMAGE_ERROR_SUCCESS;
}

?>