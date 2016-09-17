<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <?php $this->load->view('login/common/head'); ?>
</head>
<body>
<?php $this->load->view('login/common/hospital_header'); ?>
<div class="container H550">
<div class="row">
<div class="col-lg-offset-1 col-md-offset-1 col-lg-10 col-md-10">            
<div class="panel panel-default">    
<div class="panel-body">
 <div class="row"> 
 <div class="col-lg-12 col-md-12">
 <form id="sl_step2" name="sl_step2" method="POST" enctype="multipart/form-data" autocomplete="false">
	<input type="hidden" name="clinicphotoimg[]" id="clinicphotoimg1" value="" /> 
  <input type="hidden" name="clinicphotoname[]" id="clinicphotoname1" value="" />

	<input type="hidden" name="clinicphotoimg[]" id="clinicphotoimg2" value="" /> 
  <input type="hidden" name="clinicphotoname[]" id="clinicphotoname2" value="" />

	<input type="hidden" name="clinicphotoimg[]" id="clinicphotoimg3" value="" /> 
  <input type="hidden" name="clinicphotoname[]" id="clinicphotoname3" value="" />

	<input type="hidden" name="clinicphotoimg[]" id="clinicphotoimg4" value="" /> 
  <input type="hidden" name="clinicphotoname[]" id="clinicphotoname4" value="" />

	<input type="hidden" name="clinicphotoimg[]" id="clinicphotoimg5" value="" /> 
  <input type="hidden" name="clinicphotoname[]" id="clinicphotoname5" value="" />

	<div class="form-group">
  <label class="control-label">Profile Picture<?php echo form_error('image', '<span class="error_text">', '</span>'); ?></label>
  <div id="profileimgbox"><img src="<?=(@$hospital_details->image)?BASE_URL.@$hospital_details->image:IMAGE_URL.'photo_frame.jpg' ?>" 
  style="width:800px;height:300px;" /></div>          
  </div>
  <div class="form-group">
  <button type="button" class="btn btn-info btn-md" id="myBtn"><span class="glyphicon glyphicon-upload"></span>&nbsp;Select a File</button>
  <input type="hidden" name="profile_pic_base64" id="profile_pic_base64" value="" />
  <input type="hidden" name="profile_pic_base64_name" id="profile_pic_base64_name" value="" />
  </div>
  <div class="form-group">
  <label class="control-label">* Clinic/Hospital Photos : <mark>Please click on the frame below to upload a photo</mark></label>
  <p class="PT20">
  
  	<img id="imagedisplay1" class="clinicimgdisplay clinicimage" width="100" height="75" style="display: inline;" 
    src="<?=(isset($clinic_images[0]) && !empty($clinic_images[0]))?BASE_URL.$clinic_images[0]:IMAGE_URL."grey.png" ?>" />
    <span id="1" class="btn-default glyphicon glyphicon-minus remove-photo"></span>
    
    <img id="imagedisplay2" class="clinicimgdisplay clinicimage" width="100" height="75" style="display: inline;" 
    src="<?=(isset($clinic_images[1]) && !empty($clinic_images[1]))?BASE_URL.$clinic_images[1]:IMAGE_URL."grey.png"?>" />
    <span id="2" class="btn-default glyphicon glyphicon-minus remove-photo"></span>
    
    <img id="imagedisplay3" class="clinicimgdisplay clinicimage" width="100" height="75" style="display: inline;" 
    src="<?=(isset($clinic_images[2]) && !empty($clinic_images[2]))?BASE_URL.$clinic_images[2]:IMAGE_URL."grey.png"?>" />
    <span id="3" class="btn-default glyphicon glyphicon-minus remove-photo"></span>
    
    <img id="imagedisplay4" class="clinicimgdisplay clinicimage" width="100" height="75" style="display: inline;" 
    src="<?=(isset($clinic_images[3]) && !empty($clinic_images[3]))?BASE_URL.$clinic_images[3]:IMAGE_URL."grey.png"?>"  />
    <span id="4" class="btn-default glyphicon glyphicon-minus remove-photo"></span>
    
    <img id="imagedisplay5" class="clinicimgdisplay clinicimage" width="100" height="75" style="display: inline;" 
    src="<?=(isset($clinic_images[4]) && !empty($clinic_images[4]))?BASE_URL.$clinic_images[4]:IMAGE_URL."grey.png"?>"  />
    <span id="5" class="btn-default glyphicon glyphicon-minus remove-photo"></span>
  </p>
  </div>
  <div class="form-group ">
    <label for="id_clinic_name" class="control-label">Hospital Name<?php echo form_error('clinic_name', '<span class="error_text">', '</span>'); ?></label>
    <input id="id_clinic_name" name="name" value="<?php echo set_value('clinic_name', @$hospital_details->name); ?>" type="text" class="form-control"  required />
  </div>
  <div class="form-group">
    <label for="id_clinic_address" class="control-label">* Hospital Address<?php echo form_error('clinic_address', '<span class="error_text">', '</span>'); ?></label>
    <input id="id_clinic_address" name="address" value="<?php echo set_value('clinic_address', @$hospital_details->address); ?>" type="text" class="form-control"  required />
  </div>
  
  <div class="form-group">
    <label for="id_city" class="control-label">* City<?php echo form_error('city', '<span class="error_text">', '</span>'); ?></label>
    <input id="id_city" style="width:50%" type="text" class="form-control autocomplete-city" value="<?=(@$city_name)?>" autocomplete="false"/>
    <input type="hidden" id="city_id" name="city_id" value="<?=(@$city_id)?>"/>
  </div>
  <div class="form-group">
  <label for="id_locality" class="control-label">* Locality<?php echo form_error('locality', '<span class="error_text">', '</span>'); ?></label>
  <input id="id_locality" style="width:50%" type="text" class="form-control autocomplete-location" value="<?=@ucwords($location_name)?>" autocomplete="false" required/>
  <input type="hidden" name="location_id"  id="locality" value="<?=(@$location_id)?>"  />
  <input type="hidden" name="other_location"  id="locality_other" value="<?=(@$other_location)?>"  />
  </div>

   <p>Locate your clinic by dragging the location pointer <img src="//maps.gstatic.com/mapfiles/markers2/marker.png" style="height: 26px;"/> 
    <mark>OR</mark> If you do not find the exact location, choose the nearest landmark</p>
    
  <div class="form-inline" style="margin-bottom: 15px">  
     <div class="form-group" style="width:60%"> 
    <!--<label for="googleaddress" class="control-label">Loaction</label>-->
    <input type="text"  style="width:100%" class="form-control" id="googleaddress" value="" placeholder="Enter your clinic location and click Find Location" />
     </div>
     <button style="top:0" class="btngoogle btn btn-primary" onclick="showAddress(document.getElementById('googleaddress').value); return false" >Find Location</button>
     
    <br/><br/> 
    <div id="map_canvas" style="width: 100%; height: 300px"></div>
    <input type="hidden" name="latitude" id="latitude" value="<?php echo @$clinic_details->latitude; ?>" />      
    <input type="hidden" name="longitude" id="longitude" value="<?php echo @$clinic_details->longitude; ?>" />      
  </div>    
  
  <div class="form-group">
    <label for="id_pincode" class="control-label">Pincode <?php echo form_error('pincode', '<p class="error_text">', '</p>'); ?></label>
    <input id="id_pincode" style="width:250px;" name="pincode" value="<?php echo set_value('pincode', @$hospital_details->pincode); ?>" type="text" class="form-control" placeholder="Pincode" maxlength="6" />
  </div>
  
  <div class="form-group">
    <label class="control-label">* Clinic Contact No : Use Comma (,) to separate numbers <?php echo form_error('contact_number', '<p class="error_text">', '</p>'); ?> </label>
    <input name="contact_number" value="<?php echo set_value('contact_number', @$hospital_details->contact_number); ?>" type="text" placeholder="Number" 
    class="form-control" />
  </div>
  <div class="form-group">
    <div class="text-right">
      <input type="submit" name="add_clinic" class="btn btn-success" value="Save"/>
      </div>
  </div>
