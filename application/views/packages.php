<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>
			Book Dr Appointment
		</title>

		<script src="<?php echo JS_URL; ?>login/jquery.min.js"></script>

		<link id="bs-css" href="<?php echo CSS_URL; ?>login/jquery-ui-new.css" rel="stylesheet">
		<link href="<?php echo CSS_URL; ?>login/maine.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>login/style.css" />
		<link type="text/css" rel="stylesheet" href="<?php echo CSS_URL; ?>login/bootstrap.min.css"/>
		<style type="text/css">
			/*this is just to organize the demo checkboxes*/
			label
			{
				margin-right: 20px;
			}
		#apDiv1 {
	position:absolute;
	width:200px;
	height:115px;
	z-index:1;
	overflow: visible;
	visibility: visible;
	left: 1153px;
	top: 145px;
}
        </style>
		<script type="text/javascript">
			$(document).ready(function()
			{
				<?php
				if($this->session->flashdata('package_message') == '1')
				echo "alert('You have already purchased this package');"
				?>
				$(".buy-package-btn2").click(function()
				{
					alert('You have already purchased this package ok');
				});
			});
		</script>

	</head>

	<body>
		<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="pricetable">
			<?php $this->load->view('headertopfull1'); ?>
			<tr>
				<td>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td class="top_bg2">
								<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="pricetableCopy">
									<tr>
										<td width="135" height="41">&nbsp;
											
										</td>
										<td width="35" align="center">
											<img src="<?php echo IMAGE_URL; ?>home_icon.jpg" width="23" height="23" />
										</td>
										<td width="44" valign="bottom">
											<img src="<?php echo IMAGE_URL; ?>devaiter.jpg" width="44" height="40" />
										</td>
										<td class="text">
											Packages
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td valign="top" bgcolor="#f1f2e3">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<?php $this->load->view('doctor_sidebar'); ?>
							<td align="left" valign="top" bgcolor="#FFFFFF">
								<div class="topMain">
								  <div id="pakages_moscot">
										<img src="<?php echo IMAGE_URL; ?>pakages_moscot.png" width="224" height="400" />
									</div>
									<div class="two" style="text-align:center;" >
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="center"><div style="text-align:center; width:100%;"><span style="font:'Eras_Light_ITC'; font-size:38px; color:#CC0000; "> Smart Packages</span> <br />

