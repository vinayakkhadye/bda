<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>
			Book Dr Appointment
		</title>
		<link href="<?=CSS_URL?>login/maine.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="<?=CSS_URL?>login/style.css" />
		<script src="<?php echo JS_URL; ?>login/jquery.min.js">
		</script>
		<style type="text/css">
			/*this is just to organize the demo checkboxes*/
			label
			{
				margin-right: 20px;
			}
			#sevices_remove
			{
				cursor: pointer;
			}
		</style>
		<script type="text/javascript">

			function DropDown(el)
			{
				this.dd = el;
				this.initEvents();
			}
			DropDown.prototype =
			{
				initEvents : function()
				{
					var obj = this;

					obj.dd.on('click', function(event)
						{
							$(this).toggleClass('active');
							event.stopPropagation();
						});
				}
			}

			$(function()
				{

					var dd = new DropDown( $('#dd') );

					$(document).click(function()
						{
							// all dropdowns
							$('.wrapper-dropdown-5').removeClass('active');
						});

				});
			function remove_tr(obj)
			{
				if(confirm("Are you sure you want to delete "+$( obj ).prev().val()))
				{
					console.log($( obj ).closest( "tr" ).remove());
				}
			}
			function add_services_more(obj)
			{
				var curTR = $(obj).closest('tr');
				newTR = $("#service_more_tocopy").clone();
				newTR.show();
				newTR.removeAttr("id");
				service_more_tocopy
				curTR.find("#addmore_services_other").hide();
				newTR.find("#label_services").html("&nbsp;");
				$(newTR).find("#sevices_remove").hide();
				$(curTR).find("#sevices_remove").show();
				newTR.insertAfter(curTR);
			}
			function add_services_other(obj)
			{
				var curTR = $(obj).closest('tr');
				curTR.find("#addmore_services_other").hide();
				$(curTR).find("#sevices_remove").show();
				var str = '';
				str += '<tr>';
				str += '<td align="right" class="from_text3">&nbsp;</td>';
				str += '<td width="35">&nbsp;</td>';
				str += '<td width="450"><input type="text" name="services[]" class="from_list_menu" some>&nbsp;<span id="sevices_remove" style="display:none" class="from_text4-org_1" onclick="remove_tr(this);">Remove</span></td>';
				str += '<td width="450" valign="bottom" id="addmore_services_other"><img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_services_more(this);" />&nbsp;&nbsp;<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_services_other(this);" /></td>';
				str += '</tr>';
				$(str).insertAfter(curTR);
			}

			function add_specializations_more(obj)
			{
				var curTR = $(obj).closest('tr');
				newTR = $("#specializations_more_tocopy").clone();
				newTR.show();
				newTR.removeAttr("id");
				service_more_tocopy
				curTR.find("#addmore_specializations_other").hide();
				newTR.find("#label_specializations").html("&nbsp;");
				$(newTR).find("#specializations_remove").hide();
				$(curTR).find("#specializations_remove").show();
				newTR.insertAfter(curTR);
			}

			function add_specializations_other(obj)
			{
				var curTR = $(obj).closest('tr');
				$(curTR).find("#addmore_specializations_other").hide();
				$(curTR).find("#specializations_remove").show();
				var str = '';
				str += '<tr>';
				str += '<td align="right" class="from_text3">&nbsp;</td>';
				str += '<td width="35">&nbsp;</td>';
				str += '<td width="450"><input type="text" name="specializations[]" class="from_list_menu" some>&nbsp;<span id="specializations_remove" style="display:none" class="from_text4-org_1" onclick="remove_tr(this);">&nbsp;Remove</span></td>';
				str += '<td width="450" valign="bottom" id="addmore_specializations_other"><img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_specializations_more(this);" />&nbsp;&nbsp;<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_specializations_other(this);" /></td>';
				str += '</tr>';
				$(str).insertAfter(curTR);

			}
			function add_education_more(obj)
			{
				var curTR = $(obj).closest('tr');
				newTR = $("#education_more_tocopy").clone();
				newTR.show();
				newTR.removeAttr("id");
				service_more_tocopy
				curTR.find("#addmore_education_other").hide();
				newTR.find("#label_education").html("&nbsp;");
				$(newTR).find("#education_remove").hide();
				$(curTR).find("#education_remove").show();
				newTR.insertAfter(curTR);

			}
			function add_education_other(obj)
			{
				var curTR = $(obj).closest('tr');
				$(curTR).find("#addmore_education_other").hide();
				$(curTR).find("#education_remove").show();
				var str = '';
				str += '<tr>';
				str += '<td align="right" class="from_text3">&nbsp;</td>';
				str += '<td width="35">&nbsp;</td>';
				str += '<td colspan="2"><input type="text" placeholder="degree" name="education_qualification[]" class="from_list_menu" placeholder=""  style="width:183px;"  />&nbsp;&nbsp;<input type="text" name="education_college[]" placeholder="college" class="from_list_menu" placeholder="" style="width:183px;" />&nbsp;&nbsp;<input type="text" name="education_from_year[]" class="from_list_menu" placeholder="year"  style="width:183px;"/><span id="education_remove" style="display:none" class="from_text4-org_1" onclick="remove_tr(this);">Remove</span>&nbsp;<span id="addmore_education_other"><img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_education_more(this);" />&nbsp;&nbsp;<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_education_other(this);" /></span></td>';

				str += '';
				str += '</tr>';
				$(str).insertAfter(curTR);
			}
			function add_experience_more(obj)
			{
				var curTR = $(obj).closest('tr');
				newTR = $("#experience_more_tocopy").clone();
				newTR.show();
				newTR.removeAttr("id");
				service_more_tocopy
				curTR.find("#addmore_experience_other").hide();
				newTR.find("#label_experience").html("&nbsp;");
				$(newTR).find("#experience_remove").hide();
				$(curTR).find("#experience_remove").show();
				newTR.insertAfter(curTR);

			}
			function add_experience_other(obj)
			{
				var curTR = $(obj).closest('tr');
				$(curTR).find("#addmore_experience_other").hide();
				$(curTR).find("#experience_remove").show();
				var str = '';
				str += '<tr>';
				str += '<td align="right" class="from_text3">&nbsp;</td>';
				str += '<td width="35">&nbsp;</td>';
				str += '<td colspan="2"><input type="text" name="experience_from_year[]" class="from_list_menu" placeholder="from_year" style="width:80px;"  />to <input type="text" name="experience_to_year[]" class="from_list_menu" placeholder="to_year" style="width:80px;" />&nbsp;<input type="text" name="experience_role[]" class="from_list_menu" placeholder="role" style="width:183px;"/>at <input type="text" name="experience_hospital[]" class="from_list_menu" placeholder="hospital" style="width:183px;"/>&nbsp;<input type="text" name="experience_city[]" class="from_list_menu" placeholder="city" style="width:80px;"/><span id="experience_remove" style="display:none" class="from_text4-org_1" onclick="remove_tr(this);">Remove</span>&nbsp;<span id="addmore_experience_other"><img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_experience_more(this);" />&nbsp;&nbsp;<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_experience_other(this);" /></span></td>';

				str += '';
				str += '</tr>';
				$(str).insertAfter(curTR);

			}

			function add_awardsandrecognitions_more(obj)
			{
				var curTR = $(obj).closest('tr');
				newTR = $("#awardsandrecognitions_more_tocopy").clone();
				newTR.show();
				newTR.removeAttr("id");
				service_more_tocopy
				curTR.find("#addmore_awardsandrecognitions_other").hide();
				newTR.find("#label_awardsandrecognitions").html("&nbsp;");
				$(newTR).find("#awardsandrecognitions_remove").hide();
				$(curTR).find("#awardsandrecognitions_remove").show();
				newTR.insertAfter(curTR);
			}
			function add_awardsandrecognitions_other(obj)
			{
				var curTR = $(obj).closest('tr');
				$(curTR).find("#addmore_awardsandrecognitions_other").hide();
				$(curTR).find("#awardsandrecognitions_remove").show();
				var str = '';
				str += '<tr>';
				str += '<td align="right" class="from_text3">&nbsp;</td>';
				str += '<td width="35">&nbsp;</td>';
				str += '<td colspan="2"><input name="awardsandrecognitions_award[]" style="width:358px;" placeholder="" type="text" class="from_text_filed" />&nbsp;<input name="awardsandrecognitions_from_year[]" placeholder="" type="text" class="from_text_filed"  style="width:80px;" /><span id="awardsandrecognitions_remove" style="display:none" class="from_text4-org_1" onclick="remove_tr(this);">Remove</span>&nbsp;<span id="addmore_awardsandrecognitions_other"><img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_awardsandrecognitions_more(this);" />&nbsp;&nbsp;<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_awardsandrecognitions_other(this);" /></span></td>';

				str += '';
				str += '</tr>';
				$(str).insertAfter(curTR);
			}
			function add_membership_more(obj)
			{
				var curTR = $(obj).closest('tr');
				newTR = $("#membership_more_tocopy").clone();
				newTR.show();
				newTR.removeAttr("id");
				service_more_tocopy
				curTR.find("#addmore_membership_other").hide();
				newTR.find("#label_membership").html("&nbsp;");
				$(newTR).find("#membership_remove").hide();
				$(curTR).find("#membership_remove").show();
				newTR.insertAfter(curTR);
			}

			function add_membership_other(obj)
			{
				var curTR = $(obj).closest('tr');
				$(curTR).find("#addmore_membership_other").hide();
				$(curTR).find("#membership_remove").show();
				var str = '';
				str += '<tr>';
				str += '<td align="right" class="from_text3">&nbsp;</td>';
				str += '<td width="35">&nbsp;</td>';
				str += '<td width="450"><input type="text" name="membership[]" class="from_list_menu" some>&nbsp;<span id="membership_remove" style="display:none" class="from_text4-org_1" onclick="remove_tr(this);">&nbsp;Remove</span></td>';
				str += '<td width="450" valign="bottom" id="addmore_membership_other"><img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_membership_more(this);" />&nbsp;&nbsp;<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_membership_other(this);" /></td>';
				str += '</tr>';
				$(str).insertAfter(curTR);

			}
			function add_registrations_more(obj)
			{
				var curTR = $(obj).closest('tr');
				newTR = $("#registrations_more_tocopy").clone();
				newTR.show();
				newTR.removeAttr("id");
				service_more_tocopy
				curTR.find("#addmore_registrations_other").hide();
				newTR.find("#label_registrations").html("&nbsp;");
				$(newTR).find("#registrations_remove").hide();
				$(curTR).find("#registrations_remove").show();
				newTR.insertAfter(curTR);
			}
			function add_registrations_other(obj)
			{
				var curTR = $(obj).closest('tr');
				$(curTR).find("#addmore_registrations_other").hide();
				$(curTR).find("#registrations_remove").show();
				var str = '';
				str += '<tr>';
				str += '<td align="right" class="from_text3">&nbsp;</td>';
				str += '<td width="35">&nbsp;</td>';
				str += '<td colspan="2"><input type="text" name="registrations_no[]" class="from_list_menu" placeholder="" style="width:180px;"  />&nbsp;<input type="text" name="registrations_council[]" class="from_list_menu" placeholder="" style="width:180px;"/>&nbsp;<input type="text" name="registrations_year[]" class="from_list_menu" placeholder="" style="width:80px;"/><span id="registrations_remove" style="display:none" class="from_text4-org_1" onclick="remove_tr(this);">&nbsp;Remove</span>&nbsp;<span id="addmore_registrations_other"><img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_registrations_more(this);" />&nbsp;&nbsp;<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_registrations_other(this);" /></span></td>';

				str += '';
				str += '</tr>';
				$(str).insertAfter(curTR);
			}
			function add_qualifications_more(obj)
			{
				var curTR = $(obj).closest('tr');
				newTR = $("#qualifications_more_tocopy").clone();
				newTR.show();
				newTR.removeAttr("id");
				curTR.find("#addmore_qualifications_other").hide();
				newTR.find("#label_qualifications").html("&nbsp;");
				$(newTR).find("#qualifications_remove").hide();
				$(curTR).find("#qualifications_remove").show();
				newTR.insertAfter(curTR);
			}
			function add_qualifications_other(obj)
			{
				var curTR = $(obj).closest('tr');
				curTR.find("#addmore_qualifications_other").hide();
				$(curTR).find("#qualifications_remove").show();
				var str = '';
				str += '<tr>';
				str += '<td align="right" class="from_text3">&nbsp;</td>';
				str += '<td width="35">&nbsp;</td>';
				str += '<td width="450"><input type="text" name="qualifications[]" class="from_list_menu" some>&nbsp;<span id="qualifications_remove" style="display:none" class="from_text4-org_1" onclick="remove_tr(this);">Remove</span></td>';
				str += '<td width="450" valign="bottom" id="addmore_qualifications_other"><img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_qualifications_more(this);" />&nbsp;&nbsp;<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_qualifications_other(this);" /></td>';
				str += '</tr>';
				$(str).insertAfter(curTR);
			}
			function add_paperspublished_more(obj)
			{
				var curTR = $(obj).closest('tr');
				newTR = $("#paperspublished_more_tocopy").clone();
				newTR.show();
				newTR.removeAttr("id");
				curTR.find("#addmore_paperspublished_other").hide();
				newTR.find("#label_paperspublished").html("&nbsp;");
				$(newTR).find("#paperspublished_remove").hide();
				$(curTR).find("#paperspublished_remove").show();
				newTR.insertAfter(curTR);
			}
			function add_paperspublished_other(obj)
			{
				var curTR = $(obj).closest('tr');
				curTR.find("#addmore_paperspublished_other").hide();
				$(curTR).find("#paperspublished_remove").show();
				var str = '';
				str += '<tr>';
				str += '<td align="right" class="from_text3">&nbsp;</td>';
				str += '<td width="35">&nbsp;</td>';
				str += '<td width="450"><textarea name="paperspublished[]" cols="45" rows="5" class="from_text_area"></textarea><span id="paperspublished_remove" style="display:none" class="from_text4-org_1" onclick="remove_tr(this);">Remove</span></td>';
				str += '<td width="450" valign="bottom" id="addmore_paperspublished_other"><img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_paperspublished_more(this);" />&nbsp;&nbsp;<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_paperspublished_other(this);" /></td>';
				str += '</tr>';
				$(str).insertAfter(curTR);
			}
			function patient_numbers_addmore(obj)
			{
				console.log($(".patient_row").length);
				if($(".patient_row").length > 20)
				{
					alert("you can add only 20 patients");
					return false;
				}
				var curTR = $(obj).closest('tr');
				newTR = $("#patient_numbers_more_tocopy").clone();
				newTR.show();
				newTR.attr("id","patient_row");
				curTR.find("#addmore_patient_numbers").hide();
				$(newTR).find("#patient_numbers_remove").hide();
				$(curTR).find("#patient_numbers_remove").show();
				newTR.insertAfter(curTR);
			}

			function hide_steps()
			{
				$("#professional_table").hide();
				$("#accreditations_table").hide();
				$("#patient_review_table").hide();
				$("#account_setup_table").hide();
				$(".professional_step").attr("id","circle2");
				$(".accreditations_step").attr("id","circle2");
				$(".patient_step").attr("id","circle2");
				$(".account_step").attr("id","circle2");
			}
			function show_hide_steps(str)
			{
				if(str == "professional_table")
				{
					hide_steps();
					$("#professional_table").show();
					$("#meterperct").css("width","25%");
					$(".professional_step").attr("id","circle1");
				}else if(str == "accreditations_table")
				{
					hide_steps();
					$("#accreditations_table").show();
					$("#meterperct").css("width","50%");
					$(".professional_step").attr("id","circle1");
					$(".accreditations_step").attr("id","circle1");
				}else if(str == "patient_review_table")
				{
					hide_steps();
					$("#patient_review_table").show();
					$("#meterperct").css("width","75%");
					$(".professional_step").attr("id","circle1");
					$(".accreditations_step").attr("id","circle1");
					$(".patient_step").attr("id","circle1");
				}else if(str == "account_setup_table")
				{
					$("#submit_form").html("processing");
					var form_data =  $("#onlinereputation_form").serialize();
					$.ajax(
						{
							type: 'POST',
							url: "/doctor/post_onlinereputation/",
							data: $("#onlinereputation_form").serialize(),
							success: function(data)
							{
								hide_steps();
								$("#meterperct").css("width","100%");
								$("#account_setup_table").show();
								$(".professional_step").attr("id","circle1");
								$(".accreditations_step").attr("id","circle1");
								$(".patient_step").attr("id","circle1");
								$(".account_step").attr("id","circle1");
								$("#submit_form").html("submit");
							},
							error:function(data)
							{
								$("#submit_form").html("submit");
							}
						});


				}
			}
			$(function()
				{
					$("#accreditations_table").hide();
					$("#patient_review_table").hide();
					$("#account_setup_table").hide();
				})
		</script>
	</head>

	<body>
		<div id="overlay">
