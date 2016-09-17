<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Doctor Basic Profile Details | BDA</title>
		<?php $this->load->view('admin/common/head'); ?>
		<!-- <link type="text/css" rel="stylesheet" href="<?php echo CSS_URL; ?>admin/doctor.css"/> -->
		
		<!--<script src="<?=JS_URL?>jquery-1.8.2.min.js" type="text/javascript"></script>-->
		
		
	</head>
	<body>
		<?php $this->load->view('admin/common/header'); ?>
		<?php //$this->load->view('admin/common/left_menu'); ?>
<div class="container-fluid">
		<div class="panel panel-default">
		<div class="panel-heading">Doctor Basic Profile Details &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-(<span style="color:#F00">*</span>)Marked are compulsary
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-lg-8">
			      		<div style="display:none"><?php print_r($all_details); ?></div>
						 <form action="" method="POST">
							<table class="table table-striped table-bordered table-hover">
								<tr>
								<td>Profile Picture</td>
								<td>
									<a href="javascript:void(0);" id="myBtn">
										<img src="<?php echo IMAGE_URL; ?>admin/select_file.png" />
									</a>
									<input type="hidden" name="profile_pic_base64" id="profile_pic_base64" value="" />
									<input type="hidden" name="profile_pic_base64_name" id="profile_pic_base64_name" value="" />
								</td>
								</tr>
								<tr>
								<td>Name <span style="color:#F00">*</span></td>
								<td><input type="text" name="name" class="form-control" value="<?=$all_details['name']?>" /></td>
								</tr>
								<tr>
								<td>Email ID</td>
								<td><input type="text" name="email" class="form-control" value="<?=$all_details['email_id']?>" /></td>
								</tr>
								<tr>
								<td>Mobile Number</td>
								<td>
								<?php if(isset($all_details['user_id']) && !empty($all_details['user_id'])): ?>
									<input type="text" name="mob" class="form-control" value="<?=$all_details['user_contact_number']?>" />
								<?php else: ?>
									<input type="text" name="mob" class="form-control" value="<?=$all_details['doc_contact_number']?>" />
								<?php endif; ?>
								</td>
								</tr>
								<tr>
								<td>Date of Birth</td>
								<td><input type="text" class="form-control" name="dob" value="<?=$all_details['dob']?>" /></td>
								</tr>
								<tr>
								<?php $all_details['gender'] = ($all_details['user_gender'])?$all_details['user_gender']:$all_details['doc_gender'];?>
								<td>Gender</td>
								<td>
									<input type="radio"  name="gender" id="radio11" value="m" <?php
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
								<td>Speciality <span style="color:#F00">*</span></td>
								<td>
									<div class="InputsWrapper" id="speciality">
									<?php //print_r($all_details['speciality_name']); ?>
									<?php foreach($all_details['speciality_name'] as $sname): ?>
										<div>
											<select name="speciality[]" class="speciality_count form-control">
											<?php foreach($speciality as $spname): ?>
												<option value="<?=$spname->id?>" <?php if($spname->name == $sname) echo 'selected="selected"'; ?>><?=ucfirst($spname->name)?></option>
											<?php endforeach; ?>
											</select>
											<a href="javascript:void(0);" class="removeclass btn btn-default" id="speciality">Remove</a>
										</div>
									<?php endforeach; ?>
									</div>
									<div class="AddMoreFileId">
										<a href="javascript:void(0);" class="AddMoreFileBox btn btn-default" id="speciality">Add More</a><br><br>
									</div>
									<div id="lineBreak"></div>
								</td>
								</tr>
								<tr>
								<td>Other Speciality</td>
								<td>
									<div class="InputsWrapper" id="other_speciality">
										<?php
											$other_spec = explode(',', $all_details['other_speciality']);
											foreach($other_spec as $name) 
											{
												echo '<div><input type="text" class="form-control" name="speciality_other[]" value="'.ucfirst($name).'" /><a href="javascript:void(0);" class="removeclass btn btn-default" id="other_speciality">Remove</a><br/></div>';
											}
										?>
									</div>
									<div class="AddMoreFileId">
										<a href="javascript:void(0);" class="AddMoreFileBox btn btn-default" id="other_speciality">Add More</a><br><br>
									</div>
									<div id="lineBreak"></div>
								</td>
								</tr>
								<tr>
								<td>Degree <span style="color:#F00">*</span></td>
								<td>
									<div class="InputsWrapper" id="degree">
										<?php
										 if(isset($all_details['qualification_name']) && is_array($all_details['qualification_name'])){
										 foreach($all_details['qualification_name'] as $qname): ?>
											<div>
												<select name="degree[]" class="form-control">
												<?php foreach($qualifications as $qlname): ?>
													<option value="<?=$qlname->id?>" <?php if($qlname->name == $qname) echo 'selected="selected"'; ?>><?=htmlentities(ucfirst($qlname->name))?></option>
												<?php endforeach; ?>
												</select>
												<a href="javascript:void(0);" class="removeclass btn btn-default" id="degree">Remove</a>
											</div>
										<?php endforeach; 
									 }
										?>
									</div>
									<div class="AddMoreFileId">
										<a href="javascript:void(0);" class="AddMoreFileBox btn btn-default" id="degree">Add More</a><br><br>
									</div>
									<div id="lineBreak"></div>
								</td>
								</tr>
								<tr>
								<td>Other Degree</td>
								<td>
									<div class="InputsWrapper" id="degree_other">
										<?php
											$other_qual = explode(',', $all_details['other_qualification']);
											foreach($other_qual as $name) 
											{
												echo '<div><input type="text" class="form-control" name="degree_other[]" value="'.ucfirst($name).'" /><a href="javascript:void(0);" class="removeclass btn btn-default" id="degree_other">Remove</a><br/></div>';
											}
										?>
									</div>
									<div class="AddMoreFileId">
										<a href="javascript:void(0);" class="AddMoreFileBox btn btn-default" id="degree_other">Add More</a><br><br>
									</div>
									<div id="lineBreak"></div>
								</td>
								</tr>
								<tr>
								<td>Years of Experience</td>
								<td><input type="text" name="yoe" class="form-control" value="<?=$all_details['yoe']?>" /></td>
								</tr>
								<tr>
								<td>Registration No</td>
								<td><input type="text" name="regno" class="form-control" value="<?=$all_details['reg_no']?>" /></td>
								</tr>
								<tr>
								<td>State Medical Council</td>
								<!--<td><?=$all_details['council_name']?></td>-->
								<td>
									<select name="council" class="form-control">
									<?php foreach($council as $option): ?>
										<option value="<?=$option->id?>" <?php if($all_details['council_id'] == $option->id) echo 'selected="selected"'; ?>><?=$option->name?></option>
									<?php endforeach; ?>
									</select>
								</td>
								</tr>
								<tr>
								<td colspan="2" style="text-align: center;">
									<input type="submit" class="btn btn-primary" name="submit" value="Save Changes" id="submit" style="width: 120px; height: 30px;" />
								</td>
								</tr>
							</table>
						 </form>
				</div>
				<div class="col-lg-4">
					<div style="float: left; position: relative; width: auto; left: 5%; margin-top: 3%; padding: 6px; border: 3px solid rgb(170, 170, 170);" id="profileimgbox">
					<img src="/<?=($all_details['userimage'])?$all_details['userimage']:$all_details['doc_image']?>" />
					</div>
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
					$.fn.addelement = function(element)
					{
						//console.log(this);
						var id = this.attr('id');
						if(id == 'speciality')
						{
							$(".InputsWrapper#speciality").last().append('<div><select name="speciality[]" class="speciality_count"><?php foreach($speciality as $spname): ?><option value="<?=$spname->id?>"><?=ucfirst($spname->name)?></option><?php endforeach; ?></select><a href="javascript:void(0);" class="removeclass" id="speciality">Remove</a></div>');
						}
						else if(id == 'degree')
						{
							$(".InputsWrapper#degree").last().append('<div><select name="degree[]"><?php foreach($qualifications as $qlname): ?><option value="<?=$qlname->id?>"><?=mysql_real_escape_string(ucfirst($qlname->name))?></option><?php endforeach; ?></select><a href="javascript:void(0);" class="removeclass">Remove</a></div>');
						}
						else if(id == 'degree_other')
						{
							$(".InputsWrapper#degree_other").last().append('<div><input type="text" name="degree_other[]" value="" /><a href="javascript:void(0);" class="removeclass" id="degree_other">Remove</a><br/></div>');
						}
						else if(id == 'other_speciality')
						{
							$(".InputsWrapper#other_speciality").last().append('<div><input type="text" name="speciality_other[]" value="" /><a href="javascript:void(0);" class="removeclass" id="other_speciality">Remove</a><br/></div>');
						}
						
						// Attaching the click event on newly created removeclass element
						$(".removeclass").click(function()
						{
							//var count = $(".InputsWrapper#speciality").find("select").length;
							//console.log(count);
							$(this).removeelement(this.id);
						});
						$("#left_Panel").height($("#content_area").height());
					};
					
					$.fn.removeelement = function(element)
					{
						this.parent('div').remove();
					};
					
					$(".AddMoreFileBox").click(function()
					{
						$(this).addelement();
					});
					
					$(".removeclass").on("click",function()
					{
						$(this).removeelement(this.id);
					});				
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
