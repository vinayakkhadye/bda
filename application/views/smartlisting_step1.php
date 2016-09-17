<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>
			Book Dr Appointment
		</title>

		<script src="<?php echo JS_URL; ?>login/jquery.min.js"></script>
		<script src="<?php echo JS_URL; ?>login/jquery-ui-new.js"></script>
		<!--<script type="text/javascript" src="<?php echo JS_URL; ?>login/modernizr.custom.79639.js"></script>-->
		<script src="<?php echo JS_URL; ?>login/jquery-cropimg-plugin.js"></script>
		<script src="<?php echo JS_URL; ?>login/jquery.bpopup.min.js"></script>

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
					$("#sl_step1").show();
					<?php
					if(@$clinic_present)
						echo '$(".progressbar_sl").hide();';
					else
						echo '$(".progressbar_sl").show();';
					?>
				});

			function remove_tr(obj)
			{
				if(confirm("Are you sure you want to delete "))
				{
					console.log($( obj ).closest( "tr" ).remove());
				}
			}
			function add_speciality_more(obj)
			{
				var curTR = $(obj).closest('tr');
				newTR = $("#speciality_more_tocopy").clone();
				newTR.show();
				newTR.removeAttr("id");
				curTR.find("#addmore_speciality_other").hide();
				newTR.find("#label_speciality").html("&nbsp;");
				$(newTR).find("#services_remove").hide();
				$(curTR).find("#services_remove").show();
				newTR.insertAfter(curTR);
			}
			function add_speciality_other(obj)
			{
				var curTR = $(obj).closest('tr');
				curTR.find("#addmore_speciality_other").hide();
				$(curTR).find("#services_remove").show();
				var str = '';
				str += '<tr>';
				str += '<td align="right" class="from_text3">&nbsp;</td>';
				str += '<td width="35">&nbsp;</td>';
				str += '<td width="450" style="padding-top: 10px;"><input type="text" name="speciality_other[]" class="from_list_menu" some>&nbsp;<span id="services_remove" style="display:none" class="from_text4-org_1" onclick="remove_tr(this);">Remove</span></td>';
				str += '<td width="450" valign="bottom" id="addmore_speciality_other"><img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_speciality_more(this);" />&nbsp;&nbsp;<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_speciality_other(this);" /></td>';
				str += '</tr>';
				$(str).insertAfter(curTR);
			}


			function add_degree_more(obj)
			{
				var curTR = $(obj).closest('tr');
				newTR = $("#degree_more_tocopy").clone();
				newTR.show();
				newTR.removeAttr("id");
				curTR.find("#addmore_degree_other").hide();
				newTR.find("#label_degree").html("&nbsp;");
				$(newTR).find("#services_remove").hide();
				$(curTR).find("#services_remove").show();
				newTR.insertAfter(curTR);
			}
			function add_degree_other(obj)
			{
				var curTR = $(obj).closest('tr');
				curTR.find("#addmore_degree_other").hide();
				$(curTR).find("#services_remove").show();
				var str = '';
				str += '<tr>';
				str += '<td align="right" class="from_text3">&nbsp;</td>';
				str += '<td width="35">&nbsp;</td>';
				str += '<td width="450" style="padding-top: 10px;"><input type="text" name="degree_other[]" class="from_list_menu" some>&nbsp;<span id="services_remove" style="display:none" class="from_text4-org_1" onclick="remove_tr(this);">Remove</span></td>';
				str += '<td width="450" valign="bottom" id="addmore_degree_other"><img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_degree_more(this);" />&nbsp;&nbsp;<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_degree_other(this);" /></td>';
				str += '</tr>';
				$(str).insertAfter(curTR);
			}



		</script>

	</head>
	<body>
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="pricetable">
			<?php $this->load->view('headertopfull1'); ?>
			<tr>
				<td>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td bgcolor="#229B96" class="top_bg2">
								<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="pricetableCopy">
									<tr>
										<td width="135" height="41">&nbsp;
											
										</td>
										<td width="35" align="center">
											<a href="/">
												<img src="<?php echo IMAGE_URL; ?>home_icon.jpg" width="23" height="23" />
											</a>
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
							<?php $this->load->view('doctor_sidebar'); ?>
							<td width="53" valign="top">&nbsp;
								
							</td>
							<td width="985" valign="top">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td height="50">&nbsp;
											
										</td>
									</tr>
									<tr>
										<td class="maine_from">

											<table width="100%" border="0" cellspacing="0" cellpadding="0" class="progressbar_sl" style="display: none;">
												<tr>
													<td height="45" bgcolor="#3dc4bf">
														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td height="45" class="from_page_tetel">
																	Provide your profile details
																</td>
																<td>&nbsp;
																	
																</td>
																<td width="150" align="center" class="text">
																	Step 1 of 3
																</td>
															</tr>
														</table>
													</td>
												</tr>
												<tr>
													<td height="90" align="center">
														<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
															<tr>
																<td width="47">
																	<div id="circle1">
																		1
																	</div>
																</td>
																<td class="from_tetel_text">
																	Professional Details
																</td>
																<td width="47">
																	<div id="circle2">
																		2
																	</div>
																</td>
																<td>
																	<span class="from_tetel_text">
																		Clinic / Hospital Details
																	</span>
																</td>
																<td width="47">
																	<div id="circle2">
																		3
																	</div>
																</td>
																<td>
																	<span class="from_tetel_text">
																		Account Setup
																	</span>
																</td>
															</tr>
														</table>
													</td>
												</tr>
												<tr>
													<td bgcolor="#F6F6F6">
														<div class="meter">
															<span id="meterperct" style="width:33%">
															</span>
															<p>
															</p>
														</div>
													</td>
												</tr>
											</table>

											<?php $this->load->view('sl_step1'); ?>

										</td>
									</tr>
									<!--<tr>
									<td>
									&nbsp;
									</td>
									</tr>-->
								</table>
							</td>
							<td width="53">&nbsp;
								
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>

	</body>
</html>
