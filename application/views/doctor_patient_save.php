<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Book Dr Appointment</title>
	<link id="bs-css" href="<?php echo CSS_URL; ?>login/jquery-ui-new.css" rel="stylesheet">
	<link href="<?php echo CSS_URL; ?>login/maine.css" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>login/style.css" />
	<link type="text/css" rel="stylesheet" href="<?php echo CSS_URL; ?>login/bootstrap.min.css"/>
	<style type="text/css">
	.PB10 {padding-bottom:20px;}
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
	.continue_bnt{cursor:pointer}
	</style>
	<script src="<?php echo JS_URL; ?>login/jquery.min.js"></script>
	<script src="<?php echo JS_URL; ?>login/jquery-ui-new.js"></script>
	<script src="<?php echo JS_URL; ?>login/jquery-cropimg-plugin.js"></script>
	<script src="<?php echo JS_URL; ?>jquery.bpopup.min.js"></script>
	<script type="text/javascript">
	function calculatebmi_old()
	{
		var height_feet = $("#height_feet").val();
		var height_inches =  parseInt($("#height_inches").val());
		var weight =  parseInt($("#weight").val());
		var feet = parseFloat(height_feet+"."+height_inches);
		var meter = (feet/3.28).toFixed(2);
		var bmi = (weight / (meter * meter)).toFixed(2);
		$("#bmi_value").val(bmi);
	}
	function calculatebmi()
	{
		var height_feet = parseInt($("#height_feet").val());
		var height_inches =  parseInt($("#height_inches").val());
		var weight =  parseInt($("#weight").val());
		if(height_feet && weight ){
			if(isNaN(height_inches)){
				height_inches = 0;
			}
			var total_inches = (height_feet*12)+height_inches;
			
			var meter = (total_inches/39.370);
			var bmi = (weight / (meter * meter)).toFixed(2);
			$("#bmi_value").val(bmi);
		}
	}

	function hide_steps()
	{
	$("#general_info_table").hide();
	$("#family_history_table").hide();
	$("#past_disease_table").hide();
	$(".general_info_step").attr("id","circle2");
	$(".famili_history_step").attr("id","circle2");
	$(".past_disease_step").attr("id","circle2");
	}
	function remove_tr(obj,type,id)
	{
		if(confirm("Are you sure you want to permenantly delete this entry"))
		{
			if(type && id){
				if(!isNaN(id)){
					var form_data = {"type":type,"id":id};
					$.ajax({
						type: 'POST',
						url: "<?=BASE_URL?>doctor/patient_delete_bytype",
						data: form_data,
						success: function(data)
						{
							console.log($( obj ).closest( "tr" ).remove());
						},
						error:function(data)
						{
							console.log("oops");
						}
					});
				}
			}else{
				$( obj ).closest( "tr" ).remove()
			}
		}
	}
	
