<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <?php $this->load->view('login/common/head'); ?>
</head>

<body onload="getcustomer(this)"><!--return  dr_hospital_list(this), getcustomer(this)-->
<?php $this->load->view('login/common/hospital_header'); ?>
<div class="container H550">            
<!--<div class="panel-body"> -->
<div class="row">
  <div class="col-sm-12 col-xs-12 col-md-2 col-lg-2">
<div class="list-group">
  <a href="javascript:;" onclick="getcustomer(this);" id="all_customer" class="list-group-item active">All Patients</a>
  <a href="javascript:;" onclick="return add_new_patient()" id="add_new_patient" class="list-group-item">Add a Patient</a>
  <a href="javascript:;" id="patient_display_name" class="disabled list-group-item">Patient Name</a>
  <a href="javascript:;" id="patient_general_info" class="disabled list-group-item">General Information</a>
  <a href="javascript:;" id="patient_family_history" class="disabled list-group-item">Family & Self History</a>
  <a href="javascript:;" id="patient_disease_surgeries"	class="disabled list-group-item" >Past Disease & Surgeries</a>
</div>      
  </div>
  <div class="col-sm-12 col-xs-12 col-md-10 col-lg-10" id="patient-details" style="display:none">
            <div class="panel panel-default">
          <div class="panel-heading">Patient Details</div>
  <div class="panel-body">
	<div class="PB15 ajax-content" id="patient_profile">
		<form class="form" id="add_patient_form" data-toggle="validator" onsubmit="return add_patient();" autocomplete="false">
      <div class="form-group">
        <label class="control-label">Image</label>
        <div id="profileimgbox"><img src="<?=IMAGE_URL ?>photo_frame.jpg"/></div>          
      </div>
      <div class="form-group">
        <button type="button" class="btn btn-info btn-md" id="myBtn"><span class="glyphicon glyphicon-upload"></span>&nbsp;Select a File</button>
        <input type="hidden" name="profile_pic_base64" id="profile_pic_base64" value="" />
        <input type="hidden" name="profile_pic_base64_name" id="profile_pic_base64_name" value="" />
      </div>
      <!--<div class="form-group">
    		<label>Doctor Name : </label>  
        <select name="doctor_name" id="doctor_name" class="form-control" >
        <option value="">Select Doctor</option>
        <?php foreach($doctor_data as $doc_val){ ?>
        <option value="<?=$doc_val->id?>"><?=$doc_val->name?></option>
        <?php }?>
        </select>
      </div>-->
      <div class="form-group">
    		<label>Name</label>  
        <input type="text" value="" id="patient_name" class="form-control" name="patient_name" placeholder="Patient Name" required>
      </div>
      <div class="form-group">
    		<label>Email ID</label>  
        <input type="text" value="" id="email" class="form-control" name="email" placeholder="Email" >
      </div>
      <div class="form-group">
    		<label>Mobile</label>  
        <input type="text" value="" id="mobile_number" class="form-control" name="mobile_number" placeholder="Mobile Number" maxlength="12" required>
      </div>
      <div class="form-group">
    		<label>Date of Birth</label>  
        <input type="text" id="dob" value="" class="form-control" name="dob" placeholder="Date of birth">
      </div>
      <div class="form-group">
    		<label>Gender</label>  
        <div class="radio-inline">
          <label><input type="radio" value="m" id="male" name="gender"  required> Male</label>
        </div>
        <div class="radio-inline">
          <label><input type="radio" value="f" id="female" name="gender" required> Female</label>
        </div>
      </div>
      <div class="form-group">
    		<label>Address</label>  
        <input type="text" value="" id="address" class="form-control" name="address" placeholder="Address">
      </div>
      <div class="form-group">
    		<label>City</label>  
        <input class="form-control autocomplete-city" type="text" autocomplete="false"/>
        <input type="hidden" id="city_id" name="city" />
        
      </div>
      <div class="form-group">
    		<label>Pin Code</label>  
        <input type="text" placeholder="Pin Code" value="" id="pincode" class="form-control" name="pincode" maxlength="6">
      </div>
      <div class="form-group">
	      <input type="hidden" name="hospital_add_id" id="hospital_add_id" value="<?=$hospital_details->id?>" />
        <input type="hidden" name="patient_id" id="patient_id" value="" />
        <input type="submit" value="Save" class="btn btn-success">
      </div>
    </form>
  </div>
  </div> 
  </div>
  </div> <!-- patient details -->
    <div class="col-sm-12 col-xs-12 col-md-10 col-lg-10 H550" id="patient-list">
      <div class="panel panel-default">
          <div class="panel-heading">Patient List</div>
  <div class="panel-body">
  	<div class="PB15 ajax-content" id="search_form">
    <div class="form-inline" role="form">
    <div class="form-group">
    	<!--<select name="doctor_id" id="doctor_id" class="form-control">
      <option value="">Select Doctor</option>
      <?php foreach($doctor_data as $doc_val){ ?>
      <option value="<?=$doc_val->id?>"><?=$doc_val->name?></option>
      <?php }?>
      </select>-->
    </div>
    <div class="form-group">
    	<label class="label-control">Search By : </label>
    	<input type="text" id="patient_search_name" placeholder="Patient name" name="patient_search_name" class="form-control"/>
		</div>
    <div class="form-group">
    	<input type="hidden" id="hospital_id" value="<?=$hospital_details->id?>" />
    	<button id="search_btn" class="btn btn-default" value="Search" name="search" onclick="return getcustomer(this)">Search</button>
    </div>
    </div>
    </div>
    <div class="row ajax-content" id="list_customer"></div>
    <div class="clearfix ajax-content"></div>
		<div class="ajax-content" id="pagination"></div>  
  </div></div>              
  </div>
  <div class="col-sm-12 col-xs-12 col-md-10 col-lg-10" id="patient-family-details" style="display:none">
          <div class="panel panel-default">
          <div class="panel-heading">Patient History</div>
  <div class="panel-body">  
    <div class="PB15 ajax-content" id="patient_family"></div>
  </div>
  </div>
  </div>
  <div class="col-sm-12 col-xs-12 col-md-10 col-lg-10" id="patient-disease-sugery" style="display:none">
   <div class="panel panel-default">
   <!--<div class="panel-heading">Patient Disease & Surgery</div> -->
  <div class="panel-body">  
      <ul class="nav nav-tabs" id="historytabs" role="tablist">
    <li role="presentation" class="active"><a href="#medications" aria-controls="settings" role="tab" data-toggle="tab">Ongoing Medications</a></li>          
    <li role="presentation"><a href="#allergies" aria-controls="settings" role="tab" data-toggle="tab">Allergies</a></li>          
    <li role="presentation" ><a href="#selfhistory" aria-controls="home" role="tab" data-toggle="tab">Patient History</a></li>
    <li role="presentation"><a href="#familyhistory" aria-controls="profile" role="tab" data-toggle="tab">Family History</a></li>
    <li role="presentation"><a href="#surgicalhistory" aria-controls="messages" role="tab" data-toggle="tab">Surgical History</a></li>
  </ul>
      <div class="PB15 ajax-content" id="patient-disease"></div>
  </div>
  </div>        
  </div>
