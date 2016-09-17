<meta	charset="utf-8">
<meta	name="viewport"	content="width=device-width, initial-scale=1, maximum-scale=1">
<title><?php echo $metadata['title']; ?></title>
<link rel="icon" type="image/png" href="<?=IMAGE_URL?>bdaicon.ico">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="<?=$metadata['description'] ?>" />
<meta name="keywords" content="<?=$metadata['keywords']?>" />
<?php if(isset($metadata['canonical_url'])){ ?>
<link rel="canonical" href="<?=$metadata['canonical_url']?>" />
<?php }?>
<link	rel="stylesheet"	type="text/css" href="<?php echo CSS_URL; ?>Default-css.min.css">
<link rel="stylesheet"	type="text/css" href="<?php echo CSS_URL; ?>style.min.css?v=1">
<link rel='stylesheet'	type='text/css'	href='https://fonts.googleapis.com/css?family=Quicksand:300,400,700|Raleway:400,300,500,700'  >
<link rel="stylesheet"	type="text/css"	href="<?php echo CSS_URL; ?>tabulous.min.css?v=1">
<link rel="stylesheet"	type="text/css"	href="<?php echo CSS_URL; ?>responsive.min.css?v=1">
<link rel="stylesheet"	type="text/css"	href="<?php echo CSS_URL; ?>slicknav.min.css">
<!--[if gte IE 9]>
<style type="text/css">
.gradient {
filter: none;
}
</style>
<![endif]-->
