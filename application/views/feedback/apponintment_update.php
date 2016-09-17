<!doctype html>
<html>
<head>
  <meta	charset="utf-8">
  <meta	name="viewport"	content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>Appointment Update Feedback | BookDrAppointment.com</title>
  <link rel="icon" type="image/png" href="<?=IMAGE_URL?>bdaicon.ico">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link	rel="stylesheet"	type="text/css" href="<?php echo CSS_URL; ?>Default-css.css">
  <link rel="stylesheet"	type="text/css" href="<?php echo CSS_URL; ?>style.css?v=2">
  <link rel='stylesheet'	type='text/css'	href='https://fonts.googleapis.com/css?family=Quicksand:300,400,700|Raleway:400,300,500,700'  >
  <link rel="stylesheet"	type="text/css"	href="<?php echo CSS_URL; ?>tabulous.css?v=1">
  <link rel="stylesheet"	type="text/css"	href="<?php echo CSS_URL; ?>responsive.css?v=2">
  <link rel="stylesheet"	type="text/css"	href="<?php echo CSS_URL; ?>slicknav.css">
  <!--[if gte IE 9]>
  <style type="text/css">
  .gradient {
  filter: none;
  }
  </style>
  <![endif]-->
  <link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>bda.css">
</head>

<body>
<div id="header">
	<?php $this->load->view('common/header');?>
</div>

<div id="content"><!--content Start-->
<div class="container cf"><!--container cf Start-->
  <div style="padding-top:10%;padding-bottom:10%">
    <h1><?=$message?></h1>
  </div>
</div><!--container cf End-->
</div><!--content End-->
<div id="footer">
	<?php $this->load->view('common/footer'); ?>
</div>  <?php $this->load->view('common/bottom'); ?>
</body>
</html>
