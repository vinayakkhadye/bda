<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>
			Book Dr Appointment
		</title>

		<script src="<?php echo JS_URL; ?>login/jquery.min.js">
		</script>
		<script src="<?php echo JS_URL; ?>login/jquery-ui-new.js">
		</script>

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
			.from_text4
			{
				font-size: 18px;
			}
		</style>

		<script>
			$(document).ready(function()
				{
					$(".delete-clinic-btn").click(function()
					{
						var a = confirm('Are you sure you want to delete this clinic/hospital?');
						if(a == true)
						{
							var clinic = this.id;
							var clinicid = clinic.substr(6);
							$.ajax(
							{
								url : '/doctor/deleteclinic/'+clinicid,
								success: function(resp)
								{
									$(location).attr('href','/doctor/manageclinic');
								}
							});
						}
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
										<td width="135" height="41">
											&nbsp;

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
											Manage Clinic
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
							<td width="53" valign="top">
								&nbsp;

							</td>
							<td width="985" valign="top">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td height="50">
											&nbsp;

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
																	Manage  Your Clinic Details
																</td>
																<td>
																	&nbsp;

																</td>
																<td width="150" align="center" bgcolor="#0C3134" class="text">
																	<a href="/doctor/addclinic" style="text-decoration: none; color: rgb(255, 255, 255);" class="text">
																		Add Clinic
																	</a>
																</td>
															</tr>
														</table>
													</td>
												</tr>
												<tr>
													<td height="5" bgcolor="#F6F6F6">
														&nbsp;

													</td>
												</tr>
												<tr>
													<td height="23" align="center">
														<table width="97%" border="0" align="center" cellpadding="0" cellspacing="0">
															<tr>
																<td width="100%">
																	<table width="100%" border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td width="265" height="25" align="center" class="from_text5">
																				Clinic Name
																			</td>
																			<td width="120" align="center" class="from_text5">
																				Phone No.
																			</td>
																			<td width="300" align="center" class="from_text5">
																				Address
																			</td>
																			<td width="300" align="center" class="from_text5">
																				Actions<br />
																			</td>
																		</tr>
																	</table>

																</td>
															</tr>
															<tr>
																<td>
																	<table width="100%" border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td height="35">
																				<table width="100%" border="0" cellspacing="0" cellpadding="0">
																					<tr>
																						<td>

																						</td>
																					</tr>
																					<?php if(sizeof($clinics) >=1): ?>
																					<?php foreach($clinics as $row): ?>
																					<tr style="border-bottom: 5px solid rgb(255, 255, 255);">
																						<td>
																							<table width="100%" border="0" cellspacing="0" cellpadding="0">
																								<tr>
																									<td width="265" height="65" align="center" bgcolor="#ececec" class="from_text4">
																										<?php echo $row->name; ?>
																									</td>
																									<td width="120" height="65" align="center" bgcolor="#ececec" class="from_text4">
																										<?php echo $row->contact_number; ?>
																									</td>
																									<td width="300" height="65" align="center" bgcolor="#ececec" class="from_text4">
																										<?php echo $this->doctor_model->get_city_name($row->city_id).', '.$this->doctor_model->get_locality_name($row->location_id, $row->other_location); ?>
																									</td>
																									<td width="300" height="65" align="center" bgcolor="#ececec">
																										<table width="75%" border="0" cellspacing="0" cellpadding="0">
																											<tr>
																												<td width="96">
																													<a href="/doctor/editclinic/<?php echo $row->id; ?>"><img src="<?php echo IMAGE_URL; ?>Edit.png" width="96" height="32" class="edit-clinic-btn" /></a>
																												</td>
																												<td width="1">
																													&nbsp;
																												</td>
																												<td>
																													<img src="<?php echo IMAGE_URL; ?>Delete.png" style="cursor: pointer;" width="96" height="32" class="delete-clinic-btn" id="clinic<?php echo $row->id; ?>" />
																												</td>
																											</tr>
																										</table>
																									</td>
																								</tr>
																							</table>
																						</td>
																					</tr>
																					<?php endforeach; ?>
																					<?php endif; ?>
																					
																				</table>
																			</td>
																		</tr>
																		
																		<tr>
																			<!--<td class="from_text4-red">
																			Showing 1 to 1 of 1 entries
																			</td>-->
																		</tr>
																	</table>
																</td>
															</tr>
															<tr>
																<td align="center">
																	&nbsp;

																</td>
															</tr>
														</table>
													</td>
												</tr>
												<tr>
													<td height="23">
														&nbsp;
													</td>
												</tr>
												<tr>
													<td valign="top">
													</td>
												</tr>
												<tr>
													<td>
														&nbsp;

													</td>
												</tr>
												<tr>
													<td height="53" align="right" bgcolor="#f5f5f5">
														&nbsp;&nbsp;&nbsp;
													</td>
												</tr>
											</table>
										</td>
									</tr>
									<tr>
										<td>
											&nbsp;

										</td>
									</tr>
									<tr>
										<td>
											&nbsp;

										</td>
									</tr>
								</table>
							</td>
							<td width="53" valign="top">
								&nbsp;

							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td height="35" align="center" valign="middle" bgcolor="#033f44" class="text">
					© 2014 BookdrAppointment.com, All rights reserved 
				</td>
			</tr>
		</table>
	</body>
</html>
