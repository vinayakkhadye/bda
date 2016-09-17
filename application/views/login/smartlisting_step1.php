<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php $this->load->view('login/common/head'); ?>
</head>
<body>
<?php $this->load->view('login/common/doctor_header'); ?>
<div class="container H550">
<div class="row">            
<div class="col-lg-8 col-md-8 col-lg-offset-2 col-md-offset-2">
<div class="row">
<div class="panel panel-default col-lg-12 col-md-12 col-sm-12 col-xs-12 "> 
<div class="panel-heading ">
    <h3 class="panel-title ">Profile</h3>
</div>    
<div class="panel-body">  
 
<form name="smartlisting_step1"  method="POST" class="form-horizontal">
<!--<div class="col-sm-5"> -->  
	<?php if(isset($current_packages)){ ?>
  <div class="alert alert-danger">
  <label class="control-label">Current Packages:</label>
  <?php foreach($current_packages as $row){ 
  echo '<p>'.$row->name.' valid from '.date('d-m-Y', strtotime($row->start_date)).' till '.date('d-m-Y', strtotime($row->end_date)).'</p>';
  } ?>
  </div>
  <?php }; ?>
  <div class="form-group">
  <label class="control-label">Profile Picture<?php echo form_error('image', '<span class="error_text">', '</span>'); ?></label>
  <div id="profileimgbox"><img src="<?=(@$userdetails->image)?BASE_URL.@$userdetails->image:IMAGE_URL.'photo_frame.jpg' ?>" width="126" height="152" id="patient_image" /></div>          
  </div>
  <div class="form-group">
  <button type="button" class="btn btn-info btn-md" id="myBtn"><span class="glyphicon glyphicon-upload"></span>&nbsp;Select a File</button>
  <input type="hidden" name="profile_pic_base64" id="profile_pic_base64" value="" />
  <input type="hidden" name="profile_pic_base64_name" id="profile_pic_base64_name" value="" />
  <input type="hidden" name="sl_step1" value="sl_step1" />
  </div>
  <div class="form-group">
  <label class="control-label" for="id_name">* Name<?php echo form_error('name', '<span class="error_text">', '</span>'); ?></label>
  <input name="name" type="text" id="id_name" class="form-control"  required value="<?php echo @$userdetails->name; ?>" />
  </div>
  <div class="form-group">
  <label for="email" class="control-label">* E-mail Id<?php echo form_error('email', '<span class="error_text">', '</span>'); ?></label>
  <input name="email" required type="text" class="form-control" id="email" value="<?php echo @$userdetails->email_id; ?>" />
  </div>
  <div class="form-group form-inline">
  <label for="mob" class="control-label">* Mobile Number<?php echo form_error('mob', '<p class="error_text">', '</p>'); ?></label>
  <input name="mob" maxlength="10" type="text" class="form-control" id="mob" value="<?php echo @$userdetails->contact_number; ?>" readonly />
  <a href="javascript:void(0);" id="verifybtn" style="display: none; margin-left:20px;" class="btn btn-primary">Send Verification Code</a>
  <a href="javascript:void(0);" id="mobeditbtn" style="margin-left:20px;" class="btn btn-default">Edit</a>
  <a href="javascript:void(0);" id="verifiedbtn" style="display: none; margin-left:20px;" class="btn btn-success">Verified</a>
  <span id="mob_span_tag" class="label label-success"></span>
  </div>
  <div class="form-group form-inline verificationcode">
  <label class="control-label">* Verification Code<p class="error_text" id="verify_code_span"></p></label>
  <input name="code" type="text" class="form-control" id="code" value="" maxlength="4" />
  <a href="javascript:void(0);" id="verifycodebtn" class="btn btn-success">Verify</a>
  </div>
  <div class="form-group">
  <label class="control-label">* Date of Birth<?php echo form_error('dob', '<p class="error_text">', '</p>'); ?></label>
  <input name="dob" required type="text" class="form-control" value="<?php echo date('d-m-Y', strtotime(@$userdetails->dob))?>" id="dob"/>
  </div>
  <div class="form-group">
  <label class="control-label">* Gender<?php echo form_error('gender', '<p class="error_text">', '</p>'); ?></label>
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
  
  <div class="InputsWrapper" id="speciality_wrapper">
	<div class="form-group">
  <label class="control-label">* Specialty <?php echo form_error('speciality_check', '<p class="error_text">', '</p>'); ?></label>
  </div>  
	<?php 
	if(!empty($doctor_data->speciality)){
	@$specialities = explode(',', $doctor_data->speciality);
	if(is_array($specialities) && sizeof($specialities)>0){
  foreach(@$specialities as $key=>$row2){ ?>
  <div class="form-group">
  <div class="row">    
  <div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
    <input type="text" 		class="form-control"	value="<?=$speciality[$row2]['name']?>"	readonly="readonly"/>
    <input type="hidden"	class="form-control"	value="<?=$speciality[$row2]['id']?>"	name="speciality[]" />
  </div>
  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
    <button class="btn btn-danger glyphicon glyphicon-minus" onclick="return removeelement(this)"></button>
  </div>
  </div>    
  </div>
  <?php }}} ?>
  <?php 
	if(!empty($doctor_data->other_speciality)){
	@$specialities_other = explode(',', $doctor_data->other_speciality);
	if(is_array(@$specialities_other) && sizeof(@$specialities_other)>0){
  
  foreach(@$specialities_other as $row4){ ?>
  <div class="form-group">
  <div class="row">        
  <div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
	  <input name="speciality_other[]" type="text" class="form-control" value="<?php echo $row4; ?>" readonly="readonly" />
  </div>
  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
  	<button class="btn btn-danger glyphicon glyphicon-minus" onclick="return removeelement(this)"></button>
  </div>
  </div>    
  </div>
  <?php }}} ?>
  <div class="form-group">
  <div class="row">        
  <div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
  <input type="text" value="" class="form-control autocomplete-specializations" placeholder="Speciality"/>
  </div>
  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
    <button class="btn btn-success glyphicon glyphicon-plus" onclick="return addelement(this);" id="speciality"></button>
  </div>
  </div>    
  </div>
  </div>
  
  <div class="InputsWrapper" id="degree">
  <div class="form-group">
  <label class="control-label">* Qualification</label>
  </div>
  <?php
	if(!empty($doctor_data->qualification)){
  @$degree1 = explode(',', $doctor_data->qualification);
	if(is_array(@$degree1) && sizeof(@$degree1)>0){
  foreach(@$degree1 as $row3){ ?>
  <div class="form-group">
  <div class="row">      
  <div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
  <input type="text" class="form-control" value="<?=$degree[$row3]['name']?>" readonly="readonly"/>
  <input type="hidden" name="degree[]" class="form-control" value="<?=$degree[$row3]['id']?>"/>
  </div>
  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
  <button class="btn btn-danger glyphicon glyphicon-minus" onclick="return removeelement(this)"></button>
  </div>
  </div>    
  </div>
  <?php }}}?>
  <?php 
	if(!empty($doctor_data->other_qualification)){
	@$qualification_other = explode(',', $doctor_data->other_qualification);
  if(is_array(@$qualification_other) && sizeof(@$qualification_other)>0){
  foreach(@$qualification_other as $row4){ ?>
  <div class="form-group">
  <div class="row">      
  <div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
  <input type="text" name="degree_other[]" class="form-control" value="<?php echo $row4; ?>" readonly="readonly"/>
  </div>
  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
  <button class="btn btn-danger glyphicon glyphicon-minus" onclick="return removeelement(this)"></button>
  </div>
  </div>    
  </div>
  <?php }}} ?>  
	<div class="form-group">
  <div class="row">            
  <div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
  <input type="text" class="form-control autocomplete-qualification" value="" placeholder="Degree"/>
  </div>
  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
  <button class="btn btn-success glyphicon glyphicon-plus" onclick="return addelement(this);" id="degree"></button>
  </div>
  </div>    
  </div>  
  </div>
  <div class="form-group">
  <label for="yoe" class="control-label">Years of Experience<?php echo form_error('yoe', '<span class="error_text">', '</span>'); ?></label>
  <input name="yoe" type="text" class="form-control" maxlength="2" value="<?php echo @$doctor_data->yoe; ?>" />
  </div>
  <div class="form-group">
  <label for="regno" class="control-label">Registration No</label>
  <input name="regno" type="text" class="form-control" value="<?php echo @$doctor_data->reg_no; ?>"  placeholder="Eg.4Afr5356"/>
  </div>
  <div class="form-group">
  <label for="council" class="control-label">State Medical Council</label>
  <input type="text" class="autocomplete-registration-council form-control" value="<?=@$council[$doctor_data->council_id]['name']?>"  />
  <input type="hidden" class="form-control" name="council" id="council" value="<?=@$doctor_data->council_id ?>" />
  </div>
  <input type="submit" class="btn btn-success" value="<?php if(@$clinic_present) echo 'Save'; else echo 'Continue'; ?>" />
  <!--</div> -->
