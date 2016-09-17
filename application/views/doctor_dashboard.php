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
							<td width="1197" align="center" valign="top">
							<?php if(isset($sa_eligible)){ ?>
							<table width="97%" cellspacing="0" cellpadding="0" border="0" align="center">
          					<tbody>
								<tr>
									<td valign="top" height="22"></td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
								<td width="500" valign="top">
									<?php if(isset($sa_eligible)){ ?>
									<table width="100%" cellspacing="0" cellpadding="0" border="0">
										<tbody>
											<tr>
												<td bgcolor="#02687F" align="center">
													<a href="<?=BASE_URL?>doctor/scheduler"><img width="500" height="291" src="<?=IMAGE_URL?>shedular_icon_1.jpg"></a>
												</td>
											</tr>
											<tr>
												<td height="10"></td>
											</tr>
											<tr>
												<td><a href="<?=BASE_URL?>doctor/patient_manage"><img width="500" height="143" src="<?=IMAGE_URL?>my_patient_icon.jpg"></a></td>
											</tr>
										</tbody>
									</table>
									<?php }?>
								</td>
								<td width="14">&nbsp;</td>
								<td valign="top">
								<table width="100%" cellspacing="0" cellpadding="0" border="0">
									<tbody>
									<tr>
										<td><a href="<?=BASE_URL?>doctor/smartlisting"><img width="500" height="143" src="<?=IMAGE_URL?>my_profile_icon.jpg"></a></td>
									</tr>
									<tr>
										<td height="9"></td>
									</tr>
									<tr>
										<td><a href="<?=BASE_URL?>doctor/manageclinic"><img width="500" height="143" src="<?=IMAGE_URL?>My_clinic_icon.jpg"></a></td>
									</tr>
									<tr>
										<td height="9"></td>
									</tr>
									<?php if(isset($sa_eligible)){ ?>
									<!--<tr>
										<td><img width="500" height="143" src="<?=IMAGE_URL?>My_remainders_Icon.jpg"></td>
									</tr>-->
									<?php }?>
								</tbody>
								</table>
								</td>
								</tr>
								<tr>
									<td valign="top" height="22" colspan="3"></td>
								</tr>
							</tbody>
							</table>
							<?php }else{ ?>
							<table width="97%" cellspacing="0" cellpadding="0" border="0" align="center">
          					<tbody>
								<tr>
									<td valign="top" height="22"></td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
								</tr>
								<tr>
								<td width="500" valign="top">
									<a href="<?=BASE_URL?>doctor/smartlisting"><img width="500" height="143" src="<?=IMAGE_URL?>my_profile_icon.jpg"></a>
								</td>
								<td width="14">&nbsp;</td>
								<td valign="top">
								<table width="100%" cellspacing="0" cellpadding="0" border="0">
									<tbody>
									<tr>
										<td><a href="<?=BASE_URL?>doctor/manageclinic"><img width="500" height="143" src="<?=IMAGE_URL?>My_clinic_icon.jpg"></a></td>
									</tr>
									<tr>
										<td height="9"></td>
									</tr>
									
								</tbody>
								</table>
								</td>
								</tr>
								<tr>
									<td valign="top" height="22" colspan="3"></td>
								</tr>
							</tbody>
							</table>
							<?php }?>
							
							</td>
							<td width="53" valign="top">&nbsp;</td>
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