function show_hide_steps(str)
{
if(str == "general_info_table")
{
	hide_steps();
	$("#general_info_table").show();
	$("#meterperct").css("width","33%");
	$(".general_info_step").attr("id","circle1");
}else if(str == "family_history_table")
{
	hide_steps();
	$("#family_history_table").show();
	$("#meterperct").css("width","66%");
	$(".general_info_step").attr("id","circle1");
	$(".famili_history_step").attr("id","circle1");
}else if(str == "past_disease_table")
{
	hide_steps();
	$("#past_disease_table").show();
	$("#meterperct").css("width","100%");
	$(".general_info_step").attr("id","circle1");
	$(".famili_history_step").attr("id","circle1");
	$(".famili_history_step").attr("id","circle1");
}else if(str == "save_details"){
	$(".save_details").html("processing");
	var form_data =  $("#patient_save").serialize();
	//console.log(form_data);
	$.ajax(
		{
			type: 'POST',
			url: "/doctor/patient_save/",
			data: form_data,
			success: function(data)
			{
				window.location.href= "<?=BASE_URL?>doctor/patient_manage";
				$(".save_details").html("submit");
			},
			error:function(data)
			{
				$(".save_details").html("submit");
			}
		});


}

}
	function family_history_more(obj)
	{
	var curTR = $(obj).closest('tr');
	newTR = $("#family_history_tocopy").clone();
	newTR.insertAfter(curTR);
	newTR.show();
	newTR.attr("id","family_details");
 	var mem1 = newTR.find("#family_member_name_copy1");	
	var mem2 = newTR.find("#family_member_name_copy2");	
	var mem3 = newTR.find("#family_member_name_copy3");	
	var mem4 = newTR.find("#family_summary_copy1");	
	var mem5 = newTR.find("#family_disease_copy1");	


	
	mem1.attr("name","family_member_name["+(parseInt(mem1.attr("dataid"))+1)+"][0]");
	
	$("#family_history_tocopy").find("#family_member_name_copy1").attr("dataid",parseInt(mem1.attr("dataid"))+1);

	mem2.attr("name","family_member_name["+(parseInt(mem2.attr("dataid"))+1)+"][1]");
	$("#family_history_tocopy").find("#family_member_name_copy2").attr("dataid",parseInt(mem2.attr("dataid"))+1);

	mem3.attr("name","family_member_name["+(parseInt(mem3.attr("dataid"))+1)+"][2]");
	$("#family_history_tocopy").find("#family_member_name_copy3").attr("dataid",parseInt(mem3.attr("dataid"))+1);

		mem4.attr("name","family_summary["+(parseInt(mem4.attr("dataid"))+1)+"]");
	$("#family_history_tocopy").find("#family_summary_copy1").attr("dataid",parseInt(mem4.attr("dataid"))+1);

	mem5.attr("name","family_disease["+(parseInt(mem4.attr("dataid"))+1)+"]");
	$("#family_history_tocopy").find("#family_disease_copy1").attr("dataid",parseInt(mem5.attr("dataid"))+1);

	
	$(obj).hide();
	$(curTR).children().find('#family_details_remove').show();
	}
	function past_disease_more1(obj)
	{
		var curTR = $(obj).closest('tr');
		newTR = $("#past_disease_tocopy").clone();
		console.log(newTR);
		//sepTR = $("#separator").clone();
		newTR.insertAfter(curTR);
		//sepTR.insertAfter(curTR);
		//sepTR.show();
		newTR.show();
		newTR.attr("id","past_disease");

		var mem1 = newTR.find("#disease_name_copy");	
		var mem2 = newTR.find("#disease_from_month_copy");	
		var mem3 = newTR.find("#disease_from_year_copy");	
		var mem4 = newTR.find("#disease_duration_copy");	
		var mem5 = newTR.find("#disease_details_copy");	

		mem1.attr("name","disease_name["+(parseInt(mem1.attr("dataid"))+1)+"]");
		$("#past_disease_tocopy").find("#disease_name_copy").attr("dataid",parseInt(mem1.attr("dataid"))+1);
		
		mem2.attr("name","disease_from_month["+(parseInt(mem2.attr("dataid"))+1)+"]");
		$("#past_disease_tocopy").find("#disease_from_month_copy").attr("dataid",parseInt(mem2.attr("dataid"))+1);

		mem3.attr("name","disease_from_year["+(parseInt(mem3.attr("dataid"))+1)+"]");
		$("#past_disease_tocopy").find("#disease_from_year_copy").attr("dataid",parseInt(mem3.attr("dataid"))+1);

		mem4.attr("name","disease_duration["+(parseInt(mem4.attr("dataid"))+1)+"]");
		$("#past_disease_tocopy").find("#disease_duration_copy").attr("dataid",parseInt(mem4.attr("dataid"))+1);

		mem5.attr("name","disease_details["+(parseInt(mem5.attr("dataid"))+1)+"]");
		$("#past_disease_tocopy").find("#disease_details_copy").attr("dataid",parseInt(mem5.attr("dataid"))+1);
		
		$(obj).hide();
		$(curTR).children().find('#past_disease_remove').show();
	}
	function past_surgery_more1(obj)
	{
		var curTR = $(obj).closest('tr');
		newTR = $("#past_surgery_tocopy").clone();

		var mem1 = newTR.find("#surgery_name_copy");	
		var mem2 = newTR.find("#surgery_reason_copy");	
		var mem3 = newTR.find("#surgery_date_copy");
		
		mem3.datepicker(
		{
			dateFormat: "dd-mm-yy",
			defaultDate: "-25y",
			changeMonth: true,
			changeYear: true,
			yearRange: "1900:2014"
		});

		//sepTR = $("#separator").clone();
		newTR.insertAfter(curTR);
		//sepTR.insertAfter(curTR);
		//sepTR.show();
		newTR.show();
		newTR.attr("id","past_surgery_more");

		
		mem1.attr("name","surgery_name["+(parseInt(mem1.attr("dataid"))+1)+"]");
		$("#past_surgery_tocopy").find("#surgery_name_copy").attr("dataid",parseInt(mem1.attr("dataid"))+1);
		
		mem2.attr("name","surgery_reason["+(parseInt(mem2.attr("dataid"))+1)+"]");
		$("#past_surgery_tocopy").find("#surgery_reason_copy").attr("dataid",parseInt(mem2.attr("dataid"))+1);

		mem3.attr("name","surgery_date["+(parseInt(mem3.attr("dataid"))+1)+"]");
		$("#past_surgery_tocopy").find("#surgery_date_copy").attr("dataid",parseInt(mem3.attr("dataid"))+1);
			
		
		$(obj).hide();
		$(curTR).children().find('#past_surgery_remove').show();
		
	}
	function ongoing_medications_more(obj)
	{
		var curTR = $(obj).closest('tr');
		newTR = $("#ongoing_medications_tocopy").clone();
		console.log(newTR);
		//sepTR = $("#separator").clone();
		newTR.insertAfter(curTR);
		//sepTR.insertAfter(curTR);
		//sepTR.show();
		newTR.show();
		newTR.attr("id","ongoing_medications_more");
		
		var mem1 = newTR.find("#ongoing_medications_copy");	
		mem1.attr("name","ongoing_medications["+(parseInt(mem1.attr("dataid"))+1)+"]");
		$("#ongoing_medications_tocopy").find("#ongoing_medications_copy").attr("dataid",parseInt(mem1.attr("dataid"))+1);
		
		$(obj).hide();
		$(curTR).children().find('#ongoing_medications_remove').show();
	}
	function allergic_more(obj)
	{
		var curTR = $(obj).closest('tr');
		newTR = $("#allergic_tocopy").clone();
		console.log(newTR);
		//sepTR = $("#separator").clone();
		newTR.insertAfter(curTR);
		newTR.show();
		newTR.attr("id","allergic_more");
		var mem1 = newTR.find("#allergy_list_copy");	
		mem1.attr("name","allergic_list["+(parseInt(mem1.attr("dataid"))+1)+"]");
		$("#allergy_tocopy").find("#allergy_list_copy").attr("dataid",parseInt(mem1.attr("dataid"))+1);

		var mem2 = newTR.find("#allergic_copy");	
		mem2.attr("name","allergic["+(parseInt(mem2.attr("dataid"))+1)+"]");
		$("#allergy_tocopy").find("#allergic_copy").attr("dataid",parseInt(mem2.attr("dataid"))+1);

		$(obj).hide();
		$(curTR).children().find('#allergic_remove').show();
	}
	
	
	
	$(document).ready(function(){
	$("#select_file_btn").click(function(){
	$(".modalbpopup").bPopup({
	positionStyle: 'fixed',
	closeClass: 'modalclose'
	});
	$("#file").trigger('click');
	});
	
	<?php if(@$city){ ?>
	var city = $("#city").val();
	//$("#other_locality_btn").show();
	//$("#locality").show();
	//$("#locality").attr('disabled', false);
	//$("#other_locality").hide();
	//$("#other_locality").attr('disabled', true);
	//alert(state);
	
	$.ajax(
		{
			url: '/location/locality',
			type: "POST",
			data:
			{
				'city_id'	:	city
			},
			success : function(resp)
			{
				$("#locality").html(resp);
				$('[name=locality] option').filter(function()
					{
						var a = "<?php echo @$locality; ?>";
						return ($(this).val() == a);
					}).prop('selected', true);
			}
		});
	<?php } ?>
	$("#city").on('change', function()
	{
		var city = $("#city").val();
		$("#other_locality_btn").show();
		$("#locality").show();
		$("#locality").attr('disabled', false);
		$("#other_locality").hide();
		$("#other_locality").attr('disabled', true);
		$(".select-frm-list-btn").css('display', 'none');
		
		$("#googleaddress").val($("#city option:selected").text().trim()+', India');
		$(".btngoogle").trigger('click');
		
		//alert(state);
		$.ajax(
			{
				url: '/location/locality',
				type: "POST",
				data:
				{
					'city_id'	:	city
				},
				success : function(resp)
				{
					$("#locality").html(resp);
				}
			});
	});			
	$("#other_locality_btn").click(function()
	{
		$("#other_locality_btn").hide();
		$("#locality").hide();
		$("#locality").attr('disabled', true);
		$("#other_locality").show();
		$("#other_locality").attr('disabled', false);
		$(".select-frm-list-btn").css('display', 'inline');
	});
	
	$(".select-frm-list-btn").click(function()
	{
		$("#other_locality_btn").show();
		$("#locality").show();
		$("#locality").attr('disabled', false);
		$("#other_locality").hide();
		$("#other_locality").attr('disabled', true);
		$(".select-frm-list-btn").css('display', 'none');
	});			
	});
	
	
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
							Dashboard
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
			<td width="53" valign="top">&nbsp;</td>
			<td align="center" valign="top">
				<form name="patient_save" id="patient_save" method="post">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr><td height="50">&nbsp;</td></tr>
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
														Step 1 of 3
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
														<div class="general_info_step" id="circle1">
															1
														</div>
													</td>
													<td class="from_tetel_text">
														General Information
													</td>
													<td width="47">
														<div class="famili_history_step" id="circle2">
															2
														</div>
													</td>
													<td>
														<span class="from_tetel_text">
															Family & Self History
														</span>
													</td>
													<td width="47">
														<div class="past_disease_step" id="circle2">
															3
														</div>
													</td>
													<td>
														<span class="from_tetel_text">
															Past Disease & Surgeries
														</span>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td bgcolor="#F6F6F6">
											<div class="meter">
												<span style="width:33%" id="meterperct">
												</span>
											</div>
										</td>
									</tr>
									<tr id="general_info_table" >
										<td bgcolor="">
											<table width="100%" border="0" cellspacing="0" cellpadding="0" >
												<tr>
												  <td width="192">&nbsp;</td>
												  <td width="35">&nbsp;</td>
												  <td width="450">&nbsp;</td>
												  <td width="126" rowspan="6" id="profileimgbox">
													<?php
													$user_image = @$patientdetails->image;
													$readnoly = (empty($patientdetails->user_id))?'':'readonly="readonly" style="background-color:#F6F6F6"';
													if(isset($user_image) && !empty($user_image)){
														if(substr($user_image, 0, 4) == 'http'){
															echo "<img src='".$user_image."' width=\"126\" height=\"152\" />";
														}else
														{
															echo "<img src='".BASE_URL.$user_image."' width=\"126\" height=\"152\" />";
														}
													}
													?>
												  </td>
												</tr>
												<tr>
													<input type="hidden" value="<?=@$patientdetails->id?>" name="patient_id" />
													<td align="right">&nbsp;</td>
													<td width="35">&nbsp;</td>
													<td width="450">&nbsp;</td>
												</tr>
												<tr>
												  <td height="29" align="right" class="from_text3">Profile Photo <?php  var_dump(@$patientdetails->user_id);?></td>
												  <td width="35">&nbsp;</td>
												  <td>							
												  <a href="javascript:void(0);" id="select_file_btn">
												  <img src="<?php echo IMAGE_URL; ?>select_file.png" /></a>
												  <input type="hidden" name="profile_pic_base64" id="profile_pic_base64" value="" />
												  <input type="hidden" name="profile_pic_base64_name" id="profile_pic_base64_name" value="" />
