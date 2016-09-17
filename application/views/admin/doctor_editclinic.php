<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php $this->load->view('admin/common/head'); ?>
		<link type="text/css" rel="stylesheet" href="<?php echo CSS_URL; ?>admin/doctor.css"/>
    <link type="text/css" rel="stylesheet" href="<?php echo CSS_URL; ?>admin/jquery.timeentry.css"/>
    

		<style type="text/css">
			td, th
			{
				border: 1px solid #9a9d88;
				padding: 8px 50px 8px 20px;
			}
			input[type="text"]
			{
				height: 20px;
				width: 80%;
				margin: 2px 0;
			}
			select
			{
				height: 27px;
				width: 80%;
				margin: 2px 0;
			}

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
				border: 1px solid #aaa;
				background: #fff;
				overflow: hidden;
				background-repeat: no-repeat;
				cursor: move;
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
			.consult-table td
			{
				padding: 4px 5px;
			}
			#clinic_timings input[type="text"]{
				width:65px !important;
			}
		</style>
	</head>
	<body>
		<?php $this->load->view('admin/common/header'); ?>
		<?php //$this->load->view('admin / common / left_menu'); ?>
		<div id="content_area">
			<div>
				<?php #print_r($all_details); ?>
				<h2>Edit Clinic</h2>
				<form action="" method="POST">
        	<input type="hidden" name="location_id" id="location_id" value="<?=$all_details['location_id']?>" />
					<table border="1" cellpadding="0" cellspacing="0" class="basic-profile-details-table" style="float: left;">
						<tr>
							<td>Clinic Name</td>
							<td><input type="text" name="name" value="<?=@$all_details['name']?>" /></td>
						</tr>
						<tr>
							<td>Clinic Address</td>
							<td><textarea cols="40" rows="5" name="address"><?=@$all_details['address']?></textarea></td>
						</tr>
						<tr>
							<td>City</td>
							<td>
								<select name="city" id="city">
								<option value="">
									Select City
								</option>
								<?php
								foreach($cities as $row): ?>
								<option value="<?php echo $row->id; ?>"
									<?php
									if(@$all_details['city_id'] == $row->id)
									echo 'selected="selected"';
									?> >
									<?php echo $row->name; ?>
								</option>
								<?php endforeach; ?>
							</select>
							</td>
						</tr>
						<tr>
							<td>Locality</td>
							<td>
								<input type="button" value="Other Location" class="other-location-btn" />
								<input type="button" value="Location Dropdown" class="location-btn" style="display: none;" />
								<select id="locality" name="locality" class="locality">
									<option value="">Select</option>
								</select>
								<input type="text" name="other_locality" class="other_locality" disabled="disabled" value="<?=@$all_details['other_location']?>" style="display: none;" />
							</td>
						</tr>
						<tr>
							<td>Pincode</td>
							<td><input type="text" name="pincode" value="<?=@$all_details['pincode']?>" /></td>
						</tr>
						<tr>
							<td>Clinic Landline No</td>
							<td>
								<input type="text" name="contact_number" value="<?=@$all_details['contact_number']?>" />
							</td>
						</tr>
            <tr>
							<td>Number Verified</td>
							<td>
								yes <input type="radio" name="is_number_verified" <?=((@$all_details['is_number_verified']==1)?'checked="checked"':'')?> value="1"    />
                no <input type="radio" name="is_number_verified" <?=((@$all_details['is_number_verified']==0)?'checked="checked"':'')?> value="0"  />
							</td>
						</tr>
            <tr>
            <td>Clinic Timings</td>
            <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="clinic_timings">
              <tr><td colspan="9" align="right"><a href="javascript:void(0)" id="copy_to_all_days">Copy to all days</a></td></tr>
              <tr>
                <td align="center" class="from_fileld">
                  Monday
                </td>
                <td align="center">
                  <input name="mon_mor_open" type="text" class="day_time date2" id="mon_mor_open" value="<?php echo !empty($clinic_timings[1][0][0]) ? date('h:iA', strtotime(@$clinic_timings[1][0][0])) : ''; ?>" />
                </td>
                <td align="center" class="from_fileld">
                  to
                </td>
                <td align="center">
                  <input name="mon_mor_close" type="text" class="day_time date2" id="mon_mor_close" value="<?php echo !empty($clinic_timings[1][0][1]) ? date('h:iA', strtotime(@$clinic_timings[1][0][1])) : ''; ?>" />
                </td>
                <td align="center">&nbsp;
                  
                </td>
                <td align="center">
                  <input name="mon_eve_open" type="text" class="day_time date2" id="mon_eve_open" value="<?php echo !empty($clinic_timings[1][1][0]) ? date('h:iA', strtotime(@$clinic_timings[1][1][0])) : ''; ?>" />
                </td>
                <td align="center">
                  <span class="from_fileld">
                    to
                  </span>
                </td>
                <td align="center">
                <input name="mon_eve_close" type="text" class="day_time date2" id="mon_eve_close" 
                  value="<?php echo !empty($clinic_timings[1][1][1]) ? date('h:iA', strtotime(@$clinic_timings[1][1][1])) : ''; ?>"/>
                </td>
                <td align="center">
                  <input name="days[]" type="checkbox" class="checkbox_valid" id="mon" value="monday" <?php
                  if(empty($clinic_timings[1][0][1]) && empty($clinic_timings[1][1][1]) && empty($clinic_timings[1][0][0]) && empty($clinic_timings[1][1][0])) echo '';
                  else echo 'checked="checked"'; ?> />
                </td>
              </tr>
              <tr>
                <td height="1" colspan="9" align="center" bgcolor="#FFFFFF">
                </td>
              </tr>
              <tr>
                <td align="center" class="from_fileld">
                  Tuesday
                </td>
                <td align="center">
                  <input name="tue_mor_open" type="text" class="day_time date2" id="tue_mor_open" 
                  value="<?php echo !empty($clinic_timings[2][0][0]) ? date('h:iA', strtotime(@$clinic_timings[2][0][0])) : ''; ?>" />
                </td>
                <td align="center" class="from_fileld">
                  to
                </td>
                <td align="center">
                  <input name="tue_mor_close" type="text" class="day_time date2" id="tue_mor_close" value="<?php echo !empty($clinic_timings[2][0][1]) ? date('h:iA', strtotime(@$clinic_timings[2][0][1])) : ''; ?>" />
                </td>
                <td align="center">&nbsp;
                  
                </td>
                <td align="center">
                  <input name="tue_eve_open" type="text" class="day_time date2" id="tue_eve_open" value="<?php echo !empty($clinic_timings[2][1][0]) ? date('h:iA', strtotime(@$clinic_timings[2][1][0])) : ''; ?>" />
                </td>
                <td align="center">
                  <span class="from_fileld">
                    to
                  </span>
                </td>
                <td align="center">
                  <input name="tue_eve_close" type="text" class="day_time date2" id="tue_eve_close" value="<?php echo !empty($clinic_timings[2][1][1]) ? date('h:iA', strtotime(@$clinic_timings[2][1][1])) : ''; ?>" />
                </td>
                <td align="center">
                  <input name="days[]" type="checkbox" class="checkbox_valid" id="tue" value="tuesday" <?php
                  if(empty($clinic_timings[2][0][1]) && empty($clinic_timings[2][1][1]) && empty($clinic_timings[2][0][0]) && empty($clinic_timings[2][1][0])) echo '';
                  else echo 'checked="checked"'; ?> />
                </td>
              </tr>
              <tr>
                <td height="1" colspan="9" align="center" bgcolor="#FFFFFF">
                </td>
              </tr>
              <tr>
                <td align="center" class="from_fileld">
                  Wednesday
                </td>
                <td align="center">
                  <input name="wed_mor_open" type="text" class="day_time date2" id="wed_mor_open" value="<?php echo !empty($clinic_timings[3][0][0]) ? date('h:iA', strtotime(@$clinic_timings[3][0][0])) : ''; ?>" />
                </td>
                <td align="center" class="from_fileld">
                  to
                </td>
                <td align="center">
                  <input name="wed_mor_close" type="text" class="day_time date2" id="wed_mor_close" value="<?php echo !empty($clinic_timings[3][0][1]) ? date('h:iA', strtotime(@$clinic_timings[3][0][1])) : ''; ?>" />
                </td>
                <td align="center">&nbsp;
                  
                </td>
                <td align="center">
                  <input name="wed_eve_open" type="text" class="day_time date2" id="wed_eve_open" value="<?php echo !empty($clinic_timings[3][1][0]) ? date('h:iA', strtotime(@$clinic_timings[3][1][0])) : ''; ?>" />
                </td>
                <td align="center">
                  <span class="from_fileld">
                    to
                  </span>
                </td>
                <td align="center">
                  <input name="wed_eve_close" type="text" class="day_time date2" id="wed_eve_close" value="<?php echo !empty($clinic_timings[3][1][1]) ? date('h:iA', strtotime(@$clinic_timings[3][1][1])) : ''; ?>" />
                </td>
                <td align="center">
                  <input name="days[]" type="checkbox" class="checkbox_valid" id="wed" value="wednesday" <?php
                  if(empty($clinic_timings[3][0][1]) && empty($clinic_timings[3][1][1]) && empty($clinic_timings[3][0][0]) && empty($clinic_timings[3][1][0])) echo '';
                  else echo 'checked="checked"'; ?> />
                </td>
              </tr>
              <tr>
                <td height="1" colspan="9" align="center" bgcolor="#FFFFFF">
                </td>
              </tr>
              <tr>
                <td align="center" class="from_fileld">
                  Thurday
                </td>
                <td align="center">
                  <input name="thu_mor_open" type="text" class="day_time date2" id="thu_mor_open" value="<?php echo !empty($clinic_timings[4][0][0]) ? date('h:iA', strtotime(@$clinic_timings[4][0][0])) : ''; ?>" />
                </td>
                <td align="center" class="from_fileld">
                  to
                </td>
                <td align="center">
                  <input name="thu_mor_close" type="text" class="day_time date2" id="thu_mor_close" value="<?php echo !empty($clinic_timings[4][0][1]) ? date('h:iA', strtotime(@$clinic_timings[4][0][1])) : ''; ?>" />
                </td>
                <td align="center">&nbsp;
                  
                </td>
                <td align="center">
                  <input name="thu_eve_open" type="text" class="day_time date2" id="thu_eve_open" value="<?php echo !empty($clinic_timings[4][1][0]) ? date('h:iA', strtotime(@$clinic_timings[4][1][0])) : ''; ?>" />
                </td>
                <td align="center">
                  <span class="from_fileld">
                    to
                  </span>
                </td>
                <td align="center">
                  <input name="thu_eve_close" type="text" class="day_time date2" id="thu_eve_close" value="<?php echo !empty($clinic_timings[4][1][1]) ? date('h:iA', strtotime(@$clinic_timings[4][1][1])) : ''; ?>" />
                </td>
                <td align="center">
                  <input name="days[]" type="checkbox" class="checkbox_valid" id="thu" value="thursday" <?php
                  if(empty($clinic_timings[4][0][1]) && empty($clinic_timings[4][1][1]) && empty($clinic_timings[4][0][0]) && empty($clinic_timings[4][1][0])) echo '';
                  else echo 'checked="checked"'; ?> />
                </td>
              </tr>
              <tr>
                <td height="1" bgcolor="#FFFFFF" align="center" colspan="9">
                </td>
              </tr>
              <tr>
                <td align="center" class="from_fileld">
                  Firday
                </td>
                <td align="center">
                  <input name="fri_mor_open" type="text" class="day_time date2" id="fri_mor_open" value="<?php echo !empty($clinic_timings[5][0][0]) ? date('h:iA', strtotime(@$clinic_timings[5][0][0])) : ''; ?>" />
                </td>
                <td align="center" class="from_fileld">
                  to
                </td>
                <td align="center">
                  <input name="fri_mor_close" type="text" class="day_time date2" id="fri_mor_close" value="<?php echo !empty($clinic_timings[5][0][1]) ? date('h:iA', strtotime(@$clinic_timings[5][0][1])) : ''; ?>" />
                </td>
                <td align="center">&nbsp;
                  
                </td>
                <td align="center">
                  <input name="fri_eve_open" type="text" class="day_time date2" id="fri_eve_open" value="<?php echo !empty($clinic_timings[5][1][0]) ? date('h:iA', strtotime(@$clinic_timings[5][1][0])) : ''; ?>" />
                </td>
                <td align="center">
                  <span class="from_fileld">
                    to
                  </span>
                </td>
                <td align="center">
                  <input name="fri_eve_close" type="text" class="day_time date2" id="fri_eve_close" value="<?php echo !empty($clinic_timings[5][1][1]) ? date('h:iA', strtotime(@$clinic_timings[5][1][1])) : ''; ?>" />
                </td>
                <td align="center">
                  <input name="days[]" type="checkbox" class="checkbox_valid" id="fri" value="friday" <?php
                  if(empty($clinic_timings[5][0][1]) && empty($clinic_timings[5][1][1]) && empty($clinic_timings[5][0][0]) && empty($clinic_timings[5][1][0])) echo '';
                  else echo 'checked="checked"'; ?> />
                </td>
              </tr>
              <tr>
                <td height="1" bgcolor="#FFFFFF" align="center" colspan="9">
                </td>
              </tr>
              <tr>
                <td align="center" class="from_fileld">
                  Saturday
                </td>
                <td align="center">
                  <input name="sat_mor_open" type="text" class="day_time date2" id="sat_mor_open" value="<?php echo !empty($clinic_timings[6][0][0]) ? date('h:iA', strtotime(@$clinic_timings[6][0][0])) : ''; ?>" />
                </td>
                <td align="center">
                  <span class="from_fileld">
                    to
                  </span>
                </td>
                <td align="center">
                  <input name="sat_mor_close" type="text" class="day_time date2" id="sat_mor_close" value="<?php echo !empty($clinic_timings[6][0][1]) ? date('h:iA', strtotime(@$clinic_timings[6][0][1])) : ''; ?>" />
                </td>
                <td align="center">&nbsp;
                  
                </td>
                <td align="center">
                  <input name="sat_eve_open" type="text" class="day_time date2" id="sat_eve_open" value="<?php echo !empty($clinic_timings[6][1][0]) ? date('h:iA', strtotime(@$clinic_timings[6][1][0])) : ''; ?>" />
                </td>
                <td align="center">
                  <span class="from_fileld">
                    to
                  </span>
                </td>
                <td align="center">
                  <input name="sat_eve_close" type="text" class="day_time date2" id="sat_eve_close" value="<?php echo !empty($clinic_timings[6][1][1]) ? date('h:iA', strtotime(@$clinic_timings[6][1][1])) : ''; ?>" />
                </td>
                <td align="center">
                  <input name="days[]" type="checkbox" class="checkbox_valid" id="sat" value="saturday" <?php
                  if(empty($clinic_timings[6][0][1]) && empty($clinic_timings[6][1][1]) && empty($clinic_timings[6][0][0]) && empty($clinic_timings[6][1][0])) echo '';
                  else echo 'checked="checked"'; ?> />
                </td>
              </tr>
              <tr>
                <td height="1" bgcolor="#FFFFFF" align="center" colspan="9">
                </td>
              </tr>
              <tr>
                <td width="80" align="center" class="from_fileld">
                  Sunday
                </td>
                <td width="82" align="center">
                  <input name="sun_mor_open" type="text" class="day_time date2" id="sun_mor_open" value="<?php echo !empty($clinic_timings[0][0][0]) ? date('h:iA', strtotime(@$clinic_timings[0][0][0])) : ''; ?>" />
                </td>
                <td width="35" align="center" class="from_fileld">
                  to
                </td>
                <td width="82" align="center">
                  <input name="sun_mor_close" type="text" class="day_time date2" id="sun_mor_close" value="<?php echo !empty($clinic_timings[0][0][1]) ? date('h:iA', strtotime(@$clinic_timings[0][0][1])) : ''; ?>" />
                </td>
                <td width="35" align="center">&nbsp;
                  
                </td>
                <td width="82" align="center">
                  <input name="sun_eve_open" type="text" class="day_time date2" id="sun_eve_open" value="<?php echo !empty($clinic_timings[0][1][0]) ? date('h:iA', strtotime(@$clinic_timings[0][1][0])) : ''; ?>" />
                </td>
                <td width="35" align="center">
                  <span class="from_fileld">
                    to
                  </span>
                </td>
                <td width="82" align="center">
                  <input name="sun_eve_close" type="text" class="day_time date2" id="sun_eve_close" value="<?php echo !empty($clinic_timings[0][1][1]) ? date('h:iA', strtotime(@$clinic_timings[0][1][1])) : ''; ?>" />
                </td>
                <td align="center">
                  <input name="days[]" type="checkbox" class="checkbox_valid" id="sun" value="sunday" <?php
                  if(empty($clinic_timings[0][0][1]) && empty($clinic_timings[0][1][1]) && empty($clinic_timings[0][0][0]) && empty($clinic_timings[0][1][0])) echo '';
                  else echo 'checked="checked"'; ?>  />
                </td>
              </tr>
              <tr>
                <td height="1" colspan="9" align="center" bgcolor="#FFFFFF">
                </td>
              </tr>
            </table>
						</td>
            </tr>
            <tr></tr>
						<tr></tr>
						<tr>
							<td>First Consultation Fees</td>
							<td>
								<input type="radio" value="1" name="consult_fee" <?php if(isset($all_details['consultation_fees']) && !empty($all_details['consultation_fees']) && $all_details['consultation_fees'] == 1) echo 'checked' ?>>Rs. 100~300 <br>
								<input type="radio" value="2" name="consult_fee" <?php if(isset($all_details['consultation_fees']) && !empty($all_details['consultation_fees']) && $all_details['consultation_fees'] == 2) echo 'checked' ?>>Rs. 301~500 <br>
								<input type="radio" value="3" name="consult_fee" <?php if(isset($all_details['consultation_fees']) && !empty($all_details['consultation_fees']) && $all_details['consultation_fees'] == 3) echo 'checked' ?>>Rs. 501~750 <br>
								<input type="radio" value="4" name="consult_fee" <?php if(isset($all_details['consultation_fees']) && !empty($all_details['consultation_fees']) && $all_details['consultation_fees'] == 4) echo 'checked' ?>>Rs. 751~1000 <br>
								<input type="radio" value="5" name="consult_fee" <?php if(isset($all_details['consultation_fees']) && !empty($all_details['consultation_fees']) && $all_details['consultation_fees'] == 5) echo 'checked' ?>> more than Rs. 1000
							</td>
						</tr>
						<tr>
							<td>Avg Appointment Duration</td>
							<td>
								<select name="avg_patient_duration">
									<option value="">
										Select the duration
									</option>
									<option <?=(@$all_details['duration']==5)?'selected="selected"':''?> value="5">5</option>
									<option <?=(@$all_details['duration']==10)?'selected="selected"':''?> value="10">10</option>
									<option <?=(@$all_details['duration']==15)?'selected="selected"':''?> value="15">15</option>
									<option <?=(@$all_details['duration']==20)?'selected="selected"':''?> value="20">20</option>
									<option <?=(@$all_details['duration']==25)?'selected="selected"':''?> value="25">25</option>
									<option <?=(@$all_details['duration']==30)?'selected="selected"':''?> value="30">30</option>
									<option <?=(@$all_details['duration']==35)?'selected="selected"':''?> value="35">35</option>
									<option <?=(@$all_details['duration']==40)?'selected="selected"':''?> value="40">40</option>
									<option <?=(@$all_details['duration']==45)?'selected="selected"':''?> value="45">45</option>
									<option <?=(@$all_details['duration']==50)?'selected="selected"':''?> value="50">50</option>
									<option <?=(@$all_details['duration']==55)?'selected="selected"':''?> value="55">55</option>
									<option <?=(@$all_details['duration']==60)?'selected="selected"':''?> value="60">60</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>Tele Consultation</td>
							<td><input type="text" name="tele_fees" value="<?=@$all_details['tele_fees']?>" /></td>
						</tr>
						<tr>
							<td>Online Consultation</td>
							<td><input type="text" name="online_fees" value="<?=@$all_details['online_fees']?>" /></td>
						</tr>
						<tr>
							<td>Express Appointment</td>
							<td><input type="text" name="express_fees" value="<?=@$all_details['express_fees']?>" /></td>
						</tr>
						<tr>
							<td colspan="2" style="text-align: center;">
								<input type="submit" name="submit" value="Save Changes" id="submit" style="width: 120px; height: 30px;" />
							</td>
						</tr>
					</table>
				</form>

			</div>
		</div>
		<?php $this->load->view('admin/common/footer'); ?>
		<?php $this->load->view('admin/common/bottom'); ?>

		<!--<script src="<?php echo JS_URL; ?>admin/jquery-cropimg-plugin.js"></script>
		<script src="<?=JS_URL?>jquery.bpopup.min.js"></script>-->
		<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>-->
		<script src="<?php echo JS_URL; ?>admin/jquery.plugin.js"></script>
		<script src="<?php echo JS_URL; ?>admin/jquery.timeentry.js"></script>
    
		<script type="text/javascript">
			$(document).ready(function()
				{
					$(".other-location-btn").click(function()
						{
							$(".other-location-btn").hide();
							$(".location-btn").show();
							$(".locality").hide();
							$(".other_locality").show();
							$(".locality").prop('disabled', true);
							$(".other_locality").prop('disabled', false);
						});
					$(".location-btn").click(function()
						{
							$(".other-location-btn").show();
							$(".location-btn").hide();
							$(".locality").show();
							$(".other_locality").hide();
							$(".locality").prop('disabled', false);
							$(".other_locality").prop('disabled', true);
						});
					
					$("#left_Panel").height($("#content_area").height());
					
					var city = $("#city").val();
					var location_id = $("#location_id").val();
					$.ajax(
						{
							url: '/location/locality',
							type: "POST",
							data:
							{
								'city_id'	:	city,
								'location_id':location_id
							},
							success : function(resp)
							{
								$("#locality").html(resp);
							}
						});
					
					$("#city").on('change', function()
					{
						var city = $("#city").val();
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
					<?php if(isset($all_details['other_location']) && !empty($all_details['other_location'])): ?>
						$(".other-location-btn").trigger('click');
					<?php endif; ?>
					setTimeout(function()
						{
							$(".locality").val('<?php echo $all_details['location_id']; ?>');
						}, 1000);
					$("#copy_to_all_days").click(function()
						{
							var mon_mor_open = $("#mon_mor_open").val();
							var mon_mor_close = $("#mon_mor_close").val();
							var mon_eve_open = $("#mon_eve_open").val();
							var mon_eve_close = $("#mon_eve_close").val();
		
							$("#tue_mor_open").val(mon_mor_open);
							$("#wed_mor_open").val(mon_mor_open);
							$("#thu_mor_open").val(mon_mor_open);
							$("#fri_mor_open").val(mon_mor_open);
							$("#sat_mor_open").val(mon_mor_open);
							$("#sun_mor_open").val(mon_mor_open);
		
							$("#tue_eve_open").val(mon_eve_open);
							$("#wed_eve_open").val(mon_eve_open);
							$("#thu_eve_open").val(mon_eve_open);
							$("#fri_eve_open").val(mon_eve_open);
							$("#sat_eve_open").val(mon_eve_open);
							$("#sun_eve_open").val(mon_eve_open);
		
							$("#tue_mor_close").val(mon_mor_close);
							$("#wed_mor_close").val(mon_mor_close);
							$("#thu_mor_close").val(mon_mor_close);
							$("#fri_mor_close").val(mon_mor_close);
							$("#sat_mor_close").val(mon_mor_close);
							$("#sun_mor_close").val(mon_mor_close);
		
							$("#tue_eve_close").val(mon_eve_close);
							$("#wed_eve_close").val(mon_eve_close);
							$("#thu_eve_close").val(mon_eve_close);
							$("#fri_eve_close").val(mon_eve_close);
							$("#sat_eve_close").val(mon_eve_close);
							$("#sun_eve_close").val(mon_eve_close);
		
							if(mon_mor_open == '' && mon_mor_close == '' && mon_eve_open == '' && mon_eve_close == '')
							{
								$(".checkbox_valid").each(function()
									{
										this.checked = false;
									});
							}
							else
							{
								$(".checkbox_valid").each(function()
									{
										this.checked = true;
									});
							}
		
						});
					if($("#mon_mor_open").val() == '' && $("#mon_mor_close").val() == '' && $("#mon_eve_open").val() == '' && $("#mon_eve_close").val() == '')
					{
						$("#mon").prop('checked', false);
					}
					if($("#tue_mor_open").val() == '' && $("#tue_mor_close").val() == '' && $("#tue_eve_open").val() == '' && $("#tue_eve_close").val() == '')
					{
						$("#tue").prop('checked', false);
					}
					if($("#wed_mor_open").val() == '' && $("#wed_mor_close").val() == '' && $("#wed_eve_open").val() == '' && $("#wed_eve_close").val() == '')
					{
						$("#wed").prop('checked', false);
					}
					if($("#thu_mor_open").val() == '' && $("#thu_mor_close").val() == '' && $("#thu_eve_open").val() == '' && $("#thu_eve_close").val() == '')
					{
						$("#thu").prop('checked', false);
					}
					if($("#fri_mor_open").val() == '' && $("#fri_mor_close").val() == '' && $("#fri_eve_open").val() == '' && $("#fri_eve_close").val() == '')
					{
						$("#fri").prop('checked', false);
					}
					if($("#sat_mor_open").val() == '' && $("#sat_mor_close").val() == '' && $("#sat_eve_open").val() == '' && $("#sat_eve_close").val() == '')
					{
						$("#sat").prop('checked', false);
					}
					if($("#sun_mor_open").val() == '' && $("#sun_mor_close").val() == '' && $("#sun_eve_open").val() == '' && $("#sun_eve_close").val() == '')
					{
						$("#sun").prop('checked', false);
					}						
				$(".day_time").timeEntry(
				{
					spinnerImage: '',
					timeSteps: [1, 5, 0],
					defaultTime: '09:00AM'
				});
			$(".checkbox_valid").click(function()
				{
					//alert(5);
					var id = $(this).attr('id');
					var check_status = $(this).is(":checked");
					if((check_status) == false)
					{
						var day_mor_open = id+'_mor_open';
						var day_mor_close = id+'_mor_close';
						var day_eve_open = id+'_eve_open';
						var day_eve_close = id+'_eve_close';
						$("#"+day_mor_open).val('');
						$("#"+day_mor_close).val('');
						$("#"+day_eve_open).val('');
						$("#"+day_eve_close).val('');
					}
					else
					{
						var day_mor_open = id+'_mor_open';
						var day_mor_close = id+'_mor_close';
						var day_eve_open = id+'_eve_open';
						var day_eve_close = id+'_eve_close';
						$("#"+day_mor_open).val('10:00AM');
						$("#"+day_mor_close).val('01:00PM');
						$("#"+day_eve_open).val('05:00PM');
						$("#"+day_eve_close).val('08:00PM');
					}
				});

			
				});

		</script>

	</body>
</html>
