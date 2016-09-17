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
		<!--<link href="<?php echo CSS_URL; ?>jquery.timeentry.css" rel="stylesheet">-->

		<script src="<?php echo JS_URL; ?>login/jquery.min.js">
		</script>
		<script src="<?php echo JS_URL; ?>login/jquery.plugin.js"></script>
		<script src="<?php echo JS_URL; ?>login/jquery.timeentry.js"></script>

		<style type="text/css">
			body
			{
				padding-bottom: 40px;
			}
			.sidebar-nav
			{
				padding: 9px 0;
			}
			.day_time
			{
				width: 50px;
			}
		</style>
		<link href="<?php echo CSS_URL; ?>bootstrap-responsive.css" rel="stylesheet">
		<link href="<?php echo CSS_URL; ?>charisma-app.css" rel="stylesheet">
		<script type="text/javascript">
			$(document).ready(function()
				{
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

					$(".checkbox_valid").click(function()
						{
							//					alert(jid);
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
								$("#"+day_mor_open).val('09:00AM');
								$("#"+day_mor_close).val('02:00PM');
								$("#"+day_eve_open).val('07:00PM');
								$("#"+day_eve_close).val('11:00PM');
							}
						});
					//				var jq = $.noConflict();
					$(".day_time").timeEntry(
						{
							spinnerImage: '',
							timeSteps: [1, 5, 0],
							defaultTime: '09:00AM'
						});
						
					$("#teleconsult").click(function()
					{
						var check = $("#teleconsult").is(":checked");
						if(check == true)
						{
							$("#tele_info").show();
						}
						else
						{
							$("#tele_info").hide();
						}
					});
					
					$("#online_consult").click(function()
					{
						var check = $("#online_consult").is(":checked");
						if(check == true)
						{
							$("#online_info").show();
						}
						else
						{
							$("#online_info").hide();
						}
					});
					
					$("#express_app").click(function()
					{
						var check = $("#express_app").is(":checked");
						if(check == true)
						{
							$("#express_info").show();
						}
						else
						{
							$("#express_info").hide();
						}
					});
					
					$("#copy_consult_fees").click(function()
					{
						var fees = $("#consult_fee").val();
						$("#tele_fees").val(fees);
					});
					
					$("#copy_consult_fees1").click(function()
					{
						var fees = $("#consult_fee").val();
						$("#online_fees").val(fees);
					});
					
					$("#copy_consult_fees2").click(function()
					{
						var fees = $("#consult_fee").val();
						$("#express_fees").val(fees);
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
					<a class="brand" href="index.php">
						<img alt="BDA Logo" src="<?php echo IMAGE_URL; ?>logo20.png" />
					</a>

					<!-- user dropdown ends -->
					<div class="top-nav nav-collapse">
						<ul class="nav">
						</ul>
					</div><!--/.nav-collapse -->
				</div>
			</div>
		</div>

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
							Admin
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
				<div id="content" class="span10">
					<div class="row-fluid sortable">
						<div class="box span12">
							<div class="box-header well" data-original-title>
								<h2>
									Profile
								</h2>
							</div>
							<div class="box-content">
								<form action="" method="post" class="form-horizontal" id="ad_doc" name="ad_doc" onSubmit="submit" enctype="multipart/form-data" >
								<?php echo validation_errors("<p style='color:red;'>","</p>"); ?>
									<fieldset>

										<div class="control-group">
											<label class="control-label" for="focusedInput">
												Speciality
											</label>
											<div class="controls" id="speciality_div">
												<select class="input-xlarge focused Speciality" id="focusedInput" name="speciality">
													<option value="">
														Select Your Speciality
													</option>
													<?php
													foreach($speciality as $row): ?>
													<option value="<?php echo $row->name; ?>">
														<?php echo $row->name; ?>
													</option>
													<?php endforeach; ?>
												</select>
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="focusedInput">
												Degree
											</label>
											<div class="controls qualification_div" >
												<p>
													<select multiple="multiple" class="focused Qualification" id="focusedInput" name="qualification[]" style="width: 300px;">
														<?php
														foreach($qualification as $row): ?>
														<option value="<?php echo $row->name; ?>">
															<?php echo $row->name; ?>
														</option>
														<?php endforeach; ?>
													</select>
												</p>
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="focusedInput" >
												Registration Number
											</label>
											<div class="controls">
												<input type="text" name="doc_reg_no" />
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="focusedInput" >
												No. of Years of Experience
											</label>
											<div class="controls">
												<input type="text" maxlength="2" style="width: 50px;" id="textarea2 inputError"  name="experience" />
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="focusedInput">
												Clinic/Hospital Name
											</label>
											<div class="controls">
												<input class="input-xlarge focused clinic_name" id="focusedInput" name="clinic_name" type="text" value="">
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="focusedInput">
												Clinic/Hospital address
											</label>
											<div class="controls">
												<textarea id="clinic_address" name="clinic_address"></textarea>
											</div>
										</div>

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
													foreach($states as $row): ?>
													<option value="<?php echo $row->id; ?>">
														<?php echo $row->name; ?>
													</option>
													<?php endforeach; ?>
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
												</select>
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="focusedInput" >
												Pincode
											</label>
											<div class="controls" id="pincode_div">
												<input type="text" name="pincode" id="pincode" />
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="focusedInput">
												Clinic/Hospital Landline No.
											</label>
											<div class="controls">
												<input class="landline_no_code" id="focusedInput" name="clinic_number" type="text" value="" maxlength="15">
											</div>
										</div>

										<span>
											Consultation Days & Timings(Please select days for clinic)
										</span>&nbsp;
										<!--<a
										id="copy_time" onclick="copy_time()" href="javascript:void(0);">Copy in all days
										</a>-->
										<br><br>

										<!--Monday-->
										<div class="control-group">
											<label class="control-label" for="selectError3">
												Monday
											</label>
											<div class="controls">
												<input type="checkbox" data-role="none"   name="days[]"  id="mon" value="monday" checked="checked" class="checkbox_valid">
												<div class="day_mor">
													<input type="text" name="mon_mor_open"  class="day_time"  id="mon_mor_open" value="10:00AM" >-
													<input type="text" name="mon_mor_close"  class="day_time"  id="mon_mor_close" value="01:00PM" >
												</div>
												<div class="day_mor">
													<input type="text" name="mon_eve_open"  class="day_time" id="mon_eve_open" value="06:00PM" >-
													<input type="text" name="mon_eve_close"  class="day_time" id="mon_eve_close"  value="08:00PM" >
												</div>
											</div>
										</div>

										<!--Tuesday-->
										<div class="control-group">
											<label class="control-label" for="selectError3">
												Tuesday
											</label>
											<div class="controls">
												<input type="checkbox" name="days[]"  checked="checked"  id="tue" value="tuesday" class="checkbox_valid">
												<div class="day_mor">
													<input type="text" name="tue_mor_open"  class="day_time"  id="tue_mor_open" value="10:00AM" >-
													<input type="text" name="tue_mor_close"  class="day_time"  id="tue_mor_close" value="01:00PM" >
												</div>
												<div class="day_mor">
													<input type="text" name="tue_eve_open"  class="day_time" id="tue_eve_open" value="06:00PM" >
													-
													<input type="text" name="tue_eve_close"  class="day_time" id="tue_eve_close"  value="08:00PM" >
												</div>
											</div>
										</div>

										<!--Wednesday-->
										<div class="control-group">
											<label class="control-label" for="selectError3">
												Wednesday
											</label>
											<div class="controls">
												<input type="checkbox" name="days[]" checked="checked" id="wed" value="wednesday" class="checkbox_valid">
												<div class="day_mor">
													<input type="text" name="wed_mor_open"  class="day_time"  id="wed_mor_open" value="10:00AM" >
													-
													<input type="text" name="wed_mor_close"  class="day_time"  id="wed_mor_close" value="01:00PM" >
												</div>
												<div class="day_mor">
													<input type="text" name="wed_eve_open"  class="day_time" id="wed_eve_open" value="06:00PM" >
													-
													<input type="text" name="wed_eve_close"  class="day_time" id="wed_eve_close"  value="08:00PM" >
												</div>
											</div>
										</div>

										<!--Thursday-->
										<div class="control-group">
											<label class="control-label" for="selectError3">
												Thursday
											</label>
											<div class="controls">
												<input type="checkbox" name="days[]" checked="checked" id="thu" value="thursday" class="checkbox_valid">
												<div class="day_mor">
													<input type="text" name="thu_mor_open"  class="day_time"  id="thu_mor_open" value="10:00AM" >
													-
													<input type="text" name="thu_mor_close"  class="day_time"  id="thu_mor_close" value="01:00PM" >
												</div>
												<div class="day_mor">
													<input type="text" name="thu_eve_open"  class="day_time" id="thu_eve_open" value="06:00PM" >
													-
													<input type="text" name="thu_eve_close"   class="day_time" id="thu_eve_close" value="08:00PM" >
												</div>
											</div>
										</div>

										<!--Friday-->
										<div class="control-group">
											<label class="control-label" for="selectError3">
												Friday
											</label>
											<div class="controls">
												<input type="checkbox" name="days[]" checked="checked"  id="fri" value="friday" class="checkbox_valid">
												<div class="day_mor">
													<input type="text" name="fri_mor_open"  class="day_time"  id="fri_mor_open" value="10:00AM" >
													-
													<input type="text" name="fri_mor_close"  class="day_time"  id="fri_mor_close" value="01:00PM" >
												</div>
												<div class="day_mor">
													<input type="text" name="fri_eve_open"  class="day_time" id="fri_eve_open" value="06:00PM" >
													-
													<input type="text" name="fri_eve_close"  class="day_time" id="fri_eve_close" value="08:00PM" >
												</div>
											</div>
										</div>

										<!--Saturday-->
										<div class="control-group">
											<label class="control-label" for="selectError3" >
												Saturday
											</label>
											<div class="controls">
												<input type="checkbox" name="days[]" checked="checked"    id="sat" value="saturday" class="checkbox_valid" />
												<div class="day_mor">
													<input type="text" name="sat_mor_open"  class="day_time"  id="sat_mor_open" value="10:00AM" >
													-
													<input type="text" name="sat_mor_close"  class="day_time"  id="sat_mor_close" value="01:00PM" >
												</div>
												<div class="day_mor">
													<input type="text" name="sat_eve_open"  class="day_time" id="sat_eve_open" value="06:00PM" >
													-
													<input type="text" name="sat_eve_close"  class="day_time" id="sat_eve_close" value="08:00PM" >
												</div>
											</div>
										</div>

										<!--Sunday-->
										<div class="control-group">
											<label class="control-label" for="selectError3" >
												Sunday
											</label>
											<div class="controls">
												<input type="checkbox"  checked="checked" name="days[]"   id="sun" value="sunday" class="checkbox_valid">
												<div class="day_mor">
													<input type="text" name="sun_mor_open"  class="day_time"  id="sun_mor_open" value="10:00AM" >-
													<input type="text" name="sun_mor_close"  class="day_time"  id="sun_mor_close" value="01:00PM" >
												</div>
												<div class="day_mor">
													<input type="text" name="sun_eve_open"  class="day_time" id="sun_eve_open" value="06:00PM" >-
													<input type="text" name="sun_eve_close"  class="day_time" id="sun_eve_close" value="08:00PM" >
												</div>
											</div>
										</div>


										<div class="control-group">
											<label class="control-label" for="selectError3"  >
												Consultation Fees
											</label>
											<div class="controls">
												<input class="input-xlarge focused ConsultationFee" placeholder="Rs." id="consult_fee" type="text" value="" name="consult_fee">
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="selectError3"  >
												Average Duration of appointment per patient
											</label>
											<div class="controls">
												<input class="input-xlarge focused" maxlength="2" style="width: 40px;" id="avg_patient_duration" type="text" value="" name="avg_patient_duration">Mins
											</div>
										</div>

										<div class="control-group">
											<label class="control-label" for="selectError3"  >
												Would you like register to offer value added services to your patient
											</label>
											<div class="controls">
												<!--Value Added Services-->
												<div class="control-label" style="width:300px;">
													<input class="input-xlarge focused ConsultationFee" id="teleconsult" type="checkbox" value="1" name="teleconsult">Teleconsultation
													<div id="tele_info" style="display:none" >
														<div>
															<span>
																We connect you to the Patients who take your Consultation Telephonically through an Appointment
															</span>
															<div>
																Procedure
															</div>
															<div>
																<p>
																	Patient pays Tele Consultation fees as specified by you + BDA Service Charge of Rs. 100  through BDA Payment Gateway on BDA Website.
																</p>
																<p>
																	Teleconsultation Appointment is confirmed only after confirmation of online payment by the patient.
																</p>
																<p>
																	BDA pays you the Tele Consultation fees within 10 days from the Date of Tele Consultation in the Bank Account specified by you.
																</p>
																<p>
																	Your Bank Details are taken after the 1st Teleconsultation Service provided
																</p>
															</div>
															Teleconsultation Fees
															<br/>
															<span style="font-weight:bold;cursor:pointer" id="copy_consult_fees">
																Same As consultation Fees
															</span><br />
															<input style="width:100px;" class="input-xlarge focused " id="tele_fees" type="text" placeholder="Rs." value="" name="tele_fees">
														</div>
													</div>
												</div>
												<div class="control-label" style="width:300px;">
													<input class="input-xlarge focused " id="online_consult" type="checkbox" value="1" onclick="show_info('online_info',this.id)" name="online_consult">Online Consultation
													<div id="online_info" style="display:none">
														<span>
															We connect you to the Patients who take your Consultation Online through a Video Conferencing System with a prior Appointment
														</span>
														<div>
															Procedure
														</div>
														<div>
															<p>
																Patient pays Online Consultation fees as specified by you + BDA Service Charge of Rs. 200  through BDA Payment Gateway on BDA Website.
															</p>
															<p>
																Online consultation Appointment is confirmed only after confirmation of online payment by the patient.
															</p>
															<p>
																BDA pays you the Online Consultation fees within 10 days from the Date of Online Consultation in the Bank Account specified by you.
															</p>
															<p>
																Your Bank Details are taken after the 1st Online consultation Service provided
															</p>
														</div>
														Online Consultation Fees<br/>
														<span style="font-weight:bold;cursor:pointer" id="copy_consult_fees1" >
															Same As consultation Fees
														</span><br />
														<input style="width:100px;" class="input-xlarge focused " id="online_fees"  placeholder="Rs." type="text" value="" name="online_fees">
													</div>
												</div>
												<div class="control-label" style="width:300px;">
													<input class="input-xlarge focused" id="express_app" type="checkbox" value="1" onclick="show_info('express_info',this.id)" name="express_app">Express Appointment
													<div id="express_info" style="display:none">
														<span>
															Why Express Appointment?
														</span>
														<span>
															For the Patients who do not want to wait for their turn and want an instant consultation
														</span>
														<span>
															You may charge Premium Consultation fees for Express Appointment
														</span>
														<div>
															Procedure
														</div>
														<div>
															<p>
																Patient pays Premium Consultation fees as specified by you + BDA Service Charge of Rs. 100  through BDA Payment Gateway on BDA Website.
															</p>
															<p>
																Express Appointment is confirmed only after confirmation of online payment by the patient.
															</p>
															<p>
																BDA pays you the Premium Consultation fees within 10 days from the Date of Express Appointment in the Bank Account specified by you.
															</p>
															<p>
																Your Bank Details are taken after the 1st Express Appointment Service provided
															</p>
														</div>
														Express Appointment Fees<br/>
														<span style="font-weight:bold;cursor:pointer" id="copy_consult_fees2">
															Same As consultation Fees
														</span><br />
														<input style="width:100px;"  placeholder="Rs." class="input-xlarge focused " id="express_fees" type="text" value="" name="express_fees">
													</div>
												</div>
											</div>
										</div>
										<div class="form-actions">
											<input type="submit" class="btn btn-primary" name="submit" id="submit" value="Save Profile">
										</div>
									</fieldset>
								</form>
							</div>
						</div><!--/span-->
					</div><!--/row-->
					<!-- content ends -->
				</div><!--/#content.span10-->
			</div><!--/fluid-row-->
			<!-- Footer Starts -->
			<hr>
			<footer>
				<p class="pull-left">
					&copy;
					<a href="" target="_blank">
						BDA
					</a>
				</p>
			</footer>
		</div>
	</body>
</html>