</div> <!-- row main -->
<!--</div> -->
<div class="row">&nbsp;</div>
</div>

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
<div class="modal fade loader" id="loading" role="dialog">
  <img src="/static/images/bdaloader.gif" id="loading" class="PA10">
</div>
<?php $this->load->view('login/common/footer'); ?>
<?php $this->load->view('login/common/bottom'); ?>
<!-- PAGE SPECIFIC JS-->
<script src="<?php echo JS_URL; ?>admin/jquery.inputfile.js"></script>
<script src="<?php echo JS_URL; ?>admin/jquery-cropimg-plugin.js"></script>
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

<script type="text/javascript">
$(function(){
	$("#myBtn").click(function(){
			$("#myModal").modal({backdrop: true});
	});
	
	$("#dob").datetimepicker({
		timepicker:false,
		format:'d-m-Y'
	});
	$("#surgery_date").datetimepicker({
		timepicker:false,
		format:'d-m-Y'
	});
	$(".autocomplete-city").autocomplete({
		source: function(request,response){
			$.ajax({
				url: BASE_URL + "api/masters/city/",
				dataType: "json",
				data: {
					query: request.term
				},
				success: function( data ) {
					response( data );
				}
			});
		},
		minLength: 3,
		select: function( event, ui ) {
				$(this).attr("value", ui.item.value);
			$("#city_id").val(ui.item.db_id);
		}
	});			
});
// function for getting size of resp
Object.size = function(obj) {
	var size = 0, key;
	for (key in obj){
	if (obj.hasOwnProperty(key)) size++;
	}
	return size;
};

function calculatebmi()
{
	var height_feet = parseInt($("#height_feet").val());
	var height_inches =  parseInt($("#height_inches").val());
	var weight =  parseInt($("#weight").val());
	if(height_feet && weight ){
		if(isNaN(height_inches)){
			height_inches = 0;
		}
		var total_inches = (height_feet*12)+height_inches;
		
		var meter = (total_inches/39.370);
		var bmi = (weight / (meter * meter)).toFixed(2);
		$("#bmi_value").val(bmi);
	}
}

