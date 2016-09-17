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
													<td height="23" align="center">
														&nbsp;
													</td>
												</tr>
												<tr>
													<td height="23" align="center">
														<table width="85%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td width="167" align="center">
																	<img src="<?php echo IMAGE_URL; ?>Sorry_mascot.png" width="266" height="426" />
																</td>
																<td width="460" align="center" valign="top">
																	<table width="100%" border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td align="center">
																				<span class="add_on_tetel">
																					We are Sorry!<br />
																					Your Transaction seems to have failed<br />
																				</span>
																			</td>
																		</tr>
																		<tr>
																			<td align="center">
																				<span class="from_textreview">
																					<br />
																					To continue with this payment we advise <br />
																					you to retry or try again after sometime.<br />
																				</span>
																			</td>
																		</tr>
																		<tr>
																			<td height="100" align="center">
																				<table width="68%" border="0" cellspacing="0" cellpadding="0">
																					<tr>
																						<td>
																							<a href="/payment/package/<?php echo $this->session->flashdata('packageid');?>"><img src="<?php echo IMAGE_URL; ?>please_try_again.jpg" width="168" height="56" /></a>
																						</td>
																						<td width="15">
																							&nbsp;
																						</td>
																						<td>
																							<a href="/doctor/packages"><img src="<?php echo IMAGE_URL; ?>back.jpg" width="168" height="56" /></a>
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
													<td height="23">
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
