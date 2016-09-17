<?php 
$file_path	=	$_GET['url'];
$file_full_path	=	$_SERVER['DOCUMENT_ROOT']."/media/".$_GET['url'];
$defaul_image_path	=	 $_SERVER['DOCUMENT_ROOT']."/static/images/default_404.jpg";
$watermark_image_path	=	 $_SERVER['DOCUMENT_ROOT']."/static/images/watermark_logo.jpg";

$stamp = @imagecreatefromjpeg($watermark_image_path); #for water mark
$image_type	=	exif_imagetype($file_full_path);
if($image_type==1)
{
	$im = @imagecreatefromgif($file_full_path);
	
	if(isset($_GET['wm']))
	{
		$imageSize = getimagesize($file_full_path);
		$stamp_width = imagesx($stamp);
		$stamp_height = imagesy($stamp);
		$newWatermarkWidth = $imageSize[0];
		$newWatermarkHeight = number_format(($stamp_height * $newWatermarkWidth / $stamp_width),0);	
		imagecopyresized($im, $stamp, $imageSize[0] - $newWatermarkWidth, $imageSize[1] - $newWatermarkHeight, 0, 0, $newWatermarkWidth, $newWatermarkHeight, 
		$stamp_width, $stamp_height);
	}

	header("content-type: image/gif");
	imagegif($im);
	imagedestroy($im);
}
else if($image_type==2)
{
	$im = @imagecreatefromjpeg($file_full_path);

	if(isset($_GET['wm']))
	{
		$imageSize = getimagesize($file_full_path);
		$stamp_width = imagesx($stamp);
		$stamp_height = imagesy($stamp);
		$newWatermarkWidth = $imageSize[0];
		$newWatermarkHeight = number_format(($stamp_height * $newWatermarkWidth / $stamp_width),0);	
		imagecopyresized($im, $stamp, $imageSize[0] - $newWatermarkWidth, $imageSize[1] - $newWatermarkHeight, 0, 0, $newWatermarkWidth, $newWatermarkHeight, 
		$stamp_width, $stamp_height);
	}

	header("content-type: image/jpg");
	imagejpeg($im);
	imagedestroy($im);
}
else if($image_type==3)
{
	$im = @imagecreatefrompng($file_full_path);

	if(isset($_GET['wm']))
	{
		$imageSize = getimagesize($file_full_path);
		$stamp_width = imagesx($stamp);
		$stamp_height = imagesy($stamp);
		$newWatermarkWidth = $imageSize[0];
		$newWatermarkHeight = number_format(($stamp_height * $newWatermarkWidth / $stamp_width),0);	
		imagecopyresized($im, $stamp, $imageSize[0] - $newWatermarkWidth, $imageSize[1] - $newWatermarkHeight, 0, 0, $newWatermarkWidth, $newWatermarkHeight, 
		$stamp_width, $stamp_height);
	}

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