<?php
session_start();
$image = imagecreatetruecolor(100, 37);
$bgcolor = imagecolorallocate($image,255,255,255);
imagefill($image, 0, 0, $bgcolor);
$fontsize=9;
$fontcolor = imagecolorallocate($image, 0,0, 0);
$yzm='';
for ($i=0;$i<6;$i++){
    $yzm.=mt_rand(0,9);
}
header('Content-Type: image/png');
$_SESSION['yzm']=$yzm;
imagestring($image,$fontsize,(100/4),10,$yzm,$fontcolor);
//设置干扰点
for($i=0;$i<100;$i++){
    $pointcolor = imagecolorallocate($image,rand(50,200), rand(50,200), rand(50,200));
    imagesetpixel($image, rand(1,99), rand(1,29), $pointcolor);
}
imagepng($image);
imagedestroy($image);



