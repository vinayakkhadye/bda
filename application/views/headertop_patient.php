<tr>
	<td height="27" bgcolor="#05325b">
		<table width="1006" border="0" align="right" cellpadding="0" cellspacing="0" class="pricetableCopy">
			<tr>
				<!--<td height="27" align="center" class="top_shape">
					<a target="_blank" href="/profile/doctor/<?php echo @$doctorid; ?>" style="text-decoration: none; color: #ffffff;">
						View Live profile
					</a>
				</td>-->
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td height="77" align="center" bgcolor="#eeeeee">
		<table width="1006" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td height="77" align="right">
					<table width="1007" border="0" align="center" cellpadding="0" cellspacing="0">
						<tr>
							<td width="318">
								<a href="/">
									<img src="<?php echo IMAGE_URL; ?>bda_logo.jpg" width="318" height="73" class="image-wrapper" />
								</a>
							</td>
							<td width="500">&nbsp;
								
							</td>
							<td>
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>
										<td width="47" align="center">
											<div
												id="circle" style="background:url(<?php
												if(!empty($userdetails->image))
												{
												if(substr($userdetails->image, 0, 4) == 'http')
												{
												echo $userdetails->image;
												}
												else
												{
												echo "/".$userdetails->image;
												}
												}
												else
												echo "http://graph.facebook.com/".$this->session->userdata('facebook_id')."/picture?type=normal";
												?>
												); background-size: 100%;">
											</div>
										</td>
										<td width="220">

											<div id="dd" class="wrapper-dropdown-5" tabindex="1">
												<?php echo $name; ?>
												<ul class="dropdown">
													<!--<li>
														<a href="/login">
															<i class="icon-user">
															</i>Profile
														</a>
													</li>-->
													<!--<li>
													<a href="#">
													<i class="icon-cog">
													</i>Settings
													</a>
													</li>-->
													<li>
														<a href="/logout">
															<i class="icon-remove">
															</i>Log out
														</a>
													</li>
												</ul>
											</div>
											<script type="text/javascript">

												function DropDown(el)
												{
													this.dd = el;
													this.initEvents();
												}
												DropDown.prototype =
												{
													initEvents : function()
													{
														var obj = this;
														obj.dd.on('click', function(event)
															{
																$(this).toggleClass('active');
																event.stopPropagation();
															});
													}
												}

												$(function()
													{
														var dd = new DropDown( $('#dd') );
														$(document).click(function()
															{
																// all dropdowns
																$('.wrapper-dropdown-5').removeClass('active');
															});
													});

											</script>
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