</form> 
</div>
 </div>     
</div>
</div>    
</div>
</div>    
</div>
<?php $this->load->view('login/common/footer'); ?>
<?php $this->load->view('login/common/bottom'); ?>
<!-- PAGE SPECIFIC JS-->
<script src="<?php echo JS_URL; ?>login/jquery.inputfile.js"></script>
<script src="<?php echo JS_URL; ?>login/jquery-cropimg-plugin.js"></script>
<script src="<?php echo JS_URL; ?>login/jquery.plugin.js"></script>
<script src="<?php echo JS_URL; ?>login/jquery.timeentry.js"></script>
<script src="//maps.google.com/maps?file=api&v=3&key=AIzaSyCO8K3lZSCQgKMnmIyExMyglEI4s0FV4Uo"></script>
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
		<?php if(isset($hospital_details->latitude) && isset($hospital_details->longitude)): ?>
			$("#googleaddress").val('<?php echo $hospital_details->latitude.",".$hospital_details->longitude; ?>');
			$(".btngoogle").trigger('click');
			$("#googleaddress").val('');
		<?php endif; ?>
	}
}
function showAddress(address)
{
	var a = $(".autocomplete-city").val();

	var newaddress = address+', '+a+', India';
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
					console.log("latong 1=>"+marker.getLatLng().toUrlValue(6));
					var latlngarr = marker.getLatLng().toUrlValue(6).split(',');
					$("#latitude").val(latlngarr[0]);
					$("#longitude").val(latlngarr[1]);
					
					GEvent.addListener(marker, "dragend", function()
						{
							//marker.openInfoWindowHtml(marker.getLatLng().toUrlValue(6));
							console.log("latong 2=>"+marker.getLatLng().toUrlValue(6));
							var latlngarr = marker.getLatLng().toUrlValue(6).split(',');
							//$("#latlong").val(marker.getLatLng().toUrlValue(6));
							$("#latitude").val(latlngarr[0]);
							$("#longitude").val(latlngarr[1]);
						});
					GEvent.addListener(marker, "click", function()
						{
							//marker.openInfoWindowHtml(marker.getLatLng().toUrlValue(6));
							console.log("latong 3=>"+marker.getLatLng().toUrlValue(6));
							var latlngarr = marker.getLatLng().toUrlValue(6).split(',');
							//$("#latlong").val(marker.getLatLng().toUrlValue(6));
							$("#latitude").val(latlngarr[0]);
							$("#longitude").val(latlngarr[1]);
						});
					GEvent.trigger(marker, "click");
				}
			}
		);
	}
}
</script>
<script type="text/javascript">
$(document).ready(function(e) {
	google.maps.event.addDomListener(window, 'load', initialize);
	$(".autocomplete-location").on('blur', function(){
		$("#googleaddress").val($(".autocomplete-location").val()+' ,'+$(".autocomplete-city").val().trim()+', India');
		$(".btngoogle").trigger('click');
	});
	var duration	=	["5","10","15","20","25","30","35","40","45","50","55","60"];
	$(".autocomplete-duration").autocomplete({
		source: duration
	});		
	$(".autocomplete-city").autocomplete({
		source: function(request,response){
			$.ajax({
				url: BASE_URL + "api/masters/city/",
				dataType: "json",
				data: {
					query: request.term
				},
				success: function( data ) {
					response( data );
				}
			});
		},
		minLength: 3,
		select: function( event, ui ) {
			$(this).attr("value", ui.item.value);
			$("#city_id").val(ui.item.db_id);
		}
	});		
	$(".autocomplete-location").autocomplete({
		source: function(request,response){
			$.ajax({
				url: BASE_URL + "api/masters/location/",
				dataType: "json",
				data: {
					query: request.term,
					city_id:$("#city_id").val()
				},
				success: function( data ) {
					console.log(data.length);
					if( data.length==0 )
					{
						$("#locality").val(request.term);			
					}
					response( data );
				}
			});
		},
		minLength: 3,
		select: function( event, ui ) {
			if(ui.item.db_id)
			{
				$("#locality").val(ui.item.db_id);
			}
			else
			{
				$("#locality_other").val(ui.item.label);
			}
			
		},
		search: function( event, ui ) {
			$("#locality").val("");
			$("#locality_other").val("");
		}
	});		
	
	/* Profile image cropper */
	$("#myBtn").click(function(){
		$("#myModal").modal({backdrop: true});
		$("#file").click();
	});
	var options =
	{
	thumbBox: '.thumblandscapeBox',
	spinner: '.spinner',
	imgSrc: 'avatar.png'
	}
	var cropper;
	$('#file').on('change', function(){
	var reader = new FileReader();
	reader.onload = function(e) {
	options.imgSrc = e.target.result;
	cropper = $('.imageBox').cropbox(options);
	}
	reader.readAsDataURL(this.files[0]);
	this.files = [];
	})
	$('#btnCrop').on('click', function(){
	var img = cropper.getDataURL();
	$('#profileimgbox').html('<img src="'+img+'">');
	
	var imgtype= img.substr(0, img.indexOf(',')); 
	var base64imgvalue= img.substr(img.indexOf(',')+1, 999999999); 
	$('#profile_pic_base64').val(base64imgvalue);
	$('#profile_pic_base64_name').val($('#file').val());
	})
	$('#btnZoomIn').on('click', function(){
	cropper.zoomIn();
	})
	$('#btnZoomOut').on('click', function(){
	cropper.zoomOut();
	})
	
	/* Clinic image cropper*/
	$(".clinicimage").click(function(){
		$("#myClinicModal").modal({backdrop: true});
		$("#clinic-file").click();
		$(".clinic-imageBox").attr("style","");
		var imgid = this.id;
		console.log(imgid);
		var imgnumber = imgid.substr(12,1);
		console.log(imgnumber);
		$(".btnClinicCrop").attr('id', imgnumber);
	});	
	$(".remove-photo").click(function(){
		var h = confirm('Are you sure you want to delete this photo?')
		if(h == true)
		{
		var id = this.id;
		$.ajax({
		type:	'POST',
		url:	'/hospital/deletehospitalphoto',
		data:{
			'photoid'	:	id,
			'hospitalid'	:	'<?php echo @$hospital_details->id; ?>'
		},
		success: function(e){
			$("#imagedisplay"+id).attr("src",'<?=IMAGE_URL?>grey.png');
			$("#clinicphotoname"+id).val("");
			$("#clinicphotoimg"+id).val("");
		}
		});
		}
	});
	var option_clinic =
	{
	thumbBox: '.thumbbigBox',
	spinner: '.spinner',
	imgSrc: 'avatar.png'
	}
	var cropper;
	$('#clinic-file').on('change', function()
	{
		var reader = new FileReader();
		reader.onload = function(e)
		{
			option_clinic.imgSrc = e.target.result;
			cropper = $('.clinic-imageBox').cropbox(option_clinic);
		}
		reader.readAsDataURL(this.files[0]);
		this.files = [];
	})
	$('.btnClinicCrop').on('click', function()
	{
		console.log(cropper);
		var img = cropper.getDataURL()
		console.log(img);
		var idno = this.id;
		$('#clinic-photos-display-boxes').show();
		$('.remove-photo-x-btn#'+idno+'').hide();
		$('#imagedisplay'+idno+'').css('display','inline');
		$('#imagedisplay'+idno+'').css('opacity','1');
		$('.clinicimgdisplay#imagedisplay'+idno+'').css('border','0');
		$('#imagedisplay'+idno+'').attr('src', img);
		var imgtype= img.substr(0, img.indexOf(','));
		var base64imgvalue= img.substr(img.indexOf(',')+1, 999999999);
		$('#clinicphotoimg'+idno+'').val(base64imgvalue);
		//alert($('#file').val());
		$('#clinicphotoname'+idno+'').val($('#clinic-file').val());
	})
	$('#btnClinicZoomIn').on('click', function()
	{
	cropper.zoomIn();
	})
	$('#btnClinicZoomOut').on('click', function()
	{
	cropper.zoomOut();
	})
	
});
</script>
<!-- PAGE SPECIFIC JS-->	
<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog" style="width:900px;">
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title">Upload Image</h4>
</div>
<div class="modal-body">
<div class="imageBox">
<div class="thumblandscapeBox"></div>
<div class="spinner" style="display: none">Loading...</div>
</div>
<div class="PT5">
<span class="btn btn-primary btn-file">
Browse <input type="file" id="file">
</span>          
<button type="button" class="btn btn-primary" data-dismiss="modal" id="btnCrop">Crop</button>
<input type="button" id="btnZoomIn" value="Zoom in (+)" class="btn btn-primary">
<input type="button" id="btnZoomOut" value="Zoom out (-)" class="btn btn-primary">
</div>
<div class="cropped"></div>
</div>
</div>
</div>
</div>
<div class="modal fade" id="myClinicModal" role="dialog">
  <div class="modal-dialog">
  <!-- Modal content-->
  <div class="modal-content">
  <div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">&times;</button>
  <h4 class="modal-title">Upload Image</h4>
  </div>
  <div class="modal-body">
  <div class="clinic-imageBox">
  <div class="thumbbigBox"></div>
  <div class="spinner" style="display: none">Loading...</div>
  </div>
  <div class="PT5">
  <span class="btn btn-primary btn-file">
      Browse <input type="file" id="clinic-file">
  </span>          
  <button type="button" class="btn btn-primary btnClinicCrop" data-dismiss="modal" id="">Crop</button>
  <input type="button" id="btnClinicZoomIn" value="Zoom in (+)" class="btn btn-primary">
  <input type="button" id="btnClinicZoomOut" value="Zoom out (-)" class="btn btn-primary">
  </div>
  <div class="cropped"></div>
  </div>
  </div>
  </div>
</div>
</body>
</html>

