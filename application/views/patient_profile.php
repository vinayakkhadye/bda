<!DOCTYPE html>
<html lang="en">
<?php
/*	print_r($patient_details);
	echo "<br>";
	echo "<br>";
	print_r($patient_bmi_details);
	echo "<br>";
	echo "<br>";
	print_r($patient_family_details);
	echo "<br>";
	echo "<br>";
	print_r($patient_history);
	echo "<br>";
	echo "<br>";*/
?>
	<head>
		<meta charset="utf-8">
		<title>
			BookDrAppointment
		</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!-- The styles -->
		<link id="bs-css" href="<?php echo CSS_URL; ?>bootstrap-cerulean.css" rel="stylesheet">
		<!--<link href="<?php echo CSS_URL; ?>jquery.timeentry.css" rel="stylesheet">-->
		<script src="<?php echo JS_URL; ?>login/jquery.min.js"></script>
		<link href="<?php echo CSS_URL; ?>bootstrap-responsive.css" rel="stylesheet">
		<link href="<?php echo CSS_URL; ?>charisma-app.css" rel="stylesheet">
		
		<link id="bs-css" href="<?php echo CSS_URL; ?>login/jquery-ui-new.css" rel="stylesheet">
		<script src="<?php echo JS_URL; ?>jquery-new.js"></script>
		<script src="<?php echo JS_URL; ?>login/jquery-ui-new.js"></script>

		<!-- The fav icon -->
		<link rel="shortcut icon" href="img/favicon.ico">
		<script type="text/javascript">
			$(document).ready(function()
				{
					$(".dropdown-toggle").click(function()
						{
							$(".dropdown-menu").toggle("fast");
						});

					$("#state").on('change', function()
						{
							var state = $("#state").val();
							//alert(state);
							$.ajax(
								{
									url: '/location/city',
									type: "POST",
									data:
									{
										'state_id'	:	state
									},
									success : function(resp)
									{
										$("#city").html(resp);
									}
								});
						});

					$("#city").on('change', function()
						{
							var city = $("#city").val();
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
						
					$("#datepicker_surgery").datepicker(
						{
							dateFormat: "yy-mm-dd",
							changeMonth: true,
							changeYear: true,
							yearRange: "1900:2014" 
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
					<a class="brand" href="/patient/dashboard">
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
						<a href="#">
							Home
						</a>
					</li>
				</ul>
				<!-- user dropdown starts -->
				<div class="btn-group pull-right" >
					<i class="admin_icon">
					</i>
					<a class="btn dropdown-toggle admin_btn" data-toggle="dropdown" href="#">
						<span class="hidden-phone" style="float:left;">
							<?php echo $name; ?>
						</span>
						<span class="admin_dwn_arrow">
						</span>
					</a>
					<ul class="dropdown-menu">
						<li>
							<a href="/patient/dashboard">
								Profile
							</a>
						</li>
						<li>
							<a href="#">
								Change Password
							</a>
						</li>
						<li class="divider">
						</li>
						<li>
							<a href="/logout">
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
				<div id="content" class="span10">
					<div class="row-fluid sortable">
						<div class="box span12">
							<div class="box-header well" data-original-title>
								<h2>
									<i class="icon_edit">
									</i> Edit Patient
								</h2>
							</div>
							<p>
								<font color='#006633'>
									<b>
									</b>
								</font><br/>
							</p>
							<div class="box-content adPanel adPanel_02" style="display:block;">
								<form action="" method="post" class="form-horizontal" id="ad_doc" name="ad_doc" enctype="multipart/form-data" >
									<fieldset>
										
										<div class="control-group">
											<label class="control-label" for="focusedInput">
												State
											</label>
											<div class="controls" id="state_div">
												<select class="input-xlarge focused city" id="state" name="state">
													<option>
														Select Your State
													</option>
													<?php
													foreach($states as $row){ 
													echo "<option value='".$row->id."' ";
													if(isset($patient_details_stateid) && $row->id == $patient_details_stateid)
													{
														echo "selected='selected'";
													}
													echo ">";
													echo $row->name."
													</option>";
													 }; ?>
												</select>
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="focusedInput">
												City
											</label>
											<div class="controls" id="city_div">
												<select class="input-xlarge focused city" id="city" name="city">
													<option>
														Select Your City
													</option>
													<?php
													foreach($cities as $row){ 
													echo "<option value='".$row->id."' ";
													if($row->id == $patient_details->city_id)
													{
														echo "selected='selected'";
													}
													echo ">";
													echo $row->name."
													</option>";
													}; ?>
												</select>
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="focusedInput" >
												Locality
											</label>
											<div class="controls" id="locality_div">
												<select class="input-xlarge focused city" id="locality" name="locality">
													<option>
														Select Your Locality
													</option>
													<?php
													foreach($locality as $row){ 
													echo "<option value='".$row->id."' ";
													if($row->id == $patient_details->location_id)
													{
														echo "selected='selected'";
													}
													echo ">";
													echo $row->name."
													</option>";
													}; ?>
												</select>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="selectError3">
												Pincode
											</label>
											<div class="controls">
												<input class="input-xlarge focused" id="pincode" name="pincode" type="text" value="<?php
												echo isset($patient_details->pin_code) ? $patient_details->pin_code : '';
												?>">
											</div>
										</div>
										
										<div class="control-group">
											<label class="control-label" for="selectError3">
												Address
											</label>
											<div class="controls">
												<textarea class="focused" id="focusedInput" name="address"><?php
												echo isset($patient_details->address) ? $patient_details->address : '';
												?></textarea>
											</div>
										</div>
										
										<div class="control-group">
											<label class="control-label" for="selectError3">
												Weight
											</label>
											<div class="controls">
												<input class="input-xlarge focused" id="weight" name="weight" type="text" value="<?php
												echo isset($patient_bmi_details->weight) ? $patient_bmi_details->weight : '';
												?>" style="width:45px;">
												<span style="float:left;margin-left:6px;margin-right:4px;">
													Kgs
												</span>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="selectError3">
												Height
											</label>
											<div class="controls">
												<input class="input-xlarge focused" id="height_feet" name="height_feet" type="text" value="<?php
												echo isset($patient_bmi_details->height_feet) ? $patient_bmi_details->height_feet : '';
												?>" style="width:45px;">
												<span style="float:left;margin-left:6px;margin-right:4px;">
													Feet
												</span>
												<input class="input-xlarge focused" id="height_inches" name="height_inches" onchange="calculateBmi() " type="text" value="<?php
												echo isset($patient_bmi_details->height_inches) ? $patient_bmi_details->height_inches : '';
												?>" style="width: 45px;">
												<span style="float:left;margin-left:6px;">
													Inches
												</span>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="focusedInput" >
												Blood Group
											</label>
											<div class="controls">
												<select class="input-xlarge focused blood_group" id="focusedInput" type="text" value="" name="blood_group">
													<option value="">
														Select Blood Group
													</option>
													<option  value="A +ve" <?php if(isset($patient_details) && $patient_details->blood_group == 'A +ve') echo "selected='selected'"; ?> >
														A +ve
													</option>
													<option  value="A -ve" <?php if(isset($patient_details) && $patient_details->blood_group == 'A -ve') echo "selected='selected'"; ?> >
														A -ve
													</option>
													<option  value="B +ve" <?php if(isset($patient_details) && $patient_details->blood_group == 'B +ve') echo "selected='selected'"; ?> >
														B +ve
													</option>
													<option  value="B -ve" <?php if(isset($patient_details) && $patient_details->blood_group == 'B -ve') echo "selected='selected'"; ?> >
														B -ve
													</option>
													<option  value="AB +ve" <?php if(isset($patient_details) && $patient_details->blood_group == 'AB +ve') echo "selected='selected'"; ?> >
														AB +ve
													</option>
													<option  value="AB -ve" <?php if(isset($patient_details) && $patient_details->blood_group == 'AB -ve') echo "selected='selected'"; ?> >
														AB -ve
													</option>
													<option  value="O +ve" <?php if(isset($patient_details) && $patient_details->blood_group == 'O +ve') echo "selected='selected'"; ?> >
														O +ve
													</option>
													<option  value="O -ve" <?php if(isset($patient_details) && $patient_details->blood_group == 'O -ve') echo "selected='selected'"; ?> >
														O -ve
													</option>
												</select>
											</div>
										</div>
									</fieldset>
									<!--</form>  -->
									<div class="control-group">
										<label class="control-label" for="focusedInput">
											<b>
												Family History :
											</b>
										</label>
									</div>
									<fieldset>
										<div class="family_d_info">
											<div class="control-group">
												<label class="control-label" for="focusedInput">
													Disease Name
												</label>
												<div class="controls">
													<input class="focused" id="focusedInput" name="disease_name" type="text" value="<?php
												echo isset($patient_family_details->disease) ? $patient_family_details->disease : '';
												?>" >
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="focusedInput">
												</label>
												<div class="controls">
													<input type="checkbox" <?php if(isset($patient_family_details) && $patient_family_details->member_name == 'father') echo "checked='checked'"; ?> name="member_name[]" value="father" />Father
													<input type="checkbox" <?php if(isset($patient_family_details) && $patient_family_details->member_name == 'mother') echo "checked='checked'"; ?> name="member_name[]" value="mother" />Mother
													<input type="checkbox" <?php if(isset($patient_family_details) && $patient_family_details->member_name == 'siblings') echo "checked='checked'"; ?> name="member_name[]" value="siblings" />Siblings
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="focusedInput">
												</label>
												<div class="controls">
													<textarea class="focused" id="focusedInput" name="detail_info" placeholder="Additional Information"><?php
												echo isset($patient_family_details->summary) ? $patient_family_details->summary : '';
												?></textarea>
												</div>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="focusedInput">
												<b>
													Patient History :
												</b>
											</label>
										</div>
										<div class="control-group">
											<label class="control-label" for="focusedInput">
												Food Habits
											</label>
											<div class="controls">
												<label>
													<input class="input-xlarge focused"  name="food_habits" type="radio" <?php
												if(isset($patient_details->food_habits) && $patient_details->food_habits == 'Veg')
												echo "checked='checked'";
												?> value="Veg">Veg
												</label>
												<label>
													<input class="input-xlarge focused"  name="food_habits" type="radio" <?php
												if(isset($patient_details->food_habits) && $patient_details->food_habits == 'Non-Veg')
												echo "checked='checked'";
												?> value="Non-Veg">Non-Veg
												</label>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="focusedInput">
												Alcohol
											</label>
											<div class="controls">
												<label>
													<input class="input-xlarge focused" <?php
												if(isset($patient_details->alcohol) && $patient_details->alcohol == 'Frequent')
												echo "checked='checked'";
												?> name="alcohol" type="radio" value="Frequent">Frequent
												</label>
												<label>
													<input class="input-xlarge focused" <?php
												if(isset($patient_details->alcohol) && $patient_details->alcohol == 'Occasional')
												echo "checked='checked'";
												?> name="alcohol" type="radio" value="Occasional">Occasional
												</label>
												<label>
													<input class="input-xlarge focused" <?php
												if(isset($patient_details->alcohol) && $patient_details->alcohol == 'Rare')
												echo "checked='checked'";
												?> name="alcohol" type="radio" value="Rare">Rare
												</label>
												<label>
													<input class="input-xlarge focused" <?php
												if(isset($patient_details->alcohol) && $patient_details->alcohol == 'None')
												echo "checked='checked'";
												?> name="alcohol" type="radio" value="None">None
												</label>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="focusedInput">
												Smoking
											</label>
											<div class="controls">
												<label>
													<input class="input-xlarge focused" name="smoking" <?php
												if(isset($patient_details->smoking) && $patient_details->smoking == 'Frequent')
												echo "checked='checked'";
												?> type="radio" value="Frequent">Frequent
												</label>
												<label>
													<input class="input-xlarge focused" name="smoking" <?php
												if(isset($patient_details->smoking) && $patient_details->smoking == 'Occasional')
												echo "checked='checked'";
												?> type="radio" value="Occasional">Occasional
												</label>
												<label>
													<input class="input-xlarge focused" name="smoking" <?php
												if(isset($patient_details->smoking) && $patient_details->smoking == 'Rare')
												echo "checked='checked'";
												?> type="radio" value="Rare">Rare
												</label>
												<label>
													<input class="input-xlarge focused" name="smoking" <?php
												if(isset($patient_details->smoking) && $patient_details->smoking == 'None')
												echo "checked='checked'";
												?> type="radio" value="None">None
												</label>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="focusedInput">
												No. Of cigarettes/Day
											</label>
											<div class="controls">
												<input type="text" name="no_of_cig" value="<?php
												echo isset($patient_details->ciggi_per_day) ? $patient_details->ciggi_per_day : '';
												?>" />
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="focusedInput">
												Tobacco Consumption
											</label>
											<div class="controls">
												<label>
													<input class="input-xlarge focused" <?php
												if(isset($patient_details->tobacco_consumption) && $patient_details->tobacco_consumption == 'Frequent')
												echo "checked='checked'";
												?> name="tobacco" type="radio" value="Frequent">Frequent
												</label>
												<label>
													<input class="input-xlarge focused" <?php
												if(isset($patient_details->tobacco_consumption) && $patient_details->tobacco_consumption == 'Occasional')
												echo "checked='checked'";
												?> name="tobacco" type="radio" value="Occasional" >Occasional
												</label>
												<label>
													<input class="input-xlarge focused" <?php
												if(isset($patient_details->tobacco_consumption) && $patient_details->tobacco_consumption == 'Rare')
												echo "checked='checked'";
												?> name="tobacco" type="radio" value="Rare">Rare
												</label>
												<label>
													<input class="input-xlarge focused" <?php
												if(isset($patient_details->tobacco_consumption) && $patient_details->tobacco_consumption == 'None')
												echo "checked='checked'";
												?> name="tobacco" type="radio" value="None">None
												</label>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="focusedInput">
												<b>
													Past Disease :
												</b>
											</label>
										</div>
										<div id="past_disease">
											<div class="control-group">
												<label class="control-label" for="focusedInput">
													Disease Name
												</label>
												<div class="controls">
													<input type="text" class="input-xlarge focused" id="focusedInput" name="past_disease" value="<?php
												echo isset($patient_history->disease) ? $patient_history->disease : '';
												?>" />
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="focusedInput">
													Incidence
												</label>

												<div class="controls">
													<select name="incident_month">
														<option value="01" <?php if(isset($disease_duration) && $disease_duration['incident_month'] == '01') echo "selected='selected'"; ?>>
															Jan
														</option>
														<option value="02" <?php if(isset($disease_duration) && $disease_duration['incident_month'] == '02') echo "selected='selected'"; ?>>
															Feb
														</option>
														<option value="03" <?php if(isset($disease_duration) && $disease_duration['incident_month'] == '03') echo "selected='selected'"; ?>>
															Mar
														</option>
														<option value="04" <?php if(isset($disease_duration) && $disease_duration['incident_month'] == '04') echo "selected='selected'"; ?>>
															Apr
														</option>
														<option value="05" <?php if(isset($disease_duration) && $disease_duration['incident_month'] == '05') echo "selected='selected'"; ?>>
															May
														</option>
														<option value="06" <?php if(isset($disease_duration) && $disease_duration['incident_month'] == '06') echo "selected='selected'"; ?>>
															Jun
														</option>
														<option value="07" <?php if(isset($disease_duration) && $disease_duration['incident_month'] == '07') echo "selected='selected'"; ?>>
															Jul
														</option>
														<option value="08" <?php if(isset($disease_duration) && $disease_duration['incident_month'] == '08') echo "selected='selected'"; ?>>
															Aug
														</option>
														<option value="09" <?php if(isset($disease_duration) && $disease_duration['incident_month'] == '09') echo "selected='selected'"; ?>>
															Sep
														</option>
														<option value="10" <?php if(isset($disease_duration) && $disease_duration['incident_month'] == '10') echo "selected='selected'"; ?>>
															Oct
														</option>
														<option value="11" <?php if(isset($disease_duration) && $disease_duration['incident_month'] == '11') echo "selected='selected'"; ?>>
															Nov
														</option>
														<option value="12" <?php if(isset($disease_duration) && $disease_duration['incident_month'] == '12') echo "selected='selected'"; ?>>
															Dec
														</option>
													</select>
													<select name="incident_year">
													<?php
														for($i=2014; $i>=1910; $i--)
														{ 
															echo '<option value="'.$i.'">
																'.$i.'
															</option>';
														};
													?>
													</select>
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="focusedInput">
													Duration
												</label>
												<div class="controls">
													<input type="text" name="duration_year" id="duration_year" value="<?php
												echo isset($patient_history->disease) ? $disease_duration['duration_year'] : '';
												?>" placeholder="No. Of Years" />
												
													<input type="text" name="duration_month"  id="duration_month" value="<?php
												echo isset($patient_history->disease) ? $disease_duration['duration_month'] : '';
												?>" placeholder="No. Of Months" />
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="focusedInput">
													Details
												</label>
												<div class="controls">
													<textarea class="input-xlarge focused" id="focusedInput" name="disease_details"><?php
												echo isset($patient_history->disease_details) ? $patient_history->disease_details : '';
												?></textarea>
												</div>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="focusedInput">
												Ongoing Meditation
											</label>
											<div class="controls">
												<textarea class="input-xlarge focused" id="focusedInput" name="ongoing_meditation"><?php
												echo isset($patient_details->ongoing_medications) ? $patient_details->ongoing_medications : '';
												?></textarea>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="focusedInput">
												Allergic to
											</label>
											<div class="controls">
												<textarea class="input-xlarge focused" id="focusedInput" name="allergic_to"><?php
												echo isset($patient_details->allergic) ? $patient_details->allergic : '';
												?></textarea>
											</div>
										</div>
										<div class="control-group">
											<label class="control-label" for="focusedInput">
												<b>
													Past Surgeries :
												</b>
											</label>
										</div>
										<div class="control-group">
											<label class="control-label" for="focusedInput">
												Name
											</label>
											<div class="controls">
												<input  placeholder="Surgery Name" type="text" class="input-xlarge focused" id="focusedInput" name="surgery_name" value="<?php
												echo isset($patient_history->surgery) ? $patient_history->surgery : '';
												?>">
												<input type="text" placeholder="Surgery Date" class="focused" id="datepicker_surgery" name="surgery_date" readonly='true' style="cursor: initial;" value="<?php
												echo isset($patient_history->surgery_date) ? $patient_history->surgery_date : '';
												?>">
												<input type="text" placeholder="Reason For Surgery" class="input-xlarge focused" id="focusedInput" name="surgery_reason" value="<?php
												echo isset($patient_history->surgery_reason) ? $patient_history->surgery_reason : '';
												?>">
											</div>
										</div>
										<div class="form-actions">
											<input type="submit" class="btn btn-primary" name="submit" id="update" value="Save Changes">
											<input type="reset" class="btn" value="Reset">
										</div>
									</fieldset>
								</form>
							</div>
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
		<footer>
			<p class="pull-left">
				&copy;
				<a href="" target="_blank">
					BDA
				</a>
			</p>
			<!--<p class="pull-right">Powered by: <a href="http://digitalwebtech.in" target="_blank">Digital Webtech Pvt. Ltd.</a></p>-->
		</footer>
	</body>
</html>
