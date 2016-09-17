<!doctype html>
<html>
<head>
	<?php $this->load->view('common/head'); ?>
	<link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>font-styles.css">
	<!-- Owl slider -->
	<link href="<?php echo CSS_URL; ?>owl.carousel.css" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>slicknav.css">
	<link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>lightbox.css">
  <link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>bda.css">
    <!--[if gte IE 9]>
      <style type="text/css">
        .gradient {
           filter: none;
        }
      </style>
      <![endif]-->
  </head>

  <body>
  	<div id="header">
  		<?php $this->load->view('common/header'); ?>
  	</div>

  	<div id="content"><!--content Start-->

  		<div class="container cf"><!--container cf Start-->

  			<div class="full-width margin-bottom-0 last"><!--full-width margin-bottom-0 last Start-->

  				<div class="login-doctor-patients"><!--login-doctor-patients Start-->


  					<div class="login-doctor-patients-moreInner"><!--login-doctor-patients-moreInner Start-->


  						<div class="Bluelogin-doctor-patients-Inner"><!--Bluelogin-doctor-patients-Inner Start-->


  							<div class="Bluelogin-doctor-patients-Left"><!--Bluelogin-doctor-patients-Left Start-->

  								<div class="Bluelogin-doctor-patients-LeftTop"><!--Bluelogin-doctor-patients-LeftTop Start-->
  									<h2>Upgrade your experience</h2>

  								</div><!--Bluelogin-doctor-patients-LeftTop End-->



  								<div class="Bluelogin-doctor-patients-LeftMidd"><!--Bluelogin-doctor-patients-LeftMidd Start-->

  									<!--<p><a href="#"><img src="<?php echo IMAGE_URL; ?>icon2.png" alt="Login"></a></p>-->
  									<!--<p><a href="#"><img src="<?php echo IMAGE_URL; ?>icon3.png" alt="Login"></a></p>-->


<!--  									<div class="Connect_FB"><a href="<?php echo $login_url; ?>">Connect with Facebook</a></div>
  									<div class="Connect_Google"><a href="http://www.bookdrappointment.com/login/google">Connect with Google</a></div>
-->
  									<div class="Connect_FB"><a href="<?php echo $login_url; ?>"><img alt="Connect with Facebook" src="<?=IMAGE_URL?>icon10.png"></a></div>
  									<div class="Connect_Google"><a href="http://www.bookdrappointment.com/login/google"><img alt="Connect with Google" src="<?=IMAGE_URL?>icon11.png"></a></div>
                    

  								</div><!--Bluelogin-doctor-patients-LeftMidd End-->





  							</div><!--Bluelogin-doctor-patients-Left End-->


  							<div class="Bluelogin-doctor-patients-Right"><!--Bluelogin-doctor-patients-Right Start-->

  								<div class="Login_Cartoon45"></div>
  								<div class="appointment-orgd45">OR</div>	

  								<div class="Bluelogin-doctor-patients-RightTop"><!--Bluelogin-doctor-patients-RightTop Start-->
  									<h2>Use your Email Address </h2>

  								</div><!--Bluelogin-doctor-patients-RightTop End-->


  								<div class="Bluelogin-doctor-patients-RightMidd"><!--Bluelogin-doctor-patients-RightMidd Start-->
										
  									<div class="Bluelogin-doctor-Main-Login"><!--Bluelogin-doctor-Main-Login Start-->
  										<form action="" method="POST">
  											<input type="text" id="name" name="name" placeholder="Name">
  											<input type="email" id="email" name="email" placeholder="Email">
  											<input type="hidden" value="Continue" name="signup">
  											<a href="javascript:void(0);" id="signup-continue-btn" class="Bluelogin-doctor-bt">CONTINUE</a>
  										</form>
  									</div><!--Bluelogin-doctor-Main-Login End-->
										<div class="Bluelogin-doctor-Main-Login"><?php echo validation_errors('<div class="signup_error">', '</div>'); ?></div>



  								</div><!--Bluelogin-doctor-patients-RightMidd End-->



  							</div><!--Bluelogin-doctor-patients-Right End-->

  						</div><!--Bluelogin-doctor-patients-Inner End-->



  					</div><!--login-doctor-patients-moreInner End-->




  				</div><!--login-doctor-patients End-->

  			</div><!--full-width margin-bottom-0 last End-->


  		</div><!--container cf End-->

  	</div><!--content End-->


  	<div id="footer">
  		<?php $this->load->view('common/footer'); ?>
  	</div>
  	<div id="fb-root"></div>
  	<?php $this->load->view('common/bottom'); ?>
  	<script src="<?php echo JS_URL; ?>jquery.slicknav.js"></script>
  	<script src="<?php echo JS_URL; ?>owl.carousel.js"></script>
  	<script src="<?php echo JS_URL; ?>lightbox.js"></script>
  	<script type="text/javascript">
  		var owl2 = $("#select-date-slider-owl-demo");

  		owl2.owlCarousel({

		  items : 3, //10 items above 1000px browser width
		  itemsDesktop : [1000,3], //5 items between 1000px and 901px
		  itemsDesktopSmall : [900,2], // 3 items betweem 900px and 601px
		  itemsTablet: [600,2], //2 items between 600 and 0;
		  itemsMobile : [480,1], // itemsMobile disabled - inherit from itemsTablet option
		  slideSpeed: 1000,
		  autoPlay: false
		});

		  // Custom Navigation Events
		  $(".next-select-date-slider").click(function(){
		  	owl2.trigger('owl.next');
		  })
		  $(".prev-select-date-slider").click(function(){
		  	owl2.trigger('owl.prev');
		  })
		  $(function() {
		  	$( "#tabs" ).tabs();
		  });
		  $(document).ready(function(){
		  	$('#menu').slicknav();
		  });

    /*    function toggleDiv("#quick-appointment") {
           $("#quick-appointment"+divId).toggle();
        }
        */

        $("#phone-appointment").click(function(){
        	$(".phone-appointment-panel").toggle(500);
        });

        $("#quick-appointment").click(function(){
        	$(".select-date-slider").toggle(500);
        });
		/*$(document).ready(function(){
			$("#quick-appointment").click(function(){
				$(".phone-appointment-panel").toggle();
			});
});*/
$("#signup-continue-btn").click(function()
{
	$(this).closest("form").submit();
});


</script>
