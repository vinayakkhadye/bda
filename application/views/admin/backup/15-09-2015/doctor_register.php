<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Register Doctor | BDA</title>
		<?php $this->load->view('admin/common/head'); ?> 
	</head>
	<body>
		<?php $this->load->view('admin/common/header'); ?>
		<?php //$this->load->view('admin/common/left_menu'); ?>

		<div class="container-fluid">
		<div class="panel panel-default">
		<div class="panel-heading">Register Doctor</div>

		<div class="panel-body"> 
				<div class="error-msgs">
					<?php echo validation_errors(); ?>
				</div>

				
				<div class="col-lg-8">
				<form action="" method="POST">
				<table class="table table-striped table-bordered table-hover">
					<tr>
						<td>Profile Picture</td>
						<td style="width: 70%">
							<a href="javascript:void(0);" id="myBtn">
								<img src="<?php echo IMAGE_URL; ?>admin/select_file.png" />
							</a>
							<input type="hidden" name="profile_pic_base64" id="profile_pic_base64" value="" />
							<input type="hidden" name="profile_pic_base64_name" id="profile_pic_base64_name" value="" />
						</td>
					</tr>
					<tr>
						<td>Name</td>
						<td><input type="text" name="name" value="<?=$all_details['name']?>" /></td>
					</tr>
					<tr>
						<td>Email ID</td>
						<td><input type="text" name="email" value="" /></td>
					</tr>
					<tr>
						<td>Password</td>
						<td><input type="password" name="pass" value="" /></td>
					</tr>
					<tr>
						<td>Confirm Password</td>
						<td><input type="password" name="cnfmpass" value="" /></td>
					</tr>
					<tr>
						<td>Mobile Number</td>
						<td>
							<input type="text" name="mob" value="<?=$all_details['contact_number']?>" />
						</td>
					</tr>
					<tr>
						<td>Date of Birth</td>
						<td><input type="text" name="dob" id="dob" value="" /></td>
					</tr>
					<tr>
						<td>Gender</td>
						<td>
							<input type="radio" name="gender" id="radio11" value="m" <?php
							if(@strtoupper($all_details['gender']) == 'M') echo "checked='checked'"; ?> />
							<span class="from_text4">
								Male
							</span><br />
							<input type="radio" name="gender" id="radio12" value="f" <?php
							if(@strtoupper($all_details['gender']) == 'F') echo "checked='checked'"; ?> />
							<span class="from_text4">
								Female
							</span>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="text-align: center;">
							<input type="submit" name="submit" value="Register Doctor" id="submit" style="width: 120px; height: 30px;" />
						</td>
					</tr>
				</table>
					</form> 
				</div>
				 
				<div class="col-lg-4">
					<div style="float: left; position: relative; width: auto; left: 5%; margin-top: 3%; padding: 6px; border: 3px solid rgb(170, 170, 170);" id="profileimgbox">
					<img src="/<?=($all_details['image'])?$all_details['image']:$all_details['image']?>" />
					</div>
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
				$("#select_file_btn").click(function()
				{
					$(".modalbpopup").bPopup(
					{
						positionStyle: 'fixed',
						closeClass: 'modalclose'
					});
					$("#file").trigger('click');
				});
				
				$("#chackAll").change(function()
					{
						if(this.checked)
						{
							$('.rowcheck').prop('checked', true);
						}else
						{
							$('.rowcheck').prop('checked', false);
						}
					});

				$("#left_Panel").height($("#content_area").height());
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