Choose the Smart Package that suits your Practice. 
    <br />
    You can always upgrade it later by paying the difference! </div></td>
    <td width="250"><img src="<?php echo IMAGE_URL; ?>comingsoon.jpg" width="201" height="121" /></td>
  </tr>
  </table>

                                  </div>
								</div>
								<div class="main">
									<div class="top">
										<img src="<?php echo IMAGE_URL; ?>pakages_logo_image.png" width="77%">
									</div>
									<div class="mainTop">
										<div class="colomn">
											Rs.416/- per month
										</div>
										<div class="colomn">
											Rs.625/- per month
										</div>
										<div class="colomn">
											Rs.875/- per month
										</div>
										<div class="colomn">
											Rs.1125/- per month
										</div>
										<!--<div class="colomn">
											Coming Soon
										</div>-->
									<!--	<div class="colomn">
											Coming Soon
										</div>-->
									</div>
									<div class="mainMiddle">
										<div class="mainMiddleColumn">
											Impressive
											<br/>Online Visibility
										</div>
										<div class="mainMiddleColumn">
											Strong
											<br/>Online Reputation
										</div>
										<div class="mainMiddleColumn">
											Customized Scheduler -
											<br/>Appointments on the go!
										</div>
										<div class="mainMiddleColumn">
											Mark your Impression <br/>
											when your <br/>
											Patients call you
										</div>
										<!--<div class="mainMiddleColumn">
											Digitalize Practice
										</div>-->
									<!--	<div class="mainMiddleColumn">
											Digitalize Practice & <br/>
											Mark your Impression when <br/>
											your Patients call you <br/>
										</div>-->
									</div>
									<div class="middleDown">
										<div class="middle">
											Limited
											<br/>Online Profile Display
										</div>
										<div class="middle">
											Let patients select you based
											<br/>on your complete Impressive
											<br/>Profile with Authentic
											<br/>Patient Reviews & Star Rating
										</div>
										<div class="middle">
											Let your existing and new
											<br/>patients Search for you and
											<br/>Book your Online Appointment
										</div>
										<div class="middle">
											Dedicated Phone <br/>
											Number for all your Practices
										</div>
										<!--<div class="middle">
											Advanced Cloud <br/>
											Technology- Convert your <br/>
											Clinic to Paperless Smart Clinic
										</div>-->
										<!--<div class="middle">
											Advanced Cloud Technology <br/>
											for your Clinic & a Dedicated <br/>
											Phone Number for all your Practices
										</div>-->
									</div>
									<div class="bottomDown" style="margin-top:25px;">
										<div class="left" style="background-image:url('<?php echo IMAGE_URL; ?>s_02.png');">
											<p style="position:relative; top:12px; left:50px;">
												Profile Photograph
											</p>
										</div>
										<div class="bottom">
											<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>
										<div class="bottom">
											<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>
										<div class="bottom">
											<img src="<?php echo IMAGE_URL; ?>check.png"style="position:relative; top:8px;">
										</div>
										<div class="bottom">
											<!-- 	<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;"> -->
										</div>
										<!--<div class="bottom">
											<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>-->
										<!--<div class="bottom">
											<img src="<?php echo IMAGE_URL; ?>check.png"" style="position:relative; top:8px;">
										</div>-->
									</div>
									<!--        WHITE-->
									<div class="bottomDown">
										<div class="left" style="background-image:url('<?php echo IMAGE_URL; ?>s_04.png'); background-color:#000;">
											<p style="margin-top0px;position:relative; top:10px; left:50px;">
												Professional Showcase
											</p>
										</div>
										<div class="bottom" style="background-color: #fff;">
											<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>
										<div class="bottom" style="background-color: #fff;">
											<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>
										<div class="bottom" style="background-color: #fff;">
											<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>
										<div class="bottom" style="background-color: #fff;">
											<!-- 	<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;"> -->
										</div>
										<!--<div class="bottom" style="background-color: #fff;">
											<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>-->
										<!--<div class="bottom" style="background-color: #fff;">
											<img src="<?php echo IMAGE_URL; ?>check.png"" style="position:relative; top:8px;">
										</div>-->
									</div>
									<!--        WHITE ENDS-->
									<!--        GREY-->
									<div class="bottomDown">
										<div class="left" style="background-image:url('<?php echo IMAGE_URL; ?>s_06.png');">
											<p style="position:relative; top:10px; left:50px;">
												Appointment Slots Display
											</p>
										</div>
										<div class="bottom">
											<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>
										<div class="bottom">
											<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>
										<div class="bottom">
											<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>
										<div class="bottom">
											<!-- 	<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;"> -->
										</div>
									<!--	<div class="bottom">
											<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>-->
									<!--	<div class="bottom">
											<img src="<?php echo IMAGE_URL; ?>check.png"" style="position:relative; top:8px;">
										</div>-->
									</div>
									<!--        GREY ENDS-->
									<!--        WHITE-->
									<div class="bottomDown">
										<div class="left" style="background-image:url('<?php echo IMAGE_URL; ?>s_07.png'); background-color:#000;">
											<p style="margin-top0px;position:relative; top:10px; left:50px;">
												Clinic Showcase
											</p>
										</div>
										<div class="bottom" style="background-color: #fff;">
											<!-- <img src="check.png" style="position:relative; top:8px;"> -->
										</div>
										<div class="bottom" style="background-color: #fff;">
											<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>
										<div class="bottom" style="background-color: #fff;">
											<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>
										<div class="bottom" style="background-color: #fff;">
											<!-- 	<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;"> -->
										</div>
										<!--<div class="bottom" style="background-color: #fff;">
											<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>-->
										<!--<div class="bottom" style="background-color: #fff;">
											<img src="<?php echo IMAGE_URL; ?>check.png"" style="position:relative; top:8px;">
										</div>-->
									</div>
									<!--        WHITE ENDS-->
									<!--        GREY-->
									<div class="bottomDown">
										<div class="left" style="background-image:url('<?php echo IMAGE_URL; ?>s_08.png');">
											<p style="position:relative; top:10px; left:50px;">
												Verified Patient Reviews Display
											</p>
										</div>
										<div class="bottom">
											<!-- <img src="check.png" style="position:relative; top:8px;"> -->
										</div>
										<div class="bottom">
											<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>
										<div class="bottom">
											<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>
										<div class="bottom">
											<!-- <img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;"> -->
										</div>
										<!--<div class="bottom">
											<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>-->
									<!--	<div class="bottom">
											<img src="<?php echo IMAGE_URL; ?>check.png"" style="position:relative; top:8px;">
										</div>-->
									</div>
									<!--        GREY ENDS-->
									<!--        WHITE-->
									<div class="bottomDown">
										<div class="left" style="background-image:url('<?php echo IMAGE_URL; ?>s_10.png'); background-color:#000; ">
											<p style="margin-top0px;position:relative; top:10px; left:50px;">
												Happy patients
											</p>
										</div>
										<div class="bottom" style="background-color: #fff;">
											<!-- <img src="check.png" style="position:relative; top:8px;"> -->
										</div>
										<div class="bottom" style="background-color: #fff;">
											<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>
										<div class="bottom" style="background-color: #fff;">
											<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>
										<div class="bottom" style="background-color: #fff;">
											<!-- <img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;"> -->
										</div>
								<!--		<div class="bottom" style="background-color: #fff;">
											<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>-->
										<!--<div class="bottom" style="background-color: #fff;">
											<img src="<?php echo IMAGE_URL; ?>check.png"" style="position:relative; top:8px;">
										</div>-->
									</div>
									<!--        WHITE ENDS-->
									<!--        GREY-->
									<div class="bottomDown">
										<div class="left" style="background-image:url('<?php echo IMAGE_URL; ?>s_11.png');">
											<p style="position:relative; top:10px; left:50px;">
												Appoinment Scheduler
											</p>
										</div>
										<div class="bottom">
											<!-- 	<img src="check.png" style="position:relative; top:8px;"> -->
										</div>
										<div class="bottom">
											<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>
										<div class="bottom">
											<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>
										<div class="bottom">
											<!-- 	<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;"> -->
										</div>
									<!--	<div class="bottom">
											<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>-->
										<!--<div class="bottom">
											<img src="<?php echo IMAGE_URL; ?>check.png"" style="position:relative; top:8px;">
										</div>-->
									</div>
									<!--        GREY ENDS-->
									<!--        WHITE-->
									<div class="bottomDown">
										<div class="left" style="background-image:url('<?php echo IMAGE_URL; ?>s_12.png'); background-color:#000;">
											<p style="margin-top0px;position:relative; top:10px; left:50px;">
												Patient Database Management
											</p>
										</div>
										<div class="bottom" style="background-color: #fff;">
											<!-- 	<img src="check.png" style="position:relative; top:8px;"> -->
										</div>
										<div class="bottom" style="background-color: #fff;">
											<!-- <img src="check.png" style="position:relative; top:8px;"> -->
										</div>
										<div class="bottom" style="background-color: #fff;">
											<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>
										<div class="bottom" style="background-color: #fff;">
											<!-- 	<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;"> -->
										</div>
										<!--<div class="bottom" style="background-color: #fff;">
											<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>-->
									<!--	<div class="bottom" style="background-color: #fff;">
											<img src="<?php echo IMAGE_URL; ?>check.png"" style="position:relative; top:8px;">
										</div>-->
									</div>
									<!--        WHITE ENDS-->
									<!--        GREY-->
									<div class="bottomDown">
										<div class="left" style="background-image:url('<?php echo IMAGE_URL; ?>s_13.png');">
											<p style="position:relative; top:10px; left:50px;">
												Smart Reminders
											</p>
										</div>
										<div class="bottom">
											<!-- <img src="check.png" style="position:relative; top:8px;"> -->
										</div>
										<div class="bottom">
											<!-- <img src="check.png" style="position:relative; top:8px;"> -->
										</div>
										<div class="bottom">
											<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>
										<div class="bottom">
											<!-- 	<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;"> -->
										</div>
									<!--	<div class="bottom">
											<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>-->
									<!--	<div class="bottom">
											<img src="<?php echo IMAGE_URL; ?>check.png"" style="position:relative; top:8px;">
										</div>-->
									</div>
									<!--        GREY ENDS-->
									<!--        WHITE-->
									<div class="bottomDown">
										<div class="left" style="background-image:url('<?php echo IMAGE_URL; ?>s_14.png'); background-color:#000;">
											<p style="margin-top0px;position:relative; top:10px; left:50px;">
												Smart Andriod Mobile App
											</p>
										</div>
										<div class="bottom" style="background-color: #fff;">
											<!-- <img src="check.png" style="position:relative; top:8px;"> -->
										</div>
										<div class="bottom" style="background-color: #fff;">
											<!-- <img src="check.png" style="position:relative; top:8px;"> -->
										</div>
										<div class="bottom" style="background-color: #fff;">
											<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>
										<div class="bottom" style="background-color: #fff;">
											<!-- 	<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;"> -->
										</div>
									<!--	<div class="bottom" style="background-color: #fff;">
											<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>-->
								<!--		<div class="bottom" style="background-color: #fff;">
											<img src="<?php echo IMAGE_URL; ?>check.png"" style="position:relative; top:8px;">
										</div>-->
									</div>
									<!--        WHITE ENDS-->
									<!--        GREY-->
																		<!--        GREY ENDS-->
									<!--        WHITE-->
																		<!--        WHITE ENDS-->
									<!--        GREY-->
									
									<!--        GREY ENDS-->
									<!--        WHITE-->
									
									<!--        WHITE ENDS-->
									<!--        GREY-->
																		<!--        GREY ENDS-->
									<!--        WHITE-->
									
									<!--        WHITE ENDS-->
									<!--        GREY-->
									<div class="bottomDown">
										<div class="left" style="background-image:url('<?php echo IMAGE_URL; ?>s_23.png');">
											<p style="position:relative; top:10px; left:50px;">
												Multiclinic management with
												<br/>ONE phone number
											</p>
										</div>
										<div class="bottom">
											<!-- 	<img src="check.png" style="position:relative; top:8px;"> -->
										</div>
										<div class="bottom">
											<!-- <img src="check.png" style="position:relative; top:8px;"> -->
										</div>
										<div class="bottom">
											<!-- <img src="check.png" style="position:relative; top:8px;"> -->
										</div>
										<div class="bottom">
											<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>
										<!--<div class="bottom">
										 <img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>