function dr_hospital_list()
{
	$.ajax({
	url: '/hospital/dr_hospital_list',
	type: 'POST',
	cache: false,
	dataType: 'json',
	success: function(resp){
		var hospital_id ;
		var hospital_name ;
		var option ;
		for(i=0; i < Object.size(resp); i++){
			hospital_id = resp[i]['id'];
			hospital_name = resp[i]['name'];
			option = option + '<option value="'+hospital_id+'" >'+hospital_name+' </option>';
		}
		html3 = '<div class="form-inline" role="form"><div style="width:30%" class="form-group"><select name="clinic_id" id="clinic_id" style="width:100%" class="form-control"> <option value=""> select clinic </option>'+option+'</select></div>&nbsp;&nbsp;&nbsp;<div style="width:30%" class="form-group"><input style="width:100%" type="text" id="search_box" placeholder="Patient name" name="patient_name" value=""  class="form-control"/></div>&nbsp;&nbsp;&nbsp;<div class="form-group"><button id="search_btn" class="btn btn-default" value="Search" name="search" onclick="return getcustomer(this)">Search</button></div></div>';
		$('#search_form').html(html3);
	}
	});
}
function calculateAge(dateString)
{ 	
	var today = new Date();
	var birthDate = new Date(dateString);
	var age = today.getFullYear() - birthDate.getFullYear();
	var m = today.getMonth() - birthDate.getMonth();
	if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate()))
	{
		age--;
	}
	return age;
}

function getcustomer(page_id)
{
	var obj =   {};  
	//for pagination
	obj['page_id']  =$(page_id).attr('page_id'); 

	obj['patient_name'] =	$("#patient_search_name").val();
	obj['hospital_id'] =	$("#hospital_id").val();
	obj['doctor_id']  	=	$("#doctor_id").val(); 
	$.ajax({
	url:    '/hospital/patient_manage_data',
	type:   'POST',
	cache:  false,
	dataType: 'json',
	data:      obj,
	beforeSend: function() {loading();},		
	success: function(resp){ 
		var html2="";
		var patient_id ;
		var image  ;
		var name  ;
		var mobile_number;
		var hospital ;
		var created_on  ; 
		var i;
		var tmp='';
		for(i=0; i < Object.size(resp.patient_data); i++)
		{     
			patient_id = resp.patient_data[i]['id']; 
			name = resp.patient_data[i]['name'];
			image = resp.patient_data[i]['image'];
			hospital = resp.patient_data[i]['hospital'];                    
			gender	 = resp.patient_data[i]['gender'];                    
			dob	 = resp.patient_data[i]['dob'];
			age	=	calculateAge(dob);
			mobile_number = resp.patient_data[i]['mobile_number'];
			created_on = resp.patient_data[i]['created_on']; 

			tmp	=		'<div class="col-xs-6 col-sm-6 col-lg-3 col-md-6 H150">';
	    tmp	+=	'<div class="panel panel-default">';
      tmp	+=	'<div class="panel-body">';
      tmp	+=	'<img src="'+((image)?BASE_URL+image:"")+'" class="img-circle pull-right W50">';
      tmp	+=	'<a href="javascript:;" onclick="return patient_general_profile('+patient_id+')">'+((name)?name:"")+'</a>';
			//tmp	+=	'<div class="clearfix"></div>';
      tmp	+=	'<hr>';
			tmp	+=	'<p><span class="glyphicon glyphicon-earphone" aria-hidden="true">&nbsp;</span>'+ ((mobile_number)?mobile_number:"") +'<br/>'+ ((gender)? gender.toUpperCase():"")+', '+age+'</p>';
			//tmp	+=	'<h5><a href="http://google.com/+bootply">+ More Info</a></h5>';
      tmp	+=	'</div>';
			tmp	+=	'</div>';
		  tmp	+=	'</div>';
			if(i>0 && (i+1)%6==0 && (i+1)<18 )
			{
				//tmp	+=	'<div class="clearfix"></div>';
			}
			html2  = html2 + 	tmp;
		} 
		
		$('#list_customer').html(html2);
		if(typeof resp.pagination !='undefined')
		{
		var lPage = (resp.pagination['lPage']!='undefined')?resp.pagination['lPage']:'';
		var nextPage = (resp.pagination['nextPage'])?resp.pagination['nextPage']:'';
		var next_btn="", last_btn="", page_btn="";
		if(nextPage)
		{
			next_btn = '<li><a class="btn" href="javascript:;" page_id="'+resp.pagination['nextPage'].url+'" onclick="return getcustomer(this)" > next </a></li>' ;
		}
		if(lPage)
		{
			last_btn = '<li><a class="btn" href="javascript:;" page_id="'+resp.pagination['lPage'].url+'" onclick="return getcustomer(this)" > last </a></li>';
		}
		for(i=1; i <= Object.size(resp.pagination['page']); i++)
		{           
			var page =  resp.pagination['page'][i].url;
			var is_active =  resp.pagination['page'][i].active;
			if(!page)
			{
				page = 1;
			}
			page_btn = page_btn + '<li><a class="btn '+ ((is_active)?'btn-primary active':'') +'" href="javascript:;" page_id="'+ page + '" onclick="return getcustomer(this)" >'+page+'</a></li>' ;
		}
		
		html2 = '<ul class="pagination">'+page_btn + next_btn + last_btn +'</ul>';
		$('#pagination').html(html2);  
		}
		$("#patient-details").hide();
		$("#patient-family-details").hide();
		$("#patient-disease-sugery").hide();
		$("#patient-list").show();
		active_navigation_class('all_customer');
	},
	complete: function(){removeLoading();}
	});
}