</form>

</div> <!-- panel body -->   
</div>   <!-- panel --> 
</div> <!-- row -->
</div> <!-- end col -->     
</div> <!-- end row -->    
</div> <!-- end container -->    
<!-- Modal to upload the profile image-->    
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
<?php $this->load->view('login/common/bottom'); ?>
<?php $this->load->view('login/common/footer'); ?>
<!-- PAGE SPECIFIC JS-->
<script src="<?php echo JS_URL; ?>admin/jquery.inputfile.js"></script>
<script src="<?php echo JS_URL; ?>admin/jquery-cropimg-plugin.js"></script>
<script>
function addelement(obj)
{
	var element = $(obj).parent().prev().find('input');
	var db_value	=	element.val();
	var db_id	=	element.attr('attr-id');
	var ele_id	=	$(obj).attr('id');
	var input_name	=	 '';
	if(db_value)
	{
		var html	=	'<div class="form-group">';
		html			+=	'<div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">';
		if(ele_id=='speciality')
		{
			if(db_id)
			{
				html	+=	'<input type="text"	class="form-control"	value="'+db_value+'"	readonly="readonly"/>';
				html	+=	'<input type="hidden"	class="form-control"	value="'+db_id+'"	name="speciality[]" />';
			}
			else
			{
				html	+=	'<input name="speciality_other[]" type="text" class="form-control" value="'+db_value+'" readonly="readonly" />';
			}
		}
		else if(ele_id=='degree')
		{
			if(db_id)
			{
				html	+=	'<input type="text"	class="form-control"	value="'+db_value+'"	readonly="readonly"/>';
				html	+=	'<input type="hidden"	class="form-control"	value="'+db_id+'"	name="degree[]" />';
			}
			else
			{
				html	+=	'<input name="degree_other[]" type="text" class="form-control" value="'+db_value+'" readonly="readonly" />';
			}
		}
		html	+=	'</div>';
		html	+=	'<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">';
		html	+=	'<button onclick="return removeelement(this)" class="btn btn-danger glyphicon glyphicon-minus"></button>';
		html	+=	'</div>';
		html	+=	'</div>';
		
		$(html).insertBefore(element.parent().parent());			
		element.val("");
		element.attr("value","");
		element.attr("attr-id","");
	}
	return false;
}

