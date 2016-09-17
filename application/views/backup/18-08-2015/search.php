<!doctype html>
<html lang="en">
<head>
  <?php $this->load->view('common/head'); ?>
  <link rel="stylesheet" type="text/css" href="css/font-styles.css">
  <!-- Owl slider -->
  <link rel="stylesheet"	type="text/css"	href="<?php echo CSS_URL; ?>owl.carousel.css" >
  <link rel="stylesheet"	type="text/css"	href="<?php echo CSS_URL; ?>lightbox.css">
  <!-- for any custom changes from developer side used below file-->
  <link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>bda.min.css?v=2">    
</head>
<body>
	<div id="header">
	<?php $this->load->view('common/header'); ?>
  </div>
  <?php $this->load->view('common/search-panel'); ?>
  <div id="content">
  <div class="container cf">
  <h1 class="h1_sm_display"><?=$metadata['h1_text'] ?></h1>
  	<?php if(isset($doctors) && is_array($doctors) && sizeof($doctors) > 0 ){
			foreach($doctors as $key=>$val){?>
    <div class="doctor-pro-display-panel cf">
      <div class="two-third margin-bottom-0">
        <div class="profile-photo-panel">
          	<div class="profile-photo">
              <img src="<?php echo $val['doctor_image']?>" alt="<?php echo $val['doctor_name']?>" title="<?php echo $val['doctor_name']?>">
            </div>
            <?php if($val['tele_fees'] || $val['online_fees']){ ?>
            <div class="special-services">
                <p class="service-title">Also Consults on</p>
                <ul>
                	<?php if(!empty($val['tele_fees'])){ ?>
                  <li class="tele-consultation">Phone</li>
                  <?php }?>
                  <?php if(!empty($val['online_fees'])){ ?>
                  <li class="expert-appointment">Online</li>
                  <?php }?>
                </ul>
            </div>
            <?php }?>
        </div>
        <div class="profile-description-panel">
        		<?php $url	= BASE_URL.url_string($cityName)."/"."profile/".$val['url_name']; ?>
            <a href="<?=$url?>">
            <h2>Dr. <?php echo str_replace("Dr.","",$val['doctor_name'])?></h2>
            </a>
            <p class="bold-text"><?php echo strtoupper($val['qualificationStr']);?></p>
            <p><?php echo ucwords($val['specialityStr']); ?></p>
            <?php if($val['yoe']){ ?>
            <p><?php echo $val['yoe']?> years Experience</p>
            <?php  }?>
            <p class="bold-text"><?php echo ucwords($val['clinic_name']); ?></p>
            <p><?php echo ucwords($val['clinic_location_name']); ?></p>                        
            <?php if(is_array($val['clinic_images']) && sizeof($val['clinic_images'])>0){ ?> 
            <ul class="cf">
            	<?php 
							foreach($val['clinic_images'] as $img_val){
								if(!empty($img_val))
								{?>
                <li>
                  <a href="<?php echo BASE_URL.$img_val ?>" data-lightbox="profile-biodata">
	                  <img src="<?php echo BASE_URL.$img_val ?>" alt="Doctor Clniic Photo" style="max-height:43px;">
                  </a>
                </li>
                <?php }?>
                <?php }?>
            </ul>
            <?php }?>
        </div>
      </div>    
      <div class="one-third last margin-bottom-0">
      <ul class="profile-work-details">
      		<div class="hide"><?=$val['timings']?></div>
      		<?php if($val['happy_reviews_count']){ ?>
          <li class="profile-feedback"><?php echo $val['happy_reviews_count']?> Happy Patients</li>
          <?php }?>
          <?php if($val['consultation_fees']){ ?>
            <li class="profile-fees"><?php echo $val['consultation_fees'] ?></li>
					<?php }?>
					<?php if(isset($val['disptimings']) && !empty($val['disptimings']) && is_array($val['disptimings']) && sizeof($val['disptimings'])>0){ ?>
            <li class="profile-time">
            <ul>
            	<?php foreach($val['disptimings'] as $time_key=>$time_val){ ?>
	              <li class="bold-text"><?=$time_val['label']?></li>
                <li><?=$time_val['value']?></li>	
              <?php }?>
            </ul>
            </li>
					<?php }?>
          <?php if($val['health_utsav']==1){ ?>
          <!--<li class="cf">
            <span style="font-weight: bold; color:#ff4d4d;">Free Consultation on 1st August</span>
          </li>-->
          <?php }?>
					<?php if($val['quick_appointment']==1){ ?>
            <li class="cf">
            <div id="quick-appointment" class="appointment_via_time">Book<span>Dr</span>Appointment</div>	
            </li>
          <?php }else if(in_array($val['doctor_id'],array(64636,55432,55415,55168))){?>
            <li class="cf"><div id="phone-appointment" class="appointment_via_phone">Appointment<span>via Phone</span></div></li>          
          <?php }else if($val['is_ver_reg']>0 || $val['is_number_verified']==1 ){?>
            <li class="cf">
                <div id="book-appointment" class="appointment_via_time">Book<span>Dr</span>Appointment</div>
            </li>
          <?php }else{?>
            <li class="cf">
            <div id="book-appointment" class="appointment_via_time">Book<span>Dr</span>Appointment</div>	
            </li>
          <?php }?>
        </ul>
      </div>
      <div class="cf">
        <p class="hide" id="doctor_id"><?php echo $val['doctor_id']?></p>
        <p class="hide" id="clinic_id"><?php echo $val['clinic_id']?></p>
      </div>
      <?php if($val['quick_appointment']==1){ ?>
      <div class="select-date-slider"></div>
      <?php }else if(in_array($val['doctor_id'],array(64636,55432,55415,55168))){?>
	    <div class="phone-appointment-panel"></div>
      <?php }else if($val['is_ver_reg']>0 || $val['is_number_verified']==1 ){?>
	      <div class="select-date-slider"></div>
      <?php }else{?>
      <div class="select-date-slider"></div>
      <?php }?>
    </div>
    <?php }}else{ ?>
    <div class="doctor-pro-display-panel cf">
    No Doctors Found.
    </div>
    <?php } ?>
    
    <div class="doctor-pro-pagination cf"><!--doctor-pro-pagination Start-->
    <div class="breadcrum-container">
      <h5><a href="<?=BASE_URL?>"><span>Home</span></a></h5> / 
      <h5><a href="<?=BASE_URL.$query['city']?>"><span><?=ucfirst($cityName)?></span></a></h5> / 
      <?php if(isset($query['speciality'])){ ?>
      <h5><a href="<?=BASE_URL.$query['city']."/".$url_speciality?>"><span><?=ucwords($query['speciality']) ?></span></a></h5> / 
      <?php } ?>
      <?php if(isset($query['location'])){ ?>
      <h5><a href="<?=BASE_URL.$query['city']."/".$url_speciality.(isset($url_location) && $url_location!='all' ?"/".$url_location:'')	?>"><span><?=ucwords($query['location']) ?></span></a></h5>
      <?php } ?>
      <?php if(isset($query['query'])){ ?>
      <h5><?=$query['query'] ?></h5>
      <?php } ?>
		</div>
    <?php if(isset($pagination) && is_array($pagination) && sizeof($pagination)>0){ ?>
    <ul class="tsc_pagination tsc_paginationC tsc_paginationC05"> <!--pagination Start-->
        <?php
        if(isset($pagination['sPage']['url']))
        {
          ?>
          <li><a href="<?=$pagination['sPage']['url'] ?>" class="first">First</a></li>
         <?php
        } ?>
	      <?php
        if(isset($pagination['prePage']['url']))
        {
          ?>
          <li><a href="<?=$pagination['prePage']['url'] ?>" class="previous">Previous</a></li>
          <?php
        } ?>
        <?php
        if(isset($pagination['page']) && is_array($pagination['page']) && sizeof($pagination['page']) > 0)
        {
          foreach($pagination['page'] as $pkey=>$pval)
          {
            ?>
            <?php
            if($pkey == $page_id)
            {?>
            <li><a href="javascript:;" class="current"><?php echo $pkey; ?></a></li>
            <?php  }
            else
            {?>
      				<li><a href="<?php echo $pval['url'];?>"><?php echo $pkey;?></a></li>      
            <?php }?>
            <?php  
					}
        }?>
        <?php
        if(isset($pagination['nextPage']['url']))
        {
          ?>
          <li><a href="<?=$pagination['nextPage']['url'] ?>" class="next">Next</a></li>
          <?php
        } ?>
        <?php
        if(isset($pagination['lPage']['url']))
        {
          ?>
          <li><a href="<?=$pagination['lPage']['url'] ?>" class="last">Last</a></li>
          <?php
        } ?>
    </ul><!--pagination End-->
    <?php }?>
    </div>
    
  </div>
  </div>
  <?php $this->load->view('common/speciality_information'); ?>
  <div id="footer">
 	 <?php $this->load->view('common/footer'); ?>
  </div>    
  <script type="text/javascript">
  <?php
  function js_str($s)
  {
		return '{label:"' . addcslashes(ucwords($s['name']), "\0..\37\"\\") . '",value:"'.$s['url_name'].'"}';
	  #return '"' . addcslashes(ucwords($s['name']), "\0..\37\"\\") . '"';
  }
  function js_array($array)
  {
  $temp = array_map('js_str', $array);
  return '[' . implode(',', $temp) . ']';
  }
  if(isset($location)&& !empty($location))
  {
  echo 'var defaultlocation = ', js_array($location), ';';
  }
  else
  {
  echo 'var defaultlocation = \'\';';
  }
  if(isset($speciality) && !empty($speciality))
  {
  echo 'var defaultlist = ', js_array($speciality), ';';
  }
  else
  {
  echo 'var defaultlist = \'\'';
  }
  ?>
  </script>
  <?php $this->load->view('common/bottom'); ?>
  <!-- PAGE SPECIFIC JS-->
  <script src="<?=JS_URL?>owl.carousel.js"></script>
  <script src="<?=JS_URL?>lightbox.js"></script>
</body>
</html>