</td>
												</tr>
												
												<tr>
												  <td align="right">&nbsp;</td>
												  <td width="35">&nbsp;</td>
												  <td width="450">&nbsp;</td>
												</tr>
												<tr>
												  <td align="right" class="from_text3">Name </td>
												  <td width="35">&nbsp;</td>
												  <td width="450">
												  <input name="patient_name" <?=$readnoly ?>  type="text" class="from_text_filed" 
												  id="patient_name" value="<?php echo @$patientdetails->name; ?>"  /></td>
												</tr>
												<tr>
												  <td align="right">&nbsp;</td>
												  <td width="35">&nbsp;</td>
												  <td width="450">&nbsp;</td>
												</tr>
												<tr>
												  <td align="right" class="from_text3">Email ID </td>
												  <td width="35">&nbsp;</td>
												  <td width="450"><input name="email" <?=$readnoly ?> type="text" class="from_text_filed" 
												  id="email" value="<?php echo @$patientdetails->email; ?>" /></td>
												</tr>
												<tr>
												  <td align="right">&nbsp;</td>
												  <td width="35">&nbsp;</td>
												  <td width="450">&nbsp;</td>
												  <td>&nbsp;</td>
												</tr>
												<tr>
												  <td align="right" class="from_text3">Mobile </td>
												  <td width="35">&nbsp;</td>
												  <td width="450"><input name="mobile_number" <?=$readnoly ?> type="text" class="from_text_filed" id="mobile_number" value="<?php echo @$patientdetails->mobile_number; ?>" /></td>
												  <td>&nbsp;</td>
												</tr>
												<tr>
												  <td align="right">&nbsp;</td>
												  <td width="35">&nbsp;</td>
												  <td width="450">&nbsp;</td>
												  <td>&nbsp;</td>
												</tr>
												<tr>
												  <td align="right" class="from_text3">Date of Birth </td>
												  <td>&nbsp;</td>
												  <td>
													<input name="dob" type="text" class="date"  <?=$readnoly ?>
													value="<?php echo date('d-m-Y', strtotime(@$userdetails->dob))?>" id="dob" readonly="readonly" 
													style="cursor: text;" />&nbsp;</td>
												  <td>&nbsp;</td>
												</tr>
												<tr>
												  <td align="right">&nbsp;</td>
												  <td>&nbsp;</td>
												  <td>&nbsp;</td>
												  <td>&nbsp;</td>
												</tr>
												<tr>
												  <td align="right" valign="top" class="from_text3">Gender </td>
												  <td>&nbsp;</td>
												  <td>
												  <input type="radio" name="gender" id="male" <?=$readnoly ?> value="m" <?=(@$patientdetails->gender=="m")?'checked':''?> />
												  <span class="from_text4"> &nbsp; Male</span>
												  &nbsp;&nbsp;&nbsp;&nbsp;
												  <input type="radio" name="gender" id="female" <?=$readnoly ?> value="f" <?=(@$patientdetails->gender=="f")?'checked':''?> /><span class="from_text4"> &nbsp; Female</span></td>
												  <td>&nbsp;</td>
												</tr>
												<tr>
												  <td align="right">&nbsp;</td>
												  <td>&nbsp;</td>
												  <td>&nbsp;</td>
												  <td>&nbsp;</td>
												</tr>
												<tr>
												  <td align="right">Address</td>
												  <td>&nbsp;</td>
												  <td><input name="address" <?=$readnoly ?> type="text" class="from_text_filed" id="address" 
												  value="<?=@$patientdetails->address?>" /></td>
												  <td>&nbsp;</td>
												</tr>
												<tr>
												  <td align="right">&nbsp;</td>
												  <td>&nbsp;</td>
												  <td>&nbsp;</td>
												  <td>&nbsp;</td>
												</tr>
												<tr>
												  <td align="right">City </td>
												  <td>&nbsp;</td>
												  <td><select name="city" <?=$readnoly ?> class="from_list_menu" id="city">
				<option value="">
					Select Your City
				</option>
				<?php
				foreach($cities as $row): ?>
				<option value="<?php echo $row->id; ?>"
					<?php
					if(@$patientdetails->city_id == $row->id)
					echo 'selected="selected"';
					elseif(@$city_id == $row->id)
					echo 'selected="selected"';
					?> >
					<?php echo $row->name; ?>
				</option>
				<?php endforeach; ?>
			</select></td>
												  <td>&nbsp;</td>
												</tr>
												<tr>
												  <td align="right">&nbsp;</td>
												  <td>&nbsp;</td>
												  <td>&nbsp;</td>
												  <td>&nbsp;</td>
												</tr>
												<tr>
												  <td align="right">Locality </td>
												  <td>&nbsp;</td>
												  <td>
													<select name="locality" <?=$readnoly ?> class="from_list_menu" id="locality" 
													<?php  if(isset($patientdetails) && empty($patientdetails->location_id)){
																echo 'style="display:none"';
															}?>>
														<option value="">Select Your Locality</option>
														<?php if(isset($localities)){
														foreach($localities as $row): ?>
														<option value="<?php echo $row->id; ?>" 
														<?php 
														if(@$patientdetails->location_id == $row->id)
														echo 'selected="selected"';
														elseif(set_value('locality') == $row->id)
														echo 'selected="selected"';
														?> >
														<?php echo $row->name; ?>
														</option>
														<?php endforeach; }?>
													
													</select>
													<input type="text" value="<?php echo @$other_locality;?>" class="from_text_filed" id="other_locality" 
													name="other_locality" <?=(@$patientdetails->other_location)?"":'style="display:none"'?>  />
													
																						
													
			
			<a href="javascript:void(0);" 
            style="text-decoration: none; width: 20px; height: 20px; background-color: rgb(255, 120, 61); color: rgb(255, 255, 255); margin-left: 20px; padding: 6px 20px; font-size: 14px;<?php  if(isset($patientdetails) && empty($patientdetails->location_id)){echo "display:none";}else{echo 'display:inline';}?>" id="other_locality_btn">
				<span style="">
					Other
				</span>
			</a>
			<div class="select-frm-list-btn" 
            style="padding:7px 9px 6px; background-color: rgb(255, 120, 61); width: 111px; color: rgb(255, 255, 255); cursor: pointer;
			<?=(@$patientdetails->other_location)?"display:inline":"display:none"?>" >
				Select from list
			</div>
			</td>
												  <td>&nbsp;</td>
												</tr>
												<tr>
												  <td align="right">&nbsp;</td>
												  <td>&nbsp;</td>
												  <td>&nbsp;</td>
												  <td>&nbsp;</td>
												</tr>
												<tr>
												  <td align="right">Pin Code</td>
												  <td>&nbsp;</td>
												  <td><input name="pincode" type="text" class="date" id="textfield" 
												  value="<?=@$patientdetails->pin_code?>" 
												  placeholder="Pin Code" /></td>
												  <td>&nbsp;</td>
												</tr>
												<tr>
												  <td align="right">&nbsp;</td>
												  <td>&nbsp;</td>
												  <td>&nbsp;</td>
												  <td>&nbsp;</td>
												</tr>
												<tr>
										<td colspan="5" height="53" align="right" bgcolor="#f5f5f5">
										<div style="padding-right:45px;float:right;" class="continue_bnt" 
										onclick="show_hide_steps('family_history_table')">continue</div>
										<div style="padding-right:45px;float:right;margin-right:10px;" class="continue_bnt save_details" id="submit_form" 
													onclick="show_hide_steps('save_details')">submit</div>

										</td>
									</tr>
											</table>
										</td>
									</tr>
									<tr id="family_history_table" style="display:none">
										<td bgcolor="#FFFFFF">
											<table width="100%" border="0" cellspacing="0" cellpadding="0" >
												<?php if(isset($bmi) && is_array($bmi) && sizeof($bmi)>0){?>
												<tr>
												<td align="right">&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												</tr>
												<tr>
												<td align="right">&nbsp;</td>
												<td>&nbsp;</td>
												<td>
												<table width="264"  bordercolorlight="#f7f7f7" border="1"   cellspacing="0" cellpadding="0">
												<tr>
												<td align="center" class="from_text5">Weight</td>
												<td align="center" class="from_text5">Height</td>
												<td align="center" class="from_text5">BMI</td>
												</tr>
												<?php foreach($bmi as $bkey=>$bval){?>
												<tr class="from_text4-red">
												<td align="center"><?=$bval->weight ?></td>
												<td align="center"><?=$bval->height_feet.".".$bval->height_inches ?></td>
												<td align="center"><?=$bval->bmi_value ?></td>
												</tr>
												<?php }?>
												
												</table>
												</td>
												<td>&nbsp;</td>
												</tr>															  
												<?php } ?>
												<tr>
												<td align="right">&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												</tr>
											  <tr>
												<td align="right" class="from_text3">Weight </td>
												<td>&nbsp;</td>
												<td><input name="weight" type="text" class="date" id="weight" value="" /></td>
												<td>&nbsp;</td>
											  </tr>
											  <tr>
												<td align="right">&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
											  </tr>
											  <tr>
												<td align="right" class="from_text3">Height </td>
												<td>&nbsp;</td>
												<td><input name="height_feet" type="text" class="date2" id="height_feet" value="" />&nbsp;
												<span class="from_text4">Feet&nbsp;&nbsp;
												<input name="height_inches" type="text" class="date2" id="height_inches" value="" />&nbsp;Inches &nbsp;&nbsp;
												<img src="<?=IMAGE_URL?>calculateBMI.jpg" width="105" height="33" onclick="calculatebmi()" /></span></td>
												<td>&nbsp;</td>
											  </tr>
											  <tr>
												<td align="right">&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
											  </tr>
											  <tr>
												<td align="right" class="from_text3">BMI </td>
												<td>&nbsp;</td>
												<td><input name="bmi_value" type="text" class="date" id="bmi_value" value="" /></td>
												<td>&nbsp;</td>
											  </tr>
											  <tr>
												<td align="right">&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
											  </tr>
											  <tr>
												<td align="right">&nbsp;</td>
												<td>&nbsp;</td>
												<td>
												<table width="264"  bordercolorlight="#f7f7f7" border="1"   cellspacing="0" cellpadding="0">
													  <tr>
														<td align="center" class="from_text5">BMI</td>
														<td align="center" class="from_text5">Weight Status</td>
													  </tr>
													  
													  <tr class="from_text4-red">
														<td align="center">Below 18.5</td>
														<td align="center">Underweight</td>
													  </tr>
													  
													  <tr>
														<td align="center"><span class="from_text4">18.5—24.9</span></td>
														<td align="center"><span class="from_text4">Normal</span></td>
													  </tr>
													  
													  <tr>
														<td align="center"><span class="from_text4">25.0—29.9</span></td>
														<td align="center"><span class="from_text4">Overweight</span></td>
													  </tr>
													  
													  <tr>
														<td align="center"><span class="from_text4">30.0 and Above</span></td>
														<td align="center"><span class="from_text4">Obese</span></td>
													  </tr>
													</table>
												</td>
												<td>&nbsp;</td>
											  </tr>
											  <tr>
												<td align="right">&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
											  </tr>
											  <tr>
												<td align="right" class="from_text3">Blood Group</td>
												<td>&nbsp;</td>
												<td><select name="blood_group" class="from_list_menu" >
												  <option value="0">Select Blood Group</option>
												  <?php if(isset($blood_group) && sizeof($blood_group)>0){
												  foreach($blood_group as $bKey=>$bVal){?>
													  <option value="<?=$bVal->name ?>" 
													  <?=(@$patientdetails->blood_group==$bVal->name)?'selected="selected"':'' ?>><?=$bVal->name?>
													  </option>
													<?php }} ?>
												</select></td>
												<td>&nbsp;</td>
											  </tr>
											  <tr>
												<td width="192">&nbsp;</td>
												<td width="35">&nbsp;</td>
												<td width="450">&nbsp;</td>
												<td width="126">&nbsp;</td>
											  </tr>
											  <tr>
												<td height="31" bgcolor="#3dc4bf" align="left" class="from_text3" colspan="4">Family History </td>
											  </tr>    
											  
											  <tr>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
											  </tr>
											  <?php if(isset($family_details) && is_array($family_details) && sizeof($family_details)>0){
											  	foreach($family_details as $fKey=>$fVal){
												$member_name = explode("#&#",$fVal->member_name);
												
												?>
											  <tr id="family_details">
												<td align="right" valign="top">Disease Name  :<br /><br /><br /><br /><br />Description : </td>
												<td>&nbsp;</td>
												<td>
													<input name="family_detail_id[<?=$fKey?>]" type="hidden" value="<?=$fVal->id?>" />
													<input name="family_disease[<?=$fKey?>]" type="text" class="from_text_filed" value="<?=$fVal->disease?>" /><br /><br />
													<input type="checkbox" name="family_member_name[<?=$fKey?>][0]"  class="css-checkbox"  
													<?=(in_array(0,$member_name))?'checked="checked"':''?> />
													Father
													<input type="checkbox" name="family_member_name[<?=$fKey?>][1]" class="css-checkbox"
													<?=(in_array(1,$member_name))?'checked="checked"':''?> />
													Mother
													<input type="checkbox" name="family_member_name[<?=$fKey?>][2]" class="css-checkbox" 
													<?=(in_array(2,$member_name))?'checked="checked"':''?> />
													Sibling
													<br /><br />
													<textarea name="family_summary[<?=$fKey?>]" cols="45" rows="5" class="from_text_area" id="textarea4" 
													placeholder="Additional Information"><?=$fVal->summary?></textarea>
													<?php if($fKey==$family_details_count || $family_details_count==0){ ?>
													<img id="family_details_more" src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="family_history_more(this);" />
													<span id="family_details_remove" style="display:none"  onclick="remove_tr(this,'family_detail','<?=$fVal->id?>');" class="from_text4-org_1">&nbsp;Remove</span>
													<?php }else{?>
													<span id="family_details_remove"  onclick="remove_tr(this,'family_detail','<?=$fVal->id?>');" class="from_text4-org_1">&nbsp;Remove</span>
													<?php }?>
													</td>
												<td>&nbsp;</td>
											  </tr>
											  <?php }}else{ ?>
											  <tr id="family_details">
												<td align="right" valign="top">Disease Name  :<br /><br /><br /><br /><br />Description  : </td>
												<td>&nbsp;</td>
												<td>
													<input name="family_disease[0]" type="text" class="from_text_filed" /><br /><br />
													<input type="checkbox" name="family_member_name[0][0]"  class="css-checkbox" checked="checked" />
													Father
													<input type="checkbox" name="family_member_name[0][1]" class="css-checkbox" />
													Mother
													<input type="checkbox" name="family_member_name[0][2]" class="css-checkbox" />
													Sibling
													<br /><br />
													<textarea name="family_summary[0]" cols="45" rows="5" class="from_text_area" id="textarea4" 
													placeholder="Additional Information"></textarea>
													<img id="family_details_more" src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="family_history_more(this);" />
													<span id="family_details_remove" style="display:none" onclick="remove_tr(this);" class="from_text4-org_1">&nbsp;Remove</span>
													</td>
												<td>&nbsp;</td>
											  </tr>
											  <?php }?>
											  
											  <tr id="separator" style="display:none">
												<td colspan="4"><hr></td>
											  </tr>
											  
														 
											  <tr>
												<td height="31" colspan="4" align="left" valign="middle" bgcolor="#3DC4BF" class="from_text3">Self History </td>
											  </tr>
											  <tr>
												<td align="right">&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
												<td>&nbsp;</td>
											  </tr>
											  <tr>
												<td align="right" class="from_text3"><p>Food Habits</p><p>Alcohol</p><p>Smoking</p><p>No. of cigarettes/day</p><p>Tobacco Consumption</p></td>
												<td>&nbsp;</td>
												<td align="left">
													<p>
													<input type="radio" name="food_habits" id="food_habit_veg" value="1" 
													<?=(@$patientdetails->food_habits==1)?'checked="checked"':''?> />
													<span class="from_text4">Veg</span>&nbsp;
													<input type="radio" name="food_habits" id="food_habit_nonveg" value="2" 
													<?=(@$patientdetails->food_habits==2)?'checked="checked"':''?>/>
													<span class="from_text4">Non-Veg</span>
													</p>
													
													<p>
													<input type="radio" name="alcohol" id="alcohol_frequent" value="1" <?=(@$patientdetails->alcohol==1)?'checked="checked"':'' ?>   />
													<span class="from_text4">Frequent</span>&nbsp;
													<input type="radio" name="alcohol" id="alcohol_occasional" value="2" <?=(@$patientdetails->alcohol==2)?'checked="checked"':'' ?> />
													<span class="from_text4">Occasional</span>&nbsp;
													<input type="radio" name="alcohol" id="alcohol_rare" value="3" <?=(@$patientdetails->alcohol==3)?'checked="checked"':'' ?> />
													<span class="from_text4">Rare</span>&nbsp;
													<input type="radio" name="alcohol" id="alcohol_never" value="4" <?=(@$patientdetails->alcohol==4)?'checked="checked"':'' ?> />
													<span class="from_text4">Never</span></p>
													<p>
													<input type="radio" name="smoking" id="smoking_frequent" value="1" <?=(@$patientdetails->smoking==1)?'checked="checked"':'' ?> />
													<span class="from_text4">Frequent</span>&nbsp;
													<input type="radio" name="smoking" id="smoking_occasional" value="2" <?=(@$patientdetails->smoking==2)?'checked="checked"':'' ?> />
													<span class="from_text4">Occasional</span>&nbsp;
													<input type="radio" name="smoking" id="smoking_rare" value="3" <?=(@$patientdetails->smoking==3)?'checked="checked"':'' ?> />
													<span class="from_text4">Rare</span>&nbsp;
													<input type="radio" name="smoking" id="smoking_never" value="4" <?=(@$patientdetails->smoking==4)?'checked="checked"':'' ?> />
													<span class="from_text4">Never</span></p>
													<p>
													<input name="no_of_cig" type="text" class="date" id="ciggi_per_day" value="<?=@$patientdetails->ciggi_per_day ?>">
													</p>
													<p>
													<input type="radio" name="tobacco" id="tobacco_consumption_frequent" value="1" <?=(@$patientdetails->tobacco_consumption==1)?'checked="checked"':'' ?> />
													<span class="from_text4">Frequent</span>&nbsp;
													<input type="radio" name="tobacco" id="tobacco_consumption_occasional" value="2" <?=(@$patientdetails->tobacco_consumption==2)?'checked="checked"':'' ?> />
													<span class="from_text4">Occasional</span>&nbsp;
													<input type="radio" name="tobacco" id="tobacco_consumption_rare" value="3" <?=(@$patientdetails->tobacco_consumption==3)?'checked="checked"':'' ?> />
													<span class="from_text4">Rare</span>&nbsp;
													<input type="radio" name="tobacco" id="tobacco_consumption_never" value="4" <?=(@$patientdetails->tobacco_consumption==4)?'checked="checked"':'' ?> />
													<span class="from_text4">Never</span></p>														
													</td>
												<td>&nbsp;</td>
											  </tr>
												<tr>
													<td colspan="5" height="53" align="right" bgcolor="#f5f5f5">
													<div style="padding-right:45px;float:right;" class="continue_bnt" id="submit_form" 
													onclick="show_hide_steps('past_disease_table')">continue</div>
													
													<div style="padding-right:45px;float:right;margin-right:10px;" class="continue_bnt save_details" id="submit_form" 
													onclick="show_hide_steps('save_details')">submit</div>
													
													<div style="padding-right:45px;float:left;margin-right:10px;" class="continue_bnt" id="submit_form" 
													onclick="show_hide_steps('general_info_table')">previous</div>
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr id="past_disease_table" style="display:none">
										<td bgcolor="#FFFFFF">
											<table width="100%" border="0" cellspacing="0" cellpadding="0" >
												<tr>
													<td height="31" colspan="4" align="left" valign="middle" bgcolor="#3DC4BF" 
													class="from_text3">Past Disease </td>
												</tr>
												<tr>
													<td align="right">&nbsp;</td>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
												</tr>
											  <?php if(isset($past_disease) && is_array($past_disease) && sizeof($past_disease)>0){
											  	foreach($past_disease as $dKey=>$dVal){?>
											  <tr id="past_disease_more">
												<td align="right">
													<p class="PB10">Disease Name</p>
													<p class="PB10">Incidence</p>
													<p class="PB10 PT10">Duration</p>
													<p class="PB10">Details</p>
												</td>
												<td>&nbsp;</td>
												<td align="left">
												<p>
												<input name="past_disease_id[<?=$dKey?>]"  type="hidden" value="<?=$dVal->id?>" />
												<input name="disease_name[<?=$dKey ?>]" type="text" class="from_text_filed" value="<?=$dVal->disease_name ?>">
												</p>
												<p>
													<select name="disease_from_month[<?=$dKey?>]" class="from_list_menu2" >
													<option value="-1">Month</option>
													<?php foreach($month as $key=>$val){?>
														<option value="<?=$key ?>" <?php echo ($dVal->disease_from_month==$key)?'selected="selected"':'' ?>><?=$val ?></option>
													<?php } ?>
													</select>&nbsp;&nbsp;
													<select name="disease_from_year[<?=$dKey?>]" <?php echo ($dVal->disease_from_year==$key)?'selected="selected"':'' ?> 
													class="from_list_menu2" >
													<option value="-1">Year</option>
													<?php foreach($year as $key=>$val){?>
														<option value="<?=$val ?>"><?=$val ?></option>
													<?php } ?>
													</select>
												</p>
												<p>
												<input name="disease_duration[<?=$dKey?>]" style="width:60px;" type="text" class="date" value="<?=$dVal->disease_duration ?>">	   
												 Months
												</p>
												<p>
												<textarea name="disease_details[<?=$dKey?>]" cols="45" rows="5" class="from_text_area" id="textarea"><?=$dVal->disease_details ?></textarea>
												<?php if($dKey==$past_disease_count || $past_disease_count==0 ){ ?>
												<img id="past_disease_more" src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="past_disease_more1(this);" />
												<span id="past_disease_remove" style="display:none" onclick="remove_tr(this,'past_disease','<?=$dVal->id?>');" class="from_text4-org_1">&nbsp;Remove</span>
												<?php }else{?>
												<span id="past_disease_remove" onclick="remove_tr(this,'past_disease','<?=$dVal->id?>');" class="from_text4-org_1">&nbsp;Remove</span>
												<?php } ?>
												</p>
																										
												</td>
												<td>&nbsp;</td>
												</tr>
  											  <tr>
												<td colspan="4"><input name="past_disease[<?=$fKey?>]" type="hidden" value="<?=$fVal->id?>" /></td>
											  </tr>

											  <?php }}else{ ?>
											  <tr id="past_disease_more">
												<td align="right">
													<p class="PB10">Disease Name</p>
													<p class="PB10">Incidence</p>
													<p class="PB10 PT10">Duration</p>
													<p class="PB10">Details</p>
												</td>
												<td>&nbsp;</td>
												<td align="left">
												<p><input name="disease_name[0]" type="text" class="from_text_filed"></p>
												<p>
													<select name="disease_from_month[0]" class="from_list_menu2" >
													<option value="-1">Month</option>
													<?php foreach($month as $key=>$val){?>
														<option value="<?=$key ?>"><?=$val ?></option>
													<?php } ?>
													</select>&nbsp;&nbsp;
													<select name="disease_from_year[0]" class="from_list_menu2" >
													<option value="-1">Year</option>
													<?php foreach($year as $key=>$val){?>
														<option value="<?=$val ?>"><?=$val ?></option>
													<?php } ?>
													</select>
												</p>
												<p>
												<input name="disease_duration[0]" type="text" class="date" style="width:60px;" > Months
												</p>
												<p>
												<textarea name="disease_details[0]" cols="45" rows="5" class="from_text_area"></textarea>
												<img id="past_disease_more" src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="past_disease_more1(this);" />
												<span id="past_disease_remove" style="display:none" onclick="remove_tr(this);" class="from_text4-org_1">&nbsp;Remove</span>
												</p>
																										
												</td>
												<td>&nbsp;</td>
												</tr>
											  <?php } ?>

												
												
												<tr>
													<td height="31" colspan="4" align="left" valign="middle" bgcolor="#3DC4BF" 
													class="from_text3">Past Surgeries : </td>
												</tr>
												<tr>
													<td align="right">&nbsp;</td>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
												</tr>
												<?php if(isset($past_surgery) && is_array($past_surgery) && sizeof($past_surgery)>0){
												foreach($past_surgery as $sKey=>$sVal){
												 ?>
												<tr id="past_surgery_more">
												<td align="right">
													<p style="padding-bottom:14px;">Surgery name</p>
													<p style="padding-bottom:11px;">Reason For Surgery</p>
													<p style="padding-bottom:2px;">Surgery Date</p>
												</td>
												<td>&nbsp;</td>
												<td align="left">
												<p>
												
												<input type="hidden" name="past_surgery_id[<?=$sKey?>]" value="<?=$sVal->id ?>" />
												<input name="surgery_name[<?=$sKey?>]" type="text" class="from_text_filed" value="<?=$sVal->surgery_name ?>">																</p>
												<p>
												<input name="surgery_reason[<?=$sKey?>]" type="text" class="from_text_filed" value="<?=$sVal->reason ?>">
												</p>
												<p>
												<input name="surgery_date[<?=$sKey?>]" type="text" class="date" id="surgery_date" value="<?=$sVal->surgery_date ?>">
												<?php 
												if($sKey==$past_surgery_count || $past_surgery_count==0 ){ ?>
												<img id="past_surgery_more" src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="past_surgery_more1(this);" />
												<span id="past_surgery_remove" style="display:none" onclick="remove_tr(this,'past_surgery','<?=$sVal->id?>');" class="from_text4-org_1">&nbsp;Remove</span>
												<?php }else{?>
												<span id="past_surgery_remove"  onclick="remove_tr(this,'past_surgery','<?=$sVal->id?>');" class="from_text4-org_1">&nbsp;Remove</span>
												<?php }?>
												</p>
																										
												</td>
												<td>&nbsp;</td>
												</tr>
												<?php }}else{?>
												<tr id="past_surgery_more">
												<td align="right">
													<p style="padding-bottom:14px;">Surgery name</p>
													<p style="padding-bottom:11px;">Reason For Surgery</p>
													<p style="padding-bottom:2px;">Surgery Date</p>
												</td>
												<td>&nbsp;</td>
												<td align="left">
												<p>
												<input name="surgery_name[]" type="text" class="from_text_filed" >																</p>
												<p>
												<input name="surgery_reason[]" type="text" class="from_text_filed" >
												</p>
												<p>
												<input name="surgery_date[]" type="text" class="date" id="surgery_date">
												<img id="past_surgery_more" src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="past_surgery_more1(this);" />
												<span id="past_surgery_remove" style="display:none" onclick="remove_tr(this);" class="from_text4-org_1">&nbsp;Remove</span>
												</p>
																										
												</td>
												<td>&nbsp;</td>
												</tr>
												<?php }?>
												

												<tr>
													<td height="31" colspan="4" align="left" valign="middle" bgcolor="#3DC4BF" 
													class="from_text3">Current Meditation :</td>
												</tr>
												<tr>
													<td align="right">&nbsp;</td>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
												</tr>
												<?php if(isset($medication) && is_array($medication) && sizeof($medication)>0){
											  	foreach($medication as $mKey=>$mVal){
												#echo $mKey;
												#print_r($mVal->medication);
												#exit;
												?>
												<tr id="ongoing_medications_more">
													<td align="right">Ongoing Meditation</td>
													<td>&nbsp;</td>
													<td align="left">
													<input type="hidden" name="ongoing_medications_id[<?=$mKey?>]" value="<?=$mVal->id ?>" />
													<input name="ongoing_medications[<?=$mKey ?>]" type="text" class="from_text_filed" value="<?=$mVal->medication?>" >
													<?php if($mKey==$medication_count || $medication_count==0){ ?>
													<img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="ongoing_medications_more(this);" >
													<span id="ongoing_medications_remove" style="display:none" onclick="remove_tr(this,'ongoing_medications','<?=$mVal->id?>');" 
													class="from_text4-org_1">&nbsp;Remove</span>
													<?php }else{?>
													<span id="ongoing_medications_remove" onclick="remove_tr(this,'ongoing_medications','<?=$mVal->id?>');" 
													class="from_text4-org_1">&nbsp;Remove</span>
													<?php }?>
													</td>
													<td>&nbsp;</td>
												</tr>
												<?php }}else{?>
												<tr id="ongoing_medications_more">
													<td align="right">Ongoing Meditation</td>
													<td>&nbsp;</td>
													<td align="left">
													<input name="ongoing_medications[]" type="text" class="from_text_filed" >
													<img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="ongoing_medications_more(this);" >
													<span id="ongoing_medications_remove" style="display:none" onclick="remove_tr(this);" 
													class="from_text4-org_1">&nbsp;Remove</span>
													</td>
													<td>&nbsp;</td>
												</tr>
												<?php }?>
												<tr>
													<td align="right">&nbsp;</td>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
													<td>&nbsp;</td>
												</tr>
												<?php if(isset($allergic) && is_array($allergic) && sizeof($allergic)>0){
												foreach($allergic as $aKey=>$aVal){?>
												<tr id="allergic_more">
													<td align="right">Allergic to</td>
													<td>&nbsp;</td>
													<td align="left">
													<input type="hidden" name="allergic_id[<?=$aKey?>]" value="<?=$aVal->id ?>" />
													
													<select class="from_list_menu2" name="allergic_list[<?=$aKey?>]">
														<option value="0">Select Allergy</option>
														<?php foreach($allergy_list as $key=>$val){ ?>
														<option value="<?=$key ?>" <?=($key==$aVal->allery_type)?'selected="selected"':''?>><?=$val ?></option>
														<?php } ?>
													</select>
													Please Specify
													<input name="allergic[<?=$aKey?>]" type="text" class="date" value="<?=$aVal->allergic?>" >
													<?php if($aKey==$allergic_count || $allergic_count==0){ ?>
													<img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="allergic_more(this);">
													<span id="allergic_remove" style="display:none" onclick="remove_tr(this,'allergic','<?=$aVal->id?>');" class="from_text4-org_1">&nbsp;Remove</span>
													<?php }else{?>
													<span id="allergic_remove" onclick="remove_tr(this,'allergic','<?=$aVal->id?>');" class="from_text4-org_1">&nbsp;Remove</span>
													<?php }?>
													</td>
													<td>&nbsp;</td>
												</tr>
												<?php }}else{?>
												<tr id="allergic_more">
													<td align="right">Allergic to</td>
													<td>&nbsp;</td>
													<td align="left">
													<select class="from_list_menu2" name="allergic_list[]">
														<option value="0">Select Allergy</option>
														<?php foreach($allergy_list as $key=>$val){ ?>
														<option value="<?=$key ?>" <?=(@$aVal->allery_type==$key)?'selected="selected"':''?>><?=$val ?></option>
														<?php } ?>
													</select>
													Please Specify
													<input name="allergic[]" type="date" class="date" >
													
													<img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="allergic_more(this);">
													<span id="allergic_remove" style="display:none" onclick="remove_tr(this);" class="from_text4-org_1">&nbsp;Remove</span>
													</td>
													<td>&nbsp;</td>
												</tr>
												<?php }?>
												<tr>
												<td colspan="5" height="53" align="right" bgcolor="#f5f5f5">
												<div style="padding-right:45px;float:right;margin-right:10px;" class="continue_bnt save_details" id="submit_form" 
												onclick="show_hide_steps('save_details')">submit</div>
												
												<div style="padding-right:45px;float:left;margin-right:10px;" class="continue_bnt" id="submit_form" 
												onclick="show_hide_steps('family_history_table')">previous</div>
												</a>
												</td>
												</tr>
											</table>
										</td>
									</tr>
									
								</table>
							</td>
						</tr>
						<tr><td>&nbsp;</td></tr>
						<tr><td>&nbsp;</td></tr>
					</table>
				</form>
			</td>
			<td width="53" valign="top">&nbsp;
			<table>
				<tr id="family_history_tocopy" style="display:none" >
				<td align="right" valign="top">Disease Name  :<br /><br /><br /><br /><br />Description  :</td>
				<td>&nbsp;</td>
				<td>
					<input name="family_disease[<?=$family_details_count?>]" id="family_disease_copy1" dataid="<?=$family_details_count?>" type="text" class="from_text_filed" /><br /><br />
					<input type="checkbox" id="family_member_name_copy1" dataid="<?=$family_details_count ?>" name="family_member_name[<?=$family_details_count ?>][0]" 
					class="css-checkbox" checked="checked" />
					Father
					<input type="checkbox" id="family_member_name_copy2" dataid="<?=$family_details_count ?>" name="family_member_name[<?=$family_details_count ?>][1]"  class="css-checkbox" />
					Mother
					<input type="checkbox"  id="family_member_name_copy3" dataid="<?=$family_details_count ?>" name="family_member_name[<?=$family_details_count ?>][2]" 
					class="css-checkbox" />
					Sibling
					<br /><br />
					<textarea name="family_summary[<?=$family_details_count ?>]" id="family_summary_copy1" dataid="<?=$family_details_count ?>" cols="45" rows="5" class="from_text_area" placeholder="Additional Information"></textarea>
					<img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="family_history_more(this);" />
					<span id="family_details_remove" style="display:none" onclick="remove_tr(this);" class="from_text4-org_1">&nbsp;Remove</span>
					</td>
				<td>&nbsp;</td>
				</tr>
				
				<tr id="past_disease_tocopy" style="display:none">
				<td align="right">
					<p class="PB10">Disease Name</p>
					<p class="PB10">Incidence</p>
					<p class="PB10 PT10">Duration</p>
					<p class="PB10">Details</p>
				</td>
				<td>&nbsp;</td>
				<td align="left">
				<p><input name="disease_name[<?=$past_disease_count?>]" dataid="<?=$past_disease_count?>" type="text" class="from_text_filed" id="disease_name_copy" value=""></p>
				<p>
					<select name="disease_from_month[<?=$past_disease_count?>]" dataid="<?=$past_disease_count?>" class="from_list_menu2" id="disease_from_month_copy">
					<option value="-1">Month</option>
					<?php foreach($month as $key=>$val){?>
						<option value="<?=$key ?>"><?=$val ?></option>
					<?php } ?>
					</select>&nbsp;&nbsp;
					<select name="disease_from_year[<?=$past_disease_count?>]" dataid="<?=$past_disease_count?>" class="from_list_menu2" id="disease_from_year_copy">
					<option value="-1">Year</option>
					<?php foreach($year as $key=>$val){?>
						<option value="<?=$val ?>"><?=$val ?></option>
					<?php } ?>
					</select>
				</p>
				<p>
				<input name="disease_duration[<?=$past_disease_count?>]" dataid="<?=$past_disease_count?>" type="text" class="date" id="disease_duration_copy" value="<?=@$patientdetails->ciggi_per_day ?>" style="60px;"> Months
				</p>
				<p>
				<textarea name="disease_details[<?=$past_disease_count?>]" dataid="<?=$past_disease_count?>" cols="45" rows="5" class="from_text_area" id="disease_details_copy"></textarea>
				<img id="past_disease_more" src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="past_disease_more1(this);" />
				<span id="past_disease_remove" style="display:none" onclick="remove_tr(this);" class="from_text4-org_1">&nbsp;Remove</span>
				</p>
																		
				</td>
				<td>&nbsp;</td>
				</tr>
				<tr id="past_surgery_tocopy" style="display:none">
				<td align="right">
				<p class="PB10">Surgery name</p>
				<p class="PB10">Reason For Surgery</p>
				<p class="PB10 PT10">Surgery Date</p>
				</td>
				<td>&nbsp;</td>
				<td align="left">
				<p>
				<input name="surgery_name[<?=$past_surgery_count?>]" dataid="<?=$past_surgery_count?>" type="text" class="from_text_filed" id="surgery_name_copy">																</p>
				<p>
				<input name="surgery_reason[<?=$past_surgery_count?>]" dataid="<?=$past_surgery_count?>" type="text" class="from_text_filed" id="surgery_reason_copy" value="<?=@$patientdetails->surgery_reason ?>">
				</p>
				<p>
				<input name="surgery_date[<?=$past_surgery_count?>]" dataid="<?=$past_surgery_count?>" type="text" class="date" id="surgery_date_copy" >
				<img id="past_surgery_more" src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="past_surgery_more1(this);" />
				<span id="past_surgery_remove" style="display:none" onclick="remove_tr(this);" class="from_text4-org_1">&nbsp;Remove</span>
				</p>
																
				</td>
				<td>&nbsp;</td>
				</tr>
				<tr id="ongoing_medications_tocopy" style="display:none">
					<td align="right">Ongoing Meditation</td>
					<td>&nbsp;</td>
					<td align="left">
					<input name="ongoing_medications[<?=$medication_count?>]" dataid="<?=$medication_count?>" id="ongoing_medications_copy" type="text" class="from_text_filed">
					<img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="ongoing_medications_more(this);">
					<span id="ongoing_medications_remove" style="display:none" onclick="remove_tr(this);" class="from_text4-org_1">&nbsp;Remove</span>
					</td>
					<td>&nbsp;</td>
				</tr>
				<tr id="allergic_tocopy" style="display:none">
					<td align="right">Allergic to</td>
					<td>&nbsp;</td>
					<td align="left">
					<select class="from_list_menu2" name="allergic_list[<?=$allergic_count?>]" dataid="<?=$allergic_count?>" id="allergy_list_copy">
						<option value="0" selected="selected">Select Allergy</option>
						<?php foreach($allergy_list as $key=>$val){ ?>
						<option value="<?=$key ?>" ><?=$val ?></option>
						<?php } ?>
					</select>
                    Please Specify
					<input name="allergic[<?=$allergic_count?>]" dataid="<?=$allergic_count?>" type="text" class="date" id="allergic_copy">
					<img src="<?=IMAGE_URL?>addmore.jpg" width="85" height="31" onclick="allergic_more(this);">
					<span id="allergic_remove" style="display:none" onclick="remove_tr(this);" class="from_text4-org_1">&nbsp;Remove</span>
					</td>
					<td>&nbsp;</td>
				</tr>
				
			</table>
			</td>
		</tr>
	</table>
</td>
</tr>
<tr>
<td height="35" align="center" valign="middle" bgcolor="#033f44" class="text">
	2014 BookdrAppointment.com, All rights reserved
</td>
</tr>
</table>

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
	<div class="cropped"></div>
</div>
</div>
<script type="text/javascript">
$(window).load(function()
{
$("#dob").datepicker(
{
	dateFormat: "dd-mm-yy",
	defaultDate: "-25y",
	changeMonth: true,
	changeYear: true,
	yearRange: "1900:2014"
});
$("#surgery_date").datepicker(
{
	dateFormat: "dd-mm-yy",
	defaultDate: "-25y",
	changeMonth: true,
	changeYear: true,
	yearRange: "1900:2014"
});

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
</body>
</html>