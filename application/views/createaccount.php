<?php
$fbid        = $this->session->userdata('fbid');
$flag        = $this->session->userdata('code_verified');
$googleid    = $this->session->userdata('googleid');
$googleimage = $this->session->userdata('googleimage');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php $this->load->view('login/common/head'); ?>
</head>
<body>
<?php $this->load->view('login/common/account_header'); ?>
<div class="container">
<div class="row">
<div class="col-lg-offset-3 col-md-offset-3 col-sm-12 col-xs-12 col-lg-6 col-md-6">    
<div class="panel panel-default">
  <div class="panel-heading">Sign up in less than 30 seconds</div>
  <div class="panel-body">    
<form method="post" name="create_account" class="form-horizontal" data-toggle="validator">

    <div class="col-sm-12">
  <div class="form-group">
  <label class="control-label">Profile Picture : <?php echo form_error('image', '<span class="error_text">', '</span>'); ?></label>
  <div id="profileimgbox">
	<?php if(!empty($fbid)){
        echo "<img src=\"http://graph.facebook.com/{$fbid}/picture?type=normal\" />";
      }
      elseif(!empty($googleid)){
        echo "<img src='".$this->session->userdata('googleimage')."' width=\"126\" height=\"152\" />";
      }else{
        if(isset($_POST['profile_pic_base64']) && $_POST['profile_pic_base64']){
          echo "<img src='data:image/png;base64,".$_POST['profile_pic_base64']."' width=\"126\" height=\"152\" />";
        }else{
          echo "<img src='".IMAGE_URL."photo_frame.jpg' width=\"126\" height=\"152\" />";
        }
      }
  ?></div>          
  </div>
  <div class="form-group">
  <button type="button" class="btn btn-info btn-md" id="myBtn"><span class="glyphicon glyphicon-upload"></span>&nbsp;Select a File</button>
  <input type="hidden" name="profile_pic_base64" id="profile_pic_base64" value="<?php echo @$_POST['profile_pic_base64']; ?>" />
  <input type="hidden" name="profile_pic_base64_name" id="profile_pic_base64_name" value="<?php echo @	$_POST['profile_pic_base64_name']; ?>" />
  <input type="hidden" name="sl_step1" value="sl_step1" />
  </div>
  <div class="form-group">
  <label class="control-label">Name<?php echo form_error('name', '<span class="error_text">', '</span>'); ?></label>
  <input name="name" type="text" class="form-control"value="<?php echo set_value('name',$this->session->userdata('uname')); ?>" required />
  </div>
  <div class="form-group">
  <label class="control-label">E-mail Id<?php echo form_error('email', '<span class="error_text">', '</span>'); ?></label>
  <input name="email" type="text" class="form-control" id="email" value="<?php echo set_value('email',$this->session->userdata('uemail')); ?>" required />
  </div>
  <div class="form-group">
  <label class="control-label">Password<?php echo form_error('pass', '<span class="error_text">', '</span>'); ?></label>
  <input name="pass" type="password" class="form-control" id="pass" value="<?php echo set_value('pass',$this->session->userdata('pass')); ?>" required />
  </div>
  <div class="form-group">
  <label class="control-label">Confirm Password<?php echo form_error('cnfmpass', '<span class="error_text">', '</span>'); ?></label>
  <input name="cnfmpass" type="password" class="form-control" id="cnfmpass" value="<?php echo set_value('cnfmpass',$this->session->userdata('cnfmpass')); ?>" required />
  </div>
  <div class="form-group">
  <label class="control-label">Mobile Number<?php echo form_error('mob', '<span class="error_text">', '</span>'); ?></label>
  <input name="mob" maxlength="10" type="text" class="form-control" id="mob" value="<?php echo set_value('mob',$this->session->userdata('mob')); ?>" required />
  </div>
  <div class="form-group">
  <label class="control-label">Date of Birth<?php echo form_error('dob', '<span class="error_text">', '</span>'); ?></label>
  <input name="dob" type="text" class="form-control" value="<?php $ff = set_value('dob'); if(!empty($ff))echo date('d-m-Y', strtotime($ff));else echo '';?>" id="dob"/>
  </div>
  <div class="form-group">
  <label class="control-label">Gender<?php echo form_error('gender', '<span class="error_text">', '</span>'); ?></label>
  <div class="radio">
  <label><input type="radio" name="gender" value="m" <?php if(isset($_POST['gender']) && strtolower($_POST['gender']) == 'm') echo 'checked'; ?> required /> Male</label>
  </div>
  <div class="radio">
  <label><input type="radio" name="gender" value="f" <?php if(isset($_POST['gender']) && strtolower($_POST['gender']) == 'f') echo 'checked'; ?> required /> Female</label>
  </div>
  </div>
  <div class="form-group">
  <label class="control-label">User Type<?php echo form_error('usertype', '<span class="error_text">', '</span>'); ?></label>
  <div class="radio">
  <label>
  <input type="radio" name="usertype" value="1" <?php if(isset($_POST['usertype']) && $_POST['usertype'] == 1) echo 'checked'; ?> required /> I'm a Patient
  </label>
  </div>
  <div class="radio">
  <label>
  <input type="radio" name="usertype" value="2" <?php if(isset($_POST['usertype']) && $_POST['usertype'] == 2) echo 'checked'; ?> required /> I'm a Doctor
  </label>
  </div>
  <div class="radio">
  <label>
  <input type="radio" name="usertype" value="3" <?php if(isset($_POST['usertype']) && $_POST['usertype'] == 3) echo 'checked'; ?> required /> I'm a Hospital
  </label>
  </div>
  </div>
  <div class="form-group">
  <div class="checkbox">
  <label> 
  <input type="checkbox" name="acceptterms" value="1" <?php if(isset($_POST['acceptterms']) && $_POST['acceptterms'] == 1) echo 'checked'; ?> />
  I accept the <a href="<?=BASE_URL?>terms-conditions" target="_blank">Terms and Conditions</a>
  <?php echo form_error('acceptterms', '<span class="error_text">', '</span>'); ?>
  </label>
  </div>
  </div>
  <div class="form-group">
  <input type="submit" value="Submit" name="submit_x" class="btn btn-primary">
  </div>
  
  <?php
  if(!empty($fbid))
  echo '<input type="hidden" name="fbid" value="'.$fbid.'" />'; 
  if(!empty($googleid))
  echo '<input type="hidden" name="googleid" value="'.$googleid.'" />'; 
  ?>
    </div>
</form>
 </div></div>     
    </div></div>    
</div>
<?php $this->load->view('login/common/footer'); ?>
<?php $this->load->view('login/common/bottom'); ?>

<!-- PAGE SPECIFIC JS -->
<script src="<?php echo JS_URL; ?>admin/jquery.inputfile.js"></script>
<script src="<?php echo JS_URL; ?>admin/jquery-cropimg-plugin.js"></script>
<script type="text/javascript">
$(window).load(function() {
	$("#dob").datetimepicker({
		timepicker:false,
		format:'m-d-Y'
	});
	
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
	var img = cropper.getDataURL()
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
});
</script>

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
<!-- PAGE SPECIFIC JS -->
</body>
</html>