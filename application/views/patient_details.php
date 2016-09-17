<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>
			Book Dr Appointment - Patient
		</title>
				
		<script src="<?php echo JS_URL; ?>login/jquery.min.js"></script>
		<script src="<?php echo JS_URL; ?>login/jquery-ui-new.js"></script>
		<script type="text/javascript" src="<?php echo JS_URL; ?>login/modernizr.custom.79639.js"></script>
		<script src="<?php echo JS_URL; ?>login/jquery.inputfile.js"></script>
		<script src="<?php echo JS_URL; ?>login/jquery-cropimg-plugin.js"></script>
		<script src="<?php echo JS_URL; ?>jquery.bpopup.min.js"></script>
		<script src="<?php echo JS_URL; ?>jquery.formatDateTime.js"></script>
		
		<link id="bs-css" href="<?php echo CSS_URL; ?>login/jquery-ui-new.css" rel="stylesheet">
		<link href="<?php echo CSS_URL; ?>patient/maine.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>patient/style.css" />
		<link href="<?php echo CSS_URL; ?>jquerysctipttop.css" rel="stylesheet" type="text/css">
		<link type="text/css" rel="stylesheet" href="<?php echo CSS_URL; ?>login/bootstrap.min.css"/>
		<link type="text/css" rel="stylesheet" href="<?php echo CSS_URL; ?>login/jquery.inputfile.css" />
		
		<script type="text/javascript">
			$(document).ready(function()
				{
					$(".error_text").show();
					$("#verifycodebtn").hide();
					$(".verificationcode").hide();
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
						
					$("#verifybtn").click(function()
						{
							$("#verifybtn").hide();
							$("#mob_span_tag").html("<p style='display:inline;'>Sending Verification Code</p>");
							var mob = $("#mob").val().trim();
							//alert(mob);
							$.ajax(
								{
									url: '/patient/send_verification_sms',
									type: "POST",
									data:
									{
										'mob'	:	mob
									},
									success : function(resp)
									{
										//alert(resp);
										if(resp.substring(0,7) == 'success')
										{
											$("#mob_span_tag").html("<p style='display:inline;'>Verification code sent</p>");
											$("#verifybtn").hide();
											$("#verifycodebtn").show();
											$(".verificationcode").show();
										}
										else
										{
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
									url: '/patient/check_verification_code',
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
											$("#mob_span_tag").hide();
											$("#verifiedbtn").css('display', 'inline');
											$("#mob").attr("readonly", true);
											$("#code").attr("readonly", true);
										}
										else
										{
											$("#verify_code_span").html("Invalid Verification code");
										}
									}
								});
						});
						
						$("#mobeditbtn").on('click', function()
						{
							$("#mobeditbtn").hide();
							$("#verifybtn").show();
							$("#mob").attr('readonly', false);
						});
				});
		</script>
		
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
		
	</head>

	<body>
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="pricetable">
			<?php $this->load->view('headertop_patient'); ?>
			<tr>
				<td>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td class="top_bg2" bgcolor="#229B96">
								<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="pricetableCopy">
									<tr>
										<td width="135" height="41" bgcolor="#229B96">&nbsp;
											
										</td>
										<td width="35" align="center">
											<a href="/"><img src="<?php echo IMAGE_URL; ?>home_icon.jpg" width="23" height="23" /></a>
										</td>
										<td width="44" valign="bottom">
											<img src="<?php echo IMAGE_URL; ?>devaiter.jpg" width="44" height="40" />
										</td>
										<td class="text">
											Edit Profile
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
							<?php $this->load->view('patient_sidebar'); ?>
							<td width="53" valign="top">&nbsp;
								
							</td>
							<td width="985" valign="top">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td height="25">&nbsp;
											
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
																	Edit your profile details
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
														$flag        = $this->session->userdata('user_code_verified');
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
																				<?php 
																				if(!empty($user_image))
																				{
																					if(substr($user_image, 0, 4) == 'http')
																					{
																						echo "<img src='".$user_image."' width=\"126\" height=\"152\" />";
																					}
																					else
																					{
																						echo "<img src='/".$user_image."' width=\"126\" height=\"152\" />";
																					}
																				}
																				else
																				echo "<img src=\"http://graph.facebook.com/".$this->session->userdata('facebook_id')."/picture?type=normal\" />"; 
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
																				<input type="hidden" name="profile_pic_base64" id="profile_pic_base64" value="" />
																				<input type="hidden" name="profile_pic_base64_name" id="profile_pic_base64_name" value="" />
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
																				<input name="name" type="text" class="from_text_filed" id="textfield" value="<?php echo @$userdetails->name; ?>" />
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
																				<input name="email" type="text" class="from_text_filed" id="email" value="<?php echo @$userdetails->email_id; ?>" />
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
																				Mobile Number
																				<span class="from_text4-red">
																					*
																				</span>
																			</td>
																			<td width="36">&nbsp;
																				
																			</td>
																			<td width="">
																				<input name="mob" maxlength="10" type="text" class="date" id="mob" value="<?php echo @$userdetails->contact_number; ?>" readonly='readonly' /> &nbsp; 
																				<a href="javascript:void(0);" id="verifybtn" style="display: none;">
																					<img src="<?php echo IMAGE_URL; ?>Send_Verification_Code_bnt.jpg" width="" height="" />
																				</a>
																				&nbsp;
																				<a href="javascript:void(0);" id="mobeditbtn">Edit</a>
																				&nbsp;
																				<a href="javascript:void(0);" id="verifiedbtn" style="display: none;">
																					<img src="<?php echo IMAGE_URL; ?>Verified.jpg" width="" height="" />
																				</a>
																				<span id="mob_span_tag"></span>
																			</td>
																			<td align="left">
																				
																			</td>
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
																		
																		<tr class="verificationcode">
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
																		<tr class="verificationcode">
																			<td align="right">&nbsp;
																				
																			</td>
																			<td>&nbsp;
																				
																			</td>
																			<td>
																				<p class="error_text" id="verify_code_span"></p>
																			</td>
																		</tr>
																			
																		<tr>
																			<td align="right" valign="top" class="from_text3">
																				DOB
																				<span class="from_text4-red">
																					*
																				</span>
																			</td>
																			<td>&nbsp;
																				
																			</td>
																			<td>
																				<input name="dob" type="text" class="date" value="<?php 
																				echo date('d-m-Y', strtotime(@$userdetails->dob))
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
																					<input type="radio" name="gender" id="radio11" value="m" <?php if(@$userdetails->gender == 'm') echo "checked='checked'"; ?> />
																					<span class="from_text4">
																						Male
																					</span><br />
																					<input type="radio" name="gender" id="radio12" value="f" <?php if(@$userdetails->gender == 'f') echo "checked='checked'"; ?> />
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
																		
																		<tr>
																			<td align="right" class="from_text3">&nbsp;
																				
																			</td>
																			<td>&nbsp;
																				
																			</td>
																			<td>
																				<a href="/"><img src="<?php echo IMAGE_URL.'bookDrAppointment.jpg' ?>" style="height: 35px;" /></a>
																			</td>
																			<td>&nbsp;
																				
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
														<input type="image" src="<?php echo IMAGE_URL; ?>submit.jpg" width="121" height="40" value="submit" name="submit" />
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
		
		<script type="text/javascript">

			var _gaq = _gaq || [];
			_gaq.push(['_setAccount', 'UA-36251023-1']);
			_gaq.push(['_setDomainName', 'jqueryscript.net']);
			_gaq.push(['_trackPageview']);

			(function()
				{
					var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
					ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
					var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
				})();

		</script>
		
		<div class="modalbpopup">
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
