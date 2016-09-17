<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>
			Book Dr Appointment
		</title>
				
		<script src="<?php echo JS_URL; ?>login/jquery.min.js"></script>
		<link href="<?php echo CSS_URL; ?>login/maine.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" type="text/css" href="<?php echo CSS_URL; ?>login/style.css" />
		<link type="text/css" rel="stylesheet" href="<?php echo CSS_URL; ?>login/bootstrap.min.css"/>

		<script type="text/javascript">
			$(document).ready(function()
				{
					
				});
		</script>
		
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
							<td class="top_bg2" bgcolor="#229B96">
								<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="pricetableCopy">
									<tr>
										<td width="135" height="41" bgcolor="#229B96">&nbsp;
											
										</td>
										<td width="35" align="center">
											<a href="/"><img src="<?php echo IMAGE_URL; ?>home_icon.jpg" width="23" height="23" /></a>
										</td>
										<td width="44" valign="bottom">
											<img src="<?php echo IMAGE_URL; ?>devaiter.jpg" width="44" height="40" />
										</td>
										<td class="text">
											Change Password
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
							<?php 
							if($this->session->userdata('usertype') == '2')
							{
								$this->load->view('doctor_sidebar');
							}
							else
							{
								if($this->session->userdata('usertype') == '1')
								$this->load->view('patient_sidebar'); 
							}
							?>
							<td width="53" valign="top">&nbsp;
								
							</td>
							<td width="985" valign="top">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td height="50">&nbsp;
											
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
																	Change Password
																</td>
																<td>&nbsp;
																	
																</td>
																<td width="150" align="center" class="text">&nbsp;
																	
																</td>
															</tr>
														</table>
													</td>
												</tr>
												<tr>
													<td height="23">&nbsp;
														
													</td>
												</tr>
												<tr>
													<td valign="top">
														<form action="" method="post">
															<table width="100%" border="0" cellspacing="0" cellpadding="0">
																<tr>
																	<td valign="top">
																		<table width="100%" border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				<td width="198">&nbsp;
																					
																				</td>
																				<td width="36">&nbsp;
																					
																				</td>
																				<td width="367">&nbsp;
																					
																				</td>
																				<td rowspan="6">&nbsp;
																					
																				</td>
																			</tr>
																			<tr>
																				<td height="29" align="right" class="from_text3">
																					Current Password
																					<span class="from_text4-red">
																						*
																					</span>
																				</td>
																				<td width="36">&nbsp;
																					
																				</td>
																				<td width="367">
																					<input name="oldpass" type="password" class="from_text_filed" id="oldpass" />
																				</td>
																			</tr>
																			<tr>
																				<td align="right">&nbsp;
																					
																				</td>
																				<td width="36">&nbsp;
																					
																				</td>
																				<td class="error_pass" >
																					<?php echo form_error('oldpass', '<p class="error_text">', '</p>'); ?>
																				</td>
																			</tr>
																			<tr>
																				<td align="right" class="from_text3">
																					New Password
																					<span class="from_text4-red">
																						*
																					</span>
																				</td>
																				<td width="36">&nbsp;
																					
																				</td>
																				<td width="367">
																					<input name="newpass" type="password" class="from_text_filed" id="newpass" />
																				</td>
																			</tr>
																			<tr>
																				<td align="right">&nbsp;
																					
																				</td>
																				<td width="36">&nbsp;
																					
																				</td>
																				<td width="367">
																					<?php echo form_error('newpass', '<p class="error_text">', '</p>'); ?>
																				</td>
																			</tr>
																			<tr>
																				<td align="right" class="from_text3">
																					Confirm Password
																					<span class="from_text4-red">
																						*
																					</span>
																				</td>
																				<td width="36">&nbsp;
																					
																				</td>
																				<td width="367">
																					<input name="cnfmnewpass" type="password" class="from_text_filed" id="cnfmnewpass" />
																				</td>
																			</tr>
																			<tr>
																				<td align="right">&nbsp;
																					
																				</td>
																				<td width="36">&nbsp;
																					
																				</td>
																				<td width="367">
																					<?php echo form_error('cnfmnewpass', '<p class="error_text">', '</p>'); ?>
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
																		</table>
																	</td>
																	<td width="145" align="center" valign="top">&nbsp;
																		
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
													<td height="53" align="right" bgcolor="#f5f5f5">
														<input type="image" src="<?=IMAGE_URL ?>submit.jpg" name="submit" width="121" height="40" />&nbsp;&nbsp;&nbsp;
														</form>
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
							<td width="53">&nbsp;
								
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>

	</body>

</html>
