<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Register Doctor | BDA</title>
<?php $this->load->view('admin/common/head'); ?> 
</head>
<body>
<?php $this->load->view('admin/common/header'); ?>
<div class="container-fluid">
<div class="panel panel-default">
<div class="panel-heading">Register Doctor</div>
<div class="panel-body"> 
<div class="col-sm-2"></div>
<div class="col-sm-6">
<form method="POST">
<div class="form-group error_text">
<?php echo validation_errors(); ?>
</div>
<div class="form-group">
<label class="control-label">Profile Picture : </label>
<div id="profileimgbox"><img src="/<?=($all_details['image'])?$all_details['image']:IMAGE_URL.'photo_frame.jpg' ?>" width="126" height="152" /></div>
</div>
<div class="form-group">
<button type="button" class="btn btn-info btn-md" id="myBtn"><span class="glyphicon glyphicon-upload"></span>&nbsp;Select a File</button>
<input type="hidden" name="profile_pic_base64" id="profile_pic_base64" value="" />
<input type="hidden" name="profile_pic_base64_name" id="profile_pic_base64_name" value="" />
</div>
<div class="form-group">
<label class="control-label">Name : </label>
<input type="text" 	name="name" value="<?=$all_details['name']?>" class="form-control" required />
</div>
<div class="form-group">
<label class="control-label">Email ID : </label>
<input type="text" 	name="email" value="<?=$all_details['email']?>" class="form-control" required />
</div>
<div class="form-group">
<label class="control-label">Password : </label>
<input type="password" 	name="pass" class="form-control" required />
</div>
<div class="form-group">
<label class="control-label">Confirm Password : </label>
<input type="password" 	name="cnfmpass" class="form-control" required />
</div>
<div class="form-group">
<label class="control-label">Mobile Number : </label>
<input type="text" 	name="mob" value="<?=$all_details['contact_number']?>" class="form-control" required />
</div>
<div class="form-group">
<label class="control-label">Date of Birth : </label>
<input type="text"	name="dob" id="dob" class="form-control" required />
</div>
<div class="form-group">
<label class="control-label">Gender : </label>
<div class="radio">
<label><input type="radio" name="gender" value="m" required
<?php if(@strtoupper($all_details['gender']) == 'M') echo "checked='checked'"; ?> /> Male</label>
</div>
<div class="radio">
<label><input type="radio" name="gender" value="f" required
<?php if(@strtoupper($all_details['gender']) == 'F') echo "checked='checked'"; ?> /> Female</label>
</div>
</div>
<div class="form-group">
<input type="submit" name="submit" value="Register Doctor" id="submit" class="btn btn-primary" />
</div>
</form> 
</div>
</div>
<div class="panel-footer">
<?php $this->load->view('admin/common/footer'); ?> 
</div>
</div>
</div>
<?php $this->load->view('admin/common/bottom'); ?>
<script src="<?php echo JS_URL; ?>admin/jquery.inputfile.js"></script>
<script src="<?php echo JS_URL; ?>admin/jquery-cropimg-plugin.js"></script>
<script>
$(document).ready(function()
{
	$("#select_file_btn").click(function(){
		$(".modalbpopup").bPopup({
			positionStyle: 'fixed',
			closeClass: 'modalclose'
		});
		$("#file").trigger('click');
	});
});
</script>
<script type="text/javascript">
		    $(window).load(function() {
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
		            //$('.cropped').append('<img src="'+img+'">');
		            $('#profileimgbox').html('<img src="'+img+'">');
		            
					//alert($('#file').val());
					var imgtype= img.substr(0, img.indexOf(',')); 
					//alert(imgtype);
					var base64imgvalue= img.substr(img.indexOf(',')+1, 999999999); 
					//console.log(base64imgvalue);
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
<script>
			$('input[type="file"]').inputfile(
				{
					uploadText: '<span class="glyphicon glyphicon-upload"></span> Select a file',
					removeText: '<span class="glyphicon glyphicon-trash"></span>',
					restoreText: '<span class="glyphicon glyphicon-remove"></span>',

					uploadButtonClass: 'btn btn-primary',
					removeButtonClass: 'btn btn-default'
				});
		</script>
<script>
$(document).ready(function(){
		$("#myBtn").click(function(){
				$("#myModal").modal({backdrop: true});
		});
		$("#dob").datepicker(
		{
		autoclose:true,
		dateFormat: "mm/dd/yyyy",
		todayHighlight: true,
		orientation: "bottom left"
		});				
});
</script>
<!-- Modal -->
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

</body>	
</html>
