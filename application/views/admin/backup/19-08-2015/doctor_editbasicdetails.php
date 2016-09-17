<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
  <title>Edit Basic Doctor Profile | BDA</title>
  <?php $this->load->view('admin/common/head'); ?>
  </head>
  <body>
  <?php $this->load->view('admin/common/header'); ?>
  <div class="container-fluid">
  <div class="panel panel-default">
  <div class="panel-heading">Doctor Basic Profile Details 
  <div class="FR"><strong>(<span class="red">*</span>) Marked are compulsary</strong></div>
  <div class="CL"></div>
  </div>
  <div class="panel-body">
  <div class="col-md-8 col-md-offset-2">
		<form method="POST" role="form" data-toggle="validator">
      <div class="form-group">
      <label class="control-label">Profile Picture : </label>
      <?php if($all_details['userimage']){
				$image	=	BASE_URL.$all_details['userimage'];
			}else if($all_details['doc_image']){
				$image	=	BASE_URL.$all_details['doc_image'];
			}else{
				$image	=	IMAGE_URL."photo_frame.jpg";
			}?>
      
      <div id="profileimgbox"><img src="<?=$image?>" style="width:126px;" /></div>
      </div>
      <div  class="form-group">
      <button type="button" class="btn btn-info btn-md" id="myBtn"><span class="glyphicon glyphicon-upload"></span>&nbsp;Select a File</button>
      <input type="hidden" name="profile_pic_base64" id="profile_pic_base64" value="" />
      <input type="hidden" name="profile_pic_base64_name" id="profile_pic_base64_name" value="" />
      </div>
      <div class="form-group">
      <label class="control-label">Name : </label>
      <input type="text" name="name" class="form-control" value="<?=$all_details['name']?>" required />
      </div>
      <div class="form-group">
      <label class="control-label">Email ID : </label>
      <input type="text" name="email" class="form-control" value="<?=$all_details['email_id']?>" />
      </div>
      <div class="form-group">
      <label class="control-label">Mobile Number : </label>
			<?php if(isset($all_details['user_id']) && !empty($all_details['user_id'])): ?>
        <input type="text" name="mob" class="form-control" value="<?=$all_details['user_contact_number']?>" />
      <?php else: ?>
        <input type="text" name="mob" class="form-control" value="<?=$all_details['doc_contact_number']?>" />
      <?php endif; ?>
      </div>
      <div class="form-group">
      <label class="control-label">Date of Birth : </label>
      <input type="text" class="form-control" name="dob" value="<?=$all_details['dob']?>" />
      </div>
      <div class="form-group">
      <label class="control-label">Gender : </label>
      <label class="radio-inline"><input type="radio"  name="gender" value="m" <?php if(@strtolower($all_details['doc_gender']) == 'm') echo "checked='checked'"; ?>  required/>Male</label>
      <label class="radio-inline"><input type="radio" name="gender" value="f" <?php if(@strtolower($all_details['doc_gender']) == 'f') echo "checked='checked'"; ?> required />Female</label>
      </div>
			<div class="form-group form-inline">
      <label class="control-label"><span class="red">*</span>Speciality : </label>
      <div class="InputsWrapper" id="speciality">
      <?php foreach($all_details['speciality_name'] as $sname): ?>
        <div>
          <select name="speciality[]" class="form-control">
          <?php foreach($speciality as $spname): ?>
            <option value="<?=$spname->id?>" <?php if($spname->name == $sname) echo 'selected="selected"'; ?>><?=ucfirst($spname->name)?></option>
          <?php endforeach; ?>
          </select>
          <a href="javascript:void(0);" class="removeclass btn btn-default" id="speciality">Remove</a>
        </div>
      <?php endforeach; ?>
      </div>
      <div class="AddMoreFileId">
        <a href="javascript:void(0);" class="AddMoreFileBox btn btn-primary" id="speciality">Add More</a><br><br>
      </div>
      </div>
      <div class="form-group form-inline">
      <label class="control-label">Other Speciality : </label>
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
        <a href="javascript:void(0);" class="AddMoreFileBox btn btn-primary" id="other_speciality">Add More</a><br><br>
      </div>
      </div>
      <div class="form-group form-inline">
      <label class="control-label">Degree <span class="red">*</span></label>
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
        <a href="javascript:void(0);" class="AddMoreFileBox btn btn-primary" id="degree">Add More</a><br><br>
      </div>
      </div>
      <div class="form-group form-inline">
      <label class="control-label">Other Degree</label>
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
        <a href="javascript:void(0);" class="AddMoreFileBox btn btn-primary" id="degree_other">Add More</a><br><br>
      </div>
      </div>
      <div class="form-group">
      <label class="control-label">Years of Experience : </label>
      <input type="text" name="yoe" class="form-control" value="<?=$all_details['yoe']?>" />
      </div>
      <div class="form-group">
      <label class="control-label">Registration No : </label>
      <input type="text" name="regno" class="form-control" value="<?=$all_details['reg_no']?>" />
      </div>
      <div class="form-group">
      <label class="control-label">State Medical Council : </label>
      <select name="council" class="form-control">
            <?php foreach($council as $option): ?>
              <option value="<?=$option->id?>" <?php if($all_details['council_id'] == $option->id) echo 'selected="selected"'; ?>><?=$option->name?></option>
            <?php endforeach; ?>
            </select>
      </div>
      <div class="form-group">
      <label class="control-label">Sponsored By : </label>
      <input type="text" name="sponsored" class="form-control" value="<?=$all_details['sponsored']?>" />
      </div>
      <div class="form-group">
      <label class="control-label">Paid : </label>
      <input type="text" name="paid" class="form-control" value="<?=$all_details['paid']?>" />
      </div>
      <div class="form-group">
      <label class="control-label">Sort : </label>
      <input type="text" name="sort" class="form-control" value="<?=$all_details['sort']?>" />
      </div>
      <div class="form-group">
      <label class="control-label">Health_utsav : </label>
      <input type="text" name="health_utsav" class="form-control" value="<?=$all_details['health_utsav']?>" />
      </div>
      <div class="form-group">
      <input type="submit" class="btn btn-primary" name="submit" value="Save Changes" id="submit"/>
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
  $.fn.addelement = function(element)
  {
  //console.log(this);
  var id = this.attr('id');
  if(id == 'speciality')
  {
  $(".InputsWrapper#speciality").last().append('<div><select name="speciality[]" class="form-control"><?php foreach($speciality as $spname): ?><option value="<?=$spname->id?>"><?=ucfirst($spname->name)?></option><?php endforeach; ?></select><a href="javascript:void(0);" class="removeclass btn btn-default" id="speciality">Remove</a></div>');
  }
  else if(id == 'degree')
  {
  $(".InputsWrapper#degree").last().append('<div><select name="degree[]" class="form-control"><?php foreach($qualifications as $qlname): ?><option value="<?=$qlname->id?>"><?=mysql_real_escape_string(ucfirst($qlname->name))?></option><?php endforeach; ?></select><a href="javascript:void(0);" class="removeclass btn btn-default">Remove</a></div>');
  }
  else if(id == 'degree_other')
  {
  $(".InputsWrapper#degree_other").last().append('<div><input type="text" name="degree_other[]" class="form-control" value="" /><a href="javascript:void(0);" class="removeclass btn btn-default" id="degree_other">Remove</a><br/></div>');
  }
  else if(id == 'other_speciality')
  {
  $(".InputsWrapper#other_speciality").last().append('<div><input type="text" class="form-control" name="speciality_other[]" value="" /><a href="javascript:void(0);" class="removeclass btn btn-default" id="other_speciality">Remove</a><br/></div>');
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
