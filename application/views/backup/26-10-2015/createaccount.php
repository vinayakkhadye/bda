<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>
			BookDrAppointment - Sign Up
		</title>

		<script src="<?php echo JS_URL; ?>login/jquery.min.js"></script>

		<link href="<?php echo CSS_URL; ?>login/maine.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>login/style.css" />
		<link href="<?php echo CSS_URL; ?>login/jquerysctipttop.css" rel="stylesheet" type="text/css">
		<link type="text/css" rel="stylesheet" href="<?php echo CSS_URL; ?>login/bootstrap.min.css"/>
		<link type="text/css" rel="stylesheet" href="<?php echo CSS_URL; ?>login/jquery.inputfile.css" />

		<script type="text/javascript" src="<?php echo JS_URL; ?>login/modernizr.custom.79639.js"></script>
		<script src="<?php echo JS_URL; ?>login/jquery.inputfile.js"></script>
		<script src="<?php echo JS_URL; ?>login/jquery-cropimg-plugin.js"></script>
		<script src="<?php echo JS_URL; ?>jquery.bpopup.min.js"></script>

		<script src="<?php echo JS_URL; ?>login/jquery-ui-new.js"></script>
		<link id="bs-css" href="<?php echo CSS_URL; ?>login/jquery-ui-new.css" rel="stylesheet" />

		<style type="text/css">
			/*this is just to organize the demo checkboxes*/
			label
			{
				margin-right: 20px;
			}
			.modalbpopup
			{
			    background-color: #fff;
			    border-radius: 15px;
			    box-shadow: 0 0 7px 1px #999;
			    min-height: 400px;
			    padding: 15px;
			    min-width: 500px;
			}
			
			.imageBox
			{
			    position: relative;
			    height: 400px;
			    width: 400px;
			    border:1px solid #aaa;
			    background: #fff;
			    overflow: hidden;
			    background-repeat: no-repeat;
			    cursor:move;
			}

			.imageBox .thumbBox
			{
			    position: absolute;
			    top: 50%;
			    left: 50%;
			    width: 126px;
			    height: 152px;
			    margin-top: -76px;
			    margin-left: -63px;
			    border: 1px solid rgb(102, 102, 102);
			    box-shadow: 0 0 0 1000px rgba(0, 0, 0, 0.5);
			    background: none repeat scroll 0% 0% transparent;
			}

			.imageBox .spinner
			{
			    position: absolute;
			    top: 0;
			    left: 0;
			    bottom: 0;
			    right: 0;
			    text-align: center;
			    line-height: 400px;
			    background: rgba(0,0,0,0.7);
			}
		</style>

		<script type="text/javascript">
			$(document).ready(function()
				{
					$("#verifycodebtn").hide();
					$(".modalbpopup").hide();
					$("#select_file_btn").click(function()
					{
						$(".modalbpopup").bPopup(
						{
							positionStyle: 'fixed',
							closeClass: 'modalclose'
						});
						$("#file").trigger('click');
					});
					
					$("#dob").datepicker(
						{
							dateFormat: "dd-mm-yy",
							defaultDate: "-25y",
							changeMonth: true,
							changeYear: true,
							yearRange: "1900:2014"
						});

					/*$("#verifybtn").click(function()
						{
							$("#verifybtn").hide();
							$("#mob_span_tag").html("<p>Sending Verification Code</p>");
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
										
										if(resp.substring(0,7) == 'success')
										{
											$("#mob_span_tag").html("<p>Verification code sent successfully</p>");
											$("#verifybtn").hide();
											$("#verifycodebtn").show();
											$("#verfy_mobile_sms").show();
											
										}
										else
										{
											alert(resp);
											$("#verifybtn").show();
											$("#mob_span_tag").html('');
										}
									}
								});
						});

					$("#verifycodebtn").click(function()
						{
							$("#verify_code_span").html(' ');
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
																				//alert(resp);
										if(resp.substring(0,7) == 'success')
										{
											$("#verifycodebtn").hide();
											$("#mob_span_tag").hide();
											$("#verifiedbtn").show();
											$("#verfy_mobile_sms").hide();
											$("#mob").attr("readonly", "readonly");
											$("#code").attr("readonly", "readonly");
										}
										else
										{
											$("#verify_code_span").html("Invalid Verification code");
											$("#verfy_mobile_sms").hide();
										}
									}
								});
						});*/
				});
		</script>
		
	</head>

	<body>
	<?php //print_r($_POST); ?>
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="pricetable">
			<tr>
				<td height="77" align="center" bgcolor="#eeeeee">
					<table width="1006" border="0" align="center" cellpadding="0" cellspacing="0">
						<tr>
							<td height="77" align="right">
								<table width="1007" border="0" align="center" cellpadding="0" cellspacing="0">
									<tr>
										<td width="318">
											<a href="/"><img src="<?php echo IMAGE_URL; ?>bda_logo.jpg" width="318" height="73" class="image-wrapper" /></a>
										</td>
										<td width="500">&nbsp;
											
										</td>
										<td>&nbsp;
											
										</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td bgcolor="#229B96">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td class="top_bg2">
								<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="pricetableCopy">
									<tr>
										<td width="135" height="41">&nbsp;
											
										</td>
										<td width="35" align="center">
											<a href="/"><img src="<?php echo IMAGE_URL; ?>home_icon.jpg" width="23" height="23" /></a>
										</td>
										<td width="44" valign="bottom">
											<img src="<?php echo IMAGE_URL; ?>devaiter.jpg" width="44" height="40" />
										</td>
										<td class="text">
											Sign Up
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
					<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
						<tr>
							<td width="53" align="center" valign="top">&nbsp;
								
							</td>
							<td width="985" align="center" valign="top">
								<table width="75%" border="0" align="center" cellpadding="0" cellspacing="0">
									<tr>
										<td height="50">&nbsp;
											
										</td>
									</tr>
									<tr>
										<td valign="top" class="maine_from">
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												<tr>
													<td height="45" bgcolor="#3dc4bf">
														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td height="45" class="from_page_tetel">
																	Provide your profile details
																</td>
																<td>&nbsp;
																	
																</td>
																<td width="150" align="center" class="text">&nbsp;
																	
																</td>
															</tr>
														</table>
													</td>
												</tr>
												<tr>
													<td height="23">&nbsp;
														
													</td>
												</tr>
												<tr>
													<td valign="top">
														<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1">
														<?php
														$fbid        = $this->session->userdata('fbid');
														$flag        = $this->session->userdata('code_verified');
														$googleid    = $this->session->userdata('googleid');
														$googleimage = $this->session->userdata('googleimage');
														?>
														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td valign="top">
																	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
																		<tr>
																			<td width="198">&nbsp;
																				
																			</td>
																			<td width="36">&nbsp;
																				
																			</td>
																			<td width="367">&nbsp;
																				
																			</td>
																			<td rowspan="8" align="center" id="profileimgbox">
																				<?php if(!empty($fbid)) 
																				{
																					echo "<img src=\"http://graph.facebook.com/{$fbid}/picture?type=normal\" />";
																				}
																				elseif(!empty($googleid)) 
																				{
																					echo "<img src='".$this->session->userdata('googleimage')."' width=\"126\" height=\"152\" />";
																				}
																				else
																				{
																					if(isset($_POST['profile_pic_base64']) && $_POST['profile_pic_base64']){
																						echo "<img src='data:image/png;base64,".$_POST['profile_pic_base64']."' width=\"126\" height=\"152\" />";
																					}else{
																						echo "<img src='".IMAGE_URL."photo_frame.jpg' width=\"126\" height=\"152\" />";
																					}
																				}
																				?>
																			</td>
																		</tr>
																		<tr>
																			<td height="29" align="right" class="from_text3">
																				Profile Picture
																			</td>
																			<td>&nbsp;
																				
																			</td>
																			<td>
																				<a href="javascript:void(0);" id="select_file_btn"><img src="<?php echo IMAGE_URL; ?>select_file.png" /></a>
																				<input type="hidden" name="profile_pic_base64" id="profile_pic_base64" 
																				value="<?php echo @$_POST['profile_pic_base64']; ?>" />
																				<input type="hidden" name="profile_pic_base64_name" id="profile_pic_base64_name" 
																				value="<?php echo @	$_POST['profile_pic_base64_name']; ?>" />
																			</td>
																		</tr>
																		<tr>
																			<td align="right">&nbsp;
																				
																			</td>
																			<td>&nbsp;
																				
																			</td>
																			<td>&nbsp;
																				
																			</td>
																		</tr>
																		<tr>
																			<td height="29" align="right" class="from_text3">
																				Name
																				<span class="from_text4-red">
																					*
																				</span>
																			</td>
																			<td width="36">&nbsp;
																				
																			</td>
																			<td width="367">
																				<input name="name" type="text" class="from_text_filed" id="textfield" 
																				value="<?php echo set_value('name',$this->session->userdata('uname')); ?>" />
																			</td>
																		</tr>
																		<tr>
																			<td align="right">&nbsp;
																				
																			</td>
																			<td width="36">&nbsp;
																				
																			</td>
																			<td class="error_name" >
																				<?php echo form_error('name', '<p class="error_text">', '</p>'); ?>
																			</td>
																		</tr>
																		<tr>
																			<td align="right" class="from_text3">
																				E-mail id
																				<span class="from_text4-red">
																					*
																				</span>
																			</td>
																			<td width="36">&nbsp;
																				
																			</td>
																			<td width="367">
																				<input name="email" type="text" class="from_text_filed" id="email" value="<?php echo set_value('email',$this->session->userdata('uemail')); ?>" />
																			</td>
																		</tr>
																		<tr>
																			<td align="right">&nbsp;
																				
																			</td>
																			<td width="36">&nbsp;
																				
																			</td>
																			<td class="error_email" >
																				<?php echo form_error('email', '<p class="error_text">', '</p>'); ?>
																			</td>
																		</tr>
																		<tr>
																			<td align="right" class="from_text3">
																				Password
																				<span class="from_text4-red">
																					*
																				</span>
																			</td>
																			<td width="36">&nbsp;
																				
																			</td>
																			<td width="367">
																				<input name="pass" type="password" class="from_text_filed" id="pass" value="<?php echo set_value('pass'); ?>" />
																			</td>
																		</tr>
																		<tr>
																			<td align="right">&nbsp;
																				
																			</td>
																			<td width="36">&nbsp;
																				
																			</td>
																			<td class="error_pass" >
																				<?php echo form_error('pass', '<p class="error_text">', '</p>'); ?>
																			</td>
																		</tr>
																		<tr>
																			<td height="29" align="right" class="from_text3">
																				Confirm Password
																				<span class="from_text4-red">
																					*
																				</span>
																			</td>
																			<td>&nbsp;
																				
																			</td>
																			<td>
																				<input name="cnfmpass" type="password" class="from_text_filed" id="cnfmpass" value="<?php echo set_value('cnfmpass'); ?>" />
																			</td>
																			<td align="left">&nbsp;
																				
																			</td>
																		</tr>
																		<tr>
																			<td align="right" class="from_text3">&nbsp;
																				
																			</td>
																			<td>&nbsp;
																				
																			</td>
																			<td class="error_cnfmpass" >
																				<?php echo form_error('cnfmpass', '<p class="error_text">', '</p>'); ?>
																			</td>
																		</tr>
																		<tr>
																			<td align="right" class="from_text3">
																				Mobile Number
																				<span class="from_text4-red">
																					*
																				</span>
																			</td>
																			<td width="36">&nbsp;
																				
																			</td>
																			<td width="367">
																				<input name="mob" maxlength="10" type="text" class="from_text_filed" id="mob" value="<?php echo set_value('mob'); ?>" <?php
																				if($flag == '1') echo "readonly='readonly'" ?> />
																				<span id="verfy_mobile_sms" style="color:green;display:none">
																				Please wait while you receive the verification code on your mobile
																				</span>
																				
																			</td>
																			<!--<td align="left">
																				
																				<a href="javascript:void(0);" id="verifybtn" style="<?php if($flag != '1') 
																				echo 'display: block;'; 
																				else 
																				echo 'display: none;'; 
																				?>">
																					<img src="<?php echo IMAGE_URL; ?>Send_Verification_Code_bnt.jpg" width="" height="" />
																				</a>
																				<a href="javascript:void(0);" id="verifiedbtn" style="<?php if($flag == '1') 
																				echo 'display: block;'; 
																				else 
																				echo 'display: none;'; 
																				?>">
																					<img src="<?php echo IMAGE_URL; ?>Verified.jpg" width="" height="" />
																				</a>
																				<span id="mob_span_tag"></span>
																			</td>-->
																		</tr>
																		<tr>
																			<td align="right">&nbsp;
																				
																			</td>
																			<td width="36">&nbsp;
																				
																			</td>
																			<td class="error_mob" >
																				<?php echo form_error('mob', '<p class="error_text">', '</p>'); ?>
																			</td>
																		</tr>
																		<!--
																		<?php
																		if($flag != '1'): ?>
																		<tr>
																			<td align="right" class="from_text3">
																				Verification Code
																				<span class="from_text4-red">
																					*
																				</span>
																			</td>
																			<td>&nbsp;
																				
																			</td>
																			<td>
																				<table width="65%" border="0" cellspacing="0" cellpadding="0">
																					<tr>
																						<td>
																							<input name="code" type="text" class="date" id="code" value="" maxlength="4" />
																						</td>
																						<td>
																							<a href="javascript:void(0);" id="verifycodebtn">
																								<img src="<?php echo IMAGE_URL; ?>Verify.jpg" width="63" height="33" hspace="0" vspace="0" />
																							</a>
																						</td>
																						<td>
																							
																						</td>
																					</tr>
																				</table>
																			</td>
																			<td>&nbsp;
																				
																			</td>
																		</tr>
																		<tr>
																			<td align="right">&nbsp;
																				
																			</td>
																			<td>&nbsp;
																				
																			</td>
																			<td>
																				<p class="error_text" id="verify_code_span"></p>
																			</td>
																		</tr>
																		<?php endif; ?>
																		-->
																		<tr>
																			<td align="right" valign="top" class="from_text3">
																				Date of Birth
																				<span class="from_text4-red">
																					*
																				</span>
																			</td>
																			<td>&nbsp;
																				
																			</td>
																			<td>
																				<input name="dob" type="text" class="date" value="<?php 
																				$ff = set_value('dob');
																				if(!empty($ff))
																				echo date('d-m-Y', strtotime($ff));
																				else
																				echo '';
																				?>" id="dob" readonly="readonly" style="cursor: text;" />
																			</td>
																			<td>&nbsp;
																				
																			</td>
																		</tr>
																		<tr>
																			<td align="right">&nbsp;
																				
																			</td>
																			<td>&nbsp;
																				
																			</td>
																			<td class="error_dob" >
																				<?php echo form_error('dob', '<p class="error_text">', '</p>'); ?>
																			</td>
																		</tr>
																		<tr>
																			<td align="right" class="from_text3">
																				Gender
																				<span class="from_text4-red">
																					*
																				</span>
																			</td>
																			<td>&nbsp;
																				
																			</td>
																			<td>
																				<p>
																					<input type="radio" name="gender" id="radio11" value="m" <?php if(isset($_POST['gender']) && $_POST['gender'] == 'm') echo 'checked="checked"'; ?> />
																					<span class="from_text4">
																						Male
																					</span><br />
																					<input type="radio" name="gender" id="radio12" value="f" <?php if(isset($_POST['gender']) && $_POST['gender'] == 'f') echo 'checked="checked"'; ?> />
																					<span class="from_text4">
																						Female
																					</span>
																				</p>
																			</td>
																			<td>&nbsp;
																				
																			</td>
																		</tr>
																		<tr>
																			<td align="right">&nbsp;
																				
																			</td>
																			<td>&nbsp;
																				
																			</td>
																			<td class="error_gender" >
																				<?php echo form_error('gender', '<p class="error_text">', '</p>'); ?>
																			</td>
																		</tr>
																		<?php 
																		$chk_usertype_isset = $this->session->userdata('set_usertype_signup');
																		if(!empty($chk_usertype_isset) && ($chk_usertype_isset == '2' || $chk_usertype_isset == '1')):
																		?>
																		<input type="hidden" name="usertype" value="<?=$chk_usertype_isset?>" />
																		<?php else: ?>
																		<tr>
																			<td align="right" class="from_text3">
																				User Type
																				<span class="from_text4-red">
																					*
																				</span>
																			</td>
																			<td>&nbsp;
																				
																			</td>
																			<td class="from_text4">
																				<p>
																					<input type="radio" name="usertype" id="radio11" value="1" <?php if(isset($_POST['usertype']) && $_POST['usertype'] == 1) echo 'checked="checked"'; ?> />
																					I’m a Patient
																					<span class="from_text4">
																					</span><br />
																					<input type="radio" name="usertype" id="radio12" value="2" <?php if(isset($_POST['usertype']) && $_POST['usertype'] == 2) echo 'checked="checked"'; ?> />
																					I’m a Doctor
																				</p>
																			</td>
																			<td>&nbsp;
																				
																			</td>
																		</tr>
																		<tr>
																			<td align="right">&nbsp;
																				
																			</td>
																			<td>&nbsp;
																				
																			</td>
																			<td class="error_usertype" >
																				<?php echo form_error('usertype', '<p class="error_text">', '</p>'); ?>
																			</td>
																		</tr>
																		<?php endif; ?>
																		<tr>
																			<td align="right" class="from_text3">&nbsp;
																				
																			</td>
																			<td>&nbsp;
																				
																			</td>
																			<td class="from_text4">
																				<p>
																					<input type="checkbox" name="acceptterms" id="acceptterms" value="1" <?php if(isset($_POST['acceptterms']) && $_POST['acceptterms'] == 1) echo 'checked="checked"'; ?> />
																					I accept the <a href="<?=BASE_URL?>terms-conditions.html" target="_blank">Terms and Conditions</a>
																				</p>
																			</td>
																			<td>&nbsp;
																				
																			</td>
																		</tr>
																		<tr>
																			<td align="right">&nbsp;
																				
																			</td>
																			<td>&nbsp;
																				
																			</td>
																			<td class="error_usertype" >
																				<?php echo form_error('acceptterms', '<p class="error_text">', '</p>'); ?>
																			</td>
																		</tr>
																		
																		<?php
																		if(!empty($fbid))
																		echo '<input type="hidden" name="fbid" value="'.$fbid.'" />'; 
																		if(!empty($googleid))
																		echo '<input type="hidden" name="googleid" value="'.$googleid.'" />'; 
																		?>
																	</table>
																</td>
															</tr>
														</table>
													</td>
												</tr>
												<tr>
													<td>&nbsp;
														
													</td>
												</tr>
												<tr>
													<td height="53" align="right" bgcolor="#f5f5f5">
														<input width="121" type="submit" height="40" value="Submit" name="submit_x" class="continue_bnt" style="float: right; margin-right: 15px; width: 133px; padding-left: 0px;">
														<!--<input type="image" src="<?php echo IMAGE_URL; ?>submit.jpg" width="121" height="40" value="submit" name="submit" />-->
														<!--<img src="<?php echo IMAGE_URL; ?>submit.jpg" width="121" height="40" />-->&nbsp;&nbsp;&nbsp;
													</td>
												</tr>
												</form>
											</table>
										</td>
									</tr>
									<tr>
										<td>&nbsp;
											
										</td>
									</tr>
								</table>
							</td>
							<td width="53">&nbsp;
								
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		
		<script type="text/javascript">
		    $(window).load(function() {
		        var options =
		        {
		            thumbBox: '.thumbBox',
		            spinner: '.spinner',
		            imgSrc: 'avatar.png'
		        }
		        var cropper;
		        $('#file').on('change', function(){
		            var reader = new FileReader();
		            reader.onload = function(e) {
		                options.imgSrc = e.target.result;
		                cropper = $('.imageBox').cropbox(options);
		            }
		            reader.readAsDataURL(this.files[0]);
		            this.files = [];
		        })
		        $('#btnCrop').on('click', function(){
		            var img = cropper.getDataURL()
		            //$('.cropped').append('<img src="'+img+'">');
		            $('#profileimgbox').html('<img src="'+img+'">');
		            
					//alert($('#file').val());
					var imgtype= img.substr(0, img.indexOf(',')); 
					//alert(imgtype);
					var base64imgvalue= img.substr(img.indexOf(',')+1, 999999999); 
					//console.log(base64imgvalue);
					$('#profile_pic_base64').val(base64imgvalue);
		            $('#profile_pic_base64_name').val($('#file').val());
		        })
		        $('#btnZoomIn').on('click', function(){
		            cropper.zoomIn();
		        })
		        $('#btnZoomOut').on('click', function(){
		            cropper.zoomOut();
		        })
		    });
		</script>

		<script>
			$('input[type="file"]').inputfile(
				{
					uploadText: '<span class="glyphicon glyphicon-upload"></span> Select a file',
					removeText: '<span class="glyphicon glyphicon-trash"></span>',
					restoreText: '<span class="glyphicon glyphicon-remove"></span>',

					uploadButtonClass: 'btn btn-primary',
					removeButtonClass: 'btn btn-default'
				});
		</script>
		
		<div class="modalbpopup" style="display: none;">
			<div class="container">
			    <div class="imageBox">
			        <div class="thumbBox"></div>
			        <div class="spinner" style="display: none">Loading...</div>
			    </div>
			    <div class="action">
			        <input type="file" id="file" style="float:left; width: 250px">
			        <input type="button" id="btnCrop" value="Crop" style="float: right; width: 75px; margin:5px 40px 5px 5px;" class="modalclose">
			        <input type="button" id="btnZoomIn" value="+" style="float: right; width: 25px; margin:5px 2px;">
			        <input type="button" id="btnZoomOut" value="-" style="float: right; width: 25px; margin:5px 2px;">
			    </div>
			    <div class="cropped">

			    </div>
			</div>
		</div>

	</body>
</html>