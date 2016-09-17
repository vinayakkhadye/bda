<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>Add Doctor | BDA</title>
		<?php $this->load->view('admin/common/head'); ?>
	</head>
	<body>
			<?php $this->load->view('admin/common/header'); ?>

		<div class="container-fluid">
		<div class="panel panel-default">
			<div class="panel-heading">Add Doctor</div>

			<div class="panel-body">
			<form id="sl_step2" name="sl_step2" method="POST" enctype="multipart/form-data" action="" data-toggle="validator">
					<div class="col-md-8 col-md-offset-2"> 
							<div class="form-group ">
							<label class="control-label">Doctor Name :  
							</label>
							<input name="doctor_name" value="" type="text"  class="form-control" id="textfield12" required />
							</div>

							<div class="form-group ">
							<label class="control-label">Gender :  
							</label>
							<select name="gender" class="form-control" >
							<option value="m">Male</option>
							<option value="f">Female</option> 
							</select>
							</div>

							<div class="form-group ">
							<label class="control-label">Summary :  
							</label>
							<input name="summary" type="text"   class="form-control"  />
							</div>

							<div class="form-group ">
							<label class="control-label">Registration No. :  </label>
							<input name="reg_no" value="" type="text"  class="form-control"  />
							</div>

							<div class="form-group ">
							<label class="control-label">Council ID. :  </label>
							<select name="council_id[] " class="  form-control">
							<?php foreach($council as $spname): ?>
							<option value="<?=$spname->id?>"  ><?=ucfirst($spname->name)?></option>
							<?php endforeach; ?>
							</select>
							</div>

							<div class="form-group ">
							<label class="control-label">Speciality :  </label> 

							<select name="speciality[] " class="form-control"  required >
							<?php foreach($speciality as $spname): ?>
							<option value="<?=$spname->id?>"  ><?=ucfirst($spname->name)?></option>
							<?php endforeach; ?>
							</select>
							</div>

							<div class="form-group ">
							<label class="control-label">Qualification :  </label>
							<select name="qualification[] " class="form-control" required>
							<?php foreach($qualifications as $spname): ?>
							<option value="<?=$spname->id?>"  ><?=ucfirst($spname->name)?></option>
							<?php endforeach; ?>
							</select>
							</div>

							<div class="form-group ">
							<label class="control-label">Year of experience :  </label>
							<input name="year_exp" value="" type="text"  class="form-control"  />
							</div>

							<div class="form-group">
							<label class="control-label">Profile Picture :
							</label>
							<a href="javascript:void(0);" id="myBtn">
							<img src="<?php echo IMAGE_URL; ?>admin/select_file.png" />
							</a>
							<input type="hidden" name="profile_pic_base64" id="profile_pic_base64" value="" />
							<input type="hidden" name="profile_pic_base64_name" id="profile_pic_base64_name" value="" />
							
							<div id="profileimgbox">
							<img src="/ " />
							</div>

							</div>


							<div class="form-group ">
							<label class="control-label">Contact No. :  </label>
							<input name="contact_number" value="" type="text"  class="form-control" required />
							</div>

							<div class="form-group ">
							<label class="control-label">Is Verified registered:  </label>
							<select name="is_ver_reg" class="form-control" >
							<option value="1">Yes</option>
							<option value="0">No</option> 
							</select>
							</div>

							<div class="form-group ">
							<label class="control-label">Status :  </label>					
							<select name="status" class="form-control" >
							<option value="1">Enable</option>
							<option value="0">Desable</option> 
							</select>
							</div>

							<div class="form-group ">
							<label class="control-label">Created On :  </label>
							<?php 
							$time = time(); 
							$date = date('Y-m-d H:i:s',$time);
 							?>
							<input name="created_on" value=" <?php echo  $date; ?> " type="text"  class="form-control"  />
							</div> 

							<div class="form-group ">
							<label class="control-label">Is Sponsored :</label>
							<select name="sponsored" class="form-control" >
							<option value="1">Yes</option>
							<option value="0">No</option> 
							</select>
						</div>
							<div class="form-group ">
							<label class="control-label">Is Paid :  </label>
							<select name="paid" class="form-control" >
							<option value="1">Yes</option>
							<option value="0">No</option> 
							</select>
							</div>
							<div class="form-group ">
							<label class="control-label">Sort :  </label>
							<input name="sort" value="999" type="text"  class="form-control"  />
							</div>

							<div class="form-group"> 	
							<input type="submit"  name="submit" class="btn btn-primary" value="SUBMIT" /> 
							</div>
					</div>
			</form>
			</div>


			<div class="panel-footer">
			<?php $this->load->view('admin/common/footer'); ?>
			</div> 

		</div> 
		</div> 
		<?php $this->load->view('admin/common/bottom'); ?>  

	</body>
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

	
</html>
 