function active_navigation_class(id_name)
{
	
	//$( ".list-group a" ).each(function(index){
		if(id_name=="add_new_patient")
		{
			$("#all_customer").removeClass('active');
			$("#patient_general_info").addClass('disabled');
			$("#patient_family_history").addClass('disabled');
			$("#patient_disease_surgeries").addClass('disabled');
			$("#patient_general_info").removeClass('active');
			$("#patient_family_history").removeClass('active');
			$("#patient_disease_surgeries").removeClass('active');
		}
		else if(id_name=="all_customer")
		{
			$("#add_new_patient").removeClass('active');
			$("#patient_general_info").addClass('disabled');
			$("#patient_family_history").addClass('disabled');
			$("#patient_disease_surgeries").addClass('disabled');
			$("#patient_general_info").removeClass('active');
			$("#patient_family_history").removeClass('active');
			$("#patient_disease_surgeries").removeClass('active');
			
		}
		else if(id_name=="patient_general_info")
		{
			$("#all_customer").removeClass('active');
			$("#add_new_patient").removeClass('active');
			$("#patient_general_info").removeClass('disabled');
			$("#patient_family_history").removeClass('disabled');
			$("#patient_disease_surgeries").removeClass('disabled');
		}
		else if(id_name=="patient_family_history")
		{
			$("#all_customer").removeClass('active');
			$("#add_new_patient").removeClass('active');
			$("#patient_general_info").removeClass('active');
			$("#patient_disease_surgeries").removeClass('active');
		}
		else if(id_name=="patient_disease_surgeries")
		{
			$("#all_customer").removeClass('active');
			$("#add_new_patient").removeClass('active');
			$("#patient_general_info").removeClass('active');
			$("#patient_family_history").removeClass('active');
                        //set the tab
                        $('#historytabs a:first').tab('show') // Select first tab
		}
		
	//});	
	$("#"+id_name).addClass('active');
}
function add_patient()
{
	var form_data =  $("#add_patient_form").serialize();
	$.ajax({type: 'POST',
			url: "/hospital/patient_add/",
			data: form_data,
			beforeSend: function() {loading();},		
			success: function(data){getcustomer(1);},
			complete: function() {removeLoading();}
		});
	return false;
}
function add_new_patient()
{
	$("#patient-details").show();
	$("#patient-list").hide();
	$("#patient-family-details").hide();
	$("#patient-disease-sugery").hide();
	active_navigation_class('add_new_patient');
	$("#patient_name").val("");
	$("#email").val("");
	//$("#patient_image").attr("src",IMAGE_URL+"photo_frame.jpg");
	$("#profileimgbox img").attr("src",IMAGE_URL+"photo_frame.jpg");
	$("#profile_pic_base64").val("");
	$("#profile_pic_base64_name").val("");
	$("#male").prop('checked', false);
	$("#female").prop('checked', false);
	$("#mobile_number").val("");
	$("#dob").val("");
	$("#address").val("");
	$("#pincode").val("");
	$("#patient_id").val("");
}
function patient_general_profile(patient_id)
{
	$.ajax({
		url: '/hospital/get_patient',
		type: 'POST',
		dataType: 'json',
		cache: false,
		data:{'id':patient_id},
		beforeSend: function() {loading();},
		success: function(resp){
			//console.log(resp);
			add_new_patient();
			$("#patient_display_name").html(resp.name)
			$("#patient_general_info").attr('onclick','patient_general_profile('+resp.id+')');
			$("#patient_family_history").attr('onclick','patient_self_family_history('+resp.id+')');
			$("#patient_disease_surgeries").attr('onclick','patient_disease_surgeries('+resp.id+')');
			
			$("#patient_name").val(resp.name);
			$("#patient_id").val(resp.id);
			$("#email").val(resp.email);
			$("#profileimgbox img").attr("src",BASE_URL+resp.image);
			$("#address").val(resp.address);
			$("#pincode").val(resp.pin_code);
			$("#mobile_number").val(resp.mobile_number);
			$("#dob").val(resp.dob);
			
			if(resp.gender='m')
			{
				$("#male").prop('checked', true);
			}
			else if(resp.gender='f')
			{
				$("#female").prop('checked', true);
			}
			
			active_navigation_class('patient_general_info');
			$("#patient_display_name").parent('li').removeClass();
			$("#patient_family_history").parent('li').removeClass();
			$("#patient_disease_surgeries").parent('li').removeClass();
			$("#patient-list").hide();
			$("#patient-family-details").hide();
			$("#patient-disease-sugery").hide();
			$("#patient-details").show();
		},
		complete: function() {removeLoading();}
	});	
}
function patient_disease_surgeries(patient_id)
{
	$.ajax({
		url: '/hospital/patient_disease_surgeries',
		type: 'POST',
		cache: false,
		data:{'id':patient_id},
		beforeSend: function() {loading();},
		success: function(resp){
			active_navigation_class('patient_disease_surgeries');
			$("#patient-details").hide();
			$("#patient-list").hide();
			$("#patient-family-details").hide();
			$("#patient-disease-sugery").show();
			$("#patient-disease").html(resp);
		},
		complete: function() {removeLoading();}
	});	

}
function patient_self_family_history(patient_id)
{
	$.ajax({
		url: '/hospital/get_patient_self_family_history',
		type: 'POST',
		cache: false,
		data:{'id':patient_id},
		beforeSend: function() {loading();},
		success: function(resp){
			$("#patient-details").hide();
			$("#patient-list").hide();
			$("#patient-disease-sugery").hide();
			$("#patient-family-details").show();
			active_navigation_class('patient_family_history');
			$("#patient_family").html(resp);
		},
		complete: function() {removeLoading();}
	});	
}
function removeelement(element)
{
	element	=	$(element)
	console.log(element);
	var attribute 	=	element.attr('id');
	var db_id 				=	element.attr('db-id');
	switch(attribute)
	{
		case "family_delete_details":
		$.ajax({
			url: '/api/doctor/remove_patient_family_details',
			type: 'POST',
			data:{'id':db_id},
			cache: false,
			dataType: 'json',
			beforeSend: function() {
				element.removeClass("glyphicon-minus").addClass("glyphicon-refresh spinning");
			},		
			success: function(resp){
				if(resp.success)
				{
					//element.parent().prev().remove();
					element.parent().parent().next().remove();
					element.parent().remove();
				}
			},
			complete: function() {
				element.removeClass("glyphicon-refresh spinning").addClass("glyphicon-minus");
			}
		});
		break;
		case "past_disease_delete":
		$.ajax({
			url: '/api/doctor/remove_patient_past_disease',
			type: 'POST',
			data:{'id':db_id},
			cache: false,
			dataType: 'json',
			beforeSend: function() {
				element.removeClass("glyphicon-minus").addClass("glyphicon-refresh spinning");
			},		
			success: function(resp){
				if(resp.success)
				{
					//element.parent().prev().prev().prev().remove();
					//element.parent().prev().prev().remove();
					//element.parent().prev().remove();
					element.parent().parent().next().remove();
					element.parent().parent().remove();
				}
			},
			complete: function() {
				element.removeClass("glyphicon-refresh spinning").addClass("glyphicon-minus");
			}
		});
		break;
		case "past_surgery_delete":
		$.ajax({
			url: '/api/doctor/remove_patient_past_surgery',
			type: 'POST',
			data:{'id':db_id},
			cache: false,
			dataType: 'json',
			beforeSend: function() {
				element.removeClass("glyphicon-minus").addClass("glyphicon-refresh spinning");
			},		
			success: function(resp){
				if(resp.success)
				{
					element.parent().prev().prev().remove();
					element.parent().prev().remove();
					element.parent().next().remove();
					element.parent().remove();
				}
			},
			complete: function() {
				element.removeClass("glyphicon-refresh spinning").addClass("glyphicon-minus");
			}
		});
		break;

		case "allergy_detail_delete":
		$.ajax({
			url: '/api/doctor/remove_patient_allergic',
			type: 'POST',
			data:{'id':db_id},
			cache: false,
			dataType: 'json',
			beforeSend: function() {
				element.removeClass("glyphicon-minus").addClass("glyphicon-refresh spinning");
			},		
			success: function(resp){
				if(resp.success)
				{
					//element.parent().next().remove();
					element.parent().remove();
				}
			},
			complete: function() {
				element.removeClass("glyphicon-refresh spinning").addClass("glyphicon-minus");
			}
		});
		break
		
		case "medication_delete":
		$.ajax({
			url: '/api/doctor/remove_patient_medication',
			type: 'POST',
			data:{'id':db_id},
			cache: false,
			dataType: 'json',
			beforeSend: function() {
				element.removeClass("glyphicon-minus").addClass("glyphicon-refresh spinning");
			},		
			success: function(resp){
				if(resp.success)
				{
					//element.parent().next().remove();
					element.parent().remove();
				}
			},
			complete: function() {
				element.removeClass("glyphicon-refresh spinning").addClass("glyphicon-minus");
			}
		});
		break
				
		default:
		break;
	}
	return false;
};

