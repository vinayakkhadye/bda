<?php
if((isset($editclinic) && $editclinic == 'editclinic') && ($clinic_details->longitude != NULL))
{
	$latitude = $clinic_details->latitude;
	$longitude = $clinic_details->longitude;
	$latlong = $latitude.','.$longitude;
}
?>

<script src="https://maps.google.com/maps?file=api&v=3&key=AIzaSyCO8K3lZSCQgKMnmIyExMyglEI4s0FV4Uo">
</script>

<script type="text/javascript">

	var map = null;
	var geocoder = null;
	var marker = null;

	function initialize()
	{
		if (GBrowserIsCompatible())
		{
			map = new GMap2(document.getElementById("map_canvas"));
			map.setCenter(new GLatLng(20.593684, 78.96288), 1);
			map.setUIToDefault();
			geocoder = new GClientGeocoder();
			<?php if(isset($latlong)): ?>
				$("#googleaddress").val('<?php echo $latlong; ?>');
				$(".btngoogle").trigger('click');
				$("#googleaddress").val('');
			<?php endif; ?>
		}
	}

	function showAddress(address)
	{
		var a = document.getElementById("city");
		var ab = document.getElementById("city").value;
		if(ab != '')
		var b = a.options[a.selectedIndex].text;
		else
		var b = '';
		var newaddress = address+', '+b+', India';
		//console.log(newaddress);
		
		if (geocoder)
		{
			geocoder.getLatLng(
				address,
				function(point)
				{
					if (!point)
					{
						alert(address + " not found");
					} else
					{
						map.setCenter(point, 15);
						//console.log(typeof(marker));
						if(marker)
						{
							map.removeOverlay(marker);
						}
						marker = new GMarker(point, {draggable: true});
						//console.log(marker);
						map.addOverlay(marker);
						$("#latlong").val(marker.getLatLng().toUrlValue(6));
						GEvent.addListener(marker, "dragend", function()
							{
								//marker.openInfoWindowHtml(marker.getLatLng().toUrlValue(6));
								console.log(marker.getLatLng().toUrlValue(6));
								$("#latlong").val(marker.getLatLng().toUrlValue(6));
							});
						GEvent.addListener(marker, "click", function()
							{
								//marker.openInfoWindowHtml(marker.getLatLng().toUrlValue(6));
								console.log(marker.getLatLng().toUrlValue(6));
								$("#latlong").val(marker.getLatLng().toUrlValue(6));
							});
						GEvent.trigger(marker, "click");
					}
				}
			);
		}
	}
</script>



<?php
if(isset($clinic_details->image))
@$images = explode(',', @$clinic_details->image);

function get_base64($path = NULL)
{
	if($path != NULL){
		$type   = pathinfo($path, PATHINFO_EXTENSION);
		$data   = @file_get_contents($path);
		$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
		return $base64;
	}
}

function get_base64_value($path = NULL)
{
	if($path != NULL){
		$type   = pathinfo($path, PATHINFO_EXTENSION);
		$data   = @file_get_contents($path);
		$base64 = base64_encode($data);
		return $base64;
	}
}

function get_base64_name($path = NULL)
{
	if($path != NULL){
		$type   = pathinfo($path, PATHINFO_EXTENSION);
		$data   = @file_get_contents($path);
		$base64 = md5($path).'.'.$type;
		return $base64;
	}
}
?>
<script src="<?php echo JS_URL; ?>login/jquery.inputfile.js">
</script>
<script src="<?php echo JS_URL; ?>login/jquery-cropimg-plugin.js">
</script>
<script src="<?php echo JS_URL; ?>jquery.bpopup.min.js">
</script>
<script src="<?php echo JS_URL; ?>login/jquery.plugin.js">
</script>
<script src="<?php echo JS_URL; ?>login/jquery.timeentry.js">
</script>