<div id="circle_loader">
<img id="loading" src="<?php echo BASE_URL;?>static/images/bdaloader.gif">
</div>
</div>
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="pricetable">
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
											<img src="<?=IMAGE_URL?>home_icon.jpg" width="23" height="23" />
										</td>
										<td width="44" valign="bottom">
											<img src="<?=IMAGE_URL?>devaiter.jpg" width="44" height="40" />
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
								<form name="onlinereputation" id="onlinereputation_form" method="post">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td height="50">&nbsp;
												
											</td>
										</tr>
										<tr>
											<td class="maine_from" id="maine_from">
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
																	<td width="150" align="center" class="text">
																		Step 1 of 4
																	</td>
																</tr>
															</table>
														</td>
													</tr>
													<tr>
														<td height="90" align="center">
															<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
																<tr>
																	<td width="47">
																		<div class="professional_step" id="circle1">
																			1
																		</div>
																	</td>
																	<td class="from_tetel_text">
																		Professional Details
																	</td>
																	<td width="47">
																		<div class="accreditations_step" id="circle2">
																			2
																		</div>
																	</td>
																	<td>
																		<span class="from_tetel_text">
																			Accreditations
																		</span>
																	</td>
																	<td width="47">
																		<div class="patient_step" id="circle2">
																			3
																		</div>
																	</td>
																	<td>
																		<span class="from_tetel_text">
																			Patient Review
																		</span>
																	</td>
																	<td width="47">
																		<div class="account_step" id="circle2">
																			4
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
																<span style="width:25%" id="meterperct">
																</span>
															</div>
														</td>
													</tr>
													<tr id="professional_table">
														<td valign="top">
															<table width="100%" border="0" cellspacing="0" cellpadding="0" >
																<tr>
																	<td align="right" class="from_text3" id="label_services">&nbsp;
																		
																	</td>
																	<td width="35">&nbsp;
																		
																	</td>
																	<td width="450">&nbsp;
																		
																	</td>
																</tr>
																<?php
																if(isset($doctor_detail['Services']) && is_array($doctor_detail['Services']) && sizeof($doctor_detail['Services']) > 0)
																{
																	?>
																	<tr>
																		<td align="right" class="from_text3" id="label_services">
																			Services offered
																		</td>
																		<td width="35">&nbsp;
																			
																		</td>
																		<td width="450">&nbsp;
																			
																		</td>
																	</tr>
																	<?php
																	foreach($doctor_detail['Services'] as $key=>$val)
																	{
																		?>
																		<tr>
																			<td align="right" class="from_text3">&nbsp;
																				
																			</td>
																			<td width="35">&nbsp;
																				
																			</td>
																			<td width="450">
																				<input type="text" name="services[]" class="from_list_menu" value="<?=$val['description1']?>" readonly="true"  />
																				<span class="from_text4-org_1" onclick="remove_tr(this);">
																					Remove
																				</span>
																			</td>
																		</tr>
																		<?php
																	}?>
																	<tr>
																		<td align="right" class="from_text3">&nbsp;
																			
																		</td>
																		<td width="35">&nbsp;
																			
																		</td>
																		<td width="450" >
																			<select name="services[]" class="from_list_menu" >
																				<option value="">
																					Select Service
																				</option>
																				<?php
																				foreach($services as $key=>$val)
																				{
																					?>
																					<option value="<?=$val['name']?>">
																						<?=$val['name']?>
																					</option>
																					<?php
																				} ?>
																			</select>
																			<span id="sevices_remove" style="display:none" onclick="remove_tr(this);" class="from_text4-org_1">
																				&nbsp;Remove
																			</span>
																		</td>
																		<td width="450" valign="bottom" id="addmore_services_other">
																			<img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_services_more(this);" />							                      &nbsp;&nbsp;
																			<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_services_other(this,'services');" />
																		</td>
																	</tr>
																	<?php
																}
																else
																{
																	?>
																	<tr>
																		<td align="right" class="from_text3" id="label_services">
																			Services offered
																			
																		</td>
																		<td width="35">&nbsp;
																			
																		</td>
																		<td width="450">&nbsp;
																			
																		</td>
																	</tr>
																	<tr>
																		<td align="right" class="from_text3" id="label_services">&nbsp;
																			
																		</td>
																		<td width="35">&nbsp;
																			
																		</td>
																		<td width="450">
																			<select name="services[]" class="from_list_menu">
																				<option value="">
																					Select Service
																				</option>
																				<?php
																				foreach($services as $key=>$val)
																				{
																					?>
																					<option value="<?=$val['name']?>">
																						<?=$val['name']?>
																					</option>
																					<?php
																				} ?>
																			</select>
																			<span id="sevices_remove" style="display:none" onclick="remove_tr(this);" class="from_text4-org_1">
																				&nbsp;Remove
																			</span>
																		</td>
																		<td width="450" valign="bottom" id="addmore_services_other">
																			<img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_services_more(this);" />
																			&nbsp;&nbsp;<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_services_other(this);" />
																		</td>
																	</tr>
																	<?php
																}?>

																<tr>
																	<td align="right">&nbsp;
																		
																	</td>
																	<td width="35">&nbsp;
																		
																	</td>
																	<td width="450">&nbsp;
																		
																	</td>
																	<td width="450">&nbsp;
																		
																	</td>
																</tr>

																<?php
																if(isset($doctor_detail['Specializations']) && is_array($doctor_detail['Specializations']) && sizeof($doctor_detail['Specializations']) > 0)
																{
																	?>
																	<tr>
																		<td align="right" class="from_text3" id="label_specializations">
																			Specializations
																		</td>
																		<td width="35">&nbsp;
																			
																		</td>
																		<td width="450">&nbsp;
																			
																		</td>
																	</tr>
																	<?php
																	foreach($doctor_detail['Specializations'] as $key=>$val)
																	{
																		?>
																		<tr>
																			<td align="right" class="from_text3">&nbsp;
																				
																			</td>
																			<td width="35">&nbsp;
																				
																			</td>
																			<td width="450">
																				<input type="text" name="specializations[]" class="from_list_menu" value="<?=$val['description1']?>" readonly="true"  />
																				<span id="specializations_remove" onclick="remove_tr(this);" class="from_text4-org_1">
																					&nbsp;Remove
																				</span>
																			</td>
																		</tr>
																		<?php
																	}?>
																	<tr>
																		<td align="right" class="from_text3">&nbsp;
																			
																		</td>
																		<td width="35">&nbsp;
																			
																		</td>
																		<td width="450">
																			<select name="specializations[]" class="from_list_menu" >
																				<option value="">
																					Select Specialization
																				</option>
																				<?php
																				foreach($specializations as $key=>$val)
																				{
																					?>
																					<option value="<?=$val['name']?>">
																						<?=$val['name']?>
																					</option>
																					<?php
																				} ?>
																			</select>
																			<span id="specializations_remove" style="display:none" onclick="remove_tr(this);" class="from_text4-org_1">
																				&nbsp;Remove
																			</span>
																		</td>
																		<td width="450" valign="bottom" id="addmore_specializations_other">
																			<img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_specializations_more(this);" />&nbsp;&nbsp;
																			<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_specializations_other(this);" />
																		</td>
																	</tr>
																	<?php
																}
																else
																{
																	?>
																	<tr>
																		<td align="right" class="from_text3" id="label_specializations">
																			Specializations
																		</td>
																		<td width="35">&nbsp;
																			
																		</td>
																		<td width="450">&nbsp;
																			
																		</td>
																	</tr>
																	<tr>
																		<td align="right" class="from_text3" id="label_specializations">&nbsp;
																			
																		</td>
																		<td width="35">&nbsp;
																			
																		</td>
																		<td width="450">
																			<select name="specializations[]" class="from_list_menu">
																				<option value="">
																					Select Specializations
																				</option>
																				<?php
																				foreach($specializations as $key=>$val)
																				{
																					?>
																					<option value="<?=$val['name']?>">
																						<?=$val['name']?>
																					</option>
																					<?php
																				} ?>
																			</select>
																			<span id="specializations_remove" style="display:none" onclick="remove_tr(this);" class="from_text4-org_1">
																				&nbsp;Remove
																			</span>
																		</td>
																		<td width="450" valign="bottom" id="addmore_specializations_other">
																			<img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_specializations_more(this);" />
																			&nbsp;&nbsp;
																			<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_specializations_other(this);" />
																		</td>
																	</tr>
																	<?php
																}?>

																<tr>
																	<td align="right">&nbsp;
																		
																	</td>
																	<td width="35">&nbsp;
																		
																	</td>
																	<td width="450">&nbsp;
																		
																	</td>
																	<td width="450">&nbsp;
																		
																	</td>
																</tr>
																<?php
																if(isset($doctor_detail['Education']) && is_array($doctor_detail['Education']) && sizeof($doctor_detail['Education']) > 0)
																{
																	?>
																	<tr>
																		<td align="right" class="from_text3" id="label_education">
																			Education
																		</td>
																		<td width="35">&nbsp;
																			
																		</td>
																		<td width="450">&nbsp;
																			
																		</td>
																	</tr>
																	<?php
																	foreach($doctor_detail['Education'] as $key=>$val)
																	{
																		?>
																		<tr>
																			<td align="right" class="from_text3">&nbsp;
																				
																			</td>
																			<td width="35">&nbsp;
																				
																			</td>
																			<td colspan="2">
																				<input type="text" name="education_qualification[]" class="from_list_menu" value="<?=$val['description1']?>" readonly="true" style="width:183px;"  />
																				<input type="text" name="education_college[]" class="from_list_menu" value="<?=$val['description2']?>" readonly="true" style="width:183px;" />
																				<input type="text" name="education_from_year[]" class="from_list_menu" value="<?=$val['from_year']?>" readonly="true"  style="width:183px;"/>
																				<span id="education_remove" onclick="remove_tr(this);" class="from_text4-org_1">
																					&nbsp;Remove
																				</span>
																			</td>
																		</tr>
																		<?php
																	}?>
																	<tr>
																		<td align="right" class="from_text3">&nbsp;
																			
																		</td>
																		<td width="35">&nbsp;
																			
																		</td>
																		<td colspan="2">

																			<select name="education_qualification[]" class="from_list_menu3">
																				<option value="">
																					Degree
																				</option>
																				<?php
																				foreach($qualification as $key=>$val)
																				{
																					?>
																					<option value="<?=$val['name']?>">
																						<?=$val['name']?>
																					</option>
																					<?php
																				} ?>
																			</select>
																			&nbsp;
																			<select name="education_college[]" class="from_list_menu3">
																				<option value="">
																					College Name
																				</option>
																				<?php
																				foreach($college as $key=>$val)
																				{
																					?>
																					<option value="<?=$val['name']?>">
																						<?=$val['name']?>
																					</option>
																					<?php
																				} ?>
																			</select>&nbsp;
																			<select name="education_from_year[]" class="from_list_menu3">
																				<option value="">
																					Year
																				</option>
																				<?php
																				foreach($from_year as $val)
																				{
																					?>
																					<option value="<?=$val?>">
																						<?=$val?>
																					</option>
																					<?php
																				} ?>
																			</select>
																			<span id="education_remove" style="display:none" onclick="remove_tr(this);" class="from_text4-org_1">
																				&nbsp;Remove
																			</span>
																			<span id="addmore_education_other">
																				<img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_education_more(this);" />
																				<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_education_other(this);" />
																			</span>
																		</td>
																	</tr>
																	<?php
																}
																else
																{
																	?>
																	<tr>
																		<td align="right" class="from_text3" id="label_education">
																			Education
																		</td>
																		<td width="35">&nbsp;
																			
																		</td>
																		<td width="450">&nbsp;
																			
																		</td>
																	</tr>
																	<tr>
																		<td align="right" class="from_text3" id="label_education">
																		</td>
																		<td width="35">&nbsp;
																			
																		</td>
																		<td colspan="2" >

																			<select name="education_qualification[]" class="from_list_menu3">
																				<option value="">
																					Degree
																				</option>
																				<?php
																				foreach($qualification as $key=>$val)
																				{
																					?>
																					<option value="<?=$val['name']?>">
																						<?=$val['name']?>
																					</option>
																					<?php
																				} ?>
																			</select>
																			&nbsp;
																			<select name="education_college[]" class="from_list_menu3">
																				<option value="">
																					College Name
																				</option>
																				<?php
																				foreach($college as $key=>$val)
																				{
																					?>
																					<option value="<?=$val['name']?>">
																						<?=$val['name']?>
																					</option>
																					<?php
																				} ?>
																			</select>&nbsp;
																			<select name="education_from_year[]" class="from_list_menu3">
																				<option value="">
																					Year
																				</option>
																				<?php
																				foreach($from_year as $val)
																				{
																					?>
																					<option value="<?=$val?>">
																						<?=$val?>
																					</option>
																					<?php
																				} ?>
																			</select>
																			<span id="education_remove" style="display:none" onclick="remove_tr(this);" class="from_text4-org_1">
																				&nbsp;Remove
																			</span>&nbsp;
																			<span id="addmore_education_other">
																				<img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_education_more(this);" />
																				<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_education_other(this);" />
																			</span>
																		</td>
																	</tr>
																	<?php
																} ?>

																<tr>
																	<td align="right">&nbsp;
																		
																	</td>
																	<td width="35">&nbsp;
																		
																	</td>
																	<td width="450">&nbsp;
																		
																	</td>
																	<td width="450">&nbsp;
																		
																	</td>
																</tr>
																<?php
																if(isset($doctor_detail['Experience']) && is_array($doctor_detail['Experience']) && sizeof($doctor_detail['Experience']) > 0)
																{
																	?>

																	<tr>
																		<td align="right" class="from_text3" id="label_experience">
																			Experience
																		</td>
																		<td width="35">&nbsp;
																			
																		</td>
																		<td width="450">&nbsp;
																			
																		</td>
																	</tr>
																	<?php

																	foreach($doctor_detail['Experience'] as $key=>$val)
																	{
																		?>
																		<tr>
																			<td align="right" class="from_text3">&nbsp;
																				
																			</td>
																			<td width="35">&nbsp;
																				
																			</td>
																			<td colspan="2">
																				<input type="text" name="experience_from_year[]" class="from_list_menu" value="<?=$val['from_year']?>" readonly="true" style="width:80px;"  />to
																				<input type="text" name="experience_to_year[]" class="from_list_menu" value="<?=$val['to_year']?>" readonly="true" style="width:80px;" />
																				<input type="text" name="experience_role[]" class="from_list_menu" value="<?=$val['description1']?>" readonly="true"  style="width:183px;"/>at
																				<input type="text" name="experience_hospital[]" class="from_list_menu" value="<?=$val['description2']?>" readonly="true"  style="width:183px;"/>
																				<input type="text" name="experience_city[]" class="from_list_menu" value="<?=$val['description3']?>" readonly="true"  style="width:80px;"/>
																				<span id="experience_remove"  onclick="remove_tr(this);" class="from_text4-org_1">
																					&nbsp;Remove
																				</span>
																			</td>
																		</tr>
																		<?php
																	}?>
																	<tr>
																		<td align="right" class="from_text3">
																		</td>
																		<td>&nbsp;
																			
																		</td>
																		<td colspan="2" valign="top">
																			<select name="experience_from_year[]" class="from_list_menu3" style="width:80px;">
																				<option value="">
																					Year
																				</option>
																				<?php
																				foreach($from_year as $val)
																				{
																					?>
																					<option value="<?=$val?>">
																						<?=$val?>
																					</option>
																					<?php
																				} ?>
																			</select>
																			<span class="from_text4">
																				to
																				<select name="experience_to_year[]" class="from_list_menu3" style="width:80px;">
																					<option value="">
																						Year
																					</option>
																					<?php
																					foreach($to_year as $val)
																					{
																						?>
																						<option value="<?=$val?>">
																							<?=$val?>
																						</option>
																						<?php
																					} ?>
																				</select>
																				<input name="experience_role[]" type="text" class="date" placeholder="Role"  style="width:180px;" />
																				&nbsp;at
																				<input name="experience_hospital[]" type="text" class="date" placeholder="Hospital / Clinic" />
																				<select name="experience_city[]" class="from_list_menu5" style="width:80px;">
																					<option value="">
																						City
																					</option>
																					<?php
																					foreach($city as $key=>$val)
																					{
																						?>
																						<option value="<?=$val['name']?>">
																							<?=$val['name']?>
																						</option>
																						<?php
																					} ?>
																				</select>
																				<span id="experience_remove" style="display:none" onclick="remove_tr(this);" class="from_text4-org_1">
																					&nbsp;Remove
																				</span>
																				&nbsp;
																				<span id="addmore_experience_other">
																					<img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_experience_more(this);" />
																					<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_experience_other(this);" />
																				</span>
																			</span>
																		</td>
																	</tr>
																	<?php
																}
																else
																{
																	?>
																	<tr>
																		<td align="right" class="from_text3" id="label_experience">
																			Experience
																		</td>
																		<td width="35">&nbsp;
																			
																		</td>
																		<td width="450">&nbsp;
																			
																		</td>
																	</tr>

																	<tr>
																		<td align="right" class="from_text3" id="label_experience">&nbsp;
																			
																		</td>
																		<td>&nbsp;
																			
																		</td>
																		<td colspan="2" valign="top">
																			<select name="experience_from_year[]" class="from_list_menu3" style="width:80px;">
																				<option value="">
																					Year
																				</option>
																				<?php
																				foreach($from_year as $val)
																				{
																					?>
																					<option value="<?=$val?>">
																						<?=$val?>
																					</option>
																					<?php
																				} ?>
																			</select>
																			<span class="from_text4">
																				to
																				<select name="experience_to_year[]" class="from_list_menu3" style="width:80px;">
																					<option value="">
																						Year
																					</option>
																					<?php
																					foreach($to_year as $val)
																					{
																						?>
																						<option value="<?=$val?>">
																							<?=$val?>
																						</option>
																						<?php
																					} ?>
																				</select>
																				<input name="experience_role[]" type="text" class="date" placeholder="Role"  style="width:180px;" />
																				&nbsp;at
																				<input name="experience_hospital[]" type="text" class="date" placeholder="Hospital / Clinic" />
																				<select name="experience_city[]" class="from_list_menu5" style="width:80px;">
																					<option value="">
																						City
																					</option>
																					<?php
																					foreach($city as $key=>$val)
																					{
																						?>
																						<option value="<?=$val['name']?>">
																							<?=$val['name']?>
																						</option>
																						<?php
																					} ?>
																				</select>
																				<span id="experience_remove" style="display:none" onclick="remove_tr(this);" class="from_text4-org_1">
																					&nbsp;Remove
																				</span>
																				&nbsp;
																				<span id="addmore_experience_other">
																					<img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_experience_more(this);" />
																					<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_experience_other(this);" />
																				</span>
																			</span>
																		</td>
																	</tr>
																	<?php
																} ?>

																<tr>
																	<td align="right">&nbsp;
																		
																	</td>
																	<td>&nbsp;
																		
																	</td>
																	<td>&nbsp;
																		
																	</td>
																	<td>&nbsp;
																		
																	</td>
																</tr>
																<tr>
																	<td colspan="4" height="53" align="right" bgcolor="#f5f5f5">
																		<a href="#maine_from">
																			<div style="padding-right:30px;float:right" class="continue_bnt" onclick="show_hide_steps('accreditations_table')">
																				Continue
																			</div>
																		</a>

																	</td>
																</tr>
															</table>
														</td>
													</tr>

												</table>
											</td>
										</tr>
										<tr id="accreditations_table" style="display:none">
											<td bgcolor="#FFFFFF">
												<table width="100%" border="0" cellspacing="0" cellpadding="0" >
													<tr>
														<td width="192">&nbsp;
															
														</td>
														<td width="35">&nbsp;
															
														</td>
														<td width="450">&nbsp;
															
														</td>
														<td width="126">&nbsp;
															
														</td>
													</tr>
													<?php
													if(isset($doctor_detail['AwardsAndRecognitions']) && is_array($doctor_detail['AwardsAndRecognitions']) && sizeof($doctor_detail['AwardsAndRecognitions']) > 0)
													{
														?>
														<tr>
															<td align="right" class="from_text3" id="label_awardsandrecognitions">
																Awards &amp; Recognitions
															</td>
															<td width="35">&nbsp;
																
															</td>
															<td colspan="2">
															</td>
														</tr>
														<?php
														foreach($doctor_detail['AwardsAndRecognitions'] as $key=>$val)
														{
															?>
															<tr>
																<td align="right" class="from_text3">&nbsp;
																	
																</td>
																<td width="35">&nbsp;
																	
																</td>
																<td colspan="2">
																	<input name="awardsandrecognitions_award[]" style="width:358px;" value="<?=$val['description1']?>" type="text" class="from_text_filed" readonly="true" />&nbsp;<input name="awardsandrecognitions_from_year[]" value="<?=$val['from_year']?>" type="text" class="from_text_filed" readonly="true" style="width:80px;" />
																	<span id="awardsandrecognitions_remove" onclick="remove_tr(this);" class="from_text4-org_1">
																		&nbsp;Remove
																	</span>
																</td>
															</tr>
															<?php
														}?>
														<tr>
															<td align="right" class="from_text3">&nbsp;
																
															</td>
															<td width="35">&nbsp;
																
															</td>
															<td colspan="2">
																<input name="awardsandrecognitions_award[]" value="<?=$val['description1']?>" type="text" class="from_text_filed" />
																&nbsp;
																<select name="awardsandrecognitions_from_year[]" class="from_list_menu3" style="width:80px;">
																	<option value="">
																		Year
																	</option>
																	<?php
																	foreach($from_year as $val)
																	{
																		?>
																		<option value="<?=$val?>">
																			<?=$val?>
																		</option>
																		<?php
																	} ?>
																</select>
																<span id="awardsandrecognitions_remove" style="display:none" onclick="remove_tr(this);" class="from_text4-org_1">
																	&nbsp;Remove
																</span>
																&nbsp;
																<span id="addmore_awardsandrecognitions_other">
																	<img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_awardsandrecognitions_more(this);" />
																	<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_awardsandrecognitions_other(this);" />
																</span>
															</td>
														</tr>
														<?php
													}
													else
													{
														?>
														<tr>
															<td align="right" class="from_text3" id="label_awardsandrecognitions">
																Awards &amp; Recognitions
															</td>
															<td width="35">&nbsp;
																
															</td>
															<td colspan="2">
															</td>
														</tr>
														<tr>
															<td align="right" class="from_text3" >&nbsp;
																
															</td>
															<td width="35">&nbsp;
																
															</td>
															<td colspan="2">
																<input name="awardsandrecognitions_award[]" value="" type="text" class="from_text_filed" />
																&nbsp;
																<select name="awardsandrecognitions_from_year[]" class="from_list_menu3" style="width:80px;">
																	<option value="">
																		Year
																	</option>
																	<?php
																	foreach($from_year as $val)
																	{
																		?>
																		<option value="<?=$val?>">
																			<?=$val?>
																		</option>
																		<?php
																	} ?>
																</select>
																<span id="awardsandrecognitions_remove" style="display:none" onclick="remove_tr(this);" class="from_text4-org_1">
																	&nbsp;Remove
																</span>
																&nbsp;
																<span id="addmore_awardsandrecognitions_other">
																	<img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_awardsandrecognitions_more(this);" />
																	<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_awardsandrecognitions_other(this);" />
																</span>
															</td>
														</tr>
														<?php
													}?>


													<tr>
														<td align="right">&nbsp;
															
														</td>
														<td width="35">&nbsp;
															
														</td>
														<td width="450" class="from_text4">&nbsp;
															
														</td>
														<td>&nbsp;
															
														</td>
													</tr>
													<?php
													if(isset($doctor_detail['Membership']) && is_array($doctor_detail['Membership']) && sizeof($doctor_detail['Membership']) > 0)
													{
														?>
														<tr>
															<td align="right" class="from_text3" id="label_membership">
																Membership
															</td>
															<td width="35">&nbsp;
																
															</td>
															<td width="450">&nbsp;
																
															</td>
														</tr>
														<?php
														foreach($doctor_detail['Membership'] as $key=>$val)
														{
															?>
															<tr>
																<td align="right" class="from_text3">&nbsp;
																	
																</td>
																<td width="35">&nbsp;
																	
																</td>
																<td width="450">
																	<input type="text" name="membership[]" class="from_list_menu" value="<?=$val['description1']?>" readonly="true"  />
																	<span id="membership_remove" onclick="remove_tr(this);" class="from_text4-org_1">
																		&nbsp;Remove
																	</span>
																</td>
															</tr>
															<?php
														}?>
														<tr>
															<td align="right" class="from_text3">&nbsp;
																
															</td>
															<td width="35">&nbsp;
																
															</td>
															<td width="450">
																<select name="membership[]" class="from_list_menu" >
																	<option value="">
																		Select Membership
																	</option>
																	<?php
																	foreach($membership as $key=>$val)
																	{
																		?>
																		<option value="<?=$val['name']?>">
																			<?=$val['name']?>
																		</option>
																		<?php
																	} ?>
																</select>
																<span id="membership_remove" style="display:none" onclick="remove_tr(this);" class="from_text4-org_1">
																	&nbsp;Remove
																</span>
															</td>
															<td width="450" valign="bottom" id="addmore_membership_other">
																<img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_membership_more(this);" />&nbsp;&nbsp;
																<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_membership_other(this);" />
															</td>
														</tr>
														<?php
													}
													else
													{
														?>
														<tr>
															<td align="right" class="from_text3" id="label_membership">
																Membership
															</td>
															<td width="35">&nbsp;
																
															</td>
															<td width="450">&nbsp;
																
															</td>
														</tr>
														<tr>
															<td align="right" class="from_text3" id="label_membership">&nbsp;
																
															</td>
															<td width="35">&nbsp;
																
															</td>
															<td width="450">
																<select name="membership[]" class="from_list_menu">
																	<option value="">
																		Select membership
																	</option>
																	<?php
																	foreach($membership as $key=>$val)
																	{
																		?>
																		<option value="<?=$val['name']?>">
																			<?=$val['name']?>
																		</option>
																		<?php
																	} ?>
																</select>
																<span id="membership_remove" style="display:none" onclick="remove_tr(this);" class="from_text4-org_1">
																	&nbsp;Remove
																</span>
															</td>
															<td width="450" valign="bottom" id="addmore_membership_other">
																<img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_membership_more(this);" />
																&nbsp;&nbsp;
																<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_membership_other(this);" />
															</td>
														</tr>
														<?php
													} ?>


													<tr>
														<td align="right" class="from_text3">&nbsp;
															
														</td>
														<td>&nbsp;
															
														</td>
														<td>&nbsp;
															
														</td>
														<td>&nbsp;
															
														</td>
													</tr>
													<?php
													if(isset($doctor_detail['Registrations']) && is_array($doctor_detail['Registrations']) && sizeof($doctor_detail['Registrations']) > 0)
													{
														?>

														<tr>
															<td align="right" class="from_text3" id="label_registrations">
																Registrations
															</td>
															<td width="35">&nbsp;
																
															</td>
															<td width="450">&nbsp;
																
															</td>
														</tr>
														<?php
														foreach($doctor_detail['Registrations'] as $key=>$val)
														{
															?>
															<tr>
																<td align="right" class="from_text3">&nbsp;
																	
																</td>
																<td width="35">&nbsp;
																	
																</td>
																<td colspan="2">
																	<input type="text" name="registrations_no[]" class="from_list_menu" value="<?=$val['description1']?>" readonly="true" style="width:180px;"  />
																	<input type="text" name="registrations_council[]" class="from_list_menu" value="<?=$val['description2']?>" readonly="true" style="width:180px;" />
																	<input type="text" name="registrations_year[]" class="from_list_menu" value="<?=$val['to_year']?>" readonly="true"  style="width:80px;"/>
																	<span id="registrations_remove"  onclick="remove_tr(this);" class="from_text4-org_1">
																		&nbsp;Remove
																	</span>
																</td>
															</tr>
															<?php
														}?>
														<tr>
															<td align="right" class="from_text3">
															</td>
															<td>&nbsp;
																
															</td>
															<td colspan="2" valign="top">
																<input name="registrations_no[]" type="text" class="date" placeholder="Reg no " style="width:180px;" />
																<select name="registrations_council[]" class="from_list_menu3" style="width:180px;">
																	<option value="">
																		Council
																	</option>
																	<?php
																	foreach($council as $val)
																	{
																		?>
																		<option value="<?=$val['name']?>">
																			<?=$val['name']?>
																		</option>
																		<?php
																	} ?>
																</select>
																<select name="registrations_year[]" class="from_list_menu3" style="width:80px;">
																	<option value="">
																		year
																	</option>
																	<?php
																	foreach($to_year as $val)
																	{
																		?>
																		<option value="<?=$val?>">
																			<?=$val?>
																		</option>
																		<?php
																	} ?>
																</select>
																<span id="registrations_remove" style="display:none" onclick="remove_tr(this);" class="from_text4-org_1">
																	&nbsp;Remove
																</span>
																<span id="addmore_registrations_other">
																	&nbsp;<img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_registrations_more(this);" />&nbsp;&nbsp;<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_registrations_other(this);" />
																</span>
															</td>
														</tr>
														<?php
													}
													else
													{
														?>
														<tr>
															<td align="right" class="from_text3" id="label_registrations">
																Registrations
															</td>
															<td width="35">&nbsp;
																
															</td>
															<td width="450">&nbsp;
																
															</td>
														</tr>

														<tr>
															<td align="right" class="from_text3" id="label_registrations">&nbsp;
																
															</td>
															<td>&nbsp;
																
															</td>
															<td colspan="2" valign="top" >
																<input name="registrations_no[]" type="text" class="date" placeholder="Reg No"  style="width:180px;" />
																<select name="registrations_council[]" class="from_list_menu3" style="width:180px;">
																	<option value="">
																		Registration Council
																	</option>
																	<?php
																	foreach($council as $key=>$val)
																	{
																		?>
																		<option value="<?=$val['name']?>">
																			<?=$val['name']?>
																		</option>
																		<?php
																	} ?>
																</select>
																<select name="registrations_year[]" class="from_list_menu4" style="width:80px;">
																	<option value="">
																		Year
																	</option>
																	<?php
																	foreach($from_year as $val)
																	{
																		?>
																		<option value="<?=$val?>">
																			<?=$val?>
																		</option>
																		<?php
																	} ?>
																</select>
																<span id="addmore_registrations_other">
																	&nbsp;<img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_registrations_more(this);" />&nbsp;&nbsp;<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_registrations_other(this);" />
																</span>
															</td>
														</tr>
														<?php
													} ?>


													<tr>
														<td align="right">&nbsp;
															
														</td>
														<td>&nbsp;
															
														</td>
														<td>&nbsp;
															
														</td>
														<td>&nbsp;
															
														</td>
													</tr>
													<?php
													if(isset($doctor_detail['Qualifications']) && is_array($doctor_detail['Qualifications']) && sizeof($doctor_detail['Qualifications']) > 0)
													{
														?>
														<tr>
															<td align="right" class="from_text3" id="label_qualifications">
																Additional Qualifications
															</td>
															<td width="35">&nbsp;
																
															</td>
															<td width="450">&nbsp;
																
															</td>
														</tr>
														<?php
														foreach($doctor_detail['Qualifications'] as $key=>$val)
														{
															?>
															<tr>
																<td align="right" class="from_text3">&nbsp;
																	
																</td>
																<td width="35">&nbsp;
																	
																</td>
																<td width="450">
																	<input type="text" name="qualifications[]" class="from_list_menu" value="<?=$val['description1']?>" readonly="true"  />
																	<span class="from_text4-org_1" onclick="remove_tr(this);">
																		Remove
																	</span>
																</td>
															</tr>
															<?php
														}?>
														<tr>
															<td align="right" class="from_text3">&nbsp;
																
															</td>
															<td width="35">&nbsp;
																
															</td>
															<td width="450" >
																<input type="text" name="qualifications[]" class="from_list_menu" value="<?=$val['description1']?>" />
																<span id="qualifications_remove" style="display:none" onclick="remove_tr(this);" class="from_text4-org_1">
																	&nbsp;Remove
																</span>
															</td>
															<td width="450" valign="bottom" id="addmore_qualifications_other">
																<img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_qualifications_more(this);" />&nbsp;&nbsp;<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_qualifications_other(this,'qualifications');" />
															</td>
														</tr>
														<?php
													}
													else
													{
														?>
														<tr>
															<td align="right" class="from_text3" id="label_qualifications">
																Additional Qualifications
															</td>
															<td width="35">&nbsp;
																
															</td>
															<td width="450">&nbsp;
																
															</td>
														</tr>
														<tr>
															<td align="right" class="from_text3" id="label_qualifications">&nbsp;
																
															</td>
															<td width="35">&nbsp;
																
															</td>
															<td width="450">
																<input type="text" name="qualifications[]" class="from_list_menu" value=""/>
																<span id="qualifications_remove" style="display:none" onclick="remove_tr(this);" class="from_text4-org_1">
																	&nbsp;Remove
																</span>
															</td>
															<td width="450" valign="bottom" id="addmore_qualifications_other">
																<img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_qualifications_more(this);" />
																&nbsp;&nbsp;<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_qualifications_other(this);" />
															</td>
														</tr>
														<?php
													}?>




													<tr>
														<td align="right">&nbsp;
															
														</td>
														<td>&nbsp;
															
														</td>
														<td>&nbsp;
															
														</td>
														<td>&nbsp;
															
														</td>
													</tr>

													<?php
													if(isset($doctor_detail['PapersPublished']) && is_array($doctor_detail['PapersPublished']) && sizeof($doctor_detail['PapersPublished']) > 0)
													{
														?>
														<tr>
															<td align="right" valign="top" class="from_text3">
																Papers published
															</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
															<td>&nbsp;</td>
														</tr>
														<?php foreach($doctor_detail['PapersPublished'] as $key=>$val){?>
															<tr>
																<td align="right" valign="top" class="from_text3">&nbsp;</td>
																<td>&nbsp;</td>
																<td><textarea name="paperspublished[]" cols="45" rows="5" class="from_text_area" 
																readonly="readonly"><?=$val['description1']?></textarea>
																	<span id="paperspublished_remove" onclick="remove_tr(this);" class="from_text4-org_1">&nbsp;Remove</span>&nbsp;
																</td>
															</tr>
															<?php
														}?>
														<tr>
															<td align="right" valign="top" class="from_text3">&nbsp;</td>
															<td>&nbsp;</td>
															<td><textarea name="paperspublished[]" cols="45" rows="5" class="from_text_area"></textarea>
																<span id="paperspublished_remove" style="display:none" onclick="remove_tr(this);" class="from_text4-org_1">
																	&nbsp;Remove
																</span>&nbsp;
															</td>
															<td width="450" valign="bottom" id="addmore_paperspublished_other">
																<img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_paperspublished_more(this);" />&nbsp;&nbsp;<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_paperspublished_other(this);" />
															</td>
														</tr>
														<?php
													}
													else
													{
														?>
														<tr>
															<td align="right" valign="top" class="from_text3">
																Papers published
															</td>
															<td>&nbsp;
																
															</td>
															<td>&nbsp;
																
															</td>
															<td>&nbsp;
																
															</td>
														</tr>
														<tr>
															<td align="right" valign="top" class="from_text3">&nbsp;
																
															</td>
															<td>&nbsp;
																
															</td>
															<td>
																<textarea name="paperspublished[]" cols="45" rows="5" class="from_text_area"></textarea>
																<span id="paperspublished_remove" style="display:none" onclick="remove_tr(this);" class="from_text4-org_1">
																	&nbsp;Remove
																</span>
															</td>
															<td width="450" valign="bottom" id="addmore_paperspublished_other">
																<img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_paperspublished_more(this);" />&nbsp;&nbsp;<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_paperspublished_other(this);" />
															</td>
														</tr>
														<?php
													} ?>


													<tr>
														<td align="right">&nbsp;
															
														</td>
														<td>&nbsp;
															
														</td>
														<td>&nbsp;
															
														</td>
														<td>&nbsp;
															
														</td>
													</tr>
													<tr>
														<td align="right" valign="top" class="from_text3">
															Short Brief about Practice
														</td>
														<td>&nbsp;
															
														</td>
														<td>
															<textarea name="doctor_summary" cols="45" rows="5" class="from_text_area" ><?=$doctor_summary ?></textarea>
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
														<td>&nbsp;
															
														</td>
													</tr>
													<tr>
														<td colspan="4" height="53" align="right" bgcolor="#f5f5f5">
															<a href="#maine_from">
																<div style="padding-right:30px;float:right" class="continue_bnt" onclick="show_hide_steps('patient_review_table')">
																	Continue
																</div>
															</a>
															<a href="#maine_from">
																<div style="padding-right:30px;float:left" class="continue_bnt" onclick="show_hide_steps('professional_table')">
																	Previous
																</div>
															</a>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr id="patient_review_table" style="display:none">
											<td bgcolor="#FFFFFF">
												<table width="100%" border="0" cellspacing="0" cellpadding="0" >
													<tr>
														<td width="450">&nbsp;
															
														</td>
														<td width="450">&nbsp;
															
														</td>
														<td width="450">&nbsp;
															
														</td>
														<td width="450">&nbsp;
															
														</td>
													</tr>
													<tr>
														<td height="31" colspan="4" align="center" class="from_text4-red">
															<strong>
																We contact these patients and take their Review. The Reviews are posted in your Profile.<br />This helps enhance and strengthen your Profile.
															</strong>
														</td>
													</tr>
													<tr>
														<td colspan="4" align="center" class="from_textreview">
															For 20 Patient Reviews
														</td>
													</tr>
													<tr>
														<td colspan="4" align="center" class="from_text3">
															<table width="72%" border="0" cellspacing="0" cellpadding="0">
																<tr>
																	<td width="27">&nbsp;
																		
																	</td>
																	<td width="245">&nbsp;
																		
																	</td>
																	<td width="10">&nbsp;
																		
																	</td>
																	<td width="247">&nbsp;
																		
																	</td>
																	<td width="177">&nbsp;
																		
																	</td>
																</tr>
																<tr>
																	<td width="27">&nbsp;
																		
																	</td>
																	<td align="center">
																		<strong>
																			Patient Name
																		</strong>
																	</td>
																	<td>&nbsp;
																		
																	</td>
																	<td align="center">
																		<strong>
																			Mobile Number
																		</strong>
																	</td>
																	<td>&nbsp;
																		
																	</td>
																</tr>
																<?php
																if(isset($patient_numbers) && is_array($patient_numbers) && sizeof($patient_numbers) )
																{
																	foreach($patient_numbers as $key=>$val)
																	{
																		?>
																		<tr class="patient_row">
																			<td width="27" align="center">&nbsp;
																				
																			</td>
																			<td>
																				<input name="patient_name[]" value="<?=$val['patient_name']?>" type="text" class="from_text_filed_6" readonly="true" />
																			</td>
																			<td>&nbsp;
																				
																			</td>
																			<td>
																				<input name="patient_number[]" value="<?=$val['patient_number']?>" type="text" class="from_text_filed_6" readonly="true" />
																			</td>
																			<td valign="bottom">
																				<span  onclick="remove_tr(this);" class="from_text4-org_1" id="patient_numbers_remove">
																					&nbsp;Remove
																				</span>
																			</td>

																		</tr>
																		<?php
																	}?>
																	<tr class="patient_row">
																		<td width="27" align="center">&nbsp;
																			
																		</td>
																		<td>
																			<input name="patient_name[]" type="text" class="from_text_filed_6" />
																		</td>
																		<td>&nbsp;
																			
																		</td>
																		<td>
																			<input name="patient_number[]" type="text" class="from_text_filed_6" />
																		</td>
																		<td valign="bottom" class="from_text4-org_1">
																			<span  onclick="remove_tr(this);" class="from_text4-org_1" id="patient_numbers_remove" style="display:none">
																				&nbsp;Remove
																			</span>
																			<span id="addmore_patient_numbers">
																				<img onclick="patient_numbers_addmore(this);" src="<?=IMAGE_URL?>add.jpg" width="84" height="31" />
																			</span>
																		</td>
																	</tr>

																	<?php
																}
																else
																{
																	?>
																	<tr class="patient_row">
																		<td width="27" align="center">&nbsp;
																			
																		</td>
																		<td>
																			<input name="patient_name[]" type="text" class="from_text_filed_6" />
																		</td>
																		<td>&nbsp;
																			
																		</td>
																		<td>
																			<input name="patient_number[]" type="text" class="from_text_filed_6" />
																		</td>
																		<td valign="bottom" class="from_text4-org_1">
																			<span  onclick="remove_tr(this);" class="from_text4-org_1" id="patient_numbers_remove" style="display:none">
																				&nbsp;Remove
																			</span>
																			<span id="addmore_patient_numbers">
																				<img onclick="patient_numbers_addmore(this);" src="<?=IMAGE_URL?>add.jpg" width="84" height="31" />
																			</span>
																		</td>
																	</tr>
																	<?php
																}?>



																<tr>
																	<td align="center">&nbsp;
																		
																	</td>
																	<td>&nbsp;
																		
																	</td>
																	<td>&nbsp;
																		
																	</td>
																	<td>&nbsp;
																		
																	</td>
																	<td>&nbsp;
																		
																	</td>
																</tr>
																<tr>
																	<td colspan="5" align="center" class="from_text4">
																		<strong>
																			You can add this detail later by loging into your Profile on bookdrappointment.com&nbsp;&nbsp;
																		</strong>
																	</td>
																</tr>
																<tr>
																	<td align="center">&nbsp;
																		
																	</td>
																	<td>&nbsp;
																		
																	</td>
																	<td>&nbsp;
																		
																	</td>
																	<td>&nbsp;
																		
																	</td>
																	<td>&nbsp;
																		
																	</td>
																</tr>
																<tr>
																	<td align="left" colspan="5">
																	<p style="float:left;" class="from_textreview">Upload your clinic photographs by editing clinic &nbsp;</p>
																	<a style="float:left;text-decoration: none; color: rgb(255, 255, 255); background-color: rgb(255, 120, 62); padding: 10px; font-size: 16px;" 
																	href="/doctor/manageclinic">Click Here</a></td>
																</tr>
																<tr>
																	<td align="center">&nbsp;
																		
																	</td>
																	<td>&nbsp;
																		
																	</td>
																	<td>&nbsp;
																		
																	</td>
																	<td>&nbsp;
																		
																	</td>
																	<td>&nbsp;
																		
																	</td>
																</tr>
																<tr>
																	<td width="27" align="center">&nbsp;
																		
																	</td>
																	<td>&nbsp;
																		
																	</td>
																	<td>&nbsp;
																		
																	</td>
																	<td>&nbsp;
																		
																	</td>
																	<td>&nbsp;
																		
																	</td>
																</tr>

															</table>
														</td>
													</tr>
													<tr>
														<td colspan="5" height="53" align="right" bgcolor="#f5f5f5">
															<div style="padding-right:45px;float:right;cursor:pointer" class="continue_bnt" id="submit_form" 
															onclick="show_hide_steps('account_setup_table')">
																Submit
															</div>
															<a href="#maine_from">
																<div style="padding-right:30px;float:left" class="continue_bnt" onclick="show_hide_steps('accreditations_table')">
																	Previous
																</div>
															</a>
														</td>
													</tr>
												</table>
											</td>
										</tr>
										<tr id="account_setup_table" style="display:none">
											<td valign="top" bgcolor="#FFFFFF">
												<table width="100%" border="0" cellspacing="0" cellpadding="0" >
													<tr>
														<td>
															<table width="100%" border="0" cellspacing="0" cellpadding="0">
																<tr>
																	<?php if($current_packages[0]->package_id==20){
																		$package_class = "step_5";
																	}else if($current_packages[0]->package_id==30){
																		$package_class = "step_6";
																	}else{
																			$package_class = "step_5";
																	} ?>
																	<td align="center" class="<?=$package_class ?>">
																		<table width="100%" border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				<td height="430">&nbsp;
																					
																				</td>
																			</tr>
																			<tr>
																				<td>
																					<table width="55%" border="0" align="right" cellpadding="0" cellspacing="0">
																						<tr>
																							<td width="168">
																								<a href="<?=BASE_URL."profile/doctor/".$doctor_id?>">
																									<img src="<?=IMAGE_URL?>View Profile.jpg" width="168" height="56"  />
																								</a>
																							</td>
																							<td width="10">&nbsp;
																								
																							</td>
																							<td>
																								<img src="<?=IMAGE_URL?>edit_profile.jpg" width="168" height="56" onclick="show_hide_steps('professional_table')" />
																							</td>
																							<td>&nbsp;
																								
																							</td>
																						</tr>
																					</table>
																				</td>
																			</tr>
																			<tr>
																				<td>&nbsp;
																					
																				</td>
																			</tr>
																		</table>
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
											<td>&nbsp;
												
											</td>
										</tr>
									</table>
								</form>

							</td>
							<td width="53">&nbsp;
								
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		<table style="display:none">
			<tr id="service_more_tocopy" style="display:none">
				<td align="right" class="from_text3">&nbsp;
					
				</td>
				<td width="35">&nbsp;
					
				</td>
				<td width="450" >
					<select name="services[]" class="from_list_menu" >
						<option value="">
							Select Service
						</option>
						<?php
						foreach($services as $key=>$val)
						{
							?>
							<option value="<?=$val['name']?>">
								<?=$val['name']?>
							</option>
							<?php
						} ?>
					</select>
					<span id="sevices_remove" style="display:none" onclick="remove_tr(this);" class="from_text4-org_1">
						&nbsp;Remove
					</span>
				</td>
				<td width="450" valign="bottom" id="addmore_services_other">
					<img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_services_more(this);" />							                      &nbsp;&nbsp;
					<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_services_other(this,'services');" />
				</td>
			</tr>
			<tr id="specializations_more_tocopy" style="display:none">
				<td align="right" class="from_text3" id="label_specializations">&nbsp;
					
				</td>
				<td width="35">&nbsp;
					
				</td>
				<td width="450">
					<select name="specializations[]" class="from_list_menu">
						<option value="">
							Select Specializations
						</option>
						<?php
						foreach($specializations as $key=>$val)
						{
							?>
							<option value="<?=$val['name']?>">
								<?=$val['name']?>
							</option>
							<?php
						} ?>
					</select>
					<span id="specializations_remove" style="display:none" onclick="remove_tr(this);" class="from_text4-org_1">
						&nbsp;Remove
					</span>
				</td>
				<td width="450" valign="bottom" id="addmore_specializations_other">
					<img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_specializations_more(this);" />
					&nbsp;&nbsp;
					<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_specializations_other(this);" />
				</td>
			</tr>
			<tr id="education_more_tocopy" style="display:none">
				<td align="right" class="from_text3" id="label_education">
					Education
				</td>
				<td width="35">&nbsp;
					
				</td>
				<td colspan="2">

					<select name="education_qualification[]" class="from_list_menu3">
						<option value="">
							Degree
						</option>
						<?php
						foreach($qualification as $key=>$val)
						{
							?>
							<option value="<?=$val['name']?>">
								<?=$val['name']?>
							</option>
							<?php
						} ?>
					</select>
					&nbsp;
					<select name="education_college[]" class="from_list_menu3">
						<option value="">
							College Name
						</option>
						<?php
						foreach($college as $key=>$val)
						{
							?>
							<option value="<?=$val['name']?>">
								<?=$val['name']?>
							</option>
							<?php
						} ?>
					</select>&nbsp;
					<select name="education_from_year[]" class="from_list_menu3">
						<option value="">
							Year
						</option>
						<?php
						foreach($from_year as $val)
						{
							?>
							<option value="<?=$val?>">
								<?=$val?>
							</option>
							<?php
						} ?>
					</select>
					<span id="education_remove" onclick="remove_tr(this);" class="from_text4-org_1">
						&nbsp;Remove
					</span>&nbsp;
					<span id="addmore_education_other">
						<img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_education_more(this);" />
						<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_education_other(this);" />
					</span>
				</td>
			</tr>
			<tr id="experience_more_tocopy" style="display:none">
				<td align="right" class="from_text3" id="label_experience">&nbsp;
					
				</td>
				<td>&nbsp;
					
				</td>
				<td colspan="2" valign="top">
					<select name="experience_from_year[]" class="from_list_menu3" style="width:80px;">
						<option value="">
							Year
						</option>
						<?php
						foreach($from_year as $val)
						{
							?>
							<option value="<?=$val?>">
								<?=$val?>
							</option>
							<?php
						} ?>
					</select>
					<span class="from_text4">
						to
						<select name="experience_to_year[]" class="from_list_menu3" style="width:80px;">
							<option value="">
								Year
							</option>
							<?php
							foreach($to_year as $val)
							{
								?>
								<option value="<?=$val?>">
									<?=$val?>
								</option>
								<?php
							} ?>
						</select>
						<input name="experience_role[]" type="text" class="date" placeholder="Role"  style="width:180px;" />
						&nbsp;at
						<input name="experience_hospital[]" type="text" class="date" placeholder="Hospital / Clinic" />
						<select name="experience_city[]" class="from_list_menu5" style="width:80px;">
							<option value="">
								City
							</option>
							<?php
							foreach($city as $key=>$val)
							{
								?>
								<option value="<?=$val['name']?>">
									<?=$val['name']?>
								</option>
								<?php
							} ?>
						</select>
						<span id="experience_remove" style="display:none" onclick="remove_tr(this);" class="from_text4-org_1">
							&nbsp;Remove
						</span>
						&nbsp;
						<span id="addmore_experience_other">
							<img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_experience_more(this);" />
							<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_experience_other(this);" />
						</span>
					</span>
				</td>
			</tr>
			<tr id="awardsandrecognitions_more_tocopy" style="display:none">
				<td align="right" class="from_text3" id="label_awardsandrecognitions">
					Awards &amp; Recognitions
				</td>
				<td width="35">&nbsp;
					
				</td>
				<td colspan="2" style="padding:2px;">
					<input name="awardsandrecognitions_award[]" value="" type="text" class="from_text_filed" />
					&nbsp;
					<select name="awardsandrecognitions_from_year[]" class="from_list_menu3" style="width:80px;">
						<option value="">
							Year
						</option>
						<?php
						foreach($from_year as $val)
						{
							?>
							<option value="<?=$val?>">
								<?=$val?>
							</option>
							<?php
						} ?>
					</select>
					<span id="awardsandrecognitions_remove" style="display:none" onclick="remove_tr(this);" class="from_text4-org_1">
						&nbsp;Remove
					</span>
					&nbsp;
					<span id="addmore_awardsandrecognitions_other">
						<img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_awardsandrecognitions_more(this);" />
						<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_awardsandrecognitions_other(this);" />
					</span>
				</td>
			</tr>
			<tr id="membership_more_tocopy" style="display:none">
				<td align="right" class="from_text3" id="label_membership">&nbsp;
					
				</td>
				<td width="35">&nbsp;
					
				</td>
				<td width="450">
					<select name="membership[]" class="from_list_menu">
						<option value="">
							Select membership
						</option>
						<?php
						foreach($membership as $key=>$val)
						{
							?>
							<option value="<?=$val['name']?>">
								<?=$val['name']?>
							</option>
							<?php
						} ?>
					</select>
					<span id="membership_remove" style="display:none" onclick="remove_tr(this);" class="from_text4-org_1">
						&nbsp;Remove
					</span>
				</td>
				<td width="450" valign="bottom" id="addmore_membership_other">
					<img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_membership_more(this);" />
					&nbsp;&nbsp;
					<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_membership_other(this);" />
				</td>
			</tr>
			<tr id="registrations_more_tocopy" style="display:none">
				<td align="right" class="from_text3" id="label_registrations">&nbsp;
					
				</td>
				<td>&nbsp;
					
				</td>
				<td colspan="2" valign="top" >
					<input name="registrations_no[]" type="text" class="date" placeholder="Reg No" style="width:180px;" />
					<select name="registrations_council[]" class="from_list_menu3" style="width:180px;">
						<option value="">
							Registration Council
						</option>
						<?php
						foreach($council as $key=>$val)
						{
							?>
							<option value="<?=$val['name']?>">
								<?=$val['name']?>
							</option>
							<?php
						} ?>
					</select>
					<select name="registrations_year[]" class="from_list_menu4" style="width:80px;">
						<option value="">
							Year
						</option>
						<?php
						foreach($from_year as $val)
						{
							?>
							<option value="<?=$val?>">
								<?=$val?>
							</option>
							<?php
						} ?>
					</select>
					<span id="registrations_remove" style="display:none" onclick="remove_tr(this);" class="from_text4-org_1">
						&nbsp;Remove
					</span>
					<span id="addmore_registrations_other">
						&nbsp;<img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_registrations_more(this);" />&nbsp;&nbsp;<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_registrations_other(this);" />
					</span>
				</td>
			</tr>
			<tr id="qualifications_more_tocopy" style="display:none">
				<td align="right" class="from_text3">&nbsp;
					
				</td>
				<td width="35">&nbsp;
					
				</td>
				<td width="450" >
					<input type="text" name="qualifications[]" class="from_list_menu" value=""/>
					<span id="qualifications_remove" style="display:none" onclick="remove_tr(this);" class="from_text4-org_1">
						&nbsp;Remove
					</span>
				</td>
				<td width="450" valign="bottom" id="addmore_qualifications_other">
					<img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_qualifications_more(this);" />							                      &nbsp;&nbsp;
					<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_qualifications_other(this,'qualifications');" />
				</td>
			</tr>
			<tr id="paperspublished_more_tocopy" style="display:none">
				<td align="right" valign="top" class="from_text3">&nbsp;
					
				</td>
				<td>&nbsp;
					
				</td>
				<td>
					<textarea name="paperspublished[]" cols="45" rows="5" class="from_text_area"></textarea>
					<span id="paperspublished_remove" style="display:none" onclick="remove_tr(this);" class="from_text4-org_1">
						&nbsp;Remove
					</span>&nbsp;&nbsp;
				</td>
				<td width="450" valign="bottom" id="addmore_paperspublished_other">
					<img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_paperspublished_more(this);" />&nbsp;&nbsp;<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_paperspublished_other(this);" />
				</td>
			</tr>
			<tr id="patient_numbers_more_tocopy" class="patient_row" style="display:none">
				<td width="27" align="center">&nbsp;
					
				</td>
				<td>
					<input name="patient_name[]" type="text" class="from_text_filed_6" />
				</td>
				<td>&nbsp;
					
				</td>
				<td>
					<input name="patient_number[]" type="text" class="from_text_filed_6" />
				</td>
				<td valign="bottom" class="from_text4-org_1">
					<span  onclick="remove_tr(this);" class="from_text4-org_1" id="patient_numbers_remove" style="display:none">
						&nbsp;Remove
					</span>
					<span id="addmore_patient_numbers">
						<img onclick="patient_numbers_addmore(this);" src="<?=IMAGE_URL?>add.jpg" width="84" height="31" />
					</span>
				</td>
			</tr>
		</table>
		<script type="text/javascript">
			$(function(){
				$("#overlay").fadeOut('slow');
			})
		</script>
	</body>
</html>
