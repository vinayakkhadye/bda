<?php
if((isset($editclinic) && $editclinic == 'editclinic') && ($clinic_details->longitude != NULL))
{
	$latitude = $clinic_details->latitude;
	$longitude = $clinic_details->longitude;
	$latlong = $latitude.','.$longitude;
}
if(isset($clinic_details->image))@$images = explode(',', @$clinic_details->image);

function get_base64($path = NULL)
{
	if($path != NULL)
	{
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$data = @file_get_contents($path);
		$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
		return $base64;
	}
}

function get_base64_value($path = NULL)
{
	if($path != NULL)
	{
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$data = @file_get_contents($path);
		$base64 = base64_encode($data);
		return $base64;
	}
}

function get_base64_name($path = NULL)
{
	if($path != NULL)
	{
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$data = @file_get_contents($path);
		$base64 = md5($path).'.'.$type;
		return $base64;
	}
}
if(isset($editclinic) && $editclinic == 'editclinic')$cl_number = explode('-',$clinic_details->contact_number,2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Add/Edit Clinic | BDA</title>
  <?php $this->load->view('admin/common/head'); ?>
</head>
<body>
<?php $this->load->view('admin/common/header'); ?>
<div class="container-fluid">
  <div class="panel panel-default">
  <div class="panel-heading">Add/Edit Clinic</div>
  <div class="panel-body">
    <div class="col-md-10 col-md-offset-1">
    <form id="sl_step2" name="sl_step2" method="POST" enctype="multipart/form-data" action="" data-toggle="validator">
    
    <input type="hidden" name="sl_step2"  value="sl_step2" />
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
    <label class="control-label">Clinic/Hospital Name : <?php echo form_error('clinic_name', '<span class="error_text">', '</span>'); ?>
    </label>
    <input name="clinic_name" value="<?php echo set_value('clinic_name', @$clinic_details->name); ?>" type="text" 
    class="from_text_filed form-control" id="textfield12" required />
    </div>
    <div class="form-group">
    <label class="control-label">Clinic/Hospital Photos : <mark>Please click on the number below to upload a photo</mark></label>
    <p class="PT20">
    <img id="imagedisplay1" class="clinicimgdisplay clinicimage" width="100" height="75"
    <?php
    if(isset($clinic_details) && !empty($images[0]))
    echo 'src="'.get_base64(@$images[0]).'" style="display: inline; opacity:1; border:0; margin-right:0;" />  <img src="'.IMAGE_URL.'xclose.png" id="1" class="remove-photo-x-btn" style="position: relative; top: -37px; left: -19px;" ';
    else
    echo 'style="display: inline;" src="'.IMAGE_URL.'grey.png" ';
    ?>
    />
    <img id="imagedisplay2" class="clinicimgdisplay clinicimage" width="100"  height="75"
    <?php
    if(isset($clinic_details) && !empty($images[1]))
    echo 'src="'.get_base64(@$images[1]).'" style="display: inline; opacity:1; border:0; margin-right:0;" />  <img src="'.IMAGE_URL.'xclose.png" id="2" class="remove-photo-x-btn" style="position: relative; top: -37px; left: -19px;" ';
    else
    echo 'style="display: inline;" src="'.IMAGE_URL.'grey.png" ';
    ?>
    />
    <img id="imagedisplay3" class="clinicimgdisplay clinicimage" width="100"  height="75"
    <?php
    if(isset($clinic_details) && !empty($images[2]))
    echo 'src="'.get_base64(@$images[2]).'" style="display: inline; opacity:1; border:0; margin-right:0;" />  <img src="'.IMAGE_URL.'xclose.png" id="3" class="remove-photo-x-btn" style="position: relative; top: -37px; left: -19px;" ';
    else
    echo 'style="display: inline;" src="'.IMAGE_URL.'grey.png" ';
    ?>
    />
    <img id="imagedisplay4" class="clinicimgdisplay clinicimage" width="100"  height="75"
    <?php
    if(isset($clinic_details) && !empty($images[3]))
    echo 'src="'.get_base64(@$images[3]).'" style="display: inline; opacity:1; border:0; margin-right:0;" />  <img src="'.IMAGE_URL.'xclose.png" id="4" class="remove-photo-x-btn" style="position: relative; top: -37px; left: -19px;" ';
    else
    echo 'style="display: inline;" src="'.IMAGE_URL.'grey.png" ';
    ?>
    />
    <img id="imagedisplay5" class="clinicimgdisplay clinicimage" width="100"  height="75"
    <?php
    if(isset($clinic_details) && !empty($images[4]))
    echo 'src="'.get_base64(@$images[4]).'" style="display: inline; opacity:1; border:0; margin-right:0;" />  <img src="'.IMAGE_URL.'xclose.png" id="5" class="remove-photo-x-btn" style="position: relative; top: -37px; left: -19px;" ';
    else
    echo 'style="display: inline;" src="'.IMAGE_URL.'grey.png" ';
    ?>
    />
    </p>
    </div>
    <div class="form-group">
    <label class="control-label">Clinic/Hospital Address : <?php echo form_error('clinic_address', '<span class="error_text">', '</span>'); ?>
    </label>
    <textarea name="clinic_address" cols="45" rows="5" class="from_text_area form-control" id="textarea" required><?php echo set_value('clinic_address', @$clinic_details->address); ?></textarea>
    </div>
    <div class="form-group form-inline">
    <label class="control-label">City : </label>
    <select name="city" class="from_list_menu form-control" id="city" required>
    <option value="">Select Your City</option>
    <?php foreach($cities as $row): ?>
    <option value="<?php echo $row->id; ?>"
    <?php if(@$clinic_details->city_id == $row->id) echo 'selected="selected"';elseif(set_value('city') == $row->id) echo 'selected="selected"'; ?> >
    <?php echo $row->name; ?>
    </option>
    <?php endforeach; ?>
    </select>
    <?php echo form_error('city', '<span class="error_text">', '</span>'); ?>
    </div>
    <div class="form-group form-inline">
    <label class="control-label">Locality :</label>
    <select name="locality" class="from_list_menu form-control" id="locality" >
    <option value="">Select Your Locality</option>
    <?php foreach($localities as $row): ?>
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
    ?>" class="from_text_filed form-control" id="other_locality" name="other_locality" style="display: none;" disabled="disabled" />
    <a href="javascript:void(0);" class="btn btn-warning"   id="other_locality_btn">
    <span style="">Other</span>
    </a>
    <div class="select-frm-list-btn btn btn-warning" style="display: none; cursor: pointer;">Select from list</div>
    <?php echo form_error('locality', '<span class="error_text">', '</span>'); ?>
    </div>
    <div class="form-group  form-inline">
    <label class="control-label">Map Loaction :</label>
    <p>Locate your clinic by dragging the location pointer <img src="//maps.gstatic.com/mapfiles/markers2/marker.png" style="height: 26px;"/> 
    <mark>OR</mark> If you do not find the exact location, choose the nearest landmark</p>
    <p>
    <input type="text" class="form-control" id="googleaddress" value="" placeholder="Locality" />
    <input type="button" class="btngoogle btn btn-primary" value="Find Location" onclick="showAddress(document.getElementById('googleaddress').value); return false" />
    </p>
    <div id="map_canvas" style="width: 100%; height: 300px"></div>
    <input type="hidden" name="latlong" id="latlong" value="<?php echo @$latlong; ?>" />      
    </div>
    <div class="form-group form-inline">
    <label class="control-label">Pincode :</label>
    <input name="pincode" class="form-control" value="<?php echo set_value('pincode', @$clinic_details->pincode); ?>" type="text" 
    id="textfield4" placeholder="Pincode" required />
    <?php echo form_error('pincode', '<span class="error_text">', '</span>'); ?>
    </div>
    <div class="form-group  form-inline">
    <label class="control-label">Clinic / Hospital Landline No :</label>
    <?php if(@sizeof($cl_number) > 1){?>
    <input name="clinic_number_code" value="<?php echo set_value('clinic_number_code', @$cl_number[0]); ?>" 
    placeholder="Code" type="text" class="from_text_filed form-control" id="textfield12" />
    <input name="clinic_number" value="<?php echo set_value('clinic_number', @$cl_number[1]); ?>" type="text" placeholder="Number" 
    class="from_text_filed form-control" id="textfield12" required />
    <?php }else{ ?>
    <input name="clinic_number_code" value="<?php echo set_value('clinic_number_code'); ?>" placeholder="Code" type="text" class="from_text_filed form-control" id="textfield12"  />
    <input name="clinic_number" value="<?php echo set_value('clinic_number', @$clinic_details->contact_number); ?>" type="text" 
    placeholder="Number" class="from_text_filed form-control" id="textfield12" required />        
    <?php }?>
    
    <?php echo form_error('clinic_number', '<span class="error_text">', '</span>'); ?>
    <?php echo form_error('clinic_number_code', '<span class="error_text">', '</span>'); ?>
    
    </div>
    <div class="form-group form-inline">
    <label class="control-label">Is Number Verified : </label>
    <input type="checkbox" value="1" <?php if(isset($_POST['is_number_verified']) && !empty($_POST['is_number_verified'])){echo 'checked="checked"';}else{if(!empty($clinic_details->is_number_verified)){echo 'checked="checked"';}}?> name="is_number_verified" />
    </div>
    <div class="form-group form-inline">
    <label class="control-label">Extensions Can be used : </label>
    <?php foreach($knowlarity_numbers as $know_index=>$know_val){ ?>
    <code><?=$know_val['number']." : ".$know_val['extension']?></code>&nbsp;&nbsp;&nbsp;
    <?php }?>
    </div>
    <div class="form-group form-inline">
    <label class="control-label">Knowlarity Number : </label>
    <input name="knowlarity_number" class="form-control" value="<?php echo set_value('knowlarity_number', @$clinic_details->knowlarity_number); ?>" type="text" placeholder="Knowlarity Number"/>
    <?php echo form_error('knowlarity_number', '<span class="error_text">', '</span>'); ?>
    </div>
    <div class="form-group form-inline">
    <label class="control-label">Knowlarity Extension : </label>
    <input name="knowlarity_extension" class="form-control" value="<?php echo set_value('knowlarity_extension', @$clinic_details->knowlarity_extension); ?>" type="text" placeholder="Knowlarity Extension"/>
    <?php echo form_error('knowlarity_extension', '<span class="error_text">', '</span>'); ?>
    </div>
    <div class="form-group  form-inline">
    <label class="control-label">Consultation Days &amp; Timings :</label>
    <div class="table-responsive">
    <?php if(isset($editclinic) && $editclinic == 'editclinic'){?>
    <table class="table table-striped table-condensed table-bordered">
    <tr>
    <th>Day</th>
    <th colspan="3">First Half</th>
    <th colspan="3">Second Half</td>
    <th><a href="javascript:void(0)" id="copy_to_all_days">All</a></th>
    </tr>
    <tr>
      <td align="center" class="from_fileld">
        Monday
      </td>
      <td align="center">
        <input name="mon_mor_open" type="text" class="day_time" id="mon_mor_open" value="<?php echo !empty($clinic_timings[1][0][0]) ? date('h:iA', strtotime(@$clinic_timings[1][0][0])) : ''; ?>" />
      </td>
      <td align="center" class="from_fileld">
        to
      </td>
      <td align="center">
        <input name="mon_mor_close" type="text" class="day_time" id="mon_mor_close" value="<?php echo !empty($clinic_timings[1][0][1]) ? date('h:iA', strtotime(@$clinic_timings[1][0][1])) : ''; ?>" />
      </td>
      <td align="center">
        <input name="mon_eve_open" type="text" class="day_time" id="mon_eve_open" value="<?php echo !empty($clinic_timings[1][1][0]) ? date('h:iA', strtotime(@$clinic_timings[1][1][0])) : ''; ?>" />
      </td>
      <td align="center">
        <span class="from_fileld">
          to
        </span>
      </td>
      <td align="center">
        <input name="mon_eve_close" type="text" class="day_time" id="mon_eve_close"
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
    <input name="tue_mor_open" type="text" class="day_time" id="tue_mor_open"
    value="<?php echo !empty($clinic_timings[2][0][0]) ? date('h:iA', strtotime(@$clinic_timings[2][0][0])) : ''; ?>" />
    </td>
    <td align="center" class="from_fileld">
    to
    </td>
    <td align="center">
    <input name="tue_mor_close" type="text" class="day_time" id="tue_mor_close" value="<?php echo !empty($clinic_timings[2][0][1]) ? date('h:iA', strtotime(@$clinic_timings[2][0][1])) : ''; ?>" />
    </td>
    <td align="center">
    <input name="tue_eve_open" type="text" class="day_time" id="tue_eve_open" value="<?php echo !empty($clinic_timings[2][1][0]) ? date('h:iA', strtotime(@$clinic_timings[2][1][0])) : ''; ?>" />
    </td>
    <td align="center">
    <span class="from_fileld">
    to
    </span>
    </td>
    <td align="center">
    <input name="tue_eve_close" type="text" class="day_time" id="tue_eve_close" value="<?php echo !empty($clinic_timings[2][1][1]) ? date('h:iA', strtotime(@$clinic_timings[2][1][1])) : ''; ?>" />
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
    <input name="wed_mor_open" type="text" class="day_time" id="wed_mor_open" value="<?php echo !empty($clinic_timings[3][0][0]) ? date('h:iA', strtotime(@$clinic_timings[3][0][0])) : ''; ?>" />
    </td>
    <td align="center" class="from_fileld">
    to
    </td>
    <td align="center">
    <input name="wed_mor_close" type="text" class="day_time" id="wed_mor_close" value="<?php echo !empty($clinic_timings[3][0][1]) ? date('h:iA', strtotime(@$clinic_timings[3][0][1])) : ''; ?>" />
    </td>
    <td align="center">
    <input name="wed_eve_open" type="text" class="day_time" id="wed_eve_open" value="<?php echo !empty($clinic_timings[3][1][0]) ? date('h:iA', strtotime(@$clinic_timings[3][1][0])) : ''; ?>" />
    </td>
    <td align="center">
    <span class="from_fileld">
    to
    </span>
    </td>
    <td align="center">
    <input name="wed_eve_close" type="text" class="day_time" id="wed_eve_close" value="<?php echo !empty($clinic_timings[3][1][1]) ? date('h:iA', strtotime(@$clinic_timings[3][1][1])) : ''; ?>" />
    </td>
    <td align="center">
    <input name="days[]" type="checkbox" class="checkbox_valid" id="wed" value="wednesday" <?php
    if(empty($clinic_timings[3][0][1]) && empty($clinic_timings[3][1][1]) && empty($clinic_timings[3][0][0]) && empty($clinic_timings[3][1][0])) echo '';
    else echo 'checked="checked"'; ?> />
    </td>
    </tr>
    
    <tr>
    <td align="center" class="from_fileld">
    Thurday
    </td>
    <td align="center">
    <input name="thu_mor_open" type="text" class="day_time" id="thu_mor_open" value="<?php echo !empty($clinic_timings[4][0][0]) ? date('h:iA', strtotime(@$clinic_timings[4][0][0])) : ''; ?>" />
    </td>
    <td align="center" class="from_fileld">
    to
    </td>
    <td align="center">
    <input name="thu_mor_close" type="text" class="day_time" id="thu_mor_close" value="<?php echo !empty($clinic_timings[4][0][1]) ? date('h:iA', strtotime(@$clinic_timings[4][0][1])) : ''; ?>" />
    </td>
    <td align="center">
    <input name="thu_eve_open" type="text" class="day_time" id="thu_eve_open" value="<?php echo !empty($clinic_timings[4][1][0]) ? date('h:iA', strtotime(@$clinic_timings[4][1][0])) : ''; ?>" />
    </td>
    <td align="center">
    <span class="from_fileld">
    to
    </span>
    </td>
    <td align="center">
    <input name="thu_eve_close" type="text" class="day_time" id="thu_eve_close" value="<?php echo !empty($clinic_timings[4][1][1]) ? date('h:iA', strtotime(@$clinic_timings[4][1][1])) : ''; ?>" />
    </td>
    <td align="center">
    <input name="days[]" type="checkbox" class="checkbox_valid" id="thu" value="thursday" <?php
    if(empty($clinic_timings[4][0][1]) && empty($clinic_timings[4][1][1]) && empty($clinic_timings[4][0][0]) && empty($clinic_timings[4][1][0])) echo '';
    else echo 'checked="checked"'; ?> />
    </td>
    </tr>
    
    <tr>
    <td align="center" class="from_fileld">
    Firday
    </td>
    <td align="center">
    <input name="fri_mor_open" type="text" class="day_time" id="fri_mor_open" value="<?php echo !empty($clinic_timings[5][0][0]) ? date('h:iA', strtotime(@$clinic_timings[5][0][0])) : ''; ?>" />
    </td>
    <td align="center" class="from_fileld">
    to
    </td>
    <td align="center">
    <input name="fri_mor_close" type="text" class="day_time" id="fri_mor_close" value="<?php echo !empty($clinic_timings[5][0][1]) ? date('h:iA', strtotime(@$clinic_timings[5][0][1])) : ''; ?>" />
    </td>
    <td align="center">
    <input name="fri_eve_open" type="text" class="day_time" id="fri_eve_open" value="<?php echo !empty($clinic_timings[5][1][0]) ? date('h:iA', strtotime(@$clinic_timings[5][1][0])) : ''; ?>" />
    </td>
    <td align="center">
    <span class="from_fileld">
    to
    </span>
    </td>
    <td align="center">
    <input name="fri_eve_close" type="text" class="day_time" id="fri_eve_close" value="<?php echo !empty($clinic_timings[5][1][1]) ? date('h:iA', strtotime(@$clinic_timings[5][1][1])) : ''; ?>" />
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
    <input name="sat_mor_open" type="text" class="day_time" id="sat_mor_open" value="<?php echo !empty($clinic_timings[6][0][0]) ? date('h:iA', strtotime(@$clinic_timings[6][0][0])) : ''; ?>" />
    </td>
    <td align="center">
    <span class="from_fileld">
    to
    </span>
    </td>
    <td align="center">
    <input name="sat_mor_close" type="text" class="day_time" id="sat_mor_close" value="<?php echo !empty($clinic_timings[6][0][1]) ? date('h:iA', strtotime(@$clinic_timings[6][0][1])) : ''; ?>" />
    </td>
    <td align="center">
    <input name="sat_eve_open" type="text" class="day_time" id="sat_eve_open" value="<?php echo !empty($clinic_timings[6][1][0]) ? date('h:iA', strtotime(@$clinic_timings[6][1][0])) : ''; ?>" />
    </td>
    <td align="center">
    <span class="from_fileld">
    to
    </span>
    </td>
    <td align="center">
    <input name="sat_eve_close" type="text" class="day_time" id="sat_eve_close" value="<?php echo !empty($clinic_timings[6][1][1]) ? date('h:iA', strtotime(@$clinic_timings[6][1][1])) : ''; ?>" />
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
    <input name="sun_mor_open" type="text" class="day_time" id="sun_mor_open" value="<?php echo !empty($clinic_timings[0][0][0]) ? date('h:iA', strtotime(@$clinic_timings[0][0][0])) : ''; ?>" />
    </td>
    <td width="35" align="center" class="from_fileld">
    to
    </td>
    <td width="82" align="center">
    <input name="sun_mor_close" type="text" class="day_time" id="sun_mor_close" value="<?php echo !empty($clinic_timings[0][0][1]) ? date('h:iA', strtotime(@$clinic_timings[0][0][1])) : ''; ?>" />
    </td>
    <td width="82" align="center">
    <input name="sun_eve_open" type="text" class="day_time" id="sun_eve_open" value="<?php echo !empty($clinic_timings[0][1][0]) ? date('h:iA', strtotime(@$clinic_timings[0][1][0])) : ''; ?>" />
    </td>
    <td width="35" align="center">
    <span class="from_fileld">
    to
    </span>
    </td>
    <td width="82" align="center">
    <input name="sun_eve_close" type="text" class="day_time" id="sun_eve_close" value="<?php echo !empty($clinic_timings[0][1][1]) ? date('h:iA', strtotime(@$clinic_timings[0][1][1])) : ''; ?>" />
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
    <th>Day</th>
    <th colspan="3">First Half</th>
    <th colspan="3">Second Half</th>
    <th><a href="javascript:void(0)" id="copy_to_all_days">All</a></th>
    </tr>
    <tr>
    <td width="80" align="center" class="from_fileld">
    Monday
    </td>
    <td width="82" align="center">
    <input name="mon_mor_open" type="text" class="day_time" id="mon_mor_open" value="<?php echo isset($_POST['mon_mor_open']) ? $_POST['mon_mor_open'] : '10:00AM'; ?>" />
    </td>
    <td width="35" align="center" class="from_fileld">
    to
    </td>
    <td width="82" align="center">
    <input name="mon_mor_close" type="text" class="day_time" id="mon_mor_close" value="<?php echo isset($_POST['mon_mor_close']) ? $_POST['mon_mor_close'] : '01:00PM'; ?>" />
    </td>
    <td width="82" align="center">
    <input name="mon_eve_open" type="text" class="day_time" id="mon_eve_open" value="<?php echo isset($_POST['mon_eve_open']) ? $_POST['mon_eve_open'] : '05:00PM'; ?>" />
    </td>
    <td width="35" align="center">
    <span class="from_fileld">
    to
    </span>
    </td>
    <td width="82" align="center">
    <input name="mon_eve_close" type="text" class="day_time" id="mon_eve_close" value="<?php echo isset($_POST['mon_eve_close']) ? $_POST['mon_eve_close'] : '08:00PM'; ?>" />
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
    <input name="tue_mor_open" type="text" class="day_time" id="tue_mor_open" value="<?php echo isset($_POST['tue_mor_open']) ? $_POST['tue_mor_open'] : "10:00AM" ; ?>" />
    </td>
    <td align="center" class="from_fileld">
    to
    </td>
    <td align="center">
    <input name="tue_mor_close" type="text" class="day_time" id="tue_mor_close" value="<?php echo isset($_POST['tue_mor_close']) ? $_POST['tue_mor_close'] : "01:00PM" ; ?>"/>
    </td>
    <td align="center">
    <input name="tue_eve_open" type="text" class="day_time" id="tue_eve_open" value="<?php echo isset($_POST['tue_eve_open']) ? $_POST['tue_eve_open'] : "05:00PM" ; ?>" />
    </td>
    <td align="center">
    <span class="from_fileld">
    to
    </span>
    </td>
    <td align="center">
    <input name="tue_eve_close" type="text" class="day_time" id="tue_eve_close" value="<?php echo isset($_POST['tue_eve_close']) ? $_POST['tue_eve_close'] : "08:00PM" ; ?>" />
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
    <input name="wed_mor_open" type="text" class="day_time" id="wed_mor_open" value="<?php echo isset($_POST['wed_mor_open']) ? $_POST['wed_mor_open'] : "10:00AM" ; ?>" />
    </td>
    <td align="center" class="from_fileld">
    to
    </td>
    <td align="center">
    <input name="wed_mor_close" type="text" class="day_time" id="wed_mor_close" value="<?php echo isset($_POST['wed_mor_close']) ? $_POST['wed_mor_close'] : "01:00PM" ; ?>" />
    </td>
    <td align="center">
    <input name="wed_eve_open" type="text" class="day_time" id="wed_eve_open" value="<?php echo isset($_POST['wed_eve_open']) ? $_POST['wed_eve_open'] : "05:00PM" ; ?>" />
    </td>
    <td align="center">
    <span class="from_fileld">
    to
    </span>
    </td>
    <td align="center">
    <input name="wed_eve_close" type="text" class="day_time" id="wed_eve_close" value="<?php echo isset($_POST['wed_eve_close']) ? $_POST['wed_eve_close'] : "08:00PM" ; ?>" />
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
    <input name="thu_mor_open" type="text" class="day_time" id="thu_mor_open" value="<?php echo isset($_POST['thu_mor_open']) ? $_POST['thu_mor_open'] : "10:00AM" ; ?>" />
    </td>
    <td align="center" class="from_fileld">
    to
    </td>
    <td align="center">
    <input name="thu_mor_close" type="text" class="day_time" id="thu_mor_close" value="<?php echo isset($_POST['thu_mor_close']) ? $_POST['thu_mor_close'] : "01:00PM" ; ?>" />
    </td>
    <td align="center">
    <input name="thu_eve_open" type="text" class="day_time" id="thu_eve_open" value="<?php echo isset($_POST['thu_eve_open']) ? $_POST['thu_eve_open'] : "05:00PM" ; ?>" />
    </td>
    <td align="center">
    <span class="from_fileld">
    to
    </span>
    </td>
    <td align="center">
    <input name="thu_eve_close" type="text" class="day_time" id="thu_eve_close" value="<?php echo isset($_POST['thu_eve_close']) ? $_POST['thu_eve_close'] : "08:00PM" ; ?>" />
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
    <input name="fri_mor_open" type="text" class="day_time" id="fri_mor_open" value="<?php echo isset($_POST['fri_mor_open']) ? $_POST['fri_mor_open'] : "10:00AM" ; ?>" />
    </td>
    <td align="center" class="from_fileld">
    to
    </td>
    <td align="center">
    <input name="fri_mor_close" type="text" class="day_time" id="fri_mor_close" value="<?php echo isset($_POST['fri_mor_close']) ? $_POST['fri_mor_close'] : "01:00PM" ; ?>" />
    </td>
    <td align="center">
    <input name="fri_eve_open" type="text" class="day_time" id="fri_eve_open" value="<?php echo isset($_POST['fri_eve_open']) ? $_POST['fri_eve_open'] : "05:00PM" ; ?>" />
    </td>
    <td align="center">
    <span class="from_fileld">
    to
    </span>
    </td>
    <td align="center">
    <input name="fri_eve_close" type="text" class="day_time" id="fri_eve_close" value="<?php echo isset($_POST['fri_eve_close']) ? $_POST['fri_eve_close'] : "08:00PM" ; ?>" />
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
    <input name="sat_mor_open" type="text" class="day_time" id="sat_mor_open" value="<?php echo isset($_POST['sat_mor_open']) ? $_POST['sat_mor_open'] : "10:00AM" ; ?>" />
    </td>
    <td align="center" class="from_fileld">
    to
    </td>
    <td align="center">
    <input name="sat_mor_close" type="text" class="day_time" id="sat_mor_close" value="<?php echo isset($_POST['sat_mor_close']) ? $_POST['sat_mor_close'] : "01:00PM" ; ?>" />
    </td>
    <td align="center">
    <input name="sat_eve_open" type="text" class="day_time" id="sat_eve_open" value="<?php echo isset($_POST['sat_eve_open']) ? $_POST['sat_eve_open'] : "05:00PM" ; ?>" />
    </td>
    <td align="center">
    <span class="from_fileld">
    to
    </span>
    </td>
    <td align="center">
    <input name="sat_eve_close" type="text" class="day_time" id="sat_eve_close" value="<?php echo isset($_POST['sat_eve_close']) ? $_POST['sat_eve_close'] : "08:00PM" ; ?>" />
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
    <input name="sun_mor_open" type="text" class="day_time" id="sun_mor_open" value="<?php echo isset($_POST['sun_mor_open']) ? $_POST['sun_mor_open'] : "10:00AM" ; ?>" />
    </td>
    <td align="center">
    <span class="from_fileld">
    to
    </span>
    </td>
    <td align="center">
    <input name="sun_mor_close" type="text" class="day_time" id="sun_mor_close" value="<?php echo isset($_POST['sun_mor_close']) ? $_POST['sun_mor_close'] : "01:00PM" ; ?>" />
    </td>
    <td align="center">
    <input name="sun_eve_open" type="text" class="day_time" id="sun_eve_open" value="<?php echo isset($_POST['sun_eve_open']) ? $_POST['sun_eve_open'] : "05:00PM" ; ?>" />
    </td>
    <td align="center">
    <span class="from_fileld">
    to
    </span>
    </td>
    <td align="center">
    <input name="sun_eve_close" type="text" class="day_time" id="sun_eve_close" value="<?php echo isset($_POST['sun_eve_close']) ? $_POST['sun_eve_close'] : "08:00PM" ; ?>" />
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
    <label class="control-label">First Consultation Fees : <?php echo form_error('consult_fee', '<span class="error_text">', '</span>'); ?>
    </label>
    <?php
    if(isset($clinic_details->consultation_fees) && $clinic_details->consultation_fees != '' && $clinic_details->consultation_fees != NULL):
    ?>
    <input type="radio" name="consult_fee" required value="1" <?php
    if($clinic_details->consultation_fees == '1') echo ' checked="checked"'; ?> />Rs. 100~300 &nbsp;&nbsp;&nbsp;
    <input type="radio" name="consult_fee" required value="2" <?php
    if($clinic_details->consultation_fees == '2') echo ' checked="checked"'; ?> />Rs. 301~500 &nbsp;&nbsp;&nbsp;
    <input type="radio" name="consult_fee" required value="3" <?php
    if($clinic_details->consultation_fees == '3') echo ' checked="checked"'; ?> />Rs. 501~750 &nbsp;&nbsp;&nbsp;
    <input type="radio" name="consult_fee" required value="4" <?php
    if($clinic_details->consultation_fees == '4') echo ' checked="checked"'; ?> />Rs. 751~1000 &nbsp;&nbsp;&nbsp;
    <input type="radio" name="consult_fee" required value="5" <?php
    if($clinic_details->consultation_fees == '5') echo ' checked="checked"'; ?> /> more than Rs. 1000
    <?php
    else:
    //print_r($_POST);
    ?>
    <input type="radio" name="consult_fee" required value="1" <?php
    if(@$_POST['consult_fee'] == '1') echo ' checked="checked"'; ?> />Rs. 100~300 &nbsp;&nbsp;&nbsp;
    <input type="radio" name="consult_fee" required value="2" <?php
    if(@$_POST['consult_fee'] == '2') echo ' checked="checked"'; ?> />Rs. 301~500 &nbsp;&nbsp;&nbsp;
    <input type="radio" name="consult_fee" required value="3" <?php
    if(@$_POST['consult_fee'] == '3') echo ' checked="checked"'; ?> />Rs. 501~750 &nbsp;&nbsp;&nbsp;
    <input type="radio" name="consult_fee" required value="4" <?php
    if(@$_POST['consult_fee'] == '4') echo ' checked="checked"'; ?> />Rs. 751~1000 &nbsp;&nbsp;&nbsp;
    <input type="radio" name="consult_fee" required value="5" <?php
    if(@$_POST['consult_fee'] == '5') echo ' checked="checked"'; ?> /> more than Rs. 1000
    <?php
    endif;
    ?>    
    </div>
    <div class="form-group  form-inline">
    <label class="control-label">Average Duration of appointment / patient : </label>
    <select name="avg_patient_duration" class="from_list_menu form-control" required	>
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
    <span>&nbsp;Minutes</span>
    <?php echo form_error('avg_patient_duration', '<span class="error_text">', '</span>'); ?>
    </div>
    <div class="form-group form-inline">
    <label class="control-label">On line Consultaiton : </label>
    <input id="online_fees" value="<?php if(isset($_POST['online_fees']))echo $_POST['online_fees'];else{if(@$clinic_details->online_fees > 0)echo @$clinic_details->online_fees;}?>" name="online_fees" type="text" class="onlie_field_rs form-control" placeholder="Rs." />
    </div>
    <div class="form-group form-inline">
    <label class="control-label">Express Appointment : </label>
    <input id="express_fees" value="<?php if(isset($_POST['express_fees']))echo $_POST['express_fees'];else{if(@$clinic_details->express_fees > 0)echo @$clinic_details->express_fees;}?>" name="express_fees" type="text" class="exp_field_rs form-control" placeholder="Rs." />
    </div>
    <div class="form-group form-inline">
    <label class="control-label">Tele Consultation : </label>
    <input name="tele_fees" value="<?php if(isset($_POST['tele_fees']))echo $_POST['tele_fees'];else{if(@$clinic_details->tele_fees > 0)echo @$clinic_details->tele_fees;}?>" id="tele_fees" type="text" class="tete_field_rs form-control" placeholder="Rs." />
    </div>
    <div class="form-group form-inline">
    <label class="control-label">Health Utsav : </label>
    <input type="checkbox" value="1" <?php if(isset($_POST['health_utsav']) && !empty($_POST['health_utsav'])){echo 'checked="checked"';}else{if(!empty($clinic_details->health_utsav)){echo 'checked="checked"';}}?> name="health_utsav" />
    </div>
    <div class="form-group form-inline">
    <label class="control-label">Health Utsav Place Slug: </label>
    <input name="health_utsav_place" value="<?php if(isset($_POST['health_utsav_place']))echo $_POST['health_utsav_place'];else{if(@$clinic_details->health_utsav_place > 0)echo @$clinic_details->health_utsav_place;}?>" id="health_utsav_place" type="text" class="form-control" placeholder="some-place-slug" />
    </div>
    <div class="form-group">
    <?php if(isset($editclinic) && $editclinic == 'editclinic') {}else{?>
    <input type="submit" name="add_more_clinic" value="Add More Clinic" class="btn btn-primary" />
    <?php }; ?>
    <input type="submit" class="btn btn-primary" value="SUBMIT" /><!--onclick="javascript:document.getElementById('sl_step2').submit();"-->
    </div>
    </div>
    </form>
    </div>
  </div>
  <div class="panel-footer">
  <?php $this->load->view('admin/common/footer'); ?>
  </div> 
  </div>
  <div class="modal fade" id="myModal" role="dialog">
  <div class="modal-dialog">
  
  <!-- Modal content-->
  <div class="modal-content">
  <div class="modal-header">
  <button type="button" class="close" data-dismiss="modal">&times;</button>
  <h4 class="modal-title">Upload Image</h4>
  </div>
  <div class="modal-body">
  <div class="imageBox">
  <div class="thumbbigBox"></div>
  <div class="spinner" style="display: none">Loading...</div>
  </div>
  <div class="PT5">
  <span class="btn btn-primary btn-file">
      Browse <input type="file" id="file">
  </span>          
  <button type="button" class="btn btn-primary btnCrop" data-dismiss="modal" id="">Crop</button>
  <input type="button" id="btnZoomIn" value="Zoom in (+)" class="btn btn-primary">
  <input type="button" id="btnZoomOut" value="Zoom out (-)" class="btn btn-primary">
  </div>
  <div class="cropped"></div>
  </div>
  </div>
  
  </div>
  </div>
</div> 
<?php $this->load->view('admin/common/bottom'); ?> 
<script src="//maps.google.com/maps?file=api&v=3&key=AIzaSyCO8K3lZSCQgKMnmIyExMyglEI4s0FV4Uo"></script>
<script src="<?php echo JS_URL; ?>admin/jquery-cropimg-plugin.js"></script>
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
<script type="text/javascript">
$(document).ready(function()
{
<?php
$message = $this->session->flashdata('errormessage');
if(isset($message) && !empty($message))
echo "alert('{$message}');";
?>



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

$(".day_time").timepicker(
{
template: false,
showInputs: false,
minuteStep: 5,
defaultTime: false
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
<?php if(isset($clinic_details->tele_fees) && !empty($clinic_details->tele_fees))
{
?>
if(<?php echo @$clinic_details->tele_fees; ?> > 0)
{
$("#example3").show();
}

<?php
}?>

<?php if(isset($clinic_details->online_fees) && !empty($clinic_details->online_fees))
{
?>
if(<?php echo @$clinic_details->online_fees; ?> > 0)
{
$("#example2").show();
}
<?php
} ?>

<?php if(isset($clinic_details->express_fees) && !empty($clinic_details->express_fees))
{
?>
if(<?php echo @$clinic_details->express_fees; ?> > 0)
{
$("#example4").show();
}
<?php
}?>
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

$(".from_text_filed, .from_text_area").blur(function()
{
var value = $(this).val();
$(this).val($.ucfirst(value));
});



$(".clinicimage").click(function()
{
$("#myModal").modal({backdrop: true});

var imgid = this.id;
var imgnumber = imgid.substr(12,1);
$(".file").attr('id', 'file'+imgnumber);
//console.log($(".file").attr('id'));
var filebtnid = $(".file").attr('id');
//$("#"+filebtnid+"").trigger('click');

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
url:	'/bdabdabda/manage_doctors/deleteclinicphoto',
data:
{
'photoid'	:	id,
'doctorid'	:	'<?php echo @$doctorid; ?>',
'clinicid'	:	'<?php echo @$clinic_details->id; ?>'
},
success: function(e)
{
console.log(e);
//location.reload();
$("#imagedisplay"+id).attr("src",'<?=IMAGE_URL?>grey.png');
$("#clinicphotoname"+id).val("");
$("#clinicphotoimg"+id).val("");

}
});
}
});

google.maps.event.addDomListener(window, 'load', initialize);


});
</script>
<script type="text/javascript">
$(document).ready(function()
{
$("#sl_step1").hide();
$("#sl_step2").show();
$("#sl_step3").hide();
<?php
if(isset($smartlisting))
echo '$(".progressbar_sl").show();';
else
echo '$(".progressbar_sl").hide();';
?>
});
</script>
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
thumbBox: '.thumbbigBox',
spinner: '.spinner',
imgSrc: 'avatar.png'
}
var cropper;
$('#file').on('change', function()
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
//alert($('#file').val());
$('#clinicphotoname'+idno+'').val($('#file').val());
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
</body>
</html>