<style type="text/css">
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
		width: 600px;
		border: 1px solid #aaa;
		background: #fff;
		overflow: hidden;
		background-repeat: no-repeat;
		cursor: move;
	}

	.imageBox .thumbBox
	{
		background: none repeat scroll 0 0 transparent;
		border: 1px solid rgb(102, 102, 102);
		box-shadow: 0 0 0 1000px rgba(0, 0, 0, 0.5);
		height: 300px;
		left: 28%;
		margin-left: -63px;
		margin-top: -154px;
		position: absolute;
		top: 50%;
		width: 400px;
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

	.clinicimage
	{
		cursor: pointer;
	}
	.remove-photo-x-btn
	{
		cursor: pointer;
	}
	.clinicimgdisplay
	{
		border: 1px solid #555;
		opacity: 0.2;
		<?php //if(!isset($clinic_details)): ?>
		margin-right: 20px;
		<?php //endif; ?>
	}
</style>
<script type="text/javascript">
	$(document).ready(function()
		{
			$(".clinicimage").click(function()
				{
					$(".modalbpopup").bPopup(
						{
							positionStyle: 'fixed',
							closeClass: 'modalclose'
						});
				});


			<?php
			if(isset($_POST['tele_fees']) && !empty($_POST['tele_fees']))
			echo "$('#example3').show();";
			if(isset($_POST['online_fees']) && !empty($_POST['online_fees']))
			echo "$('#example2').show();";
			if(isset($_POST['express_fees']) && !empty($_POST['express_fees']))
			echo "$('#example4').show();";
			?>
			$("#other_locality_btn").click(function()
				{
					$("#other_locality_btn").hide();
					$("#locality").hide();
					$("#locality").attr('disabled', true);
					$("#other_locality").show();
					$("#other_locality").attr('disabled', false);
					$(".select-frm-list-btn").css('display', 'inline');
				});

			$(".select-frm-list-btn").click(function()
				{
					$("#other_locality_btn").show();
					$("#locality").show();
					$("#locality").attr('disabled', false);
					$("#other_locality").hide();
					$("#other_locality").attr('disabled', true);
					$(".select-frm-list-btn").css('display', 'none');
				});


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

			<?php if(set_value('city') != '')
			{
				?>

				var city = $("#city").val();
				$("#other_locality_btn").show();
				$("#locality").show();
				$("#locality").attr('disabled', false);
				$("#other_locality").hide();
				$("#other_locality").attr('disabled', true);
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
							$('[name=locality] option').filter(function()
								{
									var a = "<?php echo set_value('locality'); ?>";
									return ($(this).val() == a);
								}).prop('selected', true);
						}
					});

				<?php
			}; ?>

			$("#locality").on('change', function()
			{
				if($("#locality option:selected").text().trim() != '')
				{
					var r = $("#locality option:selected").text().trim()+', '+$("#city option:selected").text().trim()+', India';
					$("#googleaddress").val(r);
					$(".btngoogle").trigger('click');
				}
			});
			
			//SET CURSOR POSITION
			$.fn.setCursorPosition = function(pos)
			{
				this.each(function(index, elem)
					{
						if (elem.setSelectionRange)
						{
							elem.setSelectionRange(pos, pos);
						} else if (elem.createTextRange)
						{
							var range = elem.createTextRange();
							range.collapse(true);
							range.moveEnd('character', pos);
							range.moveStart('character', pos);
							range.select();
						}
					});
				return this;
			};
			
			$("#googleaddress").on('focus', function()
			{
				var v = $("#googleaddress").val();
				if(v != '')
				{
					if(v.substr(0,2) == ' ,')
					{
						$("#googleaddress").setCursorPosition(0);
					}
					else
					{					
						$("#googleaddress").val(' ,'+v);
						$("#googleaddress").setCursorPosition(0);
					}
				}
			})
			
			$("#other_locality").on('blur', function()
			{
				var v = $("#googleaddress").val();
				var c = $("#other_locality").val();
				$("#googleaddress").val(c+' ,'+$("#city option:selected").text().trim()+', India');
				$(".btngoogle").trigger('click');
			});
			
			
			$("#city").on('change', function()
				{
					var city = $("#city").val();
					$("#other_locality_btn").show();
					$("#locality").show();
					$("#locality").attr('disabled', false);
					$("#other_locality").hide();
					$("#other_locality").attr('disabled', true);
					$(".select-frm-list-btn").css('display', 'none');
					
					$("#googleaddress").val($("#city option:selected").text().trim()+', India');
					$(".btngoogle").trigger('click');
					
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

			$(".day_time").timeEntry(
				{
					spinnerImage: '',
					timeSteps: [1, 5, 0],
					defaultTime: '09:00AM'
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

			<?php if(isset($editclinic) && $editclinic == 'editclinic'): ?>
			<?php if(isset($clinic_details->tele_fees))
			{ ?>
				if(<?php echo intval(@$clinic_details->tele_fees); ?> > 0)
				{
					$("#example3").show();
				}
				
			<?php }?>

			<?php if(isset($clinic_details->online_fees))
			{ ?>
				if(<?php echo intval(@$clinic_details->online_fees); ?> > 0)
				{
					$("#example2").show();
				}
			<?php } ?>
			
			<?php if(isset($clinic_details->express_fees))
			{?>
				if(<?php echo intval(@$clinic_details->express_fees); ?> > 0)
				{
					$("#example4").show();
				}
			<?php }?>
			<?php
			endif;
			if(isset($other_locality) && !empty($other_locality)):
			?>
			$("#other_locality_btn").hide();
			$("#locality").hide();
			$("#locality").attr('disabled', true);
			$("#other_locality").show();
			$("#other_locality").attr('disabled', false);
			$(".select-frm-list-btn").css('display', 'inline');
			<?php endif; ?>

			<?php
			if(isset($_POST['other_locality']) && !empty($_POST['other_locality'])):
			?>
			$("#other_locality_btn").hide();
			$("#locality").hide();
			$("#locality").attr('disabled', true);
			$("#other_locality").show();
			$("#other_locality").attr('disabled', false);
			$(".select-frm-list-btn").css('display', 'inline');
			<?php endif; ?>

			(function($)
				{
					$.ucfirst = function(str)
					{
						if(str.length > 0)
						{
							var text = str;
							var first = text.substr(0, 1).toUpperCase();
							var rest = text.substr(1);
							var words = first+rest;

							return words;
						}
					};
				})(jQuery);

			$(".from_text_filed, .from_text_area").keyup(function()
				{
					var value = $(this).val();
					$(this).val($.ucfirst(value));
				});

			//$(".clinicimgdisplay").css('display','inline');

			$(".clinicimage").click(function()
				{
					var imgid = this.id;
					var imgnumber = imgid.substr(12,1);
					console.log(imgnumber);
					$(".file").attr('id', 'file'+imgnumber);
					//console.log($(".file").attr('id'));
					var filebtnid = $(".file").attr('id');
					$("#"+filebtnid+"").trigger('click');

					$(".btnCrop").attr('id', imgnumber);
				});

			$(".remove-photo-x-btn").click(function()
				{
					var h = confirm('Are you sure you want to delete this photo?')
					if(h == true)
					{
						var id = this.id;
						$.ajax(
							{
								type:	'POST',
								url:	'/doctor/deleteclinicphoto',
								data:
								{
									'photoid'	:	id,
									'doctorid'	:	'<?php echo @$doctorid; ?>',
									'clinicid'	:	'<?php echo @$clinic_details->id; ?>'
								},
								success: function(e)
								{
									//console.log(e);
									location.reload();
								}
							});
					}
				});

			google.maps.event.addDomListener(window, 'load', initialize);
		
			
		});
							
</script>

<form id="sl_step2" class="sl_step2" name="sl_step2" method="POST" enctype="multipart/form-data" action="" style="display: none;">
	<input type="hidden" name="sl_step2" id="sl_step2" value="sl_step2" />
	<table width="100%" border="0" cellspacing="0" cellpadding="0" id="sl_step2">
		<tr>
			<td bgcolor="#FFFFFF">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="192">&nbsp;
							
						</td>
						<td width="35">&nbsp;
							
						</td>
						<td width="450">&nbsp;
							
						</td>
						<td width="126">&nbsp;
							
						</td>
					</tr>
					<tr>
						<td align="right" class="from_text3">
							Clinic/Hospital Name
							<span class="from_text4-red">
								*
							</span>
						</td>
						<td width="35">&nbsp;
							
						</td>
						<td colspan="2">
							<input name="clinic_name" value="<?php echo set_value('clinic_name', @$clinic_details->name); ?>" type="text" class="from_text_filed" id="textfield12" />
						</td>
					</tr>
					<tr>
						<td align="right">&nbsp;
							
						</td>
						<td width="36">&nbsp;
							
						</td>
						<td class="error_message" >
							<?php echo form_error('clinic_name', '<p class="error_text">', '</p>'); ?>
						</td>
					</tr>

					<?php
					if(isset($sor_eligible)): ?>
					<tr>
						<td align="right" class="from_text3">
							Clinic/Hospital Photos
							<span class="from_text4-red">

							</span>
						</td>
						<td width="35">&nbsp;
							
						</td>
						<td width="35">
							<p style="color: rgb(26, 102, 84); font-weight: bold;">
								Please click on the number below to upload a photo
							</p>
						</td>
					</tr>
					<input type="hidden" name="clinicphotoimg1" id="clinicphotoimg1" value="<?php
					if(isset($clinic_details) && !empty($images[0])) echo get_base64_value(@$images[0]); ?>" />
					<input type="hidden" name="clinicphotoname1" id="clinicphotoname1" value="<?php
					if(isset($clinic_details) && !empty($images[0])) echo get_base64_name(@$images[0]); ?>" />

					<input type="hidden" name="clinicphotoimg2" id="clinicphotoimg2" value="<?php
					if(isset($clinic_details) && !empty($images[1])) echo get_base64_value(@$images[1]); ?>" />
					<input type="hidden" name="clinicphotoname2" id="clinicphotoname2" value="<?php
					if(isset($clinic_details) && !empty($images[1])) echo get_base64_name(@$images[1]); ?>" />

					<input type="hidden" name="clinicphotoimg3" id="clinicphotoimg3" value="<?php
					if(isset($clinic_details) && !empty($images[2])) echo get_base64_value(@$images[2]); ?>" />
					<input type="hidden" name="clinicphotoname3" id="clinicphotoname3" value="<?php
					if(isset($clinic_details) && !empty($images[2])) echo get_base64_name(@$images[2]); ?>" />

					<input type="hidden" name="clinicphotoimg4" id="clinicphotoimg4" value="<?php
					if(isset($clinic_details) && !empty($images[3])) echo get_base64_value(@$images[3]); ?>" />
					<input type="hidden" name="clinicphotoname4" id="clinicphotoname4" value="<?php
					if(isset($clinic_details) && !empty($images[3])) echo get_base64_name(@$images[3]); ?>" />

					<input type="hidden" name="clinicphotoimg5" id="clinicphotoimg5" value="<?php
					if(isset($clinic_details) && !empty($images[4])) echo get_base64_value(@$images[4]); ?>" />
					<input type="hidden" name="clinicphotoname5" id="clinicphotoname5" value="<?php
					if(isset($clinic_details) && !empty($images[4])) echo get_base64_name(@$images[4]); ?>" />


					<tr id="clinic-photos-display-boxes">
						<td align="right" class="from_text3">&nbsp;
							
						</td>
						<td width="35">&nbsp;
							
						</td>
						<td colspan="2">
							<img id="imagedisplay1" class="clinicimgdisplay clinicimage" width="100" height="75"
							<?php
							if(isset($clinic_details) && !empty($images[0]))
							echo 'src="'.get_base64(@$images[0]).'" style="display: inline; opacity:1; border:0; margin-right:0;" />  <img src="'.IMAGE_URL.'xclose.png" id="1" class="remove-photo-x-btn" style="position: relative; top: -37px; left: -19px;" ';
							else
							echo 'style="display: inline;" src="'.IMAGE_URL.'clinic_dummy/c1.png" ';
							?>
							/>
							<img id="imagedisplay2" class="clinicimgdisplay clinicimage" width="100"  height="75"
							<?php
							if(isset($clinic_details) && !empty($images[1]))
							echo 'src="'.get_base64(@$images[1]).'" style="display: inline; opacity:1; border:0; margin-right:0;" />  <img src="'.IMAGE_URL.'xclose.png" id="2" class="remove-photo-x-btn" style="position: relative; top: -37px; left: -19px;" ';
							else
							echo 'style="display: inline;" src="'.IMAGE_URL.'clinic_dummy/c2.png" ';
							?>
							/>
							<img id="imagedisplay3" class="clinicimgdisplay clinicimage" width="100"  height="75"
							<?php
							if(isset($clinic_details) && !empty($images[2]))
							echo 'src="'.get_base64(@$images[2]).'" style="display: inline; opacity:1; border:0; margin-right:0;" />  <img src="'.IMAGE_URL.'xclose.png" id="3" class="remove-photo-x-btn" style="position: relative; top: -37px; left: -19px;" ';
							else
							echo 'style="display: inline;" src="'.IMAGE_URL.'clinic_dummy/c3.png" ';
							?>
							/>
							<img id="imagedisplay4" class="clinicimgdisplay clinicimage" width="100"  height="75"
							<?php
							if(isset($clinic_details) && !empty($images[3]))
							echo 'src="'.get_base64(@$images[3]).'" style="display: inline; opacity:1; border:0; margin-right:0;" />  <img src="'.IMAGE_URL.'xclose.png" id="4" class="remove-photo-x-btn" style="position: relative; top: -37px; left: -19px;" ';
							else
							echo 'style="display: inline;" src="'.IMAGE_URL.'clinic_dummy/c4.png" ';
							?>
							/>
							<img id="imagedisplay5" class="clinicimgdisplay clinicimage" width="100"  height="75"
							<?php
							if(isset($clinic_details) && !empty($images[4]))
							echo 'src="'.get_base64(@$images[4]).'" style="display: inline; opacity:1; border:0; margin-right:0;" />  <img src="'.IMAGE_URL.'xclose.png" id="5" class="remove-photo-x-btn" style="position: relative; top: -37px; left: -19px;" ';
							else
							echo 'style="display: inline;" src="'.IMAGE_URL.'clinic_dummy/c5.png" ';
							?>
							/>
						</td>
					</tr>
					<tr>
						<td align="right">&nbsp;
							
						</td>
						<td width="36">&nbsp;
							
						</td>
						<td class="" >

						</td>
					</tr>

					<?php endif; ?>

					<tr>
						<td align="right" valign="top" class="from_text3">
							Clinic/Hospital Address
							<span class="from_text4-red">
								*
							</span>
						</td>
						<td width="35">&nbsp;
							
						</td>
						<td colspan="2">
							<textarea name="clinic_address" cols="45" rows="5" class="from_text_area" id="textarea"><?php echo set_value('clinic_address', @$clinic_details->address); ?></textarea>
						</td>
					</tr>
					<tr>
						<td align="right">&nbsp;
							
						</td>
						<td width="36">&nbsp;
							
						</td>
						<td class="error_message" >
							<?php echo form_error('clinic_address', '<p class="error_text">', '</p>'); ?>
						</td>
					</tr>


					<tr>
						<td align="right" class="from_text3">
							City
							<span class="from_text4-red">
								*
							</span>
						</td>
						<td>&nbsp;
							
						</td>
						<td colspan="2">
							<select name="city" class="from_list_menu" id="city">
								<option value="">
									Select Your City
								</option>
								<?php
								foreach($cities as $row): ?>
								<option value="<?php echo $row->id; ?>"
									<?php
									if(@$clinic_details->city_id == $row->id)
									echo 'selected="selected"';
									elseif(set_value('city') == $row->id)
									echo 'selected="selected"';
									?> >
									<?php echo $row->name; ?>
								</option>
								<?php endforeach; ?>
							</select>
						</td>
					</tr>
					<tr>
						<td align="right">&nbsp;
							
						</td>
						<td width="36">&nbsp;
							
						</td>
						<td class="error_message" >
							<?php echo form_error('city', '<p class="error_text">', '</p>'); ?>
						</td>
					</tr>

					<tr>
						<td align="right" class="from_text3">
							Locality
							<span class="from_text4-red">
								*
							</span>
						</td>
						<td>&nbsp;
							
						</td>
						<td colspan="2">
							<select name="locality" class="from_list_menu" id="locality">
								<option value="">
									Select Your Locality
								</option>
								<?php
								foreach($localities as $row): ?>
								<option value="<?php echo $row->id; ?>"
								<?php
								if(@$clinic_details->location_id == $row->id)
								echo 'selected="selected"';
								elseif(set_value('locality') == $row->id)
								echo 'selected="selected"';
								?> >
									<?php echo $row->name; ?>
								</option>
								<?php endforeach; ?>

							</select>
							<input type="text" value="<?php
							if(isset($_POST['other_locality']) && !empty($_POST['other_locality']))
							echo $_POST['other_locality'];
							else
							echo @$other_locality;
							?>" class="from_text_filed" id="other_locality" name="other_locality" style="display: none;" disabled="disabled" />
							<a href="javascript:void(0);" style="text-decoration: none; width: 20px; height: 20px; background-color: rgb(255, 120, 61); color: rgb(255, 255, 255); margin-left: 20px; padding: 6px 20px; font-size: 14px;" id="other_locality_btn">
								<span style="">
									Other
								</span>
							</a>

							<div class="select-frm-list-btn" style="padding: 7px 9px 6px; background-color: rgb(255, 120, 61); width: 111px; color: rgb(255, 255, 255); display: none; cursor: pointer;">
								Select from list
							</div>

						</td>
					</tr>
					<tr>
						<td align="right">&nbsp;
							
						</td>
						<td width="36">&nbsp;
							
						</td>
						<td class="error_message" >
							<?php echo form_error('locality', '<p class="error_text">', '</p>'); ?>
						</td>
					</tr>

					<tr>
						<td align="right" valign="top" class="from_text3">
							Pincode
							<span class="from_text4-red">
								*
							</span>
						</td>
						<td>&nbsp;
							
						</td>
						<td>
							<input name="pincode" value="<?php echo set_value('pincode', @$clinic_details->pincode); ?>" type="text" class="date" id="textfield4" value=" " placeholder="Pincode" />
						</td>
						<td>&nbsp;
							
						</td>
					</tr>
					<tr>
						<td align="right">&nbsp;
							
						</td>
						<td width="36">&nbsp;
							
						</td>
						<td class="error_message" >
							<?php echo form_error('pincode', '<p class="error_text">', '</p>'); ?>
						</td>
					</tr>
					
					<tr>
						<td align="right" valign="top" class="from_text3">&nbsp;
							
						</td>
						<td>&nbsp;
							
						</td>
						<td>
							<p style="color: rgb(49, 85, 247); text-align: center; font-weight: bold; width: 470px;">
							Locate your clinic by dragging the location pointer <img src="//maps.gstatic.com/mapfiles/markers2/marker.png" style="height: 26px;"/>
							<br/>OR<br/>
							If you do not find the exact location, choose the nearest landmark
							</p>
						</td>
						<td>&nbsp;
							
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>





	<p style="padding: 0px; border: 0px none; margin: -27px 0px 0px;">
		<input type="text" style="width: 350px; position: relative; top: 50px; z-index: 10; left: 70px; padding: 2px 5px;" id="googleaddress" value="" placeholder="Locality" />
		<input type="button" class="btngoogle" value="Find Location" onclick="showAddress(document.getElementById('googleaddress').value); return false" />
	</p>
	<style>
		.btngoogle
		{
			background: #4589F7;
			background-image: -webkit-linear-gradient(top, #4589F7, #4589F7);
			background-image: -moz-linear-gradient(top, #4589F7, #4589F7);
			background-image: -ms-linear-gradient(top, #4589F7, #4589F7);
			background-image: -o-linear-gradient(top, #4589F7, #4589F7);
			background-image: linear-gradient(to bottom, #4589F7, #4589F7);
			font-family: Arial;
			color: #ffffff;
			font-size: 14px;
			left: 65px;
			padding: 2px 10px;
			position: relative;
			text-decoration: none;
			top: 50px;
			z-index: 20;
		}
	</style>
	<div id="map_canvas" style="width: 100%; height: 300px"></div>
	
	<input type="hidden" name="latlong" id="latlong" value="<?php echo @$latlong; ?>" />

	<table width="100%" border="0" cellspacing="0" cellpadding="0" id="sl_step2">
		<tr>
			<td bgcolor="#FFFFFF">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="192">&nbsp;
							
						</td>
						<td width="35">&nbsp;
							
						</td>
						<td width="450">&nbsp;
							
						</td>
						<td width="126">&nbsp;
							
						</td>
					</tr>
					<tr>
						<td align="right" valign="top" class="from_text3">
							Clinic / Hospital Landline No
							<span class="from_text4-red">
								*
							</span>
						</td>
						<td>&nbsp;
							
						</td>
						<?php
						if(isset($editclinic) && $editclinic == 'editclinic'){
							$cl_number = explode('-',$clinic_details->contact_number,2);
						}
						?>
						<td>
							<input name="clinic_number_code" value="<?php echo set_value('clinic_number_code', @$cl_number[0]); ?>" style="width: 50px;padding-left: 5px;" placeholder="Code" type="text" class="from_text_filed" id="textfield12" />
							<input name="clinic_number" value="<?php echo set_value('clinic_number', @$cl_number[1]); ?>" style="width: 300px;padding-left: 5px;" type="text" placeholder="Number" class="from_text_filed" id="textfield12" />
						</td>
						<td>&nbsp;
							
						</td>
					</tr>
					<tr>
						<td align="right">&nbsp;
							
						</td>
						<td width="36">&nbsp;
							
						</td>
						<td class="error_message" >
							<?php echo form_error('clinic_number', '<p class="error_text">', '</p>'); ?>
							<?php echo form_error('clinic_number_code', '<p class="error_text">', '</p>'); ?>
						</td>
					</tr>
					<tr>
						<td align="right" class="from_text3">
							Consultation Days &amp; Timings
						</td>
						<td colspan="2">
							<span class="from_text3">
								<span class="add_on_text_2">
									(Note)
									<span class="from_text4-red">
										*
									</span>
								</span>
							</span>
						</td>
						<td>&nbsp;
							
						</td>
					</tr>
					<tr>
						<td colspan="4" align="left">&nbsp;
							
						</td>
					</tr>
					<tr>
						<td height="28" colspan="4" align="left" bgcolor="#083631" class="from_tetel_text_tt">
							If your Practice Timing at the Selected Clinic is :
						</td>
					</tr>
					<tr>
						<td colspan="4" align="center" >
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="333" height="115" align="center" valign="top" bgcolor="#39c0b1">
										<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
											<tr>
												<td width="75" height="35" align="center" bgcolor="#083631" class="from_tetel_text_case">
													Case (1)
												</td>
												<td width="10">&nbsp;
													
												</td>
												<td class="text">
													<strong>
														Same on all Days :
													</strong>
												</td>
											</tr>
											<tr>
												<td height="35" colspan="3" align="center" class="from_tetel_text_case">
													<span class="from_tetel_text_case_text_2">
														<span class="from_tetel_text2">
															<strong>
																:
															</strong>
														</span>
														<span class="not_text1">
															Click
														</span>
														<span class="tetecon">
															'Copy to all Days'
														</span><br />
														In case you dont Practice
														<span data-term="goog_1914360007" tabindex="0">
															on Sunday
														</span>, just deselect the Checkbox for
														<span data-term="goog_1914360008" tabindex="0">
															Sunday
														</span>.
													</span>
												</td>
											</tr>
										</table>
									</td>
									<td width="333" align="center" valign="top" bgcolor="#ff764a">
										<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
											<tr>
												<td width="75" height="35" align="center" bgcolor="#083631" class="from_tetel_text_case2">
													Case (2)
												</td>
												<td width="10">&nbsp;
													
												</td>
												<td class="text">
													<strong>
														Different on Different Days
													</strong>
												</td>
											</tr>
											<tr>
												<td height="35" colspan="3" align="center" class="from_tetel_text_case">
													<span class="from_tetel_text_case_text_2">
														<span class="not_text1">
															Click
														</span>
														<span class="from_tetel_text_case22">
															'Copy to all Days'
														</span><br />
														<span class="not_text1">
															and then deselect the checkbox for the day that you want to change the time &amp; fill in &nbsp;your Practice Time
														</span>
													</span>
												</td>
											</tr>
										</table>
									</td>
									<td width="333" align="center" valign="top" bgcolor="#ffb500">
										<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
											<tr>
												<td width="75" height="35" align="center" bgcolor="#083631" class="from_tetel_text_case3">
													Case (3)
												</td>
												<td width="10">&nbsp;
													
												</td>
												<td class="text">
													<strong>
														Different on all Days :
													</strong>
												</td>
											</tr>
											<tr>
												<td height="35" colspan="3" align="center" class="from_tetel_text_case">
													<span class="from_tetel_text_case_text_2">
														Fill in the Time in each Tab individually
													</span>
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td align="right" class="from_text3">&nbsp;
							
						</td>
						<td>&nbsp;
							
						</td>
						<td>&nbsp;
							
						</td>
						<td>&nbsp;
							
						</td>
					</tr>
					<tr>
						<td colspan="4" align="center" valign="top" class="from_text3">
							<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
								<tr>
									<td width="595">
										<table width="595" border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td width="15">&nbsp;
													
												</td>
												<td width="122" align="center">
													<img src="<?php echo IMAGE_URL; ?>morning.jpg" width="119" height="28" />
												</td>
												<td width="170">&nbsp;
													
												</td>
												<td width="119">
													<img src="<?php echo IMAGE_URL; ?>evening.jpg" width="119" height="28" />
												</td>
												<td align="center" class="from_tetel_text2">
													<a href="javascript:void(0)" id="copy_to_all_days">
														Copy to all days
													</a>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								<tr>
									<td bgcolor="#0c3134">
										<?php
										if(isset($editclinic) && $editclinic == 'editclinic'):
										if(isset($_GET['t']))
										{
											print_r($clinic_timings[1]);exit;
										}
										
										?>
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
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
										<?php
										else: ?>
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td height="10" colspan="9" align="center" class="from_fileld">
												</td>
											</tr>
											<tr>
												<td width="80" align="center" class="from_fileld">
													Monday
												</td>
												<td width="82" align="center">
													<input name="mon_mor_open" type="text" class="day_time date2" id="mon_mor_open" value="<?php echo isset($_POST['mon_mor_open']) ? $_POST['mon_mor_open'] : '10:00AM'; ?>" />
												</td>
												<td width="35" align="center" class="from_fileld">
													to
												</td>
												<td width="82" align="center">
													<input name="mon_mor_close" type="text" class="day_time date2" id="mon_mor_close" value="<?php echo isset($_POST['mon_mor_close']) ? $_POST['mon_mor_close'] : '01:00PM'; ?>" />
												</td>
												<td width="35" align="center">&nbsp;
													
												</td>
												<td width="82" align="center">
													<input name="mon_eve_open" type="text" class="day_time date2" id="mon_eve_open" value="<?php echo isset($_POST['mon_eve_open']) ? $_POST['mon_eve_open'] : '05:00PM'; ?>" />
												</td>
												<td width="35" align="center">
													<span class="from_fileld">
														to
													</span>
												</td>
												<td width="82" align="center">
													<input name="mon_eve_close" type="text" class="day_time date2" id="mon_eve_close" value="<?php echo isset($_POST['mon_eve_close']) ? $_POST['mon_eve_close'] : '08:00PM'; ?>" />
												</td>
												<td align="center">
													<input name="days[]" type="checkbox" class="checkbox_valid" id="mon" value="monday" checked="checked" />
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
													<input name="tue_mor_open" type="text" class="day_time date2" id="tue_mor_open" value="<?php echo isset($_POST['tue_mor_open']) ? $_POST['tue_mor_open'] : "10:00AM" ; ?>" />
												</td>
												<td align="center" class="from_fileld">
													to
												</td>
												<td align="center">
													<input name="tue_mor_close" type="text" class="day_time date2" id="tue_mor_close" value="<?php echo isset($_POST['tue_mor_close']) ? $_POST['tue_mor_close'] : "01:00PM" ; ?>"/>
												</td>
												<td align="center">&nbsp;
													
												</td>
												<td align="center">
													<input name="tue_eve_open" type="text" class="day_time date2" id="tue_eve_open" value="<?php echo isset($_POST['tue_eve_open']) ? $_POST['tue_eve_open'] : "05:00PM" ; ?>" />
												</td>
												<td align="center">
													<span class="from_fileld">
														to
													</span>
												</td>
												<td align="center">
													<input name="tue_eve_close" type="text" class="day_time date2" id="tue_eve_close" value="<?php echo isset($_POST['tue_eve_close']) ? $_POST['tue_eve_close'] : "08:00PM" ; ?>" />
												</td>
												<td align="center">
													<input name="days[]" type="checkbox" class="checkbox_valid" id="tue" value="tuesday" checked="checked" />
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
													<input name="wed_mor_open" type="text" class="day_time date2" id="wed_mor_open" value="<?php echo isset($_POST['wed_mor_open']) ? $_POST['wed_mor_open'] : "10:00AM" ; ?>" />
												</td>
												<td align="center" class="from_fileld">
													to
												</td>
												<td align="center">
													<input name="wed_mor_close" type="text" class="day_time date2" id="wed_mor_close" value="<?php echo isset($_POST['wed_mor_close']) ? $_POST['wed_mor_close'] : "01:00PM" ; ?>" />
												</td>
												<td align="center">&nbsp;
													
												</td>
												<td align="center">
													<input name="wed_eve_open" type="text" class="day_time date2" id="wed_eve_open" value="<?php echo isset($_POST['wed_eve_open']) ? $_POST['wed_eve_open'] : "05:00PM" ; ?>" />
												</td>
												<td align="center">
													<span class="from_fileld">
														to
													</span>
												</td>
												<td align="center">
													<input name="wed_eve_close" type="text" class="day_time date2" id="wed_eve_close" value="<?php echo isset($_POST['wed_eve_close']) ? $_POST['wed_eve_close'] : "08:00PM" ; ?>" />
												</td>
												<td align="center">
													<input name="days[]" type="checkbox" class="checkbox_valid" id="wed" value="wednesday" checked="checked" />
												</td>
											</tr>
											<tr>
												<td height="1" colspan="9" align="center" bgcolor="#FFFFFF">
												</td>
											</tr>
											<tr>
												<td align="center" class="from_fileld">
													Thursday
												</td>
												<td align="center">
													<input name="thu_mor_open" type="text" class="day_time date2" id="thu_mor_open" value="<?php echo isset($_POST['thu_mor_open']) ? $_POST['thu_mor_open'] : "10:00AM" ; ?>" />
												</td>
												<td align="center" class="from_fileld">
													to
												</td>
												<td align="center">
													<input name="thu_mor_close" type="text" class="day_time date2" id="thu_mor_close" value="<?php echo isset($_POST['thu_mor_close']) ? $_POST['thu_mor_close'] : "01:00PM" ; ?>" />
												</td>
												<td align="center">&nbsp;
													
												</td>
												<td align="center">
													<input name="thu_eve_open" type="text" class="day_time date2" id="thu_eve_open" value="<?php echo isset($_POST['thu_eve_open']) ? $_POST['thu_eve_open'] : "05:00PM" ; ?>" />
												</td>
												<td align="center">
													<span class="from_fileld">
														to
													</span>
												</td>
												<td align="center">
													<input name="thu_eve_close" type="text" class="day_time date2" id="thu_eve_close" value="<?php echo isset($_POST['thu_eve_close']) ? $_POST['thu_eve_close'] : "08:00PM" ; ?>" />
												</td>
												<td align="center">
													<input name="days[]" type="checkbox" class="checkbox_valid" id="thu" value="thursday" checked="checked" />
												</td>
											</tr>
											<tr>
												<td height="1" colspan="9" align="center" bgcolor="#FFFFFF">
												</td>
											</tr>
											<tr>
												<td align="center" class="from_fileld">
													Friday
												</td>
												<td align="center">
													<input name="fri_mor_open" type="text" class="day_time date2" id="fri_mor_open" value="<?php echo isset($_POST['fri_mor_open']) ? $_POST['fri_mor_open'] : "10:00AM" ; ?>" />
												</td>
												<td align="center" class="from_fileld">
													to
												</td>
												<td align="center">
													<input name="fri_mor_close" type="text" class="day_time date2" id="fri_mor_close" value="<?php echo isset($_POST['fri_mor_close']) ? $_POST['fri_mor_close'] : "01:00PM" ; ?>" />
												</td>
												<td align="center">&nbsp;
													
												</td>
												<td align="center">
													<input name="fri_eve_open" type="text" class="day_time date2" id="fri_eve_open" value="<?php echo isset($_POST['fri_eve_open']) ? $_POST['fri_eve_open'] : "05:00PM" ; ?>" />
												</td>
												<td align="center">
													<span class="from_fileld">
														to
													</span>
												</td>
												<td align="center">
													<input name="fri_eve_close" type="text" class="day_time date2" id="fri_eve_close" value="<?php echo isset($_POST['fri_eve_close']) ? $_POST['fri_eve_close'] : "08:00PM" ; ?>" />
												</td>
												<td align="center">
													<input name="days[]" type="checkbox" class="checkbox_valid" id="fri" value="friday" checked="checked" />
												</td>
											</tr>
											<tr>
												<td height="1" colspan="9" align="center" bgcolor="#FFFFFF">
												</td>
											</tr>
											<tr>
												<td align="center" class="from_fileld">
													Saturday
												</td>
												<td align="center">
													<input name="sat_mor_open" type="text" class="day_time date2" id="sat_mor_open" value="<?php echo isset($_POST['sat_mor_open']) ? $_POST['sat_mor_open'] : "10:00AM" ; ?>" />
												</td>
												<td align="center" class="from_fileld">
													to
												</td>
												<td align="center">
													<input name="sat_mor_close" type="text" class="day_time date2" id="sat_mor_close" value="<?php echo isset($_POST['sat_mor_close']) ? $_POST['sat_mor_close'] : "01:00PM" ; ?>" />
												</td>
												<td align="center">&nbsp;
													
												</td>
												<td align="center">
													<input name="sat_eve_open" type="text" class="day_time date2" id="sat_eve_open" value="<?php echo isset($_POST['sat_eve_open']) ? $_POST['sat_eve_open'] : "05:00PM" ; ?>" />
												</td>
												<td align="center">
													<span class="from_fileld">
														to
													</span>
												</td>
												<td align="center">
													<input name="sat_eve_close" type="text" class="day_time date2" id="sat_eve_close" value="<?php echo isset($_POST['sat_eve_close']) ? $_POST['sat_eve_close'] : "08:00PM" ; ?>" />
												</td>
												<td align="center">
													<input name="days[]" type="checkbox" class="checkbox_valid" id="sat" value="saturday" checked="checked" />
												</td>
											</tr>
											<tr>
												<td height="1" colspan="9" align="center" bgcolor="#FFFFFF">
												</td>
											</tr>
											<tr>
												<td align="center" class="from_fileld">
													Sunday
												</td>
												<td align="center">
													<input name="sun_mor_open" type="text" class="day_time date2" id="sun_mor_open" value="<?php echo isset($_POST['sun_mor_open']) ? $_POST['sun_mor_open'] : "10:00AM" ; ?>" />
												</td>
												<td align="center">
													<span class="from_fileld">
														to
													</span>
												</td>
												<td align="center">
													<input name="sun_mor_close" type="text" class="day_time date2" id="sun_mor_close" value="<?php echo isset($_POST['sun_mor_close']) ? $_POST['sun_mor_close'] : "01:00PM" ; ?>" />
												</td>
												<td align="center">&nbsp;
													
												</td>
												<td align="center">
													<input name="sun_eve_open" type="text" class="day_time date2" id="sun_eve_open" value="<?php echo isset($_POST['sun_eve_open']) ? $_POST['sun_eve_open'] : "05:00PM" ; ?>" />
												</td>
												<td align="center">
													<span class="from_fileld">
														to
													</span>
												</td>
												<td align="center">
													<input name="sun_eve_close" type="text" class="day_time date2" id="sun_eve_close" value="<?php echo isset($_POST['sun_eve_close']) ? $_POST['sun_eve_close'] : "08:00PM" ; ?>" />
												</td>
												<td align="center">
													<input name="days[]" type="checkbox" class="checkbox_valid" id="sun" value="sunday" checked="checked" />
												</td>
											</tr>
										</table>
										<?php endif; ?>
									</td>
								</tr>
							</table>&nbsp;
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
					<tr>
						<td align="right">
							<span class="from_text3">
								First Consultation Fees
								<!--<span class="from_text4-red">
								*
								</span>-->
							</span>
						</td>
						<td>&nbsp;
							
						</td>
						<td>
							<?php
							if(isset($clinic_details->consultation_fees) && $clinic_details->consultation_fees != '' && $clinic_details->consultation_fees!= NULL):
							?>
							<input type="radio" name="consult_fee" value="1" <?php if($clinic_details->consultation_fees == '1') echo ' checked="checked"'; ?> />Rs. 100~300 &nbsp;&nbsp;&nbsp;
							<input type="radio" name="consult_fee" value="2" <?php if($clinic_details->consultation_fees == '2') echo ' checked="checked"'; ?> />Rs. 301~500 &nbsp;&nbsp;&nbsp;
							<input type="radio" name="consult_fee" value="3" <?php if($clinic_details->consultation_fees == '3') echo ' checked="checked"'; ?> />Rs. 501~750 &nbsp;&nbsp;&nbsp;
							<input type="radio" name="consult_fee" value="4" <?php if($clinic_details->consultation_fees == '4') echo ' checked="checked"'; ?> />Rs. 751~1000 &nbsp;&nbsp;&nbsp;
							<input type="radio" name="consult_fee" value="5" <?php if($clinic_details->consultation_fees == '5') echo ' checked="checked"'; ?> /> more than Rs. 1000
							<?php
							else:
							//print_r($_POST);
							?>							 
							<input type="radio" name="consult_fee" value="1" <?php if(@$_POST['consult_fee'] == '1') echo ' checked="checked"'; ?> />Rs. 100~300 &nbsp;&nbsp;&nbsp;
							<input type="radio" name="consult_fee" value="2" <?php if(@$_POST['consult_fee'] == '2') echo ' checked="checked"'; ?> />Rs. 301~500 &nbsp;&nbsp;&nbsp;
							<input type="radio" name="consult_fee" value="3" <?php if(@$_POST['consult_fee'] == '3') echo ' checked="checked"'; ?> />Rs. 501~750 &nbsp;&nbsp;&nbsp;
							<input type="radio" name="consult_fee" value="4" <?php if(@$_POST['consult_fee'] == '4') echo ' checked="checked"'; ?> />Rs. 751~1000 &nbsp;&nbsp;&nbsp;
							<input type="radio" name="consult_fee" value="5" <?php if(@$_POST['consult_fee'] == '5') echo ' checked="checked"'; ?> /> more than Rs. 1000
							<?php
							endif;
							?>
							<!--<input name="consult_fee" value="<?php echo set_value('consult_fee', @$clinic_details->consultation_fees); ?>" type="text" class="from_text_filed" id="consult_fee" placeholder="Rs." />-->
						</td>
						<td>&nbsp;
							
						</td>
					</tr>
					<tr>
						<td align="right">&nbsp;
							
						</td>
						<td width="36">&nbsp;
							
						</td>
						<td class="error_message" >
							<?php echo form_error('consult_fee', '<p class="error_text">', '</p>'); ?>
						</td>
					</tr>
					<tr>
						<td align="right" class="from_text3">
							Average Duration of
							<span class="from_text4-red">
								*
							</span><br />
							appointment / patient
						</td>
						<td>&nbsp;
							
						</td>
						<td>
							<select name="avg_patient_duration" class="from_list_menu" style="width: 142px;">
								<option value="">
									Select the duration
								</option>
								<option value="5" <?php
 if(@$clinic_details->duration == '5') echo 'selected="selected"';
 else
 if(set_value('avg_patient_duration') == '5') echo 'selected="selected"'; ?> >
									5
								</option>
								<option value="10" <?php
 if(@$clinic_details->duration == '10') echo 'selected="selected"';
 else
 if(set_value('avg_patient_duration') == '10') echo 'selected="selected"'; ?> >
									10
								</option>
								<option value="15" <?php
 if(@$clinic_details->duration == '15') echo 'selected="selected"';
 else
 if(set_value('avg_patient_duration') == '15') echo 'selected="selected"'; ?> >
									15
								</option>
								<option value="20" <?php
 if(@$clinic_details->duration == '20') echo 'selected="selected"';
 else
 if(set_value('avg_patient_duration') == '20') echo 'selected="selected"'; ?> >
									20
								</option>
								<option value="25" <?php
 if(@$clinic_details->duration == '25') echo 'selected="selected"';
 else
 if(set_value('avg_patient_duration') == '25') echo 'selected="selected"'; ?> >
									25
								</option>
								<option value="30" <?php
 if(@$clinic_details->duration == '30') echo 'selected="selected"';
 else
 if(set_value('avg_patient_duration') == '30') echo 'selected="selected"'; ?> >
									30
								</option>
								<option value="35" <?php
 if(@$clinic_details->duration == '35') echo 'selected="selected"';
 else
 if(set_value('avg_patient_duration') == '35') echo 'selected="selected"'; ?> >
									35
								</option>
								<option value="40" <?php
 if(@$clinic_details->duration == '40') echo 'selected="selected"';
 else
 if(set_value('avg_patient_duration') == '40') echo 'selected="selected"'; ?> >
									40
								</option>
								<option value="45" <?php
 if(@$clinic_details->duration == '45') echo 'selected="selected"';
 else
 if(set_value('avg_patient_duration') == '45') echo 'selected="selected"'; ?> >
									45
								</option>
								<option value="50" <?php
 if(@$clinic_details->duration == '50') echo 'selected="selected"';
 else
 if(set_value('avg_patient_duration') == '50') echo 'selected="selected"'; ?> >
									50
								</option>
								<option value="55" <?php
 if(@$clinic_details->duration == '55') echo 'selected="selected"';
 else
 if(set_value('avg_patient_duration') == '55') echo 'selected="selected"'; ?> >
									55
								</option>
								<option value="60" <?php
 if(@$clinic_details->duration == '60') echo 'selected="selected"';
 else
 if(set_value('avg_patient_duration') == '60') echo 'selected="selected"'; ?> >
									60
								</option>
							</select>
							<span class="from_text4">
								&nbsp;Minutes
							</span>
						</td>
						<td>&nbsp;
							
						</td>
					</tr>
					<tr>
						<td align="right">&nbsp;
							
						</td>
						<td width="36">&nbsp;
							
						</td>
						<td class="error_message" >
							<?php echo form_error('avg_patient_duration', '<p class="error_text">', '</p>'); ?>
						</td>
					</tr>
					<tr>
						<td align="right" class="from_text3">&nbsp;
							
						</td>
						<td width="35">&nbsp;
							
						</td>
						<td width="450">
						</td>
						<td>&nbsp;
							
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
			<td bgcolor="#FFFFFF">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="450">&nbsp;
							
						</td>
						<td width="450">&nbsp;
							
						</td>
						<td width="450">&nbsp;
							
						</td>
						<td width="450">&nbsp;
							
						</td>
					</tr>
					<tr>
						<td height="31" colspan="4" align="center" class="add_on_tetel">
							Add On Services
						</td>
					</tr>
					<tr>
						<td colspan="4" align="center" class="add_on_tetel_text">
							Would you like register to offer value added services to your patients?
						</td>
					</tr>
					<tr>
						<td colspan="4" align="center">
							<table width="869" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="270" align="center" valign="top">
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td>
													<img src="<?php echo IMAGE_URL; ?>teleconsulting_top_shaper.jpg" width="270" height="160" />
												</td>
											</tr>
											<tr>
												<td align="center" valign="top" bgcolor="#39C0B1">
													<table width="100%" border="0" cellspacing="0" cellpadding="0">
														<tr>
															<td align="center" class="tetecon">
																We connect you to the Patients who <br />
																take your Consultation Telephonically <br />
																through an Appointment<br />                              <br />                              <br />
															</td>
														</tr>
														<tr>
															<td align="center" valign="bottom">
																<a id="show-example3" onclick="false">
																	<img src="<?php echo IMAGE_URL; ?>add_this.png" width="174" height="37" />
																</a>
																<div id="example3" style="display: none">
																	<br />
																	<table width="100%" border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td height="36" align="center" bgcolor="#0A534A" class="tete_text2">
																				Procedure
																			</td>
																		</tr>
																		<tr>
																			<td align="center" class="tete_text3">
																				<br />
																				Patient pays Tele Consultation fees as<br />
																				specified by you + BDA Service Charge <br />
																				of Rs. 100 through BDA Payment <br />
																				Gateway on BDA Website.<br />
																				Teleconsultation Appointment is <br />
																				confirmed only after confirmation of <br />
																				online payment by the patient. BDA <br />
																				pays you the Tele Consultation fees <br />
																				within 10 days from the Date of Tele <br />
																				Consultation in the Bank Account<br />
																				specified by you.<br />
																				Your Bank Details are taken after the <br />
																				1st Tele consultation Service provided.<br /><br /><br />
																			</td>
																		</tr>
																		<tr>
																			<td align="center" class="from_text3">
																				<strong class="from_text4">
																					Teleconsultation Fees
																				</strong>
																			</td>
																		</tr>
																		<tr>
																			<td align="center">

																				<input name="tele_fees" value="<?php
																				if(isset($_POST['tele_fees']))
																				echo $_POST['tele_fees'];
																				else
																				{
																					if(@$clinic_details->tele_fees > 0)
																					echo @$clinic_details->tele_fees;
																				}
																				?>" id="tele_fees" type="text" class="tete_field_rs" placeholder="Rs." />

																			</td>
																		</tr>
																		<!--<tr>
																		<td align="center" class="text">
																		or
																		</td>
																		</tr>
																		<tr>
																		<td align="center">

																		<p class="from_tetel_text">
																		<input type="checkbox" name="checkbox8" id="copy_consult_fees" />
																		<span class="text">
																		Same as Consultation Fees
																		</span>
																		</p>

																		</td>
																		</tr>-->
																	</table>
																</div>
																<script>
																	(function ($)
																		{
																			$(document).ready(function()
																				{
																					$("#show-example3").click(function ()
																						{
																							if ($('#example3').is(":visible"))
																							{
																								$(this).html($(this).html().replace(/Hide/, 'Show'));
																							} else
																							{
																								$(this).html($(this).html().replace(/Show/, 'Hide'));
																							}
																							// Do it afterwards as the operation is async
																							$("#example3").slideToggle("slow");
																						});
																				});
																		})(jQuery);
																</script>
															</td>
														</tr>
														<tr>
															<td>
															</td>
														</tr>
														<tr>
															<td>
															</td>
														</tr>
														<tr>
															<td>&nbsp;
																
															</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td>
													<img src="<?php echo IMAGE_URL; ?>teleconsulting_top_shape_2.jpg" width="270" height="10" />
												</td>
											</tr>
										</table>
									</td>
									<td width="28">&nbsp;
										
									</td>
									<td width="270" align="center" valign="top">
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td>
													<img src="<?php echo IMAGE_URL; ?>online_consultation - Copy.jpg" width="270" height="160" />
												</td>
											</tr>
											<tr>
												<td align="center" valign="top" bgcolor="#FF764A">
													<table width="100%" border="0" cellspacing="0" cellpadding="0">
														<tr>
															<td align="center" class="online_consul">
																We connect you to the Patients who<br />
																take your Consultation Online through <br />
																a Video Conferencing System <br />
																with a prior Appointment<br />
																<br />
															</td>
														</tr>
														<tr>
															<td align="center" valign="bottom">
																<a id="show-example2" onclick="false">
																	<img src="<?php echo IMAGE_URL; ?>add_this.png" width="174" height="37" />
																</a>
																<div id="example2" style="display: none">
																	<br />
																	<table width="100%" border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td height="36" align="center" bgcolor="#6d1f04" class="tete_text2">
																				Procedure
																			</td>
																		</tr>
																		<tr>
																			<td align="center" class="tete_text3">
																				<br />
																				Patient pays Online Consultation fees <br />
																				as specified by you + BDA Service Charge.<br />
																				of Rs. 200  through BDA Payment
																				Gateway on BDA Website.<br />
																				Online consultation Appointment is<br />

																				confirmed only after online payment by the patient.<br />

																				BDA pays you the Online Consultation
																				fees within 10 days from the Date <br />
																				of Online Consultation in the Bank
																				Account specified by you.
																				<br />
																				Your Bank Details are taken after the
																				1st Online consultation Service provided.<br /><br /><br />
																			</td>
																		</tr>
																		<tr>
																			<td align="center" class="from_text3">
																				<strong class="from_text4" style="color:#6d1f04">
																					Online Consultation Fees
																				</strong>
																			</td>
																		</tr>
																		<tr>
																			<td align="center">

																				<input id="online_fees" value="<?php
																				if(isset($_POST['online_fees']))
																				echo $_POST['online_fees'];
																				else
																				{
																					if(@$clinic_details->online_fees > 0)
																					echo @$clinic_details->online_fees;
																				}
																				?>" name="online_fees" type="text" class="onlie_field_rs" placeholder="Rs." />

																			</td>
																		</tr>
																		<!--<tr>
																		<td align="center" class="text">
																		or
																		</td>
																		</tr>
																		<tr>
																		<td align="center">

																		<p class="from_tetel_text">
																		<input type="checkbox" name="checkbox9" id="copy_consult_fees1" />
																		<span class="text">
																		Same as Consultation Fees
																		</span>
																		</p>

																		</td>
																		</tr>-->
																	</table>
																</div>
																<script>
																	(function ($)
																		{
																			$(document).ready(function()
																				{
																					$("#show-example2").click(function ()
																						{
																							if ($('#example2').is(":visible"))
																							{
																								$(this).html($(this).html().replace(/Hide/, 'Show'));
																							} else
																							{
																								$(this).html($(this).html().replace(/Show/, 'Hide'));
																							}
																							// Do it afterwards as the operation is async
																							$("#example2").slideToggle("slow");
																						});
																				});
																		})(jQuery);
																</script>
															</td>
														</tr>
														<tr>
															<td>
															</td>
														</tr>
														<tr>
															<td>
															</td>
														</tr>
														<tr>
															<td>&nbsp;
																
															</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td>
													<img src="<?php echo IMAGE_URL; ?>online_consultan.jpg" width="270" height="8" />
												</td>
											</tr>
										</table>
									</td>
									<td width="31">&nbsp;
										
									</td>
									<td width="270" valign="top">
										<table width="100%" border="0" cellspacing="0" cellpadding="0">
											<tr>
												<td>
													<img src="<?php echo IMAGE_URL; ?>express_appointment - Copy.jpg" width="270" height="160" />
												</td>
											</tr>
											<tr>
												<td align="center" valign="top" bgcolor="#FFB500">
													<table width="100%" border="0" cellspacing="0" cellpadding="0">
														<tr>
															<td align="center" class="online_consul">
																For the Patients who do not want to <br />
																wait for their turn and want your <br />
																instant consultation<br />
																<br />
																<br />
															</td>
														</tr>
														<tr>
															<td align="center" valign="bottom">
																<a id="show-example4" onclick="false">
																	<img src="<?php echo IMAGE_URL; ?>add_this.png" width="174" height="37" />
																</a>
																<div id="example4" style="display: none">
																	<br />
																	<table width="100%" border="0" cellspacing="0" cellpadding="0">
																		<tr>
																			<td height="36" align="center" bgcolor="#6d1f04" class="tete_text2">
																				Procedure
																			</td>
																		</tr>
																		<tr>
																			<td align="center" class="tete_text3">
																				<br />
																				You may charge Premium Consultation
																				fees for Express Appointment.<br />

																				Patient pays Premium Consultation
																				fees as specified by you + BDA
																				Service Charge of Rs. 100  through
																				BDA Payment Gateway on BDA Website.<br />

																				Express Appointment is confirmed
																				only after confirmation of
																				online payment by the patient.<br />

																				BDA pays you the Premium Consultation
																				fees within 10 days from the Date
																				of Express Appointment in the Bank
																				Account specified by you.<br />

																				Your Bank Details are taken after the
																				1st Express Appointment Service provided
																			</td>
																		</tr>
																		<tr>
																			<td align="center" class="from_text3">
																				<strong class="from_text4" style="color:#6d1f04">
																					Express Appointment Fees
																				</strong>
																			</td>
																		</tr>
																		<tr>
																			<td align="center">

																				<input id="express_fees" value="<?php
																				if(isset($_POST['express_fees']))
																				echo $_POST['express_fees'];
																				else
																				{
																					if(@$clinic_details->express_fees > 0)
																					echo @$clinic_details->express_fees;
																				}
																				?>" name="express_fees" type="text" class="exp_field_rs" placeholder="Rs." />

																			</td>
																		</tr>
																		<!--<tr>
																		<td align="center" class="text">
																		or
																		</td>
																		</tr>
																		<tr>
																		<td align="center">

																		<p class="from_tetel_text">
																		<input type="checkbox" name="checkbox10" id="copy_consult_fees2" />
																		<span class="text">
																		Same as Consultation Fees
																		</span>
																		</p>

																		</td>
																		</tr>-->
																	</table>
																</div>
																<script>
																	(function ($)
																		{
																			$(document).ready(function()
																				{
																					$("#show-example4").click(function ()
																						{
																							if ($('#example4').is(":visible"))
																							{
																								$(this).html($(this).html().replace(/Hide/, 'Show'));
																							} else
																							{
																								$(this).html($(this).html().replace(/Show/, 'Hide'));
																							}
																							// Do it afterwards as the operation is async
																							$("#example4").slideToggle("slow");
																						});
																				});
																		})(jQuery);
																</script>
															</td>
														</tr>
														<tr>
															<td>
															</td>
														</tr>
														<tr>
															<td>
															</td>
														</tr>
														<tr>
															<td>&nbsp;
																
															</td>
														</tr>
													</table>
												</td>
											</tr>
											<tr>
												<td>
													<img src="<?php echo IMAGE_URL; ?>express_appointment_shape.jpg" width="270" height="8" />
												</td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td colspan="4" align="center">&nbsp;
							
						</td>
					</tr>
					<tr>
						<td colspan="4" align="center">
							<?php
							if(isset($editclinic) && $editclinic == 'editclinic')
							{
							}
							else
							{
								?>
								<input type="image" name="add_more_clinic" src="<?php echo IMAGE_URL; ?>Add More Clinic.jpg" width="158" height="40" />
								<?php
							}; ?>
						</td>
					</tr>
					<tr>
						<td colspan="4" align="center">&nbsp;
							
						</td>
					</tr>
				</table>


				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td height="53" align="right" bgcolor="#f5f5f5">
							<table width="200" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="62" height="40">&nbsp;
										
									</td>
									<td width="118" class="continue_bnt" style="cursor: pointer;" onclick="javascript:document.getElementById('sl_step2').submit();">
										Submit
									</td>
									<td width="20">&nbsp;
										
									</td>
								</tr>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</form>

<script type="text/javascript">
	$(document).ready(function()
		{
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

		});
</script>


<script type="text/javascript">
	$(window).load(function()
		{
			var options =
			{
				thumbBox: '.thumbBox',
				spinner: '.spinner',
				imgSrc: 'avatar.png'
			}
			var cropper;
			$('.file').on('change', function()
				{
					var reader = new FileReader();
					reader.onload = function(e)
					{
						options.imgSrc = e.target.result;
						cropper = $('.imageBox').cropbox(options);
					}
					reader.readAsDataURL(this.files[0]);
					this.files = [];
				})
			$('.btnCrop').on('click', function()
				{
					var img = cropper.getDataURL()
					var idno = this.id;
					$('#clinic-photos-display-boxes').show();
					$('.remove-photo-x-btn#'+idno+'').hide();
					$('#imagedisplay'+idno+'').css('display','inline');
					$('#imagedisplay'+idno+'').css('opacity','1');
					$('.clinicimgdisplay#imagedisplay'+idno+'').css('border','0');
					$('#imagedisplay'+idno+'').attr('src', img);
					//console.log($('#imagedisplay'+idno+''));
					var imgtype= img.substr(0, img.indexOf(','));
					var base64imgvalue= img.substr(img.indexOf(',')+1, 999999999);
					$('#clinicphotoimg'+idno+'').val(base64imgvalue);
					$('#clinicphotoname'+idno+'').val($('#file'+idno+'').val());
				})
			$('#btnZoomIn').on('click', function()
				{
					cropper.zoomIn();
				})
			$('#btnZoomOut').on('click', function()
				{
					cropper.zoomOut();
				})
		});
</script>


<div class="modalbpopup" style="display: none;">
	<div class="container">
		<div class="imageBox">
			<div class="thumbBox">
			</div>
			<div class="spinner" style="display: none">
				Loading...
			</div>
		</div>
		<div class="action">
			<input type="file" class="file" id="file" style="float:left; width: 250px">
			<input type="button" class="btnCrop modalclose" id="btnCrop" value="Crop" style="float: right; width: 75px; margin:5px 40px 5px 5px;">
			<input type="button" id="btnZoomIn" value="+" style="float: right; width: 25px; margin:5px 2px;">
			<input type="button" id="btnZoomOut" value="-" style="float: right; width: 25px; margin:5px 2px;">
		</div>
		<div class="cropped">
		</div>
	</div>
</div>