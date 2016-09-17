<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <?php $this->load->view('login/common/head'); ?>
</head>
<body>
<?php $this->load->view('login/common/patient_header'); ?>
<div class="container H550">
<div class="row">
<div class="col-lg-offset-3 col-md-offset-1 col-lg-6 col-md-10 col-sm-12 col-xs-12">            
<div class="panel panel-default">    
<div class="panel-body">
 <div class="row"> 
 <div class="col-lg-12 col-md-12">
 <form name="patient_form" method="POST" enctype="multipart/form-data" autocomplete="false">
	<div class="form-group">
  <label class="control-label">Profile Picture<?php echo form_error('image', '<span class="error_text">', '</span>'); ?></label>
  <div id="profileimgbox"><img src="<?=($user_image)?BASE_URL.@$user_image:IMAGE_URL.'photo_frame.jpg' ?>" width="126" height="152"/></div>          
  </div>
  <div class="form-group">
  <button type="button" class="btn btn-info btn-md" id="myBtn"><span class="glyphicon glyphicon-upload"></span>&nbsp;Select a File</button>
  <input type="hidden" name="profile_pic_base64" id="profile_pic_base64" value="" />
  <input type="hidden" name="profile_pic_base64_name" id="profile_pic_base64_name" value="" />
  </div>
  
  <div class="form-group ">
    <label for="id_name" class="control-label">Patient Name<?php echo form_error('name', '<span class="error_text">', '</span>'); ?></label>
    <input id="id_name" name="name" value="<?php echo set_value('name', @$userdetails->name); ?>" type="text" class="form-control"  required />
  </div>

  <div class="form-group ">
    <label for="id_email" class="control-label">E-mail ID<?php echo form_error('email', '<span class="error_text">', '</span>'); ?></label>
    <input id="id_email" name="email" value="<?php echo set_value('name', @$userdetails->email_id); ?>" type="text" class="form-control" readonly="readonly"/>
  </div>
  <div class="form-group ">
    <label for="id_mob" class="control-label">Mobile Number<?php echo form_error('mob', '<span class="error_text">', '</span>'); ?></label>
    <input id="id_mob" name="mob" value="<?php echo set_value('name', @$userdetails->contact_number); ?>" type="text" class="form-control"  required />
  </div>
  <div class="form-group ">
    <label for="id_dob" class="control-label">Date of Birth<?php echo form_error('dob', '<span class="error_text">', '</span>'); ?></label>
    <input id="id_dob" name="dob" value="<?php echo set_value('dob', date('d-m-Y', strtotime(@$userdetails->dob))); ?>" type="text" 
    class="form-control"  required />
  </div>
  <div class="form-group form-inline">
    <label class="control-label">Gender<?php echo form_error('gender', '<span class="error_text">', '</span>'); ?></label>
    <div class="radio">
    <label><input type="radio" name="gender" value="m" <?php if(@$userdetails->gender == 'm') echo "checked='checked'"; ?> /> Male</label>
    <label><input type="radio" name="gender" value="f" <?php if(@$userdetails->gender == 'f') echo "checked='checked'"; ?> /> Female</label>
    </div>
  </div>
  <div class="form-group">
    <div class="text-right">
      <input type="submit" name="submit" class="btn btn-success" value="Save"/>
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

<script type="text/javascript">
$(document).ready(function(e) {
	/* Profile image cropper */
	$("#myBtn").click(function(){
		$("#myModal").modal({backdrop: true});
	});
	var options =
	{
	thumbBox: '.thumbBox',
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
	$("#id_dob").datetimepicker({
		timepicker:false,
		format:'m-d-Y'
	});

});
</script>
<!-- PAGE SPECIFIC JS-->	
<div class="modal fade" id="myModal" role="dialog">
	<div class="modal-dialog" style="width:700px;">
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title">Upload Image</h4>
</div>
<div class="modal-body">
<div class="imageBox">
<div class="thumbBox"></div>
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
</body>
</html>

