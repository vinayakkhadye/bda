<!doctype html>
<html>
<head>
	<?php $this->load->view('common/head'); ?>
  <link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>bda.css">
</head>

<body>
<div id="header">
	<?php $this->load->view('common/header');?>
</div>
<div id="content">
  <div class="row-fluid"> 
  <?php foreach($url_data as $city=>$data){ ?>
	  <div class="span3"><a href="<?=$data['url']?>"><?=$data['label']?></a></div>
  <?php }?> 
  </div>  
</div>
<div id="footer">
  <?php $this->load->view('common/footer'); ?>
</div>  <?php $this->load->view('common/bottom'); ?>
</body>
</html>