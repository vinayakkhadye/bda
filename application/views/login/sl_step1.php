<form name="smartlisting_step1"  method="POST">
<div class="col-sm-3"></div>
<div class="col-sm-5">
	<?php if(isset($current_packages)){ ?>
  <div class="alert alert-danger">
  <label class="control-label">Current Packages:</label>
  <?php foreach($current_packages as $row){ 
  echo '<p>'.$row->name.' valid from '.date('d-m-Y', strtotime($row->start_date)).' till '.date('d-m-Y', strtotime($row->end_date)).'</p>';
  } ?>
  </div>
  <?php }; ?>
  <div class="form-group">
  <label class="control-label">Profile Picture : <?php echo form_error('image', '<span class="error_text">', '</span>'); ?></label>
  <div id="profileimgbox"><img src="<?=(@$userdetails->image)?BASE_URL.@$userdetails->image:IMAGE_URL.'photo_frame.jpg' ?>" width="126" height="152" id="patient_image" /></div>          
  </div>
  <div class="form-group">
  <button type="button" class="btn btn-info btn-md" id="myBtn"><span class="glyphicon glyphicon-upload"></span>&nbsp;Select a File</button>
  <input type="hidden" name="profile_pic_base64" id="profile_pic_base64" value="" />
  <input type="hidden" name="profile_pic_base64_name" id="profile_pic_base64_name" value="" />
  <input type="hidden" name="sl_step1" value="sl_step1" />
  </div>
  <div class="form-group">
  <label class="control-label">Name : <?php echo form_error('name', '<span class="error_text">', '</span>'); ?></label>
  <input name="name" type="text" class="form-control"  value="<?php echo @$userdetails->name; ?>" />
  </div>
  <div class="form-group">
  <label class="control-label">E-mail Id : <?php echo form_error('email', '<span class="error_text">', '</span>'); ?></label>
  <input name="email" type="text" class="form-control" id="email" value="<?php echo @$userdetails->email_id; ?>" />
  </div>
  <div class="form-group form-inline">
  <label class="control-label">* Mobile Number : <?php echo form_error('mob', '<p class="error_text">', '</p>'); ?></label>
  <input name="mob" maxlength="10" type="text" class="form-control" id="mob" value="<?php echo @$userdetails->contact_number; ?>" readonly />
  <a href="javascript:void(0);" id="verifybtn" style="display: none;" class="btn btn-primary">Send Verification Code</a>
  <a href="javascript:void(0);" id="mobeditbtn" class="btn btn-warning">Edit</a>
  <a href="javascript:void(0);" id="verifiedbtn" style="display: none;" class="btn btn-success">Verified</a>
  <span id="mob_span_tag" class="label label-success"></span>
  </div>
  <div class="form-group form-inline verificationcode">
  <label class="control-label">* Verification Code : <p class="error_text" id="verify_code_span"></p></label>
  <input name="code" type="text" class="form-control" id="code" value="" maxlength="4" />
  <a href="javascript:void(0);" id="verifycodebtn" class="btn btn-success">Verify</a>
  </div>
  <div class="form-group form-inline">
  <label class="control-label">* DOB : <?php echo form_error('dob', '<p class="error_text">', '</p>'); ?></label>
  <input name="dob" type="text" class="form-control" value="<?php echo date('d-m-Y', strtotime(@$userdetails->dob))?>" id="dob"/>
  </div>
  <div class="form-group form-inline">
  <label class="control-label">* Gender : <?php echo form_error('gender', '<p class="error_text">', '</p>'); ?></label>
  <div class="radio">
  <label>
  <input type="radio" name="gender" id="radio11" value="m" <?php if(@strtolower(@$userdetails->gender) == 'm') echo "checked"; ?> />
  Male
  </label>
  </div>
  <div class="radio">
  <label>
  <input type="radio" name="gender" id="radio12" value="f" <?php if(@strtolower(@$userdetails->gender) == 'f') echo "checked"; ?> />
  Female
  </label>
  </div>
  
  </div>
  <div class="form-group form-inline">
  <label class="control-label"><span class="red">*</span>Speciality : </label>
  </div>
  <div class="form-group form-inline">
  <div class="InputsWrapper" id="speciality">
  <?php @$specialities = explode(',', $doctor_data->speciality);
  foreach(@$specialities as $key=>$row2){ ?>
  <div class="PT10">
  <select name="speciality[]" class="form-control">
  <?php foreach($speciality as $row){?>
  <option value="<?php echo $row->id; ?>" <?php if(@$row2 == $row->id) echo "selected='selected'"; ?> ><?php echo ucwords($row->name); ?></option>
  <?php } ?>
  </select>
  <a href="javascript:void(0);" class="removeclass btn btn-danger" id="speciality">Remove</a>
  </div>
  <?php } ?>
  </div>
  </div>
  <div class="form-group form-inline">
  <div class="AddMoreFileId">
  <a href="javascript:void(0);" class="AddMoreFileBox btn btn-primary" id="speciality">Add More</a><br><br>
  </div>
  </div>
  <div class="form-group form-inline">
  <label class="control-label"><span class="red">*</span>Other Speciality : </label>
  </div>
  <div class="form-group form-inline">
  <div class="InputsWrapper" id="other_speciality">
  <?php @$specialities_other = explode(',', $doctor_data->other_speciality);
  if(sizeof(@$specialities_other) > 1){
  foreach(@$specialities_other as $row4){ ?>
  <div>
  <input type="text" value="<?php echo $row4; ?>" class="form-control" name="speciality_other[]">
  <a href="javascript:void(0);" class="removeclass btn btn-danger" id="other_speciality">Remove</a>
  </div>
  <?php }} ?>
  </div>
  </div>
  <div class="form-group form-inline">
  <div class="AddMoreFileId">
  <a href="javascript:void(0);" class="AddMoreFileBox btn btn-primary" id="other_speciality">Add More</a><br><br>
  </div>
  </div>
  <div class="form-group form-inline">
  <label class="control-label"><span class="red">*</span>Qualification : </label>
  </div>
  <div class="form-group form-inline">
  <div class="InputsWrapper" id="degree">
  <?php
  @$degree1 = explode(',', $doctor_data->qualification);
  foreach(@$degree1 as $row3){ ?>
  <div>
  <select name="degree[]" class="form-control">
  <?php foreach($degree as $row){?>
  <option value="<?php echo $row->id; ?>" <?php if(@$row3 == $row->id) echo "selected='selected'"; ?>><?php echo $row->name; ?></option>
  <?php } reset($degree);?>
  </select>
  <a href="javascript:void(0);" class="removeclass btn btn-danger" id="degree">Remove</a>
  </div>
  <?php }
  
  ?>
  </div>
  </div>
  <div class="form-group form-inline">
  <div class="AddMoreFileId">
  <a href="javascript:void(0);" class="AddMoreFileBox btn btn-primary" id="degree">Add More</a><br><br>
  </div>
  </div>
  <div class="form-group form-inline">
  <label class="control-label"><span class="red">*</span>Other Degree : </label>
  </div>
  <div class="form-group form-inline">
  <div class="InputsWrapper" id="degree_other">
  <?php @$qualification_other = explode(',', $doctor_data->other_degree);
  if(sizeof(@$qualification_other) > 1){
  foreach(@$qualification_other as $row4){ ?>
  <div>
  <input type="text" value="<?php echo $row5; ?>" class="from_list_menu" name="degree_other[]">
  <a href="javascript:void(0);" class="removeclass btn btn-danger" id="other_degree">Remove</a>
  </div>
  <?php }} ?>
  </div>
  </div>
  <div class="form-group form-inline">
  <div class="AddMoreFileId">
  <a href="javascript:void(0);" class="AddMoreFileBox btn btn-primary" id="degree_other">Add More</a><br><br>
  </div>
  </div>
  <div class="form-group form-inline">
  <label class="control-label">Years of Experience : <?php echo form_error('yoe', '<span class="error_text">', '</span>'); ?></label>
  <input name="yoe" type="text" class="form-control" maxlength="2" value="<?php echo @$doctor_data->yoe; ?>" />
  </div>
  <div class="form-group form-inline">
  <label class="control-label">Registration No : </label>
  <input name="regno" type="text" class="form-control" value="<?php echo @$doctor_data->reg_no; ?>"  placeholder="Eg.4Afr5356"/>
  </div>
  <div class="form-group form-inline">
  <label class="control-label">State Medical Council : </label>
  <select name="council" id="council" class="form-control">
  <option value="">Select your council</option>
  <?php
  foreach($council as $row){ ?>
  <option value="<?php echo $row->id; ?>" <?php if(@$doctor_data->council_id == $row->id) echo "selected='selected'"; ?>>
  <?php echo $row->name; ?>
  </option>
  <?php } ?>
  </select>
  </div>

  <?php if(isset($sor_eligibility)){ ?>
  <a href="/doctor/onlinereputation" class="btn btn-warning">View Additional Details</a>
  <?php } ?>
  <input type="submit" class="btn btn-primary" value="<?php if(@$clinic_present) echo 'Save'; else echo 'Continue'; ?>" />
  </div>
