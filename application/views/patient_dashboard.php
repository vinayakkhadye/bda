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
										<td valign="top">
											<table width="100%" border="0" cellspacing="0" cellpadding="0">
												
												<tr>
													<td height="23">&nbsp;
														
													</td>
												</tr>
												<tr>
													<td width="985" align="center" valign="middle">
													<table width="950" border="0" align="center" cellpadding="0" cellspacing="0">
														<tr>
															<td width="381" valign="top"><img src="<?=IMAGE_URL?>my_appointment_dash.jpg" width="381" height="336" /></td>
															<td width="14">&nbsp;</td>
															<td width="380" valign="top">
																<table width="100%" border="0" cellspacing="0" cellpadding="0">
																	<tr>
																		<td>
																			<a href="<?=BASE_URL?>patient/details"><img src="<?=IMAGE_URL?>my_profile_dash.jpg" width="380" height="162" /></a>
																		</td>
																	</tr>
																	<tr>
																		<td height="9"></td>
																	</tr>
																	<tr>
																		<td>
																		<a href="<?=BASE_URL?>patient/phr">
																		<img src="<?=IMAGE_URL?>my_phr_dash.jpg" width="380" height="168" />
																		</a>
																		</td>
																	</tr>
																</table>
															</td>
															<td width="9" valign="top">&nbsp;</td>
															<td width="380" valign="top">
                                                            <a href="<?=BASE_URL?>patient/phi" >
                                                            <img src="<?=IMAGE_URL?>my_personal_health_info.jpg"  />
                                                            </a>
                                                            </td>
														</tr>
											        </table>
													</td>
												</tr>
												<tr>
													<td>&nbsp;
														
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
							<td width="53">&nbsp;</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
    <td height="45" align="center" valign="middle" bgcolor="#033f44"><span class="text">© 2014 BookdrAppointment.com, All rights reserved </span></td>
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
