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
  
  <?php foreach($url_data as $city=>$loation_data){ ?>
  <div class="sitemap-city-box">
    <div class="sitemap-city-name"><?=$city ?></div>
    <?php foreach($loation_data as $location=>$data){ ?>
    <div class="sitemap-location-name"><?=$location ?></div>
    <?php $chunk_data	= array_chunk($data,4); ?>
    <?php foreach($chunk_data as $val){?>
	    <div class="row-fluid">
    	<?php foreach($val as $display_val){ ?>
	      <div class="span3"><a href="<?=$display_val['url']?>"><?=$display_val['label']?></a></div>
    	<?php }?>  
      </div>
    <?php }?>
    <?php }?>
  </div>
  <?php }?>
  
</div>
<div id="footer">
	<?php $this->load->view('common/footer'); ?>
</div>  <?php $this->load->view('common/bottom'); ?>
</body>
</html>
