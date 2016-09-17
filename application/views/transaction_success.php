<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>
			Book Dr Appointment
		</title>

		<script src="<?php echo JS_URL; ?>login/jquery.min.js"></script>

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
		</style>

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
											<img src="<?php echo IMAGE_URL; ?>home_icon.jpg" width="23" height="23" />
										</td>
										<td width="44" valign="bottom">
											&nbsp;
										</td>
										<td class="text">
											&nbsp;
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
													<td height="5" align="center" class="add_on_tetel">
														&nbsp;
													</td>
												</tr>
												<tr>
													<td height="5" align="center" class="add_on_tetel">
														Your Transaction was successfully processed!
													</td>
												</tr>
												<tr>
													<td height="23" align="center">
														&nbsp;
													</td>
												</tr>
												<tr>
													<td height="23" align="center">
														<table width="65%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td width="167" align="center">
																	<img src="<?php echo IMAGE_URL; ?>Transaction_successfully_mascot.png" width="140" height="362" />
																</td>
																<td width="460" align="left" valign="top">
																	<table width="80%" border="0" align="left" cellpadding="0" cellspacing="0">
																		<tr>
																			<td colspan="3" align="left" class="add_on_tetel_text">
																				<strong>
																					Transaction Summary
																				</strong>
																			</td>
																		</tr>
																		<tr>
																			<td width="145" align="right">
																				&nbsp;
																			</td>
																			<td width="26" align="center">
																				&nbsp;
																			</td>
																			<td width="219" align="center">
																				&nbsp;
																			</td>
																		</tr>
																		<tr>
																			<td width="145" align="left" class="from_tetel_text">
																				Transaction ID
																			</td>
																			<td align="center">
																				:
																			</td>
																			<td align="left" class="from_text4">
																				<?php echo $this->session->flashdata('transid');?>
																			</td>
																		</tr>
																		<tr>
																			<td width="145" align="left" class="from_tetel_text">
																				&nbsp;
																			</td>
																			<td align="center">
																				&nbsp;
																			</td>
																			<td align="left">
																				&nbsp;
																			</td>
																		</tr>
																		<tr>
																			<td width="145" align="left" class="from_tetel_text">
																				Payment Status
																			</td>
																			<td width="26" align="center">
																				:
																			</td>
																			<td align="left" class="from_text4">
																				<?php echo $this->session->flashdata('paymentstatus');?>
																			</td>
																		</tr>
																		<tr>
																			<td width="145" align="left">
																				&nbsp;
																			</td>
																			<td width="26" align="center">
																				&nbsp;
																			</td>
																			<td align="left">
																				&nbsp;
																			</td>
																		</tr>
																		<tr>
																			<td width="145" align="left" class="from_tetel_text">
																				Package Type
																			</td>
																			<td align="center">
																				:
																			</td>
																			<td align="left" class="from_text4">
																				<?php echo $this->session->flashdata('pack_type');?>
																			</td>
																		</tr>
																		<tr>
																			<td width="145" align="left" class="from_tetel_text">
																				&nbsp;
																			</td>
																			<td align="center">
																				&nbsp;
																			</td>
																			<td align="left" class="from_fileld">
																				&nbsp;
																			</td>
																		</tr>
																		<tr>
																			<td width="145" align="left" class="from_tetel_text">
																				Payment Type
																			</td>
																			<td width="26" align="center">
																				:
																			</td>
																			<td align="left" class="from_text4">
																				<?php echo $this->session->flashdata('pay_type');?>
																			</td>
																		</tr>
																		<tr>
																			<td width="145" align="left">
																				&nbsp;
																			</td>
																			<td width="26" align="center">
																				&nbsp;
																			</td>
																			<td align="left">
																				<span class="from_text4-red2">

																				</span>
																			</td>
																		</tr>
																		<tr>
																			<td width="145" align="left" class="from_tetel_text">
																				&nbsp;
																			</td>
																			<td align="center">
																				&nbsp;
																			</td>
																			<td align="left" class="from_fileld">
																				&nbsp;
																			</td>
																		</tr>
																		<tr>
																			<td width="145" align="left" class="from_tetel_text">
																				Amount
																			</td>
																			<td align="center">
																				:
																			</td>
																			<td align="left" class="from_text4">
																				<?php echo $this->session->flashdata('amount');?> INR
																			</td>
																		</tr>
																		<tr>
																			<td width="145" align="left">
																				&nbsp;
																			</td>
																			<td align="center">
																				&nbsp;
																			</td>
																			<td align="left" class="from_text4-red2">
																				&nbsp;
																			</td>
																		</tr>
																		<tr>
																			<td width="145" align="left" class="from_tetel_text">
																				Transaction Date
																			</td>
																			<td align="center">
																				:
																			</td>
																			<td align="left" class="from_text4">
																				<?php echo $this->session->flashdata('trans_date');?>
																			</td>
																		</tr>
																		<tr>
																			<td width="145" align="left">
																				&nbsp;
																			</td>
																			<td width="26" align="center">
																				&nbsp;
																			</td>
																			<td align="left">
																				&nbsp;
																			</td>
																		</tr>
																		<tr>
																			<td width="145" align="left" class="from_tetel_text">
																				Time
																			</td>
																			<td align="center">
																				:
																			</td>
																			<td align="left" class="from_text4">
																				<?php echo $this->session->flashdata('trans_time');?>
																			</td>
																		</tr>
																		<tr>
																			<td width="145" align="left">
																				&nbsp;
																			</td>
																			<td align="center">
																				&nbsp;
																			</td>
																			<td align="center">
																				&nbsp;
																			</td>
																		</tr>
																		<tr>
																			<td width="145" align="left">
																				&nbsp;
																			</td>
																			<td align="center">
																				&nbsp;
																			</td>
																			<td align="center">
																				&nbsp;
																			</td>
																		</tr>
																		<tr>
																			<td width="145" align="left">
																				&nbsp;
																			</td>
																			<td width="26" align="center">
																				&nbsp;
																			</td>
																			<td align="center">
																				&nbsp;
																			</td>
																		</tr>
																	</table>
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
													<td>
														&nbsp;
													</td>
												</tr>
												<tr>
													<td height="53" align="right" bgcolor="#f5f5f5">
														<a href="/doctor/onlinereputation"><img src="<?php echo IMAGE_URL; ?>get_started.jpg" width="168" height="56" hspace="10" /></a>
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
							<td width="53">
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
