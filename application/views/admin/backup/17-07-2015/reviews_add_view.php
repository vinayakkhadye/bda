<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
    <title>Add Reviews | BDA</title>
		<?php $this->load->view('admin/common/head'); ?>
		<!--<link href="<?php echo CSS_URL; ?>admin/maine.css" rel="stylesheet" type="text/css" />-->
	</head>
	<body>
		<?php $this->load->view('admin/common/header'); ?>
    <div class="container-fluid">
    <div class="panel panel-default">
    <div class="panel-heading">Add a Review</div>
    <div class="panel-body">
    <div class="col-md-4 col-md-offset-4">
				<form method="POST" role="form" data-toggle="validator">
          <div class="form-group">
          <label class="control-label">Image : </label>
          <div id="profileimgbox"><img src="<?=IMAGE_URL ?>photo_frame.jpg" width="126" height="152" /></div>          
          </div>  
          <div class="form-group">
          <button type="button" class="btn btn-info btn-md" id="myBtn"><span class="glyphicon glyphicon-upload"></span>&nbsp;Select a File</button>
          <input type="hidden" name="profile_pic_base64" id="profile_pic_base64" value="" />
          <input type="hidden" name="profile_pic_base64_name" id="profile_pic_base64_name" value="" />
          </div>
          <div class="form-group">
          <label class="control-label">Doctor ID : </label>
          <input type="text"  name="doctorid" class="form-control" required/>
          </div>
          <div class="form-group">   
          <label class="control-label">User Name : </label>
          <input type="text" name="username" class="form-control" required/>
          </div>
          <div class="form-group">   
          <label class="control-label">Message : </label>
          <textarea name="message" class="form-control" required></textarea>
          </div>
          <div class="form-group">            
          <label class="control-label">Rating : </label>
          <label class="radio-inline">
          <input type="radio" name="rating" id="optionsRadiosInline1" value="1" checked required>Very Happy
          </label>
          <label class="radio-inline">
          <input type="radio" name="rating" id="optionsRadiosInline2" value="2" required>Happy
          </label>
          <label class="radio-inline">
          <input type="radio" name="rating" id="optionsRadiosInline3" value="3" required>Average
          </label>
          </div>
          <div class="form-group">            
          <input type="submit" name="submit" class="btn btn-primary" value="Add Review" id="reviewsubmit" />					
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
	<!-- PAGE SPECIFIC JS-->
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
  

		
		<!--<div class="modalbpopup" style="display: none;">
			<div class="container">
			    <div class="imageBox">
			        <div class="thumbBox"></div>
			        <div class="spinner" style="display: none">Loading...</div>
			    </div>
			    <div class="action">
			        <input type="file" id="file" style="float:left; width: 250px">
			        <input type="button" id="btnCrop" value="Crop" style="float: right; width: 75px; margin:5px 40px 5px 5px;" class="modalclose">
			        <input type="button" id="btnZoomIn" value="+" style="float: right; width: 25px; margin:5px 2px;">
			        <input type="button" id="btnZoomOut" value="-" style="float: right; width: 25px; margin:5px 2px;">
			    </div>
			    <div class="cropped"></div>
			</div>
		</div>-->

	<!-- PAGE SPECIFIC JS-->

	</body>
	
</html>
