<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>
			BookDrAppointment
		</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">


		<!-- The styles -->
		<link id="bs-css" href="<?php echo CSS_URL; ?>bootstrap-cerulean.css" rel="stylesheet">
		<link id="bs-css" href="<?php echo CSS_URL; ?>login/jquery-ui-new.css" rel="stylesheet">
		<script src="<?php echo JS_URL; ?>jquery-new.js">
		</script>
		<script src="<?php echo JS_URL; ?>login/jquery-ui-new.js">
		</script>
		<style type="text/css">
			body
			{
				padding-bottom: 40px;
			}
			.sidebar-nav
			{
				padding: 9px 0;
			}
		</style>
		<script type="text/javascript"> 
			/*var idx=window.location.toString().indexOf("#_=_"); 
			if (idx>0) 
			{ 
				window.location = window.location.toString().substring(0, idx); 
			}*/ 
		</script>
		
		<link href="<?php echo CSS_URL; ?>bootstrap-responsive.css" rel="stylesheet">
		<link href="<?php echo CSS_URL; ?>charisma-app.css" rel="stylesheet">
		<link href='<?php echo CSS_URL; ?>fullcalendar.css' rel='stylesheet'>
		<!--link href='<?php echo CSS_URL; ?>fullcalendar.print.css' rel='stylesheet'  media='print'-->
		<link href='<?php echo CSS_URL; ?>chosen.css' rel='stylesheet'>
		<link href='<?php echo CSS_URL; ?>uniform.default.css' rel='stylesheet'>
		<link href='<?php echo CSS_URL; ?>colorbox.css' rel='stylesheet'>
		<link href='<?php echo CSS_URL; ?>jquery.cleditor.css' rel='stylesheet'>
		<link href='<?php echo CSS_URL; ?>jquery.noty.css' rel='stylesheet'>
		<link href='<?php echo CSS_URL; ?>noty_theme_default.css' rel='stylesheet'>
		<link href='<?php echo CSS_URL; ?>elfinder.min.css' rel='stylesheet'>
		<link href='<?php echo CSS_URL; ?>elfinder.theme.css' rel='stylesheet'>
		<link href='<?php echo CSS_URL; ?>jquery.iphone.toggle.css' rel='stylesheet'>
		<link href='<?php echo CSS_URL; ?>opa-icons.css' rel='stylesheet'>
		<link href='<?php echo CSS_URL; ?>uploadify.css' rel='stylesheet'>
		<link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>jquery.timeentry.css">
		<link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>jquery.multifile.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>jquery.multiselect.css" media="screen" />




		<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<!-- The fav icon -->
		<link rel="shortcut icon" href="img/favicon.ico">

		<script type="text/javascript">
			$(document).ready(function()
				{
					$("#verifycodebtn").hide();
					$("#dob").datepicker(
						{
							dateFormat: "yy-mm-dd",
							defaultDate: "-25y",
							changeMonth: true,
							changeYear: true,
							yearRange: "1900:2014" 
						});

					$("#verifybtn").click(function()
						{
							var mob = $("#mob").val().trim();
							//alert(mob);
							$.ajax(
								{
									url: '/createaccount/send_verification_sms',
									type: "POST",
									data:
									{
										'mob'	:	mob
									},
									success : function(resp)
									{
										alert(resp);
										if(resp.substring(0,7) == 'success')
										{
											$("#verifybtn").hide();
											$("#verifycodebtn").show();
										}
									}
								});
						});

					$("#verifycodebtn").click(function()
						{
							var code = $("#code").val().trim();
//							alert(code);
							$.ajax(
								{
									url: '/createaccount/check_verification_code',
									type: "POST",
									data:
									{
										'code'	:	code
									},
									success : function(resp)
									{
//										alert(resp);
										if(resp.substring(0,7) == 'success')
										{
											$("#verifycodebtn").hide();
											$("#verifystatus").html("<p style='color:green;'>&nbsp;&nbsp;&nbsp;Verified</p>");
											$("#mob").attr("readonly", "readonly");
											$("#code").attr("readonly", "readonly");
										}
										else
										{
											$("#verifystatus").html("<p style='color:red;'>&nbsp;&nbsp;&nbsp;Invalid Verification code</p>");
										}
									}
								});
						});

				});
		</script>

	</head>

	<body>
		<!-- topbar starts -->
		<div class="navbar">
			<div class="navbar-inner">
				<div class="container-fluid" style="padding-left:0px;">
					<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
						<span class="icon-bar">
						</span>
						<span class="icon-bar">
						</span>
						<span class="icon-bar">
						</span>
					</a>
					<a class="brand" href="../index.php">
						<img alt="BDA Logo" src="<?php echo IMAGE_URL; ?>logo20.png" />
					</a>

					<div class="top-nav nav-collapse">
						<ul class="nav">
						</ul>
					</div><!--/.nav-collapse -->
				</div>
			</div>
		</div>
		<!-- topbar ends -->
		<div class="breadcrum_wrapp">
			<div class="bred_center">
				<ul class="breadcrumb">
					<li>
						<a href="index.php">
							Home
						</a>
						<span class="divider">
							/
						</span>
					</li>
					<li>
						<a href="#">
							Edit Profile
						</a>
					</li>
				</ul>
				<!-- user dropdown starts -->
				<div class="btn-group pull-right" >
					<i class="admin_icon">
					</i>
					<a class="btn dropdown-toggle admin_btn" data-toggle="dropdown" href="#">
						<span class="hidden-phone" style="float:left;">
						</span>
						<span class="admin_dwn_arrow">
						</span>
					</a>
					<ul class="dropdown-menu">
						<li>
							<a href="index.php">
								Profile
							</a>
						</li>
						<li>
							<a href="change_password.php">
								Change Password
							</a>
						</li>
						<li class="divider">
						</li>
						<li>
							<a href="logout.php">
								Logout
							</a>
						</li>

					</ul>
				</div>
				<!-- user dropdown ends -->
			</div>
		</div>
		<div class="container-fluid">
			<div class="row-fluid">
				<!-- Left Nevigation Starts -->
				<!-- Left Nevigation Ends -->


				<noscript>
					<div class="alert alert-block span10">
						<h4 class="alert-heading">
							Warning!
						</h4>
						<p>
							You need to have
							<a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">
								JavaScript
							</a> enabled to use this site.
						</p>
					</div>
				</noscript>

				<div id="content" class="span10">

					<div class="row-fluid sortable">
						<div class="box span12">
							<div class="box-header well" data-original-title>
								<h2>
									<i class="icon-edit">
									</i>  Profile
								</h2>
								<div class="box-icon">
									<!--<a href="#" class="btn btn-setting btn-round"><i class="icon-cog"></i></a>-->
									<a href="#" class="btn btn-minimize btn-round">
										<i class="icon-chevron-up">
										</i>
									</a>
									<!--<a href="#" class="btn btn-close btn-round"><i class="icon-remove"></i></a>-->
								</div>
							</div>
							<p>
							</p>
							<div class="box-content">
								<form action="" method="post" class="form-horizontal" id="ad_patient_form" name="ad_patient_form" enctype="multipart/form-data" >
								<?php echo validation_errors("<p style='color:red;'>","</p>"); ?>
								<?php if(isset($error)) echo "<p style='color:red;'>".$error."</p>"; ?>
								<?php 	
									$fbid = $this->session->userdata('fbid'); 
									$flag = $this->session->userdata('code_verified');
									$googleid = $this->session->userdata('googleid'); 
									$googleimage = $this->session->userdata('googleimage'); 
								?>
									<fieldset>
										<div class="control-group">
											<label class="control-label" for="selectError3">
												Profile Picture
											</label>
											<div class="controls">
												<input class="input-xlarge focused" accept="image/*" type="file"  name="profile_img" value="">
												<?php if(!empty($fbid)) echo "<img src=\"http://graph.facebook.com/{$fbid}/picture?type=normal\" />"; ?>
												<?php if(!empty($googleid)) echo "<img src=\"{$googleimage}\" style='max-width:200px;max-height:200px;' />"; ?>
												<span>max size 2MB</span>
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="focusedInput">
												Name
											</label>
											<div class="controls">
												<input class="input-xlarge focused" id="focusedInput" name="name" type="text" value="<?php echo $this->session->userdata('uname'); ?>">
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="focusedInput">
												Email Id
											</label>
											<div class="controls">
												<input class="input-xlarge focused" id="email" name="email" type="text" value="<?php echo $this->session->userdata('uemail'); ?>">
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="focusedInput">
												Password
											</label>
											<div class="controls">
												<input class="input-xlarge focused" id="pass" name="pass" type="password" value="<?php echo set_value('pass'); ?>">
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="focusedInput">
												Confirm Password
											</label>
											<div class="controls">
												<input class="input-xlarge focused" id="cnfmpass" name="cnfmpass" type="password" value="<?php echo set_value('cnfmpass'); ?>">
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="focusedInput">
												Mobile Number
											</label>
											<div class="controls">
												<input class="input-xlarge focused" maxlength="10" name="mob" type="text" id="mob" value="<?php echo set_value('mob'); ?>" <?php if($flag == '1') echo "readonly='readonly'" ?> >
												<?php if($flag != '1'): ?>
												<input type="button" id="verifybtn" class="btn btn-primary" style="margin-left:5px;" value="Send Verification Code" />
												<?php else: ?>
													<p style='color:green;'>&nbsp;&nbsp;&nbsp;Verified</p>
												<?php endif; ?>
											</div>
										</div>
										<?php if($flag != '1'): ?>
										<div class="control-group">
											<label class="control-label" for="focusedInput">
												Verification Code
											</label>
											<div class="controls">
												<input class="input-xlarge focused" name="code" type="text" id="code" value="" />
												<input type="button" id="verifycodebtn" class="btn btn-primary" style="margin-left:5px;" value="Verify" />
												<span id="verifystatus"></span>
											</div>
										</div>
										<?php endif; ?>

										<div class="control-group">
											<label class="control-label" for="focusedInput">
												DOB
											</label>
											<div class="controls">
												<input class="input-xlarge focused" id="dob" autocomplete="off" maxlength="10"  name="dob" type="text" value="<?php echo set_value('dob'); ?>" />
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="focusedInput">
												Gender
											</label>
											<div class="controls">
												<select name="gender">
													<option value="m">
														Male
													</option>
													<option value="f">
														Female
													</option>
												</select>
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="focusedInput">
												User Type
											</label>
											<div class="controls">
												<select name="usertype">
													<option value="1">
														Patient
													</option>
													<option value="2">
														Doctor
													</option>
												</select>
											</div>
										</div>

										<div class="form-actions">
											<?php
											if(!empty($fbid))
											echo '<input type="hidden" name="fbid" value="'.$fbid.'" />'; 
											if(!empty($googleid))
											echo '<input type="hidden" name="googleid" value="'.$googleid.'" />'; 
											?>
											<input type="submit" class="btn btn-primary" name="submit" id="submit" value="Create Account" >
										</div>
									</fieldset>
								</form>

							</div>
						</div><!--/span-->

					</div><!--/row-->


					<div class="row-fluid sortable">
						<!--/span-->

					</div><!--/row-->

					<div class="row-fluid sortable">
						<!--/span-->

					</div><!--/row-->

					<!-- content ends -->
				</div><!--/#content.span10-->
			</div><!--/fluid-row-->



			<!-- Footer Starts -->

			<hr>
			<div class="modal hide fade" id="myModal">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">
						�
					</button>
					<h3>
						Settings
					</h3>
				</div>
				<div class="modal-body">
					<p>
						Here settings can be configured...
					</p>
				</div>
				<div class="modal-footer">
					<a href="#" class="btn" data-dismiss="modal">
						Close
					</a>
					<a href="#" class="btn btn-primary">
						Save changes
					</a>
				</div>
			</div>

			<footer>
				<p class="pull-left">
					&copy;
					<a href="" target="_blank">
						BDA
					</a>
				</p>
				<!--<p class="pull-right">Powered by: <a href="http://digitalwebtech.in" target="_blank">Digital Webtech Pvt. Ltd.</a></p>-->
			</footer>

		</div><!--/.fluid-container-->

	</body>
</html>