function addelement(element)
{
	element	=	$(element)
	var doctor_id	=	'';
	var patient_id	=	$("#patient_id").val();
	var attribute 	=	element.attr('id');
	var rank 				=	element.attr('attr-rank');
	var id 				=	element.attr('db-id');
	switch(attribute)
	{
		case "family_details":
		var family_member_name	=	[];	
		var family_member_str		=	"";
		var re = /#&#$/;
		var	family_disease	=	element.parent().find("#family_detail_disease").val();
		family_member_name[0]	=	element.parent().find("#family_detail_mem1").is(":checked");
		family_member_name[1]	=	element.parent().find("#family_detail_mem2").is(":checked");
		family_member_name[2]	=	element.parent().find("#family_detail_mem3").is(":checked");
		for (i in family_member_name)
		{
			if(family_member_name[i]==true)
			{
				family_member_str	+=	i+"#&#";
			}
		}
		
    family_member_str=family_member_str.replace(re, "");
		
		var	family_summary	=	element.parent().find("#additional_info").val();
		var checked					=	'';
		if(!family_disease || !family_member_str){return false;}
		$.ajax({
			url: '/api/doctor/add_patient_family_details',
			type: 'POST',
			data:{'patient_id':patient_id,'doctor_id':doctor_id,'disease':family_disease,'member_name':family_member_str,'summary':family_summary},
			cache: false,
			dataType: 'json',
			beforeSend: function() {
				element.removeClass("glyphicon-plus").addClass("glyphicon-refresh spinning");
			},		
			success: function(resp){
				
				if(resp.success)
				{
					insert_id=resp.success;
					var html_family	=	'';
                                        html_family	+=	'<div id="" class="row"> <div class="col-sm-12">'
					html_family	+=	'<div class="form-group form-inline">';
					html_family	+=	'<label class="control-label">Disease Name</label>';
					html_family	+=	'<input type="text" class="form-control" value="'+family_disease+'" readonly />';
					checked	=	(family_member_name[0])?'checked':'';
					html_family	+=	'&nbsp;<div class="checkbox"><input type="checkbox" '+checked+' readonly /><label>&nbsp;Father</label></div>';
					checked			=	(family_member_name[1])?'checked':'';
					html_family	+=	'<div class="checkbox"><input type="checkbox" '+checked+' readonly/><label>&nbsp;Mother</label></div>';
					checked			=	(family_member_name[2])?'checked':'';
					html_family	+=	'<div class="checkbox"><input type="checkbox" '+checked+' readonly/><label>&nbsp;Sibling</label></div>';
					html_family	+=	'</div>';
					html_family	+=	'<div class="form-group">';
					html_family	+=	'<label class="control-label">Description</label>';
					html_family	+=	'<textarea rows="2" class="form-control" placeholder="Additional Information" readonly>'+family_summary+'</textarea>';
					html_family	+=	'</div>';		
					html_family	+=	'<button class="btn btn-danger glyphicon glyphicon-minus" id="family_delete_details" db-id="'+insert_id+'" onclick="removeelement(this);" title="delte" > Remove</button>';
					html_family	+=	'</div></div><div class="form-group"><hr></div>';		
					//$(html_family).insertBefore(element.parent().prev());
                                        $('#family_disease').append(html_family);
				}
			},
			complete: function() {
					element.removeClass("glyphicon-refresh spinning").addClass("glyphicon-plus");
					element.parent().find("#additional_info").val("");
					element.parent().find("#family_detail_disease").val("");
					element.parent().find("#family_detail_mem1").prop('checked' , false);
					element.parent().find("#family_detail_mem2").prop('checked' , false);
					element.parent().find("#family_detail_mem3").prop('checked' , false);
			}
		});
		
		break;

		case "past_disease":
		var	disease_name							=	element.parent().find("#disease_name").val();
		var	disease_from_month				=	element.parent().find("#disease_from_month").val();
		var	disease_from_month_label	=	element.parent().find("#disease_from_month_label").val();
		var	disease_from_year					=	element.parent().find("#disease_from_year").val();
		var	disease_duration					=	element.parent().find("#disease_duration").val();
		var	disease_details						=	element.parent().find("#disease_details").val();
		console.log(disease_name,disease_from_month,disease_from_year,disease_duration,disease_details);
		if(!disease_name || !disease_from_month || !disease_from_year){return false;}
		$.ajax({
			url: '/api/doctor/add_patient_past_disease',
			type: 'POST',
			data:{'patient_id':patient_id,'doctor_id':doctor_id,'disease_name':disease_name,'disease_from_month':disease_from_month,'disease_from_year':disease_from_year,'disease_duration':disease_duration,'disease_details':disease_details},
			cache: false,
			dataType: 'json',
			beforeSend: function() {
				element.removeClass("glyphicon-plus").addClass("glyphicon-refresh spinning");
			},		
			success: function(resp){
				
				if(resp.success)
				{
					insert_id=resp.success;
					var html_family	=	'';
                                        html_family     +=      '<div id="" class="row"> <div class="col-sm-12">'
					html_family	+=	'<div class="form-group">';
					html_family	+=	'<label class="control-label">Disease Name : </label>';
					html_family	+=	'<input type="text" readonly class="form-control" id="disease_name" value="'+disease_name+'">';
					html_family	+=	'</div>';
					html_family	+=	'<div class="form-group form-inline">';
					html_family	+=	'<label class="control-label">Incidence : </label>';
					html_family	+=	'<input type="text" readonly class="form-control autocomplete-from-month" value="'+disease_from_month_label+'" />' + ' ';
					html_family	+=	'<input type="text" readonly class="form-control autocomplete-from-year" value="'+disease_from_year+'"/>' + ' Duration Months ';
					html_family	+=	'<input type="text"  readonly class="form-control" id="disease_duration" value="'+disease_duration+'">';
					html_family	+=	'</div>';
					//html_family	+=	'<div class="form-group form-inline">';
					//html_family	+=	'<label class="control-label">Duration : </label>';
					//html_family	+=	'<input type="text"  class="form-control" id="disease_duration" value="'+disease_duration+'">';
					//html_family	+=	'</div>';
					html_family	+=	'<div class="form-group">';
					html_family	+=	'<label class="control-label">Details : </label>';
					html_family	+=	'<textarea readonly class="form-control" rows="2" cols="45" id="disease_details">'+disease_details+'</textarea>';
					html_family	+=	'</div>';
					html_family	+=	'<button class="btn btn-danger glyphicon glyphicon-minus" id="past_disease_delete" db-id="'+insert_id+'" onclick="return removeelement(this);"> Remove</button>';
					html_family	+=	'</div></div><div class="form-group"><hr /></div>';
					//$(html_family).insertBefore(element.parent().prev().prev().prev());
                                        $("#self_disease").append(html_family);
				}
			},
			complete: function() {
					element.removeClass("glyphicon-refresh spinning").addClass("glyphicon-plus");
					element.parent().find("#disease_name").val("");
					
					element.parent().find("#disease_from_month").val("");
					element.parent().find("#disease_from_month_label").val("");
					element.parent().find("#disease_from_year").val("");
					
					element.parent().find("#disease_duration").val("");
					element.parent().find("#disease_details").val("");
			}
		});
		
		break;	
		case "past_surgery":
		var	surgery_name		=	element.parent().prev().prev().find("#surgery_name").val();
		var	surgery_reason	=	element.parent().prev().find("#surgery_reason").val();
		var	surgery_date		=	element.parent().find("#surgery_date").val();

		console.log(surgery_name,surgery_reason,surgery_date);
		if(!surgery_name || !surgery_reason || !surgery_date){return false;}
		$.ajax({
			url: '/api/doctor/add_patient_past_surgery',
			type: 'POST',
			data:{'patient_id':patient_id,'surgery_name':surgery_name,'reason':surgery_reason,'surgery_date':surgery_date},
			cache: false,
			dataType: 'json',
			beforeSend: function() {
				element.removeClass("glyphicon-plus").addClass("glyphicon-refresh spinning");
			},		
			success: function(resp){
				
				if(resp.success)
				{

					insert_id=resp.success;
					var html_family	=	'';
					html_family	+=	'<div class="form-group form-inline">';
					html_family	+=	'<label class="control-label">Surgery&nbsp;</label>';
					html_family	+=	'<input type="text" readonly="" value="'+surgery_name+'" class="form-control"> ';
					html_family	+=	'<input type="text" readonly="" value="'+surgery_reason+'" class="form-control"> ';
					html_family	+=	'<input type="text" readonly="" value="'+surgery_date+'" class="form-control"> ';
					html_family	+=	'<button onclick="return removeelement(this);" db-id="'+insert_id+'" id="past_surgery_delete" class="btn btn-danger glyphicon glyphicon-minus"></button>';
					html_family	+=	'</div>';
				 $("#past_surgeries").append(html_family);
					//$(html_family).insertBefore(element.parent().prev().prev());
				}
			},
			complete: function() {
					element.removeClass("glyphicon-refresh spinning").addClass("glyphicon-plus");
					element.parent().prev().prev().find("#surgery_name").val("");
					element.parent().prev().find("#surgery_reason").val("");
					element.parent().find("#surgery_date").val("");
			}
		});
		
		break;			
		case "allergy_detail":
		var	allergic					=	element.parent().parent().find("#allergic").val();
		var	allery_type				=	element.parent().parent().find("#allery_type").val();
		var	allery_type_label	=	element.parent().parent().find("#allery_type_label").val();
		

		console.log(allery_type,allergic);
		if(!allery_type || !allergic){return false;}
		$.ajax({
			url: '/api/doctor/add_patient_allergic',
			type: 'POST',
			data:{'patient_id':patient_id,'allery_type':allery_type,'allergic':allergic},
			cache: false,
			dataType: 'json',
			beforeSend: function() {
				element.removeClass("glyphicon-plus").addClass("glyphicon-refresh spinning");
			},		
			success: function(resp){
				if(resp.success)
				{
					insert_id=resp.success;
					var html_family	=	'';
					html_family	+=	'<div class="form-group form-inline">';
					html_family	+=	'<label class="control-label">Allergy Type</label>';
					html_family	+=	'<input readonly type="text" class="form-control" value="'+allery_type_label+'" /> ';
					html_family	+=	'<label class="control-label">Specify</label>';
					html_family	+=	'<input readonly type="text" class="form-control" id="allergic" value="'+allergic+'" /> ';
					html_family	+=	'<button class="btn btn-danger glyphicon glyphicon-minus" id="allergy_detail_delete" db-id="'+insert_id+'" onclick="return removeelement(this);"></button>';
					html_family	+=	'</div>';
					//html_family	+=	'<div class="form-group"><hr /></div>';
					//$(html_family).insertBefore(element.parent());
                                        $("#allergies_list").append(html_family)
				}
			},
			complete: function() {
					element.removeClass("glyphicon-refresh spinning").addClass("glyphicon-plus");
					element.parent().find("#allergic").val("");
					element.parent().find("#allery_type_label").val("");
			}
		});
		
		break;	
		case "medication_detail":
		var	medication	=	element.parent().find("#medication").val();

		console.log(medication);
		if(!medication){return false;}
		$.ajax({
			url: '/api/doctor/add_patient_medication',
			type: 'POST',
			data:{'patient_id':patient_id,'medication':medication},
			cache: false,
			dataType: 'json',
			beforeSend: function() {
				element.removeClass("glyphicon-plus").addClass("glyphicon-refresh spinning");
			},		
			success: function(resp){
				if(resp.success)
				{
					insert_id=resp.success;
					var html_family	=	'';
					html_family	+=	'<div class="col-sm-6 col-lg-6 col-md-6 col-xs-10 form-group form-inline">';
					//html_family	+=	'<div class="form-group form-inline">';
					//html_family	+=	'<label class="control-label">Ongoing Meditation : </label>';
					html_family	+=	'<input readonly type="text" class="form-control" id="medication" value="'+medication+'" /> ';
					html_family	+=	'<button class="btn btn-danger glyphicon glyphicon-minus" id="medication_delete" db-id="'+insert_id+'" onclick="return removeelement(this);"></button>';
					html_family	+=	'</div>';
					//html_family	+=	'<div class="form-group"><hr /></div>';

					//$(html_family).insertBefore(element.parent());
                                        $("#ongoingmeds_list").append(html_family);
				}
			},
			complete: function() {
					element.removeClass("glyphicon-refresh spinning").addClass("glyphicon-plus");
					element.parent().find("#medication").val("");
			}
		});
		
		break;			
		default:
		break;
	}
	return false;
};

</script>



<!-- PAGE SPECIFIC JS-->
</body>
</html>
