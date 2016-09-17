<?php

if((isset($editclinic) && $editclinic == 'editclinic') && ($clinic_details->longitude != NULL))
{
	$latitude = $clinic_details->latitude;
	$longitude = $clinic_details->longitude;
	$latlong = $latitude.','.$longitude;
}
if(isset($editclinic) && $editclinic == 'editclinic')
{
	$cl_number = explode('-',$clinic_details->contact_number,2);
}

?>
<?php
if(isset($clinic_details->image))
@$images = explode(',', @$clinic_details->image);
#print_r($images);exit;
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
function get_thumbnail($image)
{
	$file_path	=	 pathinfo($image);
	$file_path['filename']	=	$file_path['filename']."_t";
	return $file_path['dirname']."/".$file_path['filename'].".".$file_path['extension'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <?php $this->load->view('login/common/head'); ?>
</head>
<body>
<?php $this->load->view('login/common/doctor_header'); ?>
<div class="container">
<div class="row">
<div class="col-lg-offset-1 col-md-offset-1 col-lg-10 col-md-10">            
<div class="panel panel-default">    
<div class="panel-body">
 <div class="row"> 
 <div class="col-lg-12 col-md-12">
 <form id="sl_step2" name="sl_step2" method="POST" enctype="multipart/form-data">
   <input type="hidden" name="sl_step2" id="sl_step2" value="sl_step2" />
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
  <div class="form-group ">
    <label for="id_clinic_name" class="control-label">*Clinic/Hospital Name<?php echo form_error('clinic_name', '<span class="error_text">', '</span>'); ?></label>
    <input id="id_clinic_name" name="clinic_name" value="<?php echo set_value('clinic_name', @$clinic_details->name); ?>" type="text" class="form-control"  required />
  </div>

  <?php if(isset($sor_eligible)){ ?>
  <div class="form-group">
  <label class="control-label">* Clinic/Hospital Photos : <mark>Please click on the number below to upload a photo</mark></label>
  <p class="PT20">
    <img id="imagedisplay1" class="clinicimgdisplay clinicimage" width="100" height="75"
    <?php
		$base_url		=	BASE_URL;#"https://www.bookdrappointment.com/";
		$image_url	=	BASE_URL;#"https://www.bookdrappointment.com/static/images";
		
    if(isset($clinic_details) && !empty($images[0]))
    echo 'src="'.$base_url.get_thumbnail($images[0]).'" style="display: inline; opacity:1; border:0; margin-right:0;" />  <img src="'.IMAGE_URL.'xclose.png" id="1" class="remove-photo-x-btn" style="position: relative; top: -37px; left: -19px;" ';
    else
    echo 'style="display: inline;" src="'.IMAGE_URL.'grey.png" ';
    ?>
    />
    <img id="imagedisplay2" class="clinicimgdisplay clinicimage" width="100"  height="75"
    <?php

    if(isset($clinic_details) && !empty($images[1]))
    echo 'src="'.$base_url.get_thumbnail($images[1]).'" style="display: inline; opacity:1; border:0; margin-right:0;" />  <img src="'.IMAGE_URL.'xclose.png" id="2" class="remove-photo-x-btn" style="position: relative; top: -37px; left: -19px;" ';
    else
    echo 'style="display: inline;" src="'.IMAGE_URL.'grey.png" ';
    ?>
    />
    <img id="imagedisplay3" class="clinicimgdisplay clinicimage" width="100"  height="75"
    <?php
    if(isset($clinic_details) && !empty($images[2]))
    echo 'src="'.$base_url.get_thumbnail($images[2]).'" style="display: inline; opacity:1; border:0; margin-right:0;" />  <img src="'.IMAGE_URL.'xclose.png" id="3" class="remove-photo-x-btn" style="position: relative; top: -37px; left: -19px;" ';
    else
    echo 'style="display: inline;" src="'.IMAGE_URL.'grey.png" ';
    ?>
    />
    <img id="imagedisplay4" class="clinicimgdisplay clinicimage" width="100"  height="75"
    <?php
    if(isset($clinic_details) && !empty($images[3]))
    echo 'src="'.$base_url.get_thumbnail($images[3]).'" style="display: inline; opacity:1; border:0; margin-right:0;" />  <img src="'.IMAGE_URL.'xclose.png" id="4" class="remove-photo-x-btn" style="position: relative; top: -37px; left: -19px;" ';
    else
    echo 'style="display: inline;" src="'.IMAGE_URL.'grey.png" ';
    ?>
    />
    <img id="imagedisplay5" class="clinicimgdisplay clinicimage" width="100"  height="75"
    <?php
    if(isset($clinic_details) && !empty($images[4]))
    echo 'src="'.$base_url.get_thumbnail($images[4]).'" style="display: inline; opacity:1; border:0; margin-right:0;" />  <img src="'.IMAGE_URL.'xclose.png" id="5" class="remove-photo-x-btn" style="position: relative; top: -37px; left: -19px;" ';
    else
    echo 'style="display: inline;" src="'.IMAGE_URL.'grey.png" ';
    ?>
    />
    </p>
  </div>
  <?php }?>
  
  <div class="form-group">
    <label for="id_clinic_address" class="control-label">* Clinic/Hospital Address<?php echo form_error('clinic_address', '<span class="error_text">', '</span>'); ?></label>
    <input id="id_clinic_address" name="clinic_address" value="<?php echo set_value('clinic_address', @$clinic_details->address); ?>" type="text" class="form-control"  required />
  </div>
  
  <div class="form-group">
    <label for="id_city" class="control-label">* City<?php echo form_error('city', '<span class="error_text">', '</span>'); ?></label>
    <input id="id_city" style="width:50%" type="text" class="form-control autocomplete-city" value="<?=(@$city_name)?>"/>
    <input type="hidden" id="city_id" name="city" value="<?=(@$city_id)?>"/>
  </div>
  <div class="form-group">
  <label for="id_locality" class="control-label">* Locality<?php echo form_error('locality', '<span class="error_text">', '</span>'); ?></label>
  <input id="id_locality" style="width:50%" type="text" class="form-control autocomplete-location" value="<?=(@$location_name)?>" required/>
  <input type="hidden" name="locality"  id="locality" value="<?=(@$location_id)?>"  />
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
    <input type="hidden" name="latlong" id="latlong" value="<?php echo @$latlong; ?>" />      
  </div>    
  
  <div class="form-group">
    <label for="id_pincode" class="control-label">*Pincode <?php echo form_error('pincode', '<p class="error_text">', '</p>'); ?></label>
    <input id="id_pincode" style="width:250px;" name="pincode" value="<?php echo set_value('pincode', @$clinic_details->pincode); ?>" type="text" class="form-control" placeholder="Pincode" maxlength="6" />
  </div>
  
  <div class="form-group form-inline">
    <label class="control-label">* Clinic/Hospital Landline No<?php echo form_error('clinic_number', '<p class="error_text">', '</p>'); ?> <?php echo form_error('clinic_number_code', '<p class="error_text">', '</p>'); ?></label>
    <input name="clinic_number_code" value="<?php echo set_value('clinic_number_code', @$cl_number[0]); ?>" placeholder="Code" type="text" 
    class="form-control W60"  />
    <input name="clinic_number" value="<?php echo set_value('clinic_number', @$cl_number[1]); ?>" type="text" placeholder="Number" 
    class="form-control" />
  </div>
  
  <div class="form-group">
    <label class="control-label">Consultation Days &amp; Timings : </label>
    <div class="row">
    <div class="col-sm-4">
    	<div class="panel panel-success">
      	<div class="panel-heading"><strong>Case (1)</strong></div>
        <div class="panel-body panel-consultation-note">
        Same on all Days :Click 'Copy to all Days' In case you dont Practice on Sunday , just deselect the Checkbox for Sunday.
        </div>
      </div>
    </div>
    <div class="col-sm-4">
    <div class="panel panel-success">
      	<div class="panel-heading"><strong>Case (2)</strong></div>
        <div class="panel-body panel-consultation-note">
        Different on Different Days Click 'Copy to all Days' and then deselect the checkbox for the day that you want to change the time & fill in  your Practice Time
        </div>
      </div>
    </div>
    <div class="col-sm-4">
    <div class="panel panel-success">
      	<div class="panel-heading"><strong>Case (3)</strong></div>
        <div class="panel-body panel-consultation-note">
        Different on all Days : Fill in the Time in each Tab individually
        </div>
      </div>
    </div>
    </div>
    <div class="table-responsive">
    <?php if(isset($editclinic) && $editclinic == 'editclinic'){?>
    <table class="table table-striped table-condensed table-bordered">
    <tr>
    <th class="text-center">Day</th>
    <th class="text-center" colspan="3">First Half</th>
    <th class="text-center" colspan="3">Second Half</td>
    <th class="text-center"><a href="javascript:void(0)" id="copy_to_all_days">Copy To All Days</a></th>
    </tr>
    <tr>
      <td align="center" class="from_fileld">
        Monday
      </td>
      <td align="center">
        <input name="mon_mor_open" type="text" class="day_time wk-dt-width" id="mon_mor_open" value="<?php echo !empty($clinic_timings[1][0][0]) ? date('h:iA', strtotime(@$clinic_timings[1][0][0])) : ''; ?>" />
      </td>
    <td align="center">
    To
    </td>
      <td align="center">
        <input name="mon_mor_close" type="text" class="day_time wk-dt-width" id="mon_mor_close" value="<?php echo !empty($clinic_timings[1][0][1]) ? date('h:iA', strtotime(@$clinic_timings[1][0][1])) : ''; ?>" />
      </td>
      <td align="center">
        <input name="mon_eve_open" type="text" class="day_time wk-dt-width" id="mon_eve_open" value="<?php echo !empty($clinic_timings[1][1][0]) ? date('h:iA', strtotime(@$clinic_timings[1][1][0])) : ''; ?>" />
      </td>
    <td align="center">
    To
    </td>
      <td align="center">
        <input name="mon_eve_close" type="text" class="day_time wk-dt-width" id="mon_eve_close"
        value="<?php echo !empty($clinic_timings[1][1][1]) ? date('h:iA', strtotime(@$clinic_timings[1][1][1])) : ''; ?>"/>
      </td>
      <td align="center">
        <input name="days[]" type="checkbox" class="checkbox_valid" id="mon" value="monday" <?php
        if(empty($clinic_timings[1][0][1]) && empty($clinic_timings[1][1][1]) && empty($clinic_timings[1][0][0]) && empty($clinic_timings[1][1][0])) echo '';
        else echo 'checked="checked"'; ?> />
      </td>
    </tr>
    <tr>
    <td align="center" class="from_fileld">
    Tuesday
    </td>
    <td align="center">
    <input name="tue_mor_open" type="text" class="day_time wk-dt-width" id="tue_mor_open"
    value="<?php echo !empty($clinic_timings[2][0][0]) ? date('h:iA', strtotime(@$clinic_timings[2][0][0])) : ''; ?>" />
    </td>
    <td align="center">
    To
    </td>
    <td align="center">
    <input name="tue_mor_close" type="text" class="day_time wk-dt-width" id="tue_mor_close" value="<?php echo !empty($clinic_timings[2][0][1]) ? date('h:iA', strtotime(@$clinic_timings[2][0][1])) : ''; ?>" />
    </td>
    <td align="center">
    <input name="tue_eve_open" type="text" class="day_time wk-dt-width" id="tue_eve_open" value="<?php echo !empty($clinic_timings[2][1][0]) ? date('h:iA', strtotime(@$clinic_timings[2][1][0])) : ''; ?>" />
    </td>
    <td align="center">
    To
    </td>
    <td align="center">
    <input name="tue_eve_close" type="text" class="day_time wk-dt-width" id="tue_eve_close" value="<?php echo !empty($clinic_timings[2][1][1]) ? date('h:iA', strtotime(@$clinic_timings[2][1][1])) : ''; ?>" />
    </td>
    <td align="center">
    <input name="days[]" type="checkbox" class="checkbox_valid" id="tue" value="tuesday" <?php
    if(empty($clinic_timings[2][0][1]) && empty($clinic_timings[2][1][1]) && empty($clinic_timings[2][0][0]) && empty($clinic_timings[2][1][0])) echo '';
    else echo 'checked="checked"'; ?> />
    </td>
    </tr>
    
    <tr>
    <td align="center" class="from_fileld">
    Wednesday
    </td>
    <td align="center">
    <input name="wed_mor_open" type="text" class="day_time wk-dt-width" id="wed_mor_open" value="<?php echo !empty($clinic_timings[3][0][0]) ? date('h:iA', strtotime(@$clinic_timings[3][0][0])) : ''; ?>" />
    </td>
    <td align="center">
    To
    </td>
    <td align="center">
    <input name="wed_mor_close" type="text" class="day_time wk-dt-width" id="wed_mor_close" value="<?php echo !empty($clinic_timings[3][0][1]) ? date('h:iA', strtotime(@$clinic_timings[3][0][1])) : ''; ?>" />
    </td>
    <td align="center">
    <input name="wed_eve_open" type="text" class="day_time wk-dt-width" id="wed_eve_open" value="<?php echo !empty($clinic_timings[3][1][0]) ? date('h:iA', strtotime(@$clinic_timings[3][1][0])) : ''; ?>" />
    </td>
    <td align="center">
    To
    </td>
    <td align="center">
    <input name="wed_eve_close" type="text" class="day_time wk-dt-width" id="wed_eve_close" value="<?php echo !empty($clinic_timings[3][1][1]) ? date('h:iA', strtotime(@$clinic_timings[3][1][1])) : ''; ?>" />
    </td>
    <td align="center">
    <input name="days[]" type="checkbox" class="checkbox_valid" id="wed" value="wednesday" <?php
    if(empty($clinic_timings[3][0][1]) && empty($clinic_timings[3][1][1]) && empty($clinic_timings[3][0][0]) && empty($clinic_timings[3][1][0])) echo '';
    else echo 'checked="checked"'; ?> />
    </td>
    </tr>
    
    <tr>
    <td align="center" class="from_fileld">
    Thursday
    </td>
    <td align="center">
    <input name="thu_mor_open" type="text" class="day_time wk-dt-width" id="thu_mor_open" value="<?php echo !empty($clinic_timings[4][0][0]) ? date('h:iA', strtotime(@$clinic_timings[4][0][0])) : ''; ?>" />
    </td>
    <td align="center">
    To
    </td>
    <td align="center">
    <input name="thu_mor_close" type="text" class="day_time wk-dt-width" id="thu_mor_close" value="<?php echo !empty($clinic_timings[4][0][1]) ? date('h:iA', strtotime(@$clinic_timings[4][0][1])) : ''; ?>" />
    </td>
    <td align="center">
    <input name="thu_eve_open" type="text" class="day_time wk-dt-width" id="thu_eve_open" value="<?php echo !empty($clinic_timings[4][1][0]) ? date('h:iA', strtotime(@$clinic_timings[4][1][0])) : ''; ?>" />
    </td>
    <td align="center">
    To
    </td>
    <td align="center">
    <input name="thu_eve_close" type="text" class="day_time wk-dt-width" id="thu_eve_close" value="<?php echo !empty($clinic_timings[4][1][1]) ? date('h:iA', strtotime(@$clinic_timings[4][1][1])) : ''; ?>" />
    </td>
    <td align="center">
    <input name="days[]" type="checkbox" class="checkbox_valid" id="thu" value="thursday" <?php
    if(empty($clinic_timings[4][0][1]) && empty($clinic_timings[4][1][1]) && empty($clinic_timings[4][0][0]) && empty($clinic_timings[4][1][0])) echo '';
    else echo 'checked="checked"'; ?> />
    </td>
    </tr>
    
    <tr>
    <td align="center" class="from_fileld">
    Friday
    </td>
    <td align="center">
    <input name="fri_mor_open" type="text" class="day_time wk-dt-width" id="fri_mor_open" value="<?php echo !empty($clinic_timings[5][0][0]) ? date('h:iA', strtotime(@$clinic_timings[5][0][0])) : ''; ?>" />
    </td>
    <td align="center">
    To
    </td>
    <td align="center">
    <input name="fri_mor_close" type="text" class="day_time wk-dt-width" id="fri_mor_close" value="<?php echo !empty($clinic_timings[5][0][1]) ? date('h:iA', strtotime(@$clinic_timings[5][0][1])) : ''; ?>" />
    </td>
    <td align="center">
    <input name="fri_eve_open" type="text" class="day_time wk-dt-width" id="fri_eve_open" value="<?php echo !empty($clinic_timings[5][1][0]) ? date('h:iA', strtotime(@$clinic_timings[5][1][0])) : ''; ?>" />
    </td>
    <td align="center">
    To
    </td>
    <td align="center">
    <input name="fri_eve_close" type="text" class="day_time wk-dt-width" id="fri_eve_close" value="<?php echo !empty($clinic_timings[5][1][1]) ? date('h:iA', strtotime(@$clinic_timings[5][1][1])) : ''; ?>" />
    </td>
    <td align="center">
    <input name="days[]" type="checkbox" class="checkbox_valid" id="fri" value="friday" <?php
    if(empty($clinic_timings[5][0][1]) && empty($clinic_timings[5][1][1]) && empty($clinic_timings[5][0][0]) && empty($clinic_timings[5][1][0])) echo '';
    else echo 'checked="checked"'; ?> />
    </td>
    </tr>
    
    <tr>
    <td align="center" class="from_fileld">
    Saturday
    </td>
    <td align="center">
    <input name="sat_mor_open" type="text" class="day_time wk-dt-width" id="sat_mor_open" value="<?php echo !empty($clinic_timings[6][0][0]) ? date('h:iA', strtotime(@$clinic_timings[6][0][0])) : ''; ?>" />
    </td>
    <td align="center">
    To
    </td>
    <td align="center">
    <input name="sat_mor_close" type="text" class="day_time wk-dt-width" id="sat_mor_close" value="<?php echo !empty($clinic_timings[6][0][1]) ? date('h:iA', strtotime(@$clinic_timings[6][0][1])) : ''; ?>" />
    </td>
    <td align="center">
    <input name="sat_eve_open" type="text" class="day_time wk-dt-width" id="sat_eve_open" value="<?php echo !empty($clinic_timings[6][1][0]) ? date('h:iA', strtotime(@$clinic_timings[6][1][0])) : ''; ?>" />
    </td>
    <td align="center">
    To
    </td>
    <td align="center">
    <input name="sat_eve_close" type="text" class="day_time wk-dt-width" id="sat_eve_close" value="<?php echo !empty($clinic_timings[6][1][1]) ? date('h:iA', strtotime(@$clinic_timings[6][1][1])) : ''; ?>" />
    </td>
    <td align="center">
    <input name="days[]" type="checkbox" class="checkbox_valid" id="sat" value="saturday" <?php
    if(empty($clinic_timings[6][0][1]) && empty($clinic_timings[6][1][1]) && empty($clinic_timings[6][0][0]) && empty($clinic_timings[6][1][0])) echo '';
    else echo 'checked="checked"'; ?> />
    </td>
    
    </tr>
    
    <tr>
    <td width="80" align="center" class="from_fileld">
    Sunday
    </td>
    <td width="82" align="center">
    <input name="sun_mor_open" type="text" class="day_time wk-dt-width" id="sun_mor_open" value="<?php echo !empty($clinic_timings[0][0][0]) ? date('h:iA', strtotime(@$clinic_timings[0][0][0])) : ''; ?>" />
    </td>
    <td align="center">
    To
    </td>
    <td width="82" align="center">
    <input name="sun_mor_close" type="text" class="day_time wk-dt-width" id="sun_mor_close" value="<?php echo !empty($clinic_timings[0][0][1]) ? date('h:iA', strtotime(@$clinic_timings[0][0][1])) : ''; ?>" />
    </td>
    <td width="82" align="center">
    <input name="sun_eve_open" type="text" class="day_time wk-dt-width" id="sun_eve_open" value="<?php echo !empty($clinic_timings[0][1][0]) ? date('h:iA', strtotime(@$clinic_timings[0][1][0])) : ''; ?>" />
    </td>
    <td align="center">
    To
    </td>
    <td width="82" align="center">
    <input name="sun_eve_close" type="text" class="day_time wk-dt-width" id="sun_eve_close" value="<?php echo !empty($clinic_timings[0][1][1]) ? date('h:iA', strtotime(@$clinic_timings[0][1][1])) : ''; ?>" />
    </td>
    <td align="center">
    <input name="days[]" type="checkbox" class="checkbox_valid" id="sun" value="sunday" <?php
    if(empty($clinic_timings[0][0][1]) && empty($clinic_timings[0][1][1]) && empty($clinic_timings[0][0][0]) && empty($clinic_timings[0][1][0])) echo '';
    else echo 'checked="checked"'; ?>  />
    </td>
    </tr>
    </table>
    <?php }else{?>
    <table class="table table-striped table-condensed table-bordered">
    <tr>
    <th class="text-center">Day</th>
    <th class="text-center" colspan="3">First Half</th>
    <th class="text-center" colspan="3">Second Half</th>
    <th class="text-center"><a href="javascript:void(0)" id="copy_to_all_days">Copy To All Days</a></th>
    </tr>
    <tr>
    <td width="80" align="center" class="from_fileld">
    Monday
    </td>
    <td width="82" align="center">
    <input name="mon_mor_open" type="text" class="day_time wk-dt-width" id="mon_mor_open" value="<?php echo isset($_POST['mon_mor_open']) ? $_POST['mon_mor_open'] : '10:00AM'; ?>" />
    </td>
    <td align="center" class="">
    To
    </td>
    <td width="82" align="center">
    <input name="mon_mor_close" type="text" class="day_time wk-dt-width" id="mon_mor_close" value="<?php echo isset($_POST['mon_mor_close']) ? $_POST['mon_mor_close'] : '01:00PM'; ?>" />
    </td>
    <td width="82" align="center">
    <input name="mon_eve_open" type="text" class="day_time wk-dt-width" id="mon_eve_open" value="<?php echo isset($_POST['mon_eve_open']) ? $_POST['mon_eve_open'] : '05:00PM'; ?>" />
    </td>
    <td align="center">
    To
    </td>
    <td width="82" align="center">
    <input name="mon_eve_close" type="text" class="day_time wk-dt-width" id="mon_eve_close" value="<?php echo isset($_POST['mon_eve_close']) ? $_POST['mon_eve_close'] : '08:00PM'; ?>" />
    </td>
    <td align="center">
    <input name="days[]" type="checkbox" class="checkbox_valid" id="mon" value="monday" checked="checked" />
    </td>
    </tr>
    <tr>
    <td align="center" class="from_fileld">
    Tuesday
    </td>
    <td align="center">
    <input name="tue_mor_open" type="text" class="day_time wk-dt-width" id="tue_mor_open" value="<?php echo isset($_POST['tue_mor_open']) ? $_POST['tue_mor_open'] : "10:00AM" ; ?>" />
    </td>
    <td align="center" >
    To
    </td>
    <td align="center">
    <input name="tue_mor_close" type="text" class="day_time wk-dt-width" id="tue_mor_close" value="<?php echo isset($_POST['tue_mor_close']) ? $_POST['tue_mor_close'] : "01:00PM" ; ?>"/>
    </td>
    <td align="center">
    <input name="tue_eve_open" type="text" class="day_time wk-dt-width" id="tue_eve_open" value="<?php echo isset($_POST['tue_eve_open']) ? $_POST['tue_eve_open'] : "05:00PM" ; ?>" />
    </td>
    <td align="center">
    To
    </td>
    <td align="center">
    <input name="tue_eve_close" type="text" class="day_time wk-dt-width" id="tue_eve_close" value="<?php echo isset($_POST['tue_eve_close']) ? $_POST['tue_eve_close'] : "08:00PM" ; ?>" />
    </td>
    <td align="center">
    <input name="days[]" type="checkbox" class="checkbox_valid" id="tue" value="tuesday" checked="checked" />
    </td>
    </tr>
    <tr>
    <td align="center" class="from_fileld">
    Wednesday
    </td>
    <td align="center">
    <input name="wed_mor_open" type="text" class="day_time wk-dt-width" id="wed_mor_open" value="<?php echo isset($_POST['wed_mor_open']) ? $_POST['wed_mor_open'] : "10:00AM" ; ?>" />
    </td>
    <td align="center">
    To
    </td>
    <td align="center">
    <input name="wed_mor_close" type="text" class="day_time wk-dt-width" id="wed_mor_close" value="<?php echo isset($_POST['wed_mor_close']) ? $_POST['wed_mor_close'] : "01:00PM" ; ?>" />
    </td>
    <td align="center">
    <input name="wed_eve_open" type="text" class="day_time wk-dt-width" id="wed_eve_open" value="<?php echo isset($_POST['wed_eve_open']) ? $_POST['wed_eve_open'] : "05:00PM" ; ?>" />
    </td>
    <td align="center">
    To
    </td>
    <td align="center">
    <input name="wed_eve_close" type="text" class="day_time wk-dt-width" id="wed_eve_close" value="<?php echo isset($_POST['wed_eve_close']) ? $_POST['wed_eve_close'] : "08:00PM" ; ?>" />
    </td>
    <td align="center">
    <input name="days[]" type="checkbox" class="checkbox_valid" id="wed" value="wednesday" checked="checked" />
    </td>
    </tr>
    <tr>
    <td align="center" class="from_fileld">
    Thursday
    </td>
    <td align="center">
    <input name="thu_mor_open" type="text" class="day_time wk-dt-width" id="thu_mor_open" value="<?php echo isset($_POST['thu_mor_open']) ? $_POST['thu_mor_open'] : "10:00AM" ; ?>" />
    </td>
    <td align="center">
    To
    </td>
    <td align="center">
    <input name="thu_mor_close" type="text" class="day_time wk-dt-width" id="thu_mor_close" value="<?php echo isset($_POST['thu_mor_close']) ? $_POST['thu_mor_close'] : "01:00PM" ; ?>" />
    </td>
    <td align="center">
    <input name="thu_eve_open" type="text" class="day_time wk-dt-width" id="thu_eve_open" value="<?php echo isset($_POST['thu_eve_open']) ? $_POST['thu_eve_open'] : "05:00PM" ; ?>" />
    </td>
    <td align="center">
    To
    </td>
    <td align="center">
    <input name="thu_eve_close" type="text" class="day_time wk-dt-width" id="thu_eve_close" value="<?php echo isset($_POST['thu_eve_close']) ? $_POST['thu_eve_close'] : "08:00PM" ; ?>" />
    </td>
    <td align="center">
    <input name="days[]" type="checkbox" class="checkbox_valid" id="thu" value="thursday" checked="checked" />
    </td>
    </tr>
    <tr>
    <td align="center" class="from_fileld">
    Friday
    </td>
    <td align="center">
    <input name="fri_mor_open" type="text" class="day_time wk-dt-width" id="fri_mor_open" value="<?php echo isset($_POST['fri_mor_open']) ? $_POST['fri_mor_open'] : "10:00AM" ; ?>" />
    </td>
    <td align="center">
    To
    </td>
    <td align="center">
    <input name="fri_mor_close" type="text" class="day_time wk-dt-width" id="fri_mor_close" value="<?php echo isset($_POST['fri_mor_close']) ? $_POST['fri_mor_close'] : "01:00PM" ; ?>" />
    </td>
    <td align="center">
    <input name="fri_eve_open" type="text" class="day_time wk-dt-width" id="fri_eve_open" value="<?php echo isset($_POST['fri_eve_open']) ? $_POST['fri_eve_open'] : "05:00PM" ; ?>" />
    </td>
    <td align="center">
    To
    </td>
    <td align="center">
    <input name="fri_eve_close" type="text" class="day_time wk-dt-width" id="fri_eve_close" value="<?php echo isset($_POST['fri_eve_close']) ? $_POST['fri_eve_close'] : "08:00PM" ; ?>" />
    </td>
    <td align="center">
    <input name="days[]" type="checkbox" class="checkbox_valid" id="fri" value="friday" checked="checked" />
    </td>
    </tr>
    <tr>
    <td align="center" class="from_fileld">
    Saturday
    </td>
    <td align="center">
    <input name="sat_mor_open" type="text" class="day_time wk-dt-width" id="sat_mor_open" value="<?php echo isset($_POST['sat_mor_open']) ? $_POST['sat_mor_open'] : "10:00AM" ; ?>" />
    </td>
    <td align="center">
    To
    </td>
    <td align="center">
    <input name="sat_mor_close" type="text" class="day_time wk-dt-width" id="sat_mor_close" value="<?php echo isset($_POST['sat_mor_close']) ? $_POST['sat_mor_close'] : "01:00PM" ; ?>" />
    </td>
    <td align="center">
    <input name="sat_eve_open" type="text" class="day_time wk-dt-width" id="sat_eve_open" value="<?php echo isset($_POST['sat_eve_open']) ? $_POST['sat_eve_open'] : "05:00PM" ; ?>" />
    </td>
    <td align="center">
    To
    </td>
    <td align="center">
    <input name="sat_eve_close" type="text" class="day_time wk-dt-width" id="sat_eve_close" value="<?php echo isset($_POST['sat_eve_close']) ? $_POST['sat_eve_close'] : "08:00PM" ; ?>" />
    </td>
    <td align="center">
    <input name="days[]" type="checkbox" class="checkbox_valid" id="sat" value="saturday" checked="checked" />
    </td>
    </tr>
    <tr>
    <td align="center" class="from_fileld">
    Sunday
    </td>
    <td align="center">
    <input name="sun_mor_open" type="text" class="day_time wk-dt-width" id="sun_mor_open" value="<?php echo isset($_POST['sun_mor_open']) ? $_POST['sun_mor_open'] : "10:00AM" ; ?>" />
    </td>
    <td align="center">
    To
    </td>
    <td align="center">
    <input name="sun_mor_close" type="text" class="day_time wk-dt-width" id="sun_mor_close" value="<?php echo isset($_POST['sun_mor_close']) ? $_POST['sun_mor_close'] : "01:00PM" ; ?>" />
    </td>
    <td align="center">
    <input name="sun_eve_open" type="text" class="day_time wk-dt-width" id="sun_eve_open" value="<?php echo isset($_POST['sun_eve_open']) ? $_POST['sun_eve_open'] : "05:00PM" ; ?>" />
    </td>
    <td align="center">
    To
    </td>
    <td align="center">
    <input name="sun_eve_close" type="text" class="day_time wk-dt-width" id="sun_eve_close" value="<?php echo isset($_POST['sun_eve_close']) ? $_POST['sun_eve_close'] : "08:00PM" ; ?>" />
    </td>
    <td align="center">
    <input name="days[]" type="checkbox" class="checkbox_valid" id="sun" value="sunday" checked="checked" />
    </td>
    </tr>
    </table>
    <?php }?>
    </div>
  </div>
  <div class="form-group  form-inline">
    <label class="control-label">First Consultation Fees<?php echo form_error('consult_fee', '<span class="error_text">', '</span>'); ?></label>
    <div class="radio">
    <label class="label-control"><input type="radio" name="consult_fee" required value="1" <?php
    if(isset($clinic_details->consultation_fees) && $clinic_details->consultation_fees == '1') echo ' checked="checked"'; ?> /> Rs. 100~300</label>
    
    <label class="label-control">
    <input type="radio" name="consult_fee" required value="2" <?php
    if(isset($clinic_details->consultation_fees) && $clinic_details->consultation_fees == '2') echo ' checked="checked"'; ?> /> Rs. 301~500</label>
    <label class="label-control">
    <input type="radio" name="consult_fee" required value="3" <?php
    if(isset($clinic_details->consultation_fees) && $clinic_details->consultation_fees == '3') echo ' checked="checked"'; ?> /> Rs. 501~750</label>
    <label class="label-control">
    <input type="radio" name="consult_fee" required value="4" <?php
    if(isset($clinic_details->consultation_fees) && $clinic_details->consultation_fees == '4') echo ' checked="checked"'; ?> /> Rs. 751~1000</label>
    <label class="label-control">
    <input type="radio" name="consult_fee" required value="5" <?php
    if(isset($clinic_details->consultation_fees) && $clinic_details->consultation_fees == '5') echo ' checked="checked"'; ?> /> more than Rs. 1000</label>
    </div>
    </div>
  <div class="form-group  form-inline">
    <label class="control-label">Average Duration of Appointment<?php echo form_error('avg_patient_duration', '<p class="error_text">', '</p>'); ?></label>
    <input name="avg_patient_duration" id="avg_patient_duration " class="form-control autocomplete-duration" value="<?=@$clinic_details->duration ?>"  /> Minutes
    </div>
  
  <div class="form-group">
  	<div style="margin-bottom:20px;" class="row text-center">
            <h1>Add On Services <span class="label label-success">Coming Soon</span></h1>    
     	<!--<div class="col-sm-12">
    	<div class="panel">
      <div class="panel-heading ">
      <div class="text-center"><strong> Add On Services </strong></div>
      <div class="text-center">Would you like register to offer value added services to your patients?</div>
      </div>
      </div>
      </div> -->
    </div>
  	
    <div class="row">
      <div class="col-sm-4">
          <div class="panel panel-success panel-profile">
            <div class="panel-heading"></div>
            <div class="panel-body text-center panel-services">
              <img src="<?=IMAGE_URL?>teleconsulting_icon.png" class="panel-profile-img">
              <h5 class="panel-title services-panel" >Tele Consultation</h5>
              <p class="procedure-panel">We connect you to the Patients who take your Consultation Telephonically through an Appointment</p>
              <!--<p class="procedure-panel">Patient pays Tele Consultation fees as specified by you + BDA Service Charge of Rs. 100 through BDA Payment Gateway on BDA Website. Teleconsultation Appointment is confirmed only after confirmation of online payment by the patient. BDA pays you the Tele Consultation fees within 10 days from the Date of Tele Consultation in the Bank Account specified by you. Your Bank Details are taken after the 1st Tele consultation Service provided.</p>
              -->
            </div>
            <!--<div class="panel-footer">
            	<p class="text-center">
              <input type="text" placeholder="Rs." class="form-control" id="tele_fees" value="300" name="tele_fees" />
              </p>
            </div> -->
          </div>
        </div>
      <div class="col-sm-4">
        <div class="panel panel-warning panel-profile">
          <div class="panel-heading"></div>
          <div class="panel-body text-center panel-services">
            <img src="<?=IMAGE_URL?>online_consultation_icon.png" class="panel-profile-img">
            <h5 class="panel-title services-panel" >Online Consultation</h5>
            <p class="procedure-panel">We connect you to the Patients who take your Consultation Online through a Video Conferencing System with a prior Appointment</p>
            <!--<p class="procedure-panel">Patient pays Online Consultation fees as specified by you + BDA Service Charge. of Rs. 200 through BDA Payment Gateway on BDA Website. Online consultation Appointment is confirmed only after online payment by the patient. BDA pays you the Online Consultation fees within 10 days from the Date of Online Consultation in the Bank Account specified by you. Your Bank Details are taken after the 1st Online consultation Service provided. </p>
            -->
          </div>
         <!-- <div class="panel-footer">
            	<p class="text-center">
            <input type="text" placeholder="Rs." class="form-control" name="online_fees" value="500" id="online_fees">
            </p>
            </div> -->
        </div>
      </div>
      <div class="col-sm-4">
        <div class="panel panel-danger panel-profile ">
          <div class="panel-heading"></div>
          <div class="panel-body text-center panel-services">
            <img src="<?=IMAGE_URL?>express_appointment_icon.png" class="panel-profile-img">
            <h5 class="panel-title services-panel" >Express Appointment</h5>
            <p class="procedure-panel">For the Patients who do not want to wait for their turn and want your instant consultation</p>
            <!--<p class="procedure-panel">You may charge Premium Consultation fees for Express Appointment. Patient pays Premium Consultation fees as specified by you + BDA Service Charge of Rs. 100 through BDA Payment Gateway on BDA Website. Express Appointment is confirmed only after confirmation of online payment by the patient. BDA pays you the Premium Consultation fees within 10 days from the Date of Express Appointment in the Bank Account specified by you. Your Bank Details are taken after the 1st Express Appointment Service provided</p>
            -->
          </div>
          <!--<div class="panel-footer">
            	<p class="text-center">
            <input type="text" placeholder="Rs." class="form-control" name="express_fees" value="800" id="express_fees">
            </p>
            </div>-->
        </div>
      </div>
      
    </div>    
    </div>
    <div class="form-group">
	    <div class="text-right">
			<?php if(isset($editclinic) && $editclinic == 'editclinic'){}else{?>
      	<input type="submit" name="add_more_clinic" class="btn btn-default" value="Add More clinic"/>
        <?php }; ?>    
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
		<?php if(isset($latlong)): ?>
			$("#googleaddress").val('<?php echo $latlong; ?>');
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
<script type="text/javascript">
$(document).ready(function(e) {
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
	
	google.maps.event.addDomListener(window, 'load', initialize);
	$(".autocomplete-location").on('blur', function(){
		$("#googleaddress").val($(".autocomplete-location").val()+' ,'+$(".autocomplete-city").val().trim()+', India');
		$(".btngoogle").trigger('click');
	});
	
	var duration	=	["5","10","15","20","25","30","35","40","45","50","55","60"];
	$(".autocomplete-duration").autocomplete({
		source: duration,
		minLength: 0
	}).focus(function() {$(this).autocomplete("search", $(this).val());});
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
			$("#locality").val(ui.item.db_id);
		},
		search: function( event, ui ) {
			$("#locality").val("");
		}
	});		

	/* Clinic image cropper*/
	$(".clinicimage").click(function(){
		$("#myClinicModal").modal({backdrop: true});
		var imgid = this.id;
		console.log(imgid);
		var imgnumber = imgid.substr(12,1);
		console.log(imgnumber);
		$(".btnClinicCrop").attr('id', imgnumber);
	});	
	$(".remove-photo-x-btn").click(function(){
		var h = confirm('Are you sure you want to delete this photo?')
		if(h == true)
		{
		var id = this.id;
		$.ajax({
		type:	'POST',
		url:	'/doctor/deleteclinicphoto',
		data:{
			'photoid'	:	id,
			'doctorid'	:	'<?php echo @$doctorid; ?>',
			'clinicid'	:	'<?php echo @$clinic_details->id; ?>'
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
