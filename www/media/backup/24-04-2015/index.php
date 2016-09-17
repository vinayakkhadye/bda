<?php 
$file_path	=	$_GET['url'];
$file_full_path	=	$_SERVER['DOCUMENT_ROOT']."/media/".$_GET['url'];
$defaul_image_path	=	 $_SERVER['DOCUMENT_ROOT']."/static/images/default_404.jpg";

$image_type	=	exif_imagetype($file_full_path);
if(isset($_GET['t']))
{
	$image_info	=	 getimagesize($file_full_path);
	print_r( exif_imagetype($file_full_path));
	print_r($image_info);exit;
}

if($image_type==1)
{
	$im = @imagecreatefromgif($file_full_path);
	header("content-type: image/gif");
	imagegif($im);
	imagedestroy($im);
}
else if($image_type==2)
{
	$im = @imagecreatefromjpeg($file_full_path);
	header("content-type: image/jpg");
	imagejpeg($im);
	imagedestroy($im);
}
else if($image_type==3)
{
	$im = @imagecreatefrompng($file_full_path);
	header("content-type: image/png");
	imagepng($im);
	imagedestroy($im);

}
else
{
	$im = @imagecreatefromjpeg($defaul_image_path);
	header("content-type: image/jpg");
	imagejpeg($im);
	imagedestroy($im);

}
?>