-->									<!--	<div class="bottom">
											<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>-->
									</div>
									<!--        GREY ENDS-->
									<!--        WHITE-->
									<div class="bottomDown">
										<div class="left" style="background-image:url('<?php echo IMAGE_URL; ?>s_24.png'); background-color:#000;">
											<p style="margin-top0px;position:relative; top:10px; left:50px;">
												24X7 IVR
												Telephone Service
											</p>
										</div>
										<div class="bottom" style="background-color: #fff;">
											<!-- 	<img src="check.png" style="position:relative; top:8px;"> -->
										</div>
										<div class="bottom" style="background-color: #fff;">
											<!-- <img src="check.png" style="position:relative; top:8px;"> -->
										</div>
										<div class="bottom" style="background-color: #fff;">
											<!-- <img src="check.png" style="position:relative; top:8px;"> -->
										</div>
										<div class="bottom" style="background-color: #fff;">
											<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>
										<!--<div class="bottom" style="background-color: #fff;">
											<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>-->
									<!--	<div class="bottom" style="background-color: #fff;">
											<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>-->
									</div>
									<!--        WHITE ENDS-->
									<!--        GREY-->
									<div class="bottomDown">
										<div class="left" style="background-image:url('<?php echo IMAGE_URL; ?>s_25.png');">
											<p style="position:relative; top:10px; left:50px;">
												Missed call alerts
											</p>
										</div>
										<div class="bottom">
											<!-- <img src="check.png" style="position:relative; top:8px;"> -->
										</div>
										<div class="bottom">
											<!-- <img src="check.png" style="position:relative; top:8px;"> -->
										</div>
										<div class="bottom">
											<!-- <img src="check.png" style="position:relative; top:8px;"> -->
										</div>
										<div class="bottom">
											<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>
									<!--	<div class="bottom">
											<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>-->
										<!--<div class="bottom">
											<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>-->
									</div>
									<!--        GREY ENDS-->
									<!--        WHITE-->
									<div class="bottomDown">
										<div class="left" style="background-image:url('<?php echo IMAGE_URL; ?>s_27.png'); background-color:#000;">
											<p style="margin-top0px;position:relative; top:10px; left:50px;">
												Customised Call
												<br/>Flows to Staff
											</p>
										</div>
										<div class="bottom" style="background-color: #fff;">
											<!-- <img src="check.png" style="position:relative; top:8px;"> -->
										</div>
										<div class="bottom" style="background-color: #fff;">
											<!-- <img src="check.png" style="position:relative; top:8px;"> -->
										</div>
										<div class="bottom" style="background-color: #fff;">
											<!-- <img src="check.png" style="position:relative; top:8px;"> -->
										</div>
										<div class="bottom" style="background-color: #fff;">
											<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>
										<!--<div class="bottom" style="background-color: #fff;">
											 <img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;"> 
										</div>-->
									<!--	<div class="bottom" style="background-color: #fff;">
											<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>-->
									</div>
									<!--        WHITE ENDS-->
									<!--        GREY-->
									<div class="bottomDown">
										<div class="left" style="background-image:url('<?php echo IMAGE_URL; ?>s_28.png');">
											<p style="position:relative; top:10px; left:65px;">
												Access to Clinic’s Call Recordings
											</p>
										</div>
										<div class="bottom">
											<!-- 	<img src="check.png" style="position:relative; top:8px;"> -->
										</div>
										<div class="bottom">
											<!-- <img src="check.png" style="position:relative; top:8px;"> -->
										</div>
										<div class="bottom">
											<!-- <img src="check.png" style="position:relative; top:8px;"> -->
										</div>
										<div class="bottom">
											<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>
										<!--<div class="bottom">
											<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>-->
										<!--<div class="bottom">
											<img src="<?php echo IMAGE_URL; ?>check.png" style="position:relative; top:8px;">
										</div>-->
									</div>
									<!--        GREY ENDS-->
									<div class="footerBottom">
										<div class="footer">
											<a href="javascript:void(0);" id="10" class="buy-package-btn2"><img src="<?php echo IMAGE_URL; ?>login/package_1.png"></a>
										</div>
										<div class="footer">
											<a href="/payment/package/20" id="20" class="buy-package-btn"><img src="<?php echo IMAGE_URL; ?>login/package_2.png"></a>
										</div>
										<div class="greyFooter">
											<a href="/payment/package/30"id="30" class="buy-package-btn"><img src="<?php echo IMAGE_URL; ?>login/package_3.png"></a>
										</div>
										<div class="greyFooter">
											<a href="/payment/package/40" id="40" class="buy-package-btn"><img src="<?php echo IMAGE_URL; ?>login/package_4.png"></a>
										</div>
										<!--<div class="greyFooter">
											<img src="<?php echo IMAGE_URL; ?>packages/package_5.png">
										</div>-->
										<!--<div class="greyFooter">
											<img src="<?php echo IMAGE_URL; ?>packages/package_6.png">
										</div>-->
									</div>
									<div class="footerBottom" style="margin: 0px;">
										<div style="background-color: rgb(40, 166, 152); font-family: &quot;Century Gothic&quot;; font-size: 24px; width: 100%; margin-top: 10px; height: 55px; padding-top: 10px; margin-bottom: 10px; text-align:right">
											Explore BDA Free Trial ( 7 Days )
											<a href="/doctor/freetrial"><img style="" src="<?php echo IMAGE_URL; ?>subscribe.png"></a>
										</div>
									</div>
								</div>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</body>
</html>
