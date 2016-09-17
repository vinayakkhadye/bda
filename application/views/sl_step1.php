<script type="text/javascript">
	function remove_tr(obj)
	{
		if(confirm("Are you sure you want to delete"))
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
		$(newTR).find("#sevices_remove").hide();
		$(curTR).find("#sevices_remove").show();
		newTR.insertAfter(curTR);
	}
	function add_speciality_other(obj)
	{
		var curTR = $(obj).closest('tr');
		curTR.find("#addmore_speciality_other").hide();
		$(curTR).find("#sevices_remove").show();
		var str = '';
		str += '<tr>';
		str += '<td align="right" class="from_text3">&nbsp;</td>';
		str += '<td width="35">&nbsp;</td>';
		str += '<td width="450" style="padding-top: 10px;"><input type="text" name="speciality_other[]" class="from_list_menu" some>&nbsp;<span id="sevices_remove" style="display:none" class="from_text4-org_1" onclick="remove_tr(this);">Remove</span></td>';
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
		$(newTR).find("#sevices_remove").hide();
		$(curTR).find("#sevices_remove").show();
		newTR.insertAfter(curTR);
	}
	function add_degree_other(obj)
	{
		var curTR = $(obj).closest('tr');
		curTR.find("#addmore_degree_other").hide();
		$(curTR).find("#sevices_remove").show();
		var str = '';
		str += '<tr>';
		str += '<td align="right" class="from_text3">&nbsp;</td>';
		str += '<td width="35">&nbsp;</td>';
		str += '<td width="450" style="padding-top: 10px;"><input type="text" name="degree_other[]" class="from_list_menu" some>&nbsp;<span id="sevices_remove" style="display:none" class="from_text4-org_1" onclick="remove_tr(this);">Remove</span></td>';
		str += '<td width="450" valign="bottom" id="addmore_degree_other"><img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_degree_more(this);" />&nbsp;&nbsp;<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_degree_other(this);" /></td>';
		str += '</tr>';
		$(str).insertAfter(curTR);
	}
	
	
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
							url: '/doctor/send_verification_sms',
							type: "POST",
							data:
							{
								'mob'	:	mob
							},
							success : function(resp)
							{
//								alert(resp);
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
							url: '/doctor/check_verification_code',
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
<form id="sl_step1" class="sl_step1" method="POST" enctype="multipart/form-data" action="" style="display: none;">
	<table width="100%" border="0" cellspacing="0" cellpadding="0" id="sl_step1">
		<tr>
			<td height="23">&nbsp;
				
			</td>
		</tr>
		<tr>
			<td valign="top">
				<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
					<?php if(isset($current_packages)): ?>
					<tr style="color: white; border-radius: 3px; height: 36px; word-spacing: 5px; font-size: 15px; font-weight: bold; background-color: rgb(232, 76, 61); border: 2px solid rgb(0, 0, 0);">
						<td style="text-align: right;">Current Packages:</td>
						<td>&nbsp;</td>
						<td colspan="2">
							<?php foreach($current_packages as $row): 
//							if($row->package_id == '40')
							echo $row->name.' valid from '.date('d-m-Y', strtotime($row->start_date)).' till '.date('d-m-Y', strtotime($row->end_date)).''.'<br>';
							endforeach; ?>
						</td>
					</tr>
					<?php endif; ?>
					<tr>
						<td width="198">&nbsp;
							
						</td>
						<td width="36">&nbsp;
							
						</td>
						<td width="367">&nbsp;
							
						</td>
						<td rowspan="8" align="center" id="profileimgbox">
							<?php
							if(!empty($userdetails->image))
							{
								echo "<img src='/".$userdetails->image."' width=\"126\" height=\"152\" />";
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
							<a href="javascript:void(0);" id="select_file_btn">
								<img src="<?php echo IMAGE_URL; ?>select_file.png" />
							</a>
							<input type="hidden" name="profile_pic_base64" id="profile_pic_base64" value="" />
							<input type="hidden" name="profile_pic_base64_name" id="profile_pic_base64_name" value="" />

							<input type="hidden" name="sl_step1" id="sl_step1" value="sl_step1" />

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
							<a href="javascript:void(0);" id="mobeditbtn">
								Edit
							</a>
							&nbsp;
							<a href="javascript:void(0);" id="verifiedbtn" style="display: none;">
								<img src="<?php echo IMAGE_URL; ?>Verified.jpg" width="" height="" />
							</a>
							<span id="mob_span_tag">
							</span>
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
							<p class="error_text" id="verify_code_span">
							</p>
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

								<input type="radio" name="gender" id="radio11" value="m" <?php
								if(@strtolower(@$userdetails->gender) == 'm') echo "checked='checked'"; ?> />
								<span class="from_text4">
									Male
								</span><br />
								<input type="radio" name="gender" id="radio12" value="f" <?php
								if(@strtolower(@$userdetails->gender) == 'f') echo "checked='checked'"; ?> />
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
						<td align="right" class="from_text3" id="label_speciality" style="position: relative;">
							<div style="position: absolute; top: 31px; left: 112px;">Speciality 
							<span style="color: #ff0000; position: absolute; top:-4px;">*</span></div>
							<span class="from_text4-org_1">
							</span>
						</td>
						<td width="35">&nbsp;
							
						</td>
						<td width="450">&nbsp;
							
						</td>
					</tr>
					
					<?php 
					@$specialities = explode(',', $doctor_data->speciality);
					foreach(@$specialities as $row2){
					?>
					<tr>
						<td align="right" class="from_text3" id="label_speciality">&nbsp;
							
						</td>
						<td width="35">&nbsp;
							
						</td>
						<td width="450" style="padding-top: 10px;" id="sevices_copy">
							<select name="speciality[]" class="from_list_menu">
								<option value="">
									Select your Speciality
								</option>
								<?php foreach($speciality as $row):?>
									<option value="<?php echo $row->id; ?>" <?php
 if(@$row2 == $row->id) echo "selected='selected'"; ?> ><?php echo ucwords($row->name); ?></option>
								<?php endforeach; ?>
							</select>
							<span id="sevices_remove" style="display:none" onclick="remove_tr(this);" class="from_text4-org_1">
								&nbsp;Remove
							</span>
						</td>
						<td width="450" valign="bottom" id="addmore_speciality_other">
							<img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_speciality_more(this);" />
							&nbsp;&nbsp;
							<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_speciality_other(this);" />
						</td>
					</tr>
					<?php }; ?>
					
					
					<?php 
					@$specialities_other = explode(',', $doctor_data->other_speciality);
					if(sizeof(@$specialities_other) > 0){
					foreach(@$specialities_other as $row4){
					?>
					<tr>
						<td align="right" class="from_text3">&nbsp;</td>
						<td width="35">&nbsp;</td>
						<td width="450" style="padding-top: 10px;">
							<input type="text" value="<?php echo $row4; ?>" class="from_list_menu" name="speciality_other[]">&nbsp;
							<span onclick="remove_tr(this);" class="from_text4-org_1" style="" id="sevices_remove">Remove</span>
						</td>
						
						<td width="450" valign="bottom" id="addmore_speciality_other" style="display: none;">
							<img width="85" height="31" onclick="add_speciality_more(this);" src="http://revamp.bookdrappointment.com/static/images/addmore.jpg">&nbsp;&nbsp;
							<img width="85" height="31" onclick="add_speciality_other(this);" src="http://revamp.bookdrappointment.com/static/images/addother.jpg">
						</td>
					</tr>
					<?php }}; ?>
					
					
					<tr>
						<td align="right">&nbsp;
							
						</td>
						<td>&nbsp;
							
						</td>
						<td class="error_message" >
							<?php echo form_error('speciality', '<p class="error_text">', '</p>'); ?>
						</td>
					</tr>
					<tr>
						<td align="right" class="from_text3" id="label_degree" style="position: relative;">
							<div style="position: absolute; top: 31px; left: 124px;">Degree 
							<span style="color: #ff0000; position: absolute; top:-4px;">*</span></div>
							<span class="from_text4-org_1">
							</span>
						</td>
						<td width="35">&nbsp;
							
						</td>
						<td width="450">&nbsp;
							
						</td>
					</tr>
					
					<?php 
					@$degree1 = explode(',', $doctor_data->qualification);
					foreach(@$degree1 as $row3){
					?>
					<tr>
						<td align="right" class="from_text3" id="label_degree">&nbsp;
							
						</td>
						<td width="35">&nbsp;
							
						</td>
						<td width="450" style="padding-top: 10px;" id="sevices_copy">
							<select name="degree[]" class="from_list_menu">
								<option value="">
									Select your Degree
								</option>
								<?php foreach($degree as $row):?>
									<option value="<?php echo $row->id; ?>" <?php
 if(@$row3 == $row->id) echo "selected='selected'"; ?>><?php echo $row->name; ?></option>
								<?php endforeach; ?>
							</select>
							<span id="sevices_remove" style="display:none" onclick="remove_tr(this);" class="from_text4-org_1">
								&nbsp;Remove
							</span>
						</td>
						<td width="450" valign="bottom" id="addmore_degree_other">
							<img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_degree_more(this);" />
							&nbsp;&nbsp;
							<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_degree_other(this);" />
						</td>
					</tr>
					<?php }; ?>
					
					
					
					<?php 
					@$qualification_other = explode(',', $doctor_data->other_qualification);
					if(sizeof($qualification_other) > 1){
					foreach(@$qualification_other as $row5){
					?>
					<tr>
						<td align="right" class="from_text3">&nbsp;</td>
						<td width="35">&nbsp;</td>
						<td width="450" style="padding-top: 10px;">
							<input type="text" value="<?php echo $row5; ?>" class="from_list_menu" name="degree_other[]">&nbsp;
							<span onclick="remove_tr(this);" class="from_text4-org_1" style="" id="sevices_remove">Remove</span>
						</td>
						<td width="450" valign="bottom" id="addmore_degree_other" style="display: none;">
							<img width="85" height="31" onclick="add_degree_more(this);" src="http://revamp.bookdrappointment.com/static/images/addmore.jpg">&nbsp;&nbsp;
							<img width="85" height="31" onclick="add_degree_other(this);" src="http://revamp.bookdrappointment.com/static/images/addother.jpg">
						</td>
					</tr>
					<?php }}; ?>
					
					
					
					<tr>
						<td align="right">&nbsp;
							
						</td>
						<td>&nbsp;
							
						</td>
						<td class="error_gender" >
							<?php echo form_error('degree', '<p class="error_text">', '</p>'); ?>
						</td>
					</tr>

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


					<tr>
						<td align="right" class="from_text3">
							Years of Experience
						</td>
						<td>&nbsp;
							
						</td>
						<td>
							<input name="yoe" type="text" class="date" maxlength="2" value="<?php echo @$doctor_data->yoe; ?>" />
						</td>
						<td>&nbsp;
							
						</td>
					</tr>
					<tr>
						<td align="right" class="from_text3">&nbsp;
							
						</td>
						<td>&nbsp;
							
						</td>
						<td>
							<?php echo form_error('yoe', '<p class="error_text">', '</p>'); ?>
						</td>
					</tr>
					
					
					<tr>
						<td align="right" class="from_text3">
							Registration No
						</td>
						<td>&nbsp;
							
						</td>
						<td>
							<input name="regno" type="text" class="date"  value="<?php echo @$doctor_data->reg_no; ?>"  placeholder="Eg.45356"/>
						</td>
						<td>&nbsp;
							
						</td>
					</tr>
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
					<tr>
						<td align="right" class="from_text3">
							State Medical Council
						</td>
						<td>&nbsp;
							
						</td>
						<td>
							<select name="council" id="council" class="from_list_menu">
								<option value="">
									Select your council
								</option>
								<?php
								foreach($council as $row): ?>
								<option value="<?php echo $row->id; ?>" <?php
 if(@$doctor_data->council_id == $row->id) echo "selected='selected'"; ?>>
									<?php echo $row->name; ?>
								</option>
								<?php endforeach; ?>
							</select>
						</td>
						<td>&nbsp;
							
						</td>
					</tr>
					<?php if(isset($sor_eligibility)): ?>
					<tr>
						<td>&nbsp;</td>
						<td>&nbsp;</td>
						<td style="height: 75px;">
							<a href="/doctor/onlinereputation" style="text-decoration: none; color: rgb(255, 255, 255); background-color: rgb(255, 120, 62); padding: 10px; font-size: 16px;">View Additional Details</a>
						</td>
						<td>&nbsp;</td>
					</tr>
					<?php endif; ?>


				</table>
			</td>
		</tr>
		<tr>
			<td>&nbsp;
				
			</td>
		</tr>
		<tr>
			<td height="53" align="right" bgcolor="#f5f5f5">
				<table width="200" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="62" height="40">&nbsp;
							
						</td>
						<td width="118" class="continue_bnt" style="cursor: pointer;" onclick="javascript:document.getElementById('sl_step1').submit();">
							<?php if(@$clinic_present) echo 'Save'; else echo 'Continue'; ?>
						</td>
						<td width="20">&nbsp;
							
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</form>




<tr id="degree_more_tocopy" style="display:none">
	<td align="right" class="from_text3">&nbsp;
		
	</td>
	<td width="35">&nbsp;
		
	</td>
	<td width="450" style="padding-top: 10px;" >
		<select name="degree[]" class="from_list_menu" >
			<option value="">
				Select your Degree
			</option>
			<?php foreach($degree as $row):?>
				<option value="<?php echo $row->id; ?>"><?php echo ucwords($row->name); ?></option>
			<?php endforeach; ?>
		</select>
		<span id="sevices_remove" style="display:none" onclick="remove_tr(this);" class="from_text4-org_1">
			&nbsp;Remove
		</span>
	</td>
	<td width="450" valign="bottom" id="addmore_degree_other">
		<img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_degree_more(this);" />							                      &nbsp;&nbsp;
		<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_degree_other(this,'degree');" />
	</td>
</tr>






<tr id="speciality_more_tocopy" style="display:none">
	<td align="right" class="from_text3">&nbsp;
		
	</td>
	<td width="35">&nbsp;
		
	</td>
	<td width="450" style="padding-top: 10px;" >
		<select name="speciality[]" class="from_list_menu" >
			<option value="">
				Select your Speciality
			</option>
			<?php foreach($speciality as $row):?>
				<option value="<?php echo $row->id; ?>"><?php echo ucwords($row->name); ?></option>
			<?php endforeach; ?>
		</select>
		<span id="sevices_remove" style="display:none" onclick="remove_tr(this);" class="from_text4-org_1">
			&nbsp;Remove
		</span>
	</td>
	<td width="450" valign="bottom" id="addmore_speciality_other">
		<img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="add_speciality_more(this);" />							                      &nbsp;&nbsp;
		<img src="<?=IMAGE_URL?>addother.jpg" width="85" height="31" onclick="add_speciality_other(this,'speciality');" />
	</td>
</tr>





<div class="modalbpopup" style="display: none;">
	<div class="container">
		<div class="imageBox">
			<div class="thumbBox">
			</div>
			<div class="spinner" style="display: none">
				Loading...
			</div>
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


<script type="text/javascript">
	$(window).load(function()
		{
			var options =
			{
				thumbBox: '.thumbBox',
				spinner: '.spinner',
				imgSrc: 'avatar.png'
			}
			var cropper;
			$('#file').on('change', function()
				{
					var reader = new FileReader();
					reader.onload = function(e)
					{
						options.imgSrc = e.target.result;
						cropper = $('.imageBox').cropbox(options);
					}
					reader.readAsDataURL(this.files[0]);
					this.files = [];
				})
			$('#btnCrop').on('click', function()
				{
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
			$('#btnZoomIn').on('click', function()
				{
					cropper.zoomIn();
				})
			$('#btnZoomOut').on('click', function()
				{
					cropper.zoomOut();
				})
		});
</script>