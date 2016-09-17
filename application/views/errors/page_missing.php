<!doctype html>
<html>
<head>
  <meta	charset="utf-8">
  <meta	name="viewport"	content="width=device-width, initial-scale=1, maximum-scale=1">
  <title>Page not found | BookDrAppointment.com</title>
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
  <div style="padding-top:8%;padding-bottom:7%">
    <!--<img src="<?=IMAGE_URL?>page-not-found.png" style="width:100%" alt="page you are looking for is missing"/>-->
    <h2 align="center" ><!--style="background-color:#638fb7;"-->
    	<font color="#393939" face="Helvetica 65 Medium" size="+3" style="line-height:20px;padding-top:20%">The page you are looking for is missing </font>
    </h2>
  <p>
	<a href="<?=BASE_URL?>">
  	<font color="#FF0000" size="+3"> &leftarrow; </font>
    <font color="#FF0000" size="+1">Go Back To Home page</font>
	</a>
  </div>
</div><!--container cf End-->
</div>
<div id="footer">
	<?php $this->load->view('common/footer'); ?>
</div>  
<?php $this->load->view('common/bottom'); ?>
</body>
</html>