function removeelement(obj)
{
  $(obj).parent().parent().remove();
	return false;
}

$(document).ready(function()
{
	$("#select_file_btn").click(function(){
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
		$('#file').click();		
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
	$("#sl_step1").show();
	<?php
	if(@$clinic_present)
		echo '$(".progressbar_sl").hide();';
	else
		echo '$(".progressbar_sl").show();';
	?>
		
	$(".error_text").show();
	$("#verifycodebtn").hide();
	$(".verificationcode").hide();
	$(".modalbpopup").hide();
	$("#dob").datetimepicker({
	timepicker:false,
	format:'d-m-Y'
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
	
	var speciality		=	 <?=$json_speciality;?>;
	var qualificaiton	=	 <?=$json_degree;?>;
	var council				=	 <?=$json_council;?>;
	
	$(".autocomplete-registration-council").autocomplete({
		source: council,
		minLength: 0,
		select: function( event, ui ) {
			$("#council").attr("value", ui.item.db_id)
		}
	}).focus(function() {$(this).autocomplete("search", $(this).val());});	
	$( ".autocomplete-specializations" ).autocomplete({
		source: speciality,
		select: function( event, ui ) {
			$(this).attr('value', ui.item.label);
			$(this).attr('attr-id', ui.item.db_id);
		},
		search: function( event, ui ) {
			$(this).attr('value', '');
			$(this).attr('attr-id', '');
		},
		minLength: 0
	}).focus(function() {$(this).autocomplete("search", $(this).val());});
	
	$(".autocomplete-qualification").autocomplete({
		source: qualificaiton,
		minLength: 3,
		select: function( event, ui ) {
			$(this).attr('value', ui.item.label);
			$(this).attr('attr-id', ui.item.db_id);
		},
		search: function( event, ui ) {
			$(this).attr('value', '');
			$(this).attr('attr-id', '');
		},
		minLength: 0
	}).focus(function() {$(this).autocomplete("search", $(this).val());});

});
</script>
<!-- PAGE SPECIFIC JS-->
</body>
</html>
