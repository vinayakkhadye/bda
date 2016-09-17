<!doctype html>
<html>
<head>
	<?php $this->load->view('common/head'); ?>
	<link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>font-styles.css">
	<!-- Owl slider -->
	<link href="<?php echo CSS_URL; ?>owl.carousel.css" rel="stylesheet">
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

  						<div class="Bluelogin-doctor-patients-MobileTop"><!--Bluelogin-doctor-patients-MobileTop Start-->
  							<img src="<?=IMAGE_URL ?>mobile-my.png" alt="">
  						</div><!--Bluelogin-doctor-patients-MobileTop Start-->
  						<div class="Bluelogin-doctor-patients-Inner"><!--Bluelogin-doctor-patients-Inner Start-->



  							<div class="Bluelogin-doctor-patients-Left"><!--Bluelogin-doctor-patients-Left Start-->

  								<div class="Bluelogin-doctor-patients-LeftTop"><!--Bluelogin-doctor-patients-LeftTop Start-->
  									<h2>Upgrade your experience</h2>

  								</div><!--Bluelogin-doctor-patients-LeftTop End-->



  								<div class="Bluelogin-doctor-patients-LeftMidd"><!--Bluelogin-doctor-patients-LeftMidd Start-->

  									<!--<p><a href="#"><img src="<?=IMAGE_URL ?>icon2.png" alt="Login"></a></p>-->
  									<!--<p><a href="#"><img src="<?=IMAGE_URL ?>icon3.png" alt="Login"></a></p>-->


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


  								<div class="Bluelogin-doctor-patients-RightMidd" id="login1-col"><!--Bluelogin-doctor-patients-RightMidd Start-->

  									<div class="RightMar45" id="sign-up"><!--RightMar45 Start-->

  										<span><a href="/register"><img src="<?=IMAGE_URL ?>icon4.png" alt="Sign Up"></a></span>

  										<p><a href="/register">Sign Up</a></p>


  									</div><!--RightMar45 End-->

  									<div class="RightMar45" id="login"><!--RightMar45 Start-->

  										<span><a href="javascript:void(0);"><img src="<?=IMAGE_URL ?>icon5.png" alt="Login"></a></span>

  										<p><a href="javascript:void(0);">Login</a></p>


  									</div><!--RightMar45 End-->


  								</div><!--Bluelogin-doctor-patients-RightMidd End-->

  								<div class="Bluelogin-doctor-patients-RightMidd hide" id="login2-col"><!--Bluelogin-doctor-patients-RightMidd Start-->
  									<div class="Bluelogin-doctor-Main-Login"><!--Bluelogin-doctor-Main-Login Start-->
  										<!--<form action="/login/check" method="POST">-->
                      
  											<input type="email" id="email" name="email" placeholder="Email">
  											<input type="password" id="pass" name="pass" placeholder="* * * *">
  											<a href="javascript:void(0);" class="Bluelogin-doctor-bt" id="login_button">LOGIN</a>
                        <span id="login_error_msg" class="hide"></span>
  									<!--	</form>-->
  									</div><!--Bluelogin-doctor-Main-Login End-->
										
  									<div class="Bluelogin-doctor-Main-Login1"><!--Bluelogin-doctor-Main-Login1 Start-->
  										<!--<p><input type="checkbox" id="remember_me" name="_remember_me" checked /> Remember me</p>-->

  										<p><a href="javascript:;" id="forgotPass">Forgot Password?</a></p>


  									</div><!--Bluelogin-doctor-Main-Login1 End-->
                    <div class="Bluelogin-doctor-Main-Login" ><!--Bluelogin-doctor-Main-Login Start-->
	                    <a id="backto_login_signup"> << Sign up </a>
                    </div>
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
<div class="modalbpopup hide" >
  <div class="container">
    <center id="email_show">
      <p>Enter your email <br>to receive your password reset link</p>
      <div>
        <input type="email" name="email" id="emailforgotpass"  /><!--style="width: 250px; height: 25px;"-->
        <p id="forgotpassmodalerrormsg" >This email is not present in our system</p><!--style="display:none; color: red;"-->
        <p class="hide" id="forgotpassmodalmsg">Checking email....</p>
        <input type="button" class="btn" id="forgotpass_email_send" name="submit" value="Submit" />
      </div>
    </center>
		<center id="successfull_msg" class="hide"><p>Password reset link was sent successfully</p></center>
  </div>
</div>
<div id="fb-root"></div>
<?php $this->load->view('common/bottom'); ?>
<script src="<?php echo JS_URL; ?>owl.carousel.js"></script>
<script src="<?php echo JS_URL; ?>lightbox.js"></script>
<script src="<?php echo JS_URL; ?>jquery.bpopup.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
$("#pass").keyup(function (e) {
		if (e.keyCode == 13) {
				$("#login_button").click();
		}
});	

$("#forgotPass").click(function(){
	$("#email_show").show();
	$("#emailforgotpass").val('');
	$("#forgotpass_email_send").show();
	$("#forgotpassmodalerrormsg").hide();
	$("#forgotpassmodalmsg").hide();
	$("#successfull_msg").hide();
	
	var bPopup = $(".modalbpopup").bPopup({
		positionStyle: 'fixed',
		closeClass: 'modalclose'
	});
});

$("#forgotpass_email_send").click(function(){
	$("#forgotpass_email_send").hide();
	$("#forgotpassmodalerrormsg").hide();
	$("#forgotpassmodalmsg").show();
	var email = $("#emailforgotpass").val();
	$.ajax({
		url : '/login/forgotpassword',
		type : 'POST',
		data :{
		'email'	: email
		},
		success: function(resp){
			if(resp.substr(0,7) == 'success'){
				//$(".container").html('<center><br><br><h2 style="color: rgb(119, 119, 119);">Password reset link was sent successfully</h2></center>');
				$("#email_show").hide();
				$("#successfull_msg").show();
				setTimeout(function()
				{
					$(".modalbpopup").bPopup().close();
				}, 2000);
			}else{
				$("#forgotpassmodalmsg").hide();
				$("#submitbtn").show();
				$("#forgotpassmodalerrormsg").show();
			}
	}
	});
});
						
});

</script>
