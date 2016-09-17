<script type="text/javascript">
			function loading() {
		        // add the overlay with loading image to the page
		        var over = '<div id="overlay">' +
		        	'<div id="circle_loader">' +
		            	'<img id="loading" src="<?php echo BASE_URL;?>static/images/bdaloader.gif">' +
		            '</div>'+
		            '</div>';
		        $(over).appendTo('#calendar_td');
	        }
	        
	        function removeLoading() {
				$('#overlay').remove();
			}
</script>
<style type="text/css">
/*	Loading overlay CSS		*/
#overlay {
	position: fixed;
	left: 0;
	top: 0;
	bottom: 0;
	right: 0;
	background: #222;
	opacity: 0.7;
	filter: alpha(opacity=70);
	z-index: 999;
}
#loading {
	margin: -6px 0 0;
	opacity: 1;
}
#circle_loader {
	background-color: #fff;
	background-position: center center;
	border-radius: 50px;
	color: #ffffff;
	font-family: "Clarendon Lt BT";
	font-size: 26px;
	height: 92px;
	left: 47%;
	padding-top: 7px;
	position: absolute;
	text-align: center;
	text-decoration: none;
	top: 50%;
	width: 92px;
}
</style>

<tr>
	<td height="27" bgcolor="#05325b">
		<table width="1006" border="0" align="right" cellpadding="0" cellspacing="0" class="pricetableCopy">
			<tr>
				<td height="27" align="center" class="top_shape">
					<a target="_blank" href="/profile/doctor/<?php echo @$doctorid; ?>?ck=1" style="text-decoration: none; color: #ffffff;">
						View Live profile
					</a>
				</td>
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
													echo "/".$userdetails->image;
												} ?>
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