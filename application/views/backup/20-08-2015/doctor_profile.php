<!doctype html>
<html lang="en">
  <head>
		<?php $this->load->view('common/head'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>font-styles.css">
    <!-- Owl slider -->
    <link href="<?php echo CSS_URL; ?>owl.carousel.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>lightbox.css">
    <link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>bda.min.css?v=2">
  </head>
  <body>
    <div id="header">
      <?php $this->load->view('common/header'); ?>
    </div>
    <?php $this->load->view('common/search-panel'); ?>
    <div id="content">
<div class="container cf">
        <div class="breadcrum-profile-container">
          <h5><a href="<?=BASE_URL?>"><span>Home</span></a></h5> / 
          <h5><a href="<?=BASE_URL.url_string($cityName)?>"><span><?=ucfirst(reverse_url_string($cityName))?></span></a></h5> / 
          <h5><a href="<?=BASE_URL.url_string($cityName."/".$doctor['speciality'][0]['url_name'])?>">
          <span><?=ucwords($doctor['speciality'][0]['name'])?></span></a></h5> / 
          <h5><a href="<?=BASE_URL.url_string($cityName."/".$doctor['speciality'][0]['url_name']."/".$clinicData[0]['location']['url_name']) ?>">
          <span><?=ucwords($clinicData[0]['location']['location_name'])?></span></a></h5> /
          <h5>Dr. <?=ucwords($doctor['doctor_name'])?></h5>
        </div>
      	<div class="doctor-pro-display-panel cf">
	        <div class="full-width margin-bottom-0 last">
            <div class="pro-page-profile-photo-panel">
            	<div class="profile-photo">
								<?php
                #var_dump($doctor['doctor_image'],$doctor['doctor_gender']);
                $image_url ='';
                if($doctor['doctor_image'])
                {
                if(strpos($doctor['doctor_image'],"http") !== false)
                {
                $image_url = $doctor['doctor_image'];
                }
                else
                {
                $image_url = BASE_URL.$doctor['doctor_image']."?wm";
                }
                }
                else
                {
                if(strtolower($doctor['doctor_gender']) == "m")
                {
                $image_url = IMAGE_URL."default_doctor.png";
                }
                elseif(strtolower($doctor['doctor_gender']) == "f")
                {
                $image_url = IMAGE_URL."female_doctor.jpg";
                }
                elseif(strtolower($doctor['doctor_gender']) == "o")
                {
                $image_url = IMAGE_URL."default_404.jpg";
                }
                else
                {
                $image_url = IMAGE_URL."default_404.jpg";
                }
                } 
                ?>
                <img src="<?php echo $image_url; ?>" alt="<?php echo str_replace("Dr.","",$doctor['doctor_name']); ?>" 
                title="<?php echo str_replace("Dr.","",$doctor['doctor_name']); ?>">
            </div>
            </div>
            <div class="profile-description-panel pro-page-profile-description-panel">
              <h1>Dr.	<?php echo str_replace("Dr.","",trim($doctor['doctor_name'])); ?></h1>
              <p class="bold-text"><?php echo strtoupper($doctor['qualificationStr']) ?></p>
              <p><?php echo ucwords($doctor['specialityStr']) ?></p>
              <?php if(isset($doctor['yoe']) && !empty($doctor['yoe'])): ?>
              <p><?php echo $doctor['yoe']; ?> years Experience</p>
              <?php endif; ?>
              <?php if($happy_reviews_count > 0): ?>
              <ul class="profile-work-details cf margin-bottom-0">
              <li class="profile-feedback margin-bottom-0"><?=$happy_reviews_count;?> Happy Patients</li>
              </ul>
              <?php endif; ?>
              <?php if($doctor_id =='17964'): ?>
              <p class="doctor-experience-details more">
              <?php echo $doctor['summary']; ?>
              </p>
              <?php endif; ?>
            </div>
            <div class="cf"></div>
            <div id="tabs-doctor-profile">
              <ul class="cf">
                <li><a href="#tabs-1-doctor-profile" title=""><span class="tabs-doctor-pro-clinic"></span>Clinic</a></li>
                <li><a href="#tabs-2-doctor-profile" title=""><span class="tabs-doctor-pro-profile"></span>Profile</a></li>
                <li><a href="#tabs-3-doctor-profile" title=""><span class="tabs-doctor-pro-review"></span>Review</a></li>
              </ul>
              <div id="tabs_container-doctor-profile">
                <div id="tabs-1-doctor-profile">
                  <?php 
                    if(isset($clinicData) && sizeof($clinicData) > 0):
                    foreach($clinicData as $clKey=>$clVal):
                  ?>
                  <div class="doctor-clinic-more-details cf">
                    <div class="one-third margin-bottom-0">
                      <ul class="doctor-pro-clinic-details cf">
                        <li class="clinic-location">
                          <span class="clinic-location-bold-text"><?php echo ucfirst($clVal['clinic_name'])?></span><br/>
                          <?php echo ucfirst($clVal['clinic_address']); ?>
                        </li>
                        <li class="profile-clinic-fees"><?php echo $this->doctor_model->get_clinic_consultation_fees($clVal['consultation_fees']); ?></li>
                      </ul>
                      <?php if($clVal['clinic_latitude'] && $clVal['clinic_longitude']){?>
                      <a href="javascript:;" latitude="<?=$clVal['clinic_latitude'] ?>" longitude="<?=$clVal['clinic_longitude'] ?>" class="clinic-location-map-bt clniic-view-map">View Map</a>
                      <?php }?>
                    </div>
                    <div class="one-third margin-bottom-0">
                      <?php if(isset($clVal['disptimings']) && !empty($clVal['disptimings']) && is_array($clVal['disptimings']) && sizeof($clVal['disptimings'])>0){ ?>
                      <ul class="profile-work-details">
                        <li class="profile-time">
                          <ul>
                            <?php foreach($clVal['disptimings'] as $time_key=>$time_val){ ?>
                            <li class="bold-text"><?=$time_val['label']?></li>
                            <li><?=$time_val['value']?></li>
                            <?php }?>
                          </ul>
                        </li>
                        <li>
												<?php if($doctor['health_utsav']==1){ ?>
                        <!--<span style="font-weight: bold; color: rgb(255, 77, 77);">Free Consultation on 1st August</span>-->
                        <?php }?>
                        </li>
                      </ul>
                      <?php } ?>
                      <div class="float-right">
                      <?php if($doctor['quick_appointment']==1){ ?>
                        <div id="quick-appointment" class="profile_appointment_via_time">Book<span>Dr</span>Appointment</div>	
                       <?php }else if(in_array($doctor['doctor_id'],array(64636,55432,55415,55168))){?>
                         <div id="phone-appointment" class="profile_appointment_via_phone">Appointment<span>via Phone</span></div> 
                       <?php }else if($doctor['is_ver_reg']>0 || $clVal['is_number_verified']==1 ){?>
                        <div id="book-appointment" class="profile_appointment_via_time">Book<span>Dr</span>Appointment</div>
                      <?php }else{?>
                      <div id="book-appointment" class="profile_appointment_via_time">Book<span>Dr</span>Appointment</div>	
                      <?php }?>  
                      </div>
                    </div>
                    <div class="one-third margin-bottom-0 last">
                      <?php 
                      if(is_array($clVal['clinic_images']) && sizeof($clVal['clinic_images'])>0){ ?>
                      <ul class="doctor-photo-biodata cf">
                        <?php foreach($clVal['clinic_images'] as $img_val){ 
                        if(!empty($img_val)){
                        ?>
                        <li>
                          <a href="<?php echo BASE_URL.$img_val; ?>" data-lightbox="profile-biodata" >
                            <img src="<?php echo BASE_URL.$img_val; ?>" alt="Doctor Photo Biodata" style="max-height:43px;">
                          </a>
                        </li>
                        <?php }}?>  
                      </ul>
                      <?php }?>
                      <?php if(!empty($clVal['tele_fees']) || !empty($clVal['express_fees'])): ?>
                      <div class="special-services">
                        <p class="service-title">
                          Also Offers
                        </p>
                        <?php if(isset($clVal['tele_fees']) && !empty($clVal['tele_fees'])): ?>
                        <span class="March-tele-consultation"><a href="#">Tele Consultation</a></span>
                        <?php endif; ?>
                        <?php if(isset($clVal['express_fees']) && !empty($clVal['express_fees'])): ?>
                        <span class="March-expert-appointment"><a href="#">Express Appointment</a></span>
                        <?php endif; ?>
                      </div>
                      <?php endif; ?>
                    </div>
                    <div class="cf">
                      <p id="doctor_id" class="hide"><?php echo $doctor['doctor_id'];?></p>
                      <p id="clinic_id" class="hide"><?php echo $clVal['clinic_id'];?></p>
                    </div>
                    <?php if($doctor['quick_appointment']==1){ ?>
                    <div class="select-date-slider mt10"></div>
                    <?php }else if(in_array($doctor['doctor_id'],array(64636,55432,55415,55168))){?>
                    <div class="phone-appointment-panel mt10"></div>
                    <?php }else if($doctor['is_ver_reg']>0 || $clVal['is_number_verified']==1 ){?>
                      <div class="select-date-slider mt10"></div>
                    <?php }else{?>
                    <div class="select-date-slider mt10"></div>
                    <?php }?>
                  </div>
                  <?php endforeach; ?>
                  <?php endif; ?>
                </div>
                <?php
                  if(is_array($doctor['detail']) && sizeof($doctor['detail']) > 0):
                ?>
                <div id="tabs-2-doctor-profile">
                  <?php 
                    if(isset($doctor['detail']['Services']) && !empty($doctor['detail']['Services'])): 
                  ?>
                  <div class="doctor-profile-more-details">
                    <h2><span class="services-icon"></span>Services</h2>
                    <ul class="doctor-pro-service cf">
                      <?php foreach($doctor['detail']['Services'] as $row): ?>
                        <li><?php echo $row['description1'] ?></li>
                      <?php endforeach; ?>
                    </ul>
                    <div class="doctor-pro-tab-show-more-link">
                      <span class="service-view-more">
                        + View all
                      </span>
                    </div>
                  </div>
                  <?php 
                    endif; 
                    unset($doctor['detail']['Services']);
                    unset($doctor['detail']['Qualifications']);
                    if(isset($doctor['detail']['PapersPublished']) && is_array($doctor['detail']['PapersPublished']) && sizeof($doctor['detail']['PapersPublished'])){
                      $papers = $doctor['detail']['PapersPublished'];
                    }
                    unset($doctor['detail']['PapersPublished']);
                    //print_r($doctor['detail']);
                    $i = 0;
                    //echo sizeof($doctor['detail']);
                  ?>
                  <?php foreach($doctor['detail'] as $row=>$val): ?>
                  <?php 
                    //echo $i;
                    //print_r($row);
                    //print_r($val);
                    $r = $i % 3;
                    if($r == 0): 
                  ?>
                  <div class="doctor-profile-more-details cf">
                  <?php endif; ?>
                    <?php if($row == 'Education'): ?>
                    <div class="doctor-pro-tab-one-third">
                      <h2><span class="education-icon"></span>Education</h2>
                      <ul class="doctor-pro-education cf">
                      <?php foreach($val as $values): ?>
                        <li><?php echo $values['description1'].' '.$values['description2'].' '.$values['from_year'] ?></li>
                      <?php endforeach; ?>
                      </ul>
                      <div class="doctor-pro-tab-show-more-link">
                        <span class="education-view-more">
                          + View all
                        </span>
                      </div>
                    </div>
                    <?php endif; ?>
                    <?php if($row == 'Membership'): ?>
                    <div class="doctor-pro-tab-one-third">
                      <h2><span class="membership-icon"></span>Membership</h2>
                      <ul class="doctor-pro-membership cf">
                        <?php foreach($val as $values): ?>
                          <li><?php echo $values['description1'] ?></li>
                        <?php endforeach; ?>
                      </ul>
                      <div class="doctor-pro-tab-show-more-link">
                        <span class="membership-view-more">
                          + View all
                        </span>
                      </div>
                    </div>
                    <?php endif; ?>
                    <?php if($row == 'Registrations'): ?>
                    <div class="doctor-pro-tab-one-third">
                      <h2><span class="registrations-icon"></span>Registrations</h2>
                      <ul class="doctor-pro-registrations cf">
                        <?php foreach($val as $values): ?>
                          <li><?php echo $values['description1'].' - '.$values['description2'].' '.$values['from_year']  ?></li>
                        <?php endforeach; ?>
                      </ul>
                      <div class="doctor-pro-tab-show-more-link">
                        <span class="registrations-view-more">
                          + View all
                        </span>
                      </div>
                    </div>
                    <?php endif; ?>
                    <?php if($row == 'Experience'): ?>
                    <div class="doctor-pro-tab-one-third">
                      <h2><span class="experience-icon"></span>Experience</h2>
                      <ul class="doctor-pro-experience cf">
                        <?php foreach($val as $values): ?>
                          <li><?php echo $values['description1'].' '.$values['description2'].' '.$values['description3'].' '.$values['from_year'].'-'.$values['to_year']  ?></li>
                        <?php endforeach; ?>
                      </ul>
                      <div class="doctor-pro-tab-show-more-link">
                        <span class="experience-view-more">
                          + View all
                        </span>
                      </div>
                    </div>
                    <?php endif; ?>
                    <?php if($row == 'Specializations'): ?>
                    <div class="doctor-pro-tab-one-third">
                      <h2><span class="specialization-icon"></span>Specializations</h2>
                      <ul class="doctor-pro-specializations cf">
                        <?php foreach($val as $values): ?>
                          <li><?php echo $values['description1'] ?></li>
                        <?php endforeach; ?>
                      </ul>
                      <div class="doctor-pro-tab-show-more-link">
                        <span class="specializations-view-more">
                          + View all
                        </span>
                      </div>
                    </div>
                    <?php endif; ?>
                    <?php if($row == 'AwardsAndRecognitions'): ?>
                    <div class="doctor-pro-tab-one-third">
                      <h2><span class="award-icon"></span>Awards and Recognitions</h2>
                      <ul class="doctor-pro-award cf">
                        <?php foreach($val as $values): ?>
                          <li><?php echo $values['description1'].' '.$values['from_year']  ?></li>
                        <?php endforeach; ?>
                      </ul>
                      <div class="doctor-pro-tab-show-more-link">
                        <span class="award-view-more">
                          + View all
                        </span>
                      </div>
                    </div>
                    <?php endif; ?>
                  <?php if(($r == 2) || (sizeof($doctor['detail'])-1 == $i)): ?>
                  </div>
                  <?php 
                    endif; 
                    $i++;
                    endforeach; 
                  ?>
                  <?php if(isset($papers)){ ?>
                  <div class="doctor-profile-more-details">
                    <h2><span class="award-icon"></span>Papers Published</h2>
                    <ul class="doctor-pro-papers-published cf">
                      <?php foreach($papers as $paper) ?>
                      <li class="two-third margin-bottom-0 last"><?php echo $paper['description1']; ?></li>
                    </ul>
                  </div>
                  <?php }?>
                </div>
                <?php endif; ?>
                <div id="tabs-3-doctor-profile"><!--tabs-3-doctor-profile Start-->
                  <div class="doctor-review1-more-details cf"><!--doctor-review1-more-details Start-->
                    <div class="doctor-review1-more-details_heading cf">
                      Patient Reviews <span>for <?php echo $doctor['doctor_name']; ?></span>
                    </div>
                    <div class="doctor-review1-more-details_write_review cf"><!--doctor-review1-more-details_write_review Start-->
                      <div class="one-half margin-bottom-0">
                        <div class="doctor-review1-Box1"><!--doctor-review1-Box1 Start-->
                          <h2>Write a Review</h2>
                          <textarea class="review_text_field_box" name="review_message" cols="" rows=""></textarea>
                        </div><!--doctor-review1-Box1 End-->
                      </div>
                      <div class="one-half last margin-bottom-0">
                        <div class="doctor-review1-Box2"><!--doctor-review1-Box2 Start-->
                          <h2>Rate Your Experience</h2>
                          <div class="smile_box1">
                            <p> <a href="javascript:void(0);"><img id="smiley1" src="<?php echo IMAGE_URL; ?>smile11.png" alt="" title="" /></a></p>
                            <p> <a href="javascript:void(0);"><img id="smiley2" src="<?php echo IMAGE_URL; ?>smile22.png" alt="" title="" /></a></p>
                            <p> <a href="javascript:void(0);"><img id="smiley3" src="<?php echo IMAGE_URL; ?>smile33.png" alt="" title="" /></a></p>
                          </div>
                          <div class="review1-bt" id="review_submit_bnt"><a href="javascript:void(0);">Submit</a></div>
                        </div><!--doctor-review1-Box2 End-->
                      </div>
                    </div><!--doctor-review1-more-details_write_review End-->
                    <div class="doctor-patients-review1-more-details_write_review cf"><!--doctor-patients-review1-more-details_write_review Start-->
                      <?php foreach($reviews as $row): ?>
                      <div class="doctor-patients-review1-moreInner cf"><!--doctor-patients-review1-moreInner Start-->
                        <div class="patient1-profile-photo-panel"><!--patient1-profile-photo-panel Start-->
                          <div class="patient1-profile-photo">
                            <?php
                              if(!empty($row->image)):
                              if(strpos($row->image,"media")!==false):
                            ?>
                                    <img src="<?=BASE_URL.$row->image?>" />
                                    <?php else: ?>
                            <img src="<?=$row->image?>" />
                            <?php endif; ?>
                            <?php else: ?>
                            <img src="<?=IMAGE_URL?>default_profile.jpg" />
                            <?php endif; ?>
                          </div>
                        </div><!--patient1-profile-photo-panel End-->
                        <div class="patient1-profile-description-panel"><!--patient1-profile-description-panel Start-->
                          <h2><?php echo $row->name ?> <!--- <span>a Verified Patient</span>--></h2>
                          <p class="bold-text2"><?php echo date('M d, Y', strtotime($row->added_on))?> -</p>
                          <p class="bold-text"><?php echo $row->comment?></p>
                        </div><!--patient1-profile-description-panel End-->
                      </div><!--doctor-patients-review1-moreInner End-->
                      <?php endforeach; ?>
                      <div class="review2-bt"><a href="javascript:void(0);">View All Reviews</a></div>
                    </div><!--doctor-patients-review1-more-details_write_review End-->
                  </div><!--doctor-review1-more-details Start-->
                </div><!--tabs-3-doctor-profile End-->
              </div><!--End tabs container-->
            </div><!--End tabs-->
          </div>
        </div>
      </div>
    </div>
    <div id="footer">
	    <?php $this->load->view('common/footer'); ?>
    </div>
    <!-- Popup code by Naved begins -->
    <div style="clear:both" ></div>
    <div class="view-map-popup" style="display: none;">
      <a target="_blank" id="view-map-popup-link" >
	      <img id="view-map-popup-img" src="" alt="Google Map" style="width:100%;height:100%">
      </a>
    </div>
    <div class="modalbpopup" style="display: none;">
    	<div class="container">
      	<center>
	        <div>
          <h3 style="padding: 0 10px;">Please login with facebook to post the review</h3><br>
          <a href="javascript:;" onClick="login();">
          	<img src="<?=IMAGE_URL?>fb_login.png" border="0" style="width: 265px;" />
          </a><br><br>
        </div>
        </center>
      </div>
    </div>
    <div class="modalbpopup2" style="display: none;">
	    <img src="https://www.bookdrappointment.com/static/images/bdaloader.gif">
    </div>
    <script type="text/javascript">
    <?php
    function js_str($s)
    {
			return '{label:"' . addcslashes(ucwords($s['name']), "\0..\37\"\\") . '",value:"'.$s['url_name'].'"}';
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
  	  echo 'var defaultlocation = \'\'';
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
    <!--Popup code by Naved Ends-->
    <?php $this->load->view('common/bottom'); ?>
    <script src="<?php echo JS_URL; ?>owl.carousel.js"></script>
    <script src="<?php echo JS_URL; ?>lightbox.js"></script>
    <script src="<?php echo JS_URL; ?>jquery.bpopup.min.js"></script>
    <script type="text/javascript">
    window.fbAsyncInit = function()
    {
			FB.init({
				appId      : '<?=$this->config->item('appId') ?>',
				xfbml      : true,
				version    : 'v2.1'
			});
    };
    (function(d, s, id){
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)){
				return;
			}
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/sdk.js";
			fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    function fb_api()
    {
			$(".modalbpopup2").bPopup(
			{
				positionStyle: 'fixed',
				closeClass: 'modalclose'
			});
			FB.api('/me', function(response)
			{
				var name = response.name;
				var email = response.email;
				var fbid = response.id;
				var g = $(".review_text_field_box").val().trim();
				console.log(encodeURI(g));
				$.post( "/profile/postreview",
				{
					doctorid: "<?=$doctor_id?>",
					message: encodeURI(g),
					rating: rating_value,
					name: name,
					email: email,
					fbid: fbid
				}).done(function( data )
				{
				$(".modalbpopup2").bPopup().close();
					window.location.replace('/profile/<?php echo url_string(replace_special_chars($doctor['doctor_name']))?>/<?php echo $doctor_id;?>.html');
				});
			});
    }
    function fb_login()
    {
			FB.login(function(response){
			if (response.authResponse)
			{
				fb_api();
			}else{}
			},{scope: 'email,public_profile',return_scopes: true});
    }
    function login()
    {
			$(".modalbpopup").bPopup().close();
			$(".modalbpopup2").bPopup(
			{
				positionStyle: 'fixed',
				closeClass: 'modalclose'
			});
			FB.getLoginStatus(function(response)
			{
				if (response.status === 'connected')
				{
					var uid = response.authResponse.userID;
					var accessToken = response.authResponse.accessToken;
					fb_api();
					//console.log(uid);console.log(response);
				} else if (response.status === 'not_authorized')
				{
					fb_login();
				} else
				{
					fb_login();
				}
			});
			$(".modalbpopup2").bPopup().close();
    }
    </script>
    <script type="text/javascript">
    <?php if($doctor_id =='17964'): ?>
    $(document).ready(function() {
    // Configure/customize these variables.
    var showChar = 200; // How many characters are shown by default
    var ellipsestext = "...";
    var moretext = "more";
    var lesstext = "less";
    $('.more').each(function() {
    var content = $(this).html();
    if(content.length > showChar) {
    var c = content.substr(0, showChar);
    var h = content.substr(showChar, content.length - showChar);
    var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';
    $(this).html(html);
    }
    });
    $(".morelink").click(function(){
    if($(this).hasClass("less")) {
    $(this).removeClass("less");
    $(this).html(moretext);
    } else {
    $(this).addClass("less");
    $(this).html(lesstext);
    }
    $(this).parent().prev().toggle();
    $(this).prev().toggle();
    return false;
    });
    });
    <?php endif; ?>
    $(function()
    {
    /*$( "#tabs" ).tabs();*/
    $( "#tabs-doctor-profile" ).tabs();
    });
    var loggedin = <?=$loginchk;?>;
    var rating_value = 0;
    $(document).ready(function()
    {
    <?php
    $message = $this->session->userdata('message');
    $this->session->unset_userdata('message');
    if(isset($message) && $message == '1')
    echo 'alert("Your review will be posted after verification");';
    ?>
    var icon1_clicked = false;
    var icon2_clicked = false;
    var icon3_clicked = false;
    $("#smiley1").mouseover(function()
    {
    if(icon1_clicked == false)
    $(this).attr('src', '<?php echo IMAGE_URL; ?>smile1.png');
    });
    $("#smiley1").mouseout(function()
    {
    if(icon1_clicked == false)
    $(this).attr('src', '<?php echo IMAGE_URL; ?>smile11.png');
    });
    $("#smiley2").mouseover(function()
    {
    if(icon2_clicked == false)
    $(this).attr('src', '<?php echo IMAGE_URL; ?>smile2.png');
    });
    $("#smiley2").mouseout(function()
    {
    if(icon2_clicked == false)
    $(this).attr('src', '<?php echo IMAGE_URL; ?>smile22.png');
    });
    $("#smiley3").mouseover(function()
    {
    if(icon3_clicked == false)
    $(this).attr('src', '<?php echo IMAGE_URL; ?>smile3.png');
    });
    $("#smiley3").mouseout(function()
    {
    if(icon3_clicked == false)
    $(this).attr('src', '<?php echo IMAGE_URL; ?>smile33.png');
    });
    $('#smiley1').click(function()
    {
    rating_value = 1;
    icon1_clicked = true;
    icon2_clicked = false;
    icon3_clicked = false;
    $('#smiley1').attr('src', '<?php echo IMAGE_URL; ?>smile1.png');
    $('#smiley2').attr('src', '<?php echo IMAGE_URL; ?>smile22.png');
    $('#smiley3').attr('src', '<?php echo IMAGE_URL; ?>smile33.png');
    });
    $('#smiley2').click(function()
    {
    rating_value = 2;
    icon1_clicked = false;
    icon2_clicked = true;
    icon3_clicked = false;
    $('#smiley1').attr('src', '<?php echo IMAGE_URL; ?>smile11.png');
    $('#smiley2').attr('src', '<?php echo IMAGE_URL; ?>smile2.png');
    $('#smiley3').attr('src', '<?php echo IMAGE_URL; ?>smile33.png');
    });
    $('#smiley3').click(function()
    {
    rating_value = 3;
    icon1_clicked = false;
    icon2_clicked = false;
    icon3_clicked = true;
    $('#smiley1').attr('src', '<?php echo IMAGE_URL; ?>smile11.png');
    $('#smiley2').attr('src', '<?php echo IMAGE_URL; ?>smile22.png');
    $('#smiley3').attr('src', '<?php echo IMAGE_URL; ?>smile3.png');
    });
    $("#review_submit_bnt").click(function()
    {
    //							console.log(rating_value);
    if(rating_value != 1 && rating_value != 2 && rating_value != 3)
    {
	    alert('Please rate your experience');
    }
    else
    {
    console.log($(".review_text_field_box").val());
    /*if(loggedin == 0)
    alert("Please login to post a review");
    else
    window.location.replace('/profile/postreview?doctorid=<?=$doctor_id?>&message='+$(".review_text_field_box").val().trim()+'&rating='+rating_value);*/
    FB.getLoginStatus(function(response)
    {
    if(response.status === 'connected')
    {
    fb_api();
    }
    else
    {
    var bPopup = $(".modalbpopup").bPopup(
    {
    positionStyle: 'fixed',
    closeClass: 'modalclose'
    });
    }
    });
		}
    });
    // View more / less services
    $('.doctor-pro-specializations li:gt(2)').hide();
    $(".specializations-view-more").click(function()
    {
    $(".doctor-pro-specializations li:gt(2)").toggle(500);
    var $this = $(this);
    $this.toggleClass('specializations-view-more');
    if($this.hasClass('specializations-view-more'))
    {
    $this.text('+ View all');
    } else
    {
    $this.text('- View less');
    }
    });
    $('.doctor-pro-service li:gt(17)').hide();
    $(".service-view-more").click(function()
    {
    $(".doctor-pro-service li:gt(17)").toggle(500);
    var $this = $(this);
    $this.toggleClass('service-view-more');
    if($this.hasClass('service-view-more'))
    {
    $this.text('+ View all');
    } else
    {
    $this.text('- View less');
    }
    });
    // View more / less education
    $('.doctor-pro-education li:gt(2)').hide();
    $(".education-view-more").click(function()
    {
    $(".doctor-pro-education li:gt(2)").toggle(500);
    var $this = $(this);
    $this.toggleClass('education-view-more');
    if($this.hasClass('education-view-more'))
    {
    $this.text('+ View all');
    } else
    {
    $this.text('- View less');
    }
    });
    // View more / less Memberships
    $('.doctor-pro-membership li:gt(2)').hide();
    $(".membership-view-more").click(function()
    {
    $(".doctor-pro-membership li:gt(2)").toggle(500);
    var $this = $(this);
    $this.toggleClass('membership-view-more');
    if($this.hasClass('membership-view-more'))
    {
    $this.text('+ View all');
    } else
    {
    $this.text('- View less');
    }
    });
    // View more / less Registrations
    $('.doctor-pro-registrations li:gt(1)').hide();
    $(".registrations-view-more").click(function()
    {
    $(".doctor-pro-registrations li:gt(1)").toggle(500);
    var $this = $(this);
    $this.toggleClass('registrations-view-more');
    if($this.hasClass('registrations-view-more'))
    {
    $this.text('+ View all');
    } else
    {
    $this.text('- View less');
    }
    });
    // View more / less Experience
    $('.doctor-pro-experience li:gt(2)').hide();
    $(".experience-view-more").click(function()
    {
    $(".doctor-pro-experience li:gt(2)").toggle(500);
    var $this = $(this);
    $this.toggleClass('experience-view-more');
    if($this.hasClass('experience-view-more'))
    {
    $this.text('+ View all');
    } else
    {
    $this.text('- View less');
    }
    });
    // View more / less Award
    $('.doctor-pro-award li:gt(2)').hide();
    $(".award-view-more").click(function()
    {
    $(".doctor-pro-award li:gt(2)").toggle(500);
    var $this = $(this);
    $this.toggleClass('award-view-more');
    if($this.hasClass('award-view-more'))
    {
    $this.text('+ View all');
    } else
    {
    $this.text('- View less');
    }
    });
    $('.doctor-patients-review1-moreInner:gt(1)').hide();
    $(".review2-bt").click(function()
    {
    $(".doctor-patients-review1-moreInner").show(500);
    $(".review2-bt").hide();
    });
    });
    </script>
  </body>
</html>