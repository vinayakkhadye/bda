<!doctype html>
<html lang="en">
<head>
    <?php $this->load->view('common/head'); ?>
    <!-- for any custom changes from developer side used below file-->
    <link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>bda.min.css?v=3">    
</head>
<body>
	<div id="hover"></div>
	<div id="header">
  	<?php $this->load->view('common/header'); ?>
  </div>
  <div id="banner">
	  <div class="container">
      <div class="doctor-image">
      	<img src="<?=IMAGE_URL?>search-panel-bg.png" alt="Doctor Image"> 
      </div>
      <ul class="appointment-steps">
        <li class="appointment-step-1">
          <span>STEP 1</span>
          Find a Doctor
        </li>
        <li class="appointment-step-2">
          <span>STEP 2</span>
          Select Date & Time
        </li>
        <li class="appointment-step-3">
          <span>STEP 3</span>
          Book Appointment
        </li>
        <li class="appointment-step-4">
          <span>STEP 4</span>
          Consult Doctor
        </li>
      </ul>
			<div id="tabs">
        <ul class="cf">
          <li>
          	<a href="#tabs-1" title=""><span class="mobile-view-hide">Search by Speciality</span><span class="mobile-view-show">Speciality</span></a>
					</li>
          <li>
          	<a href="#tabs-2" title=""><span class="mobile-view-hide">Search by Name</span><span class="mobile-view-show">Doctor</span></a>
					</li>
          <li>
          	<a href="#tabs-3" title=""><span class="mobile-view-hide">Search by Clinic / Hospital Name</span><span class="mobile-view-show">Clinic</span></a>
					</li>
        </ul>
        <div id="tabs_container">
        <div id="tabs-1"> 
          <input class="search-speaciality" name="speciality" type="text" id="speciality" value="" url-data="" placeholder="Dentist, Pediatrician, Gynaecologist etc." />
          <input type="text" name="speciality" id="speciality-x" disabled="disabled" style="color: #CCC; position: absolute; background: transparent; z-index: 1; display: none; "/>
              
          <input class="search-location" name="location" type="text" id="location" value="" url-data="" placeholder="in Location" />
            <input type="text" name="location" id="location-x" disabled="disabled" style="color: #CCC; position: absolute; background: transparent; z-index: 1; display: none;"/>
          
          <input type="submit">
          <img src="<?=IMAGE_URL?>free-text.jpg" alt="Ohh yes It's Free"> 
        </div>
        <div id="tabs-2"> 
	        <input class="search-name" type="text" name="doctor" id="doctor_name" placeholder="Doctor Name" />

          <input type="submit">
          <img src="<?=IMAGE_URL?>free-text.jpg" alt="Ohh yes It's Free"> 
        </div>
        <div id="tabs-3">
	        <input class="search-name" type="text" id="clinic_name" name="clinic" placeholder="Clinic Name"/>
          <input type="submit">
          <img src="<?=IMAGE_URL?>free-text.jpg" alt="Ohh yes It's Free"> 
        </div>
        </div>
      </div>
      <?php if($cityName=='pune'){ ?>
      <div class="cf thumb-slider">
      	<a href="<?=BASE_URL.$cityName?>/health-utsav?place=mirchandani-palms" title="Pune Health Utsav Pimple Saudagar Mirchandani Palms">
	        <img src="<?=IMAGE_URL?>healthutsav_mirchandani.jpg" alt="Pune Health Utsav Pimple Saudagar Mirchandani Palms" style="width:49%">
        </a>
        <span style="width:20%"></span>
        <a href="<?=BASE_URL.$cityName?>/health-utsav?place=dwarkadeesh-residency" title="Pune Health Utsav Pimple Saudagar Dwarkadeesh Residency">
	        <img src="<?=IMAGE_URL?>healthutsav_dwarkadeesh.jpg" alt="Pune Health Utsav Pimple Saudagar Dwarkadeesh Residency" style="width:49%">
        </a>
      </div>
      
      <?php } ?>
      <?php
			if(isset($top_speciality) && is_array($top_speciality) && sizeof($top_speciality)>0)
			{ ?>
			<div class="thumb-slider"> 
        <div id="thumb-slider-owl-demo" class="owl-carousel">
        <?php foreach($top_speciality as $top_spKey=>$top_spVal)
				{ ?>
        <div class="item">
          <span><img src="<?php echo BASE_URL.$top_spVal['display_image']?>" alt="<?=$top_spVal['display_name']?>"/></span>
          <p id="display_term"><?=$top_spVal['display_name']?></p>
          <p  id="term"><?=$top_spVal['url_name']?></p>
          </div>
        <?php }?>
        </div>
        <div class="thumbSliderCustomNavigation">
          <a class="btn prev-thumb-slider">Previous</a>
          <a class="btn next-thumb-slider">Next</a>
        </div>
      </div>
			<?php }?>
      <!--div class="banner-play-store-image cf">
      	<img src="<?=IMAGE_URL?>banner-play-store-image.png" alt="Icon Google Play Store" class="item">
      </div-->
      <div class=" cf">
        <div class="row">
          <div class="col-lg-12" >
            <a href="https://play.google.com/store/apps/details?id=com.bda.patientapp&hl=en">
            	<img src="<?=IMAGE_URL?>patients_tab.jpg" alt="Icon Google Play Store" class="item" >
            </a>
            <a href="https://play.google.com/store/apps/details?id=com.bookdrappointment.doctorapp&hl=en">
            	<img src="<?=IMAGE_URL?>doctor_tab.jpg" alt="Icon Google Play Store" class="item" >
						</a>
          </div>  
        </div>
      </div>
		</div>
  </div>
  <div id="content">
    <div class="app-display-panel">
      <div class="container">
          <div class="one-half margin-bottom-0">
          <h2>Smart Mobile App for Doctors</h2>
          <h3>Digitalize your Practice</h3>
          <div class="mobile-view-show">
            <div class="one-half last">
                  <img src="<?=IMAGE_URL?>app-for-doctor-image.jpg" alt="Google Play Store BDA App for Doctor">
						</div>
            <div class="play-store-image cf">
              <a href="https://play.google.com/store/apps/details?id=com.bookdrappointment.doctorapp&hl=en">
	              <img src="<?=IMAGE_URL?>play-store-image-black.jpg" class="float-right" alt="Google Play Store BDA App link">
              </a>
						</div>
          </div>
          <p>Manage your Appointments easily</p>
          <p>Edit & Update your	Online Profile</p>
          <p>Maintain your Patient Database</p>
          <p>Send Appointment Reminder  SMS to Patients</p>
          <div class="play-store-image mobile-view-hide cf">
          <a href="https://play.google.com/store/apps/details?id=com.bookdrappointment.doctorapp&hl=en">
          <img src="<?=IMAGE_URL?>play-store-image-black.jpg" class="float-right" alt="Google Play Store BDA App link">
            </a>
          </div>
          </div>
          <div class="one-half last margin-bottom-0 mobile-view-hide">
          <img src="<?=IMAGE_URL?>app-for-doctor-image.jpg" alt="Google Play Store BDA App">
          </div>
          <div class="cf"></div>
        </div>
    </div>
    <div class="app-display-panel">
      <div class="container">
        <div class="one-half margin-bottom-0 mobile-view-hide">
        <img src="<?=IMAGE_URL?>app-for-patient-image.jpg" alt="Google Play Store BDA App for Patient">
        </div>
        <div class="one-half last margin-bottom-0">
        <h2>Smart Mobile App for Patients</h2>
        <h3>Best Doctors at your Fingertips</h3>
        <div class="one-half mobile-view-show">
        <img src="<?=IMAGE_URL?>app-for-patient-image.jpg" alt="Google Play Store BDA App for Patient">
        </div>
        <p>Find a Trusted Doctor, nearby</p>
        <p>Book Doctor Appointment instantly, Online</p>
        <p>Select Doctor based on Happy Patient Reviews </p>
        <p>Manage PHR (Personal Health Records) Online & Access from anywhere</p>
        <div class="play-store-image cf">
          <a href="https://play.google.com/store/apps/details?id=com.bda.patientapp&hl=en">
	          <img src="<?=IMAGE_URL?>play-store-image-black.jpg" class="float-right" alt="Google Play Store BDA App for Patient link">
          </a>
        </div>
        </div>
        <div class="cf"></div>
      </div>
    </div>
    <?php if(isset($latest_doctor) && is_array($latest_doctor) && sizeof($latest_doctor) > 0)
		{ ?> 
    <div class="doctors-display-panel">
      <h1>Welcome Doctors!</h1>
      <div class="doctor-profile-display-panel"> 
        <div id="doctor-profile-display-slider" class="owl-carousel">
	        <?php foreach($latest_doctor as $key=>$val)
					{
						if($val['doctor_image'])
						{
							if(strpos($val['doctor_image'],"http")!==false)
							{
								$image_url = $val['doctor_image'];
							}else
							{
								$image_url = BASE_URL.$val['doctor_image'];
							}
						}else
						{
							if(strtolower($val['doctor_gender'])=="m")
							{
								$image_url = IMAGE_URL."default_doctor.png";
							}else if(strtolower($val['doctor_gender'])=="f")
							{
								$image_url = IMAGE_URL."default_doctor.png";
							}	
						} 
						?>
          <div class="item">
          <img src="<?php echo $image_url;?>" title="" alt="Doctor Profile Photo" style="width:104px;" />
          <p class="doctor-name"><?php echo ucwords($val['doctor_name']);?></p>
          <p class="doctor-degree">
						<?php
            if(isset($val['qualification_detail']) && is_array($val['qualification_detail']))
						{
							$qualification_str = ''; 
							foreach($val['qualification_detail'] as $quKey=>$quVal)
							{
								$qualification_str .=  ucwords($quVal['name']).", ";
							}
							echo substr(trim($qualification_str,", "),0,25);
            }
            ?>
          </p>
          <p class="doctor-speciality">
						<?php
            if(isset($val['speciality_detail']) && is_array($val['speciality_detail']))
						{
							$speciality_str = ''; 
							foreach($val['speciality_detail'] as $spKey=>$spVal)
							{
								$speciality_str .=  ucwords($spVal['name']).", ";
							}
							echo substr(trim($speciality_str,", "),0,25);
            }
            ?>
          </p>
          <!--<p class="doctor-location">Mumbai</p>-->
          </div>
          <?php }?>
        </div>
        <div class="doctorDisplaySliderCustomNavigation">
          <a class="btn prev-doctor-profile-display-slider">Previous</a>
          <a class="btn next-doctor-profile-display-slider">Next</a>
        </div>
      </div>
	  </div>
    <?php }?>
    <div class="discription-panel">
      <div class="container">
        <p>
        "BookDrAppointment.com as the name suggests is the reliable destination for patients to find a doctor and book doctor appointment online. Our site offers hassle-free search for trusted doctors across cities &amp; a smooth experience ofonline appointment booking. The need of online appointment fordoctors is surely on the rise today as no patient wants to wait for hours at the Doctors clinic for their turn. Browse through to book doctors online appointment on our site with database of trusted doctors to choose from based on their detailed professional showcase and happy patient reviews. This will surely enable &amp; help arrive at a decision of the right Doctor!"
        </p>
      </div>
    </div>
  </div>

  <!-- Pop up on mobile Devices -->
  <?php if($platform  != 'iPhone' OR $platform  != 'iPod' OR $platform  != 'iPad' ){?>
  <div id="popup">
  <img  src="<?=IMAGE_URL?>mobile_web.png">
  <a href="https://play.google.com/store/apps/details?id=com.bda.patientapp&hl=en"><img id="pop_download" src="<?=IMAGE_URL?>download.png"></a>  
  <div id="close2"><label id="pop_label">Continue to Website <span style="color:red;font-size:1.2em">>></span></label></div></div>
  <?php }?>  
  <div id="footer2">
    <?php $this->load->view('common/footer_top_links'); ?>
  </div>
  <div id="footer">
	  <?php $this->load->view('common/footer'); ?>
  </div>
	<?php $this->load->view('common/bottom'); ?>
	<!-- PAGE SPECIFIC JS -->
  <script src="<?=JS_URL?>owl.carousel.js"></script>
	<script type="text/javascript">
	$(document).ready(function(){
		$("#close2").click(function(){
			$("#hover").fadeOut();
			$("#popup").fadeOut();
		});
	});	
		var owl = $("#thumb-slider-owl-demo");
		owl.owlCarousel({
			items : 7, //10 items above 1000px browser width
			itemsDesktop : [1000,7], //5 items between 1000px and 901px
			itemsDesktopSmall : [900,5], // 3 items betweem 900px and 601px
			itemsTablet: [600,4], //2 items between 600 and 0;
			itemsMobile : [480,2], // itemsMobile disabled - inherit from itemsTablet option
			slideSpeed: 1000,
			autoPlay: true
		});
		// Custom Navigation Events
		$(".next-thumb-slider").click(function(){
			owl.trigger('owl.next');
		})
		$(".prev-thumb-slider").click(function(){
			owl.trigger('owl.prev');
		})
		var owl1 = $("#doctor-profile-display-slider");
		owl1.owlCarousel({
			items : 4, //10 items above 1000px browser width
			itemsDesktop : [1024,3], //5 items between 1000px and 901px
			itemsDesktopSmall : [900,2], // 3 items betweem 900px and 601px
			itemsTablet: [600,2], //2 items between 600 and 0;
			itemsMobile : [480,1], // itemsMobile disabled - inherit from itemsTablet option
			slideSpeed: 1000,
			autoPlay: true
		});
		// Custom Navigation Events
		$(".next-doctor-profile-display-slider").click(function(){
			owl1.trigger('owl.next');
		})
		$(".prev-doctor-profile-display-slider").click(function(){
			owl1.trigger('owl.prev');
		})
/*		$(function() {
			$( "#tabs" ).tabs();
		});
*/		$(document).ready(function(){
			$('#menu').slicknav();
			$('.footerCol_New h3').click(function() {
					$('.footerCol_New h3').not($(this)).removeClass('activemenu');
					$(this).toggleClass('activemenu');
					$('.colContent_New').not($(this).next()).removeClass('showmenu_New');
					$(this).next().toggleClass('showmenu_New');
			});
		});
  </script>
</body>
</html>