</form>
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
});
</script>
<script type="text/javascript">
$(window).load(function() {
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
<script type="text/javascript">
$(document).ready(function()
{
$(".error_text").show();
$("#verifycodebtn").hide();
$(".verificationcode").hide();
$(".modalbpopup").hide();
$("#dob").datetimepicker({
timepicker:false,
format:'Y-m-d'
});

$("#verifybtn").click(function()
{
$("#verifybtn").hide();
$("#mob_span_tag").html("Sending Verification Code");
var mob = $("#mob").val().trim();
//alert(mob);
$.ajax(
{
url: '/doctor/send_verification_sms',
type: "POST",
data:
{
'mob'	:	mob
},
success : function(resp)
{
resp	=	resp.trim();
if(resp.substring(0,7) == 'success')
{
$("#mob_span_tag").html("Verification code sent");
$("#verifybtn").hide();
$("#verifycodebtn").show();
$(".verificationcode").show();
}
else
{
$("#verifybtn").show();
$("#mob_span_tag").html('');
}
}
});
});

$("#verifycodebtn").click(function()
{
$("#verify_code_span").html(' ');
var code = $("#code").val().trim();
//							alert(code);
$.ajax(
{
url: '/doctor/check_verification_code',
type: "POST",
data:
{
'code'	:	code
},
success : function(resp)
{
//										alert(resp);
if(resp.substring(0,7) == 'success')
{
$("#verifycodebtn").hide();
$("#mob_span_tag").hide();
$("#verifiedbtn").css('display', 'inline');
$("#mob").attr("readonly", true);
$("#code").attr("readonly", true);
}
else
{
$("#verify_code_span").html("Invalid Verification code");
}
}
});
});

$("#mobeditbtn").on('click', function()
{
$("#mobeditbtn").hide();
$("#verifybtn").show();
$("#mob").attr('readonly', false);
});
$.fn.addelement = function(element)
{
var id = this.attr('id');
if(id == 'speciality')
{
$(".InputsWrapper#speciality").last().append('<div class="PT10"><select name="speciality[]" class="form-control"><?php foreach($speciality as $spname): ?><option value="<?=$spname->id?>"><?=ucfirst($spname->name)?></option><?php endforeach; ?></select> <a href="javascript:void(0);" class="removeclass btn btn-danger" id="speciality">Remove</a></div>');
}
else if(id == 'degree')
{

$(".InputsWrapper#degree").last().append('<div class="PT10"><select name="degree[]" class="form-control"><?php foreach($degree as $qlname): ?><option value="<?=$qlname->id?>"><?=ucfirst(str_replace("'","",$qlname->name))?></option><?php endforeach; ?></select>&nbsp;<a href="javascript:void(0);" class="removeclass btn btn-danger">Remove</a></div>');

}
else if(id == 'degree_other')
{

$(".InputsWrapper#degree_other").last().append('<div class="PT10"><input type="text" name="degree_other[]" class="form-control" value="" /> <a href="javascript:void(0);" class="removeclass btn btn-danger" id="degree_other">Remove</a><br/></div>');

}
else if(id == 'other_speciality')
{
$(".InputsWrapper#other_speciality").last().append('<div class="PT10"><input type="text" class="form-control" name="speciality_other[]" value="" /> <a href="javascript:void(0);" class="removeclass btn btn-danger" id="other_speciality">Remove</a><br/></div>');			
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
});

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
</script>