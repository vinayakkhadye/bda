<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php $this->load->view('login/common/head'); ?>
</head>
<body>
<?php $this->load->view('login/common/doctor_header'); ?>
<div class="container H550">            

<div class="row">
<div class="col-lg-offset-1 col-md-offset-1 col-lg-2 col-md-2 col-sm-12 col-xs-12 list-group">
  <a class="list-group-item active" href="javascript:;" onclick="show_block(this,'professional_details');">Professional Details</a></li>
  <a class="list-group-item" href="javascript:;" onclick="show_block(this,'accreditations');">Accreditations</a></li>
  </ul>  
</div>
    
<div class="col-lg-9 col-md-9 col-xs-12 col-sm-12">
<div class="panel panel-default"> 
<div class="panel-body">  
<div class="form-horizontal tab-content" id="professional_details">
<ul class="nav nav-tabs" id="historytabs" role="tablist">
  <li role="presentation" class="active"><a href="#service-wrapper" role="tab" data-toggle="tab">Service Offered</a></li>
  <li role="presentation"><a href="#specializations-wrapper" role="tab" data-toggle="tab">Specializations</a></li>          
  <li role="presentation" ><a href="#education-wrapper" role="tab" data-toggle="tab">Education</a></li>
  <li role="presentation"><a href="#experience-wrapper" role="tab" data-toggle="tab">Experience</a></li>
</ul>
<!--Services Start-->
<div role="tabpanel" class="tab-pane active PT15" id="service-wrapper">
<div class="panel panel-default">
<div class="panel-heading">Services</div>    
<div class="panel-body" id="services-list">
<?php if(isset($doctor_detail['Services']) && is_array($doctor_detail['Services']) && sizeof($doctor_detail['Services']) > 0){  ?>
<?php foreach($doctor_detail['Services'] as $key=>$val){ ?>
<div class="row form-group">
<div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
  <input type="text" class="form-control" value="<?=ucfirst($val['description1'])?>" readonly />
</div>
<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
	<button class="btn btn-danger glyphicon glyphicon-minus" id="<?=$val['id']?>" onclick="removeelement(this)"></button>
</div>
</div>
<?php }} ?>
</div>
</div>
<div class="panel panel-default">
<div class="panel-heading"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Services</div>    
<div class="panel-body">       
<div class="row">
  <div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
  <input type="text" value="" class="form-control autocomplete-service" placeholder="Services"/>
  </div>
  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
    <button class="btn btn-success glyphicon glyphicon-plus" id="Services" onclick="addelement(this);"></button>
  </div>
</div>
</div>
</div>
</div>
<!--Services End-->

<!--Specializations Start-->
<div role="tabpanel" class="tab-pane PT15" id="specializations-wrapper">
<div class="panel panel-default">
<div class="panel-heading">Specializations</div>    
<div class="panel-body" id="specializations-list">
<?php if(isset($doctor_detail['Specializations']) && is_array($doctor_detail['Specializations']) && sizeof($doctor_detail['Specializations']) > 0){  ?>
<?php foreach($doctor_detail['Specializations'] as $key=>$val){ ?>
<div class="row form-group">
<div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
  <input type="text" class="form-control" value="<?=ucfirst($val['description1'])?>" readonly />
</div>
<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
	<button class="btn btn-danger glyphicon glyphicon-minus" id="<?=$val['id']?>" onclick="removeelement(this)"></button>
</div>
</div>
<?php }} ?>
</div>
</div>
<div class="panel panel-default">
<div class="panel-heading"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Specializations</div>    
<div class="panel-body">       
<div class="row form-group">
  <div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
  <input type="text" value="" class="form-control autocomplete-specializations" placeholder="Specializations"/>
  </div>
  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
    <button class="btn btn-success glyphicon glyphicon-plus" id="Specializations" onclick="addelement(this);"></button>
  </div>
</div>
</div>
</div>
</div>
<!--Specializations End-->

<!--Education Start-->
<div role="tabpanel" id="education-wrapper" class="tab-pane col-md-12 col-lg-12 col-sm-12 col-xs-12 PT15 " >
<div class="panel panel-default">
<div class="panel-heading">Education</div>    
<div class="panel-body" id="education-list">
<?php if(isset($doctor_detail['Education']) && is_array($doctor_detail['Education']) && sizeof($doctor_detail['Education']) > 0){  ?>
<?php foreach($doctor_detail['Education'] as $key=>$val){ ?>
<div class="row form-group">
  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
  <input type="text" value="<?=ucfirst($val['description1'])?>" class="form-control" readonly />
  </div>
  <div class="col-lg-5 col-md-5 col-sm-4 col-xs-12">
  <input type="text" value="<?=ucfirst($val['description2'])?>" class="form-control" readonly />
  </div>
  <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
  <input type="text" value="<?=ucfirst($val['from_year'])?>" class="form-control" readonly />
  </div>
  <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
  <button class="btn btn-danger glyphicon glyphicon-minus" id="<?=$val['id']?>" onclick="removeelement(this)"></button>
  </div>
</div>
<?php }} ?>
</div>
</div>
<div class="panel panel-default">
<div class="panel-heading"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Education</div>    
<div class="panel-body">
<div class="row">
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
<input type="text" value="" class="form-control autocomplete-qualification" placeholder="Qualification"/>
</div>
<div class="col-lg-5 col-md-5 col-sm-4 col-xs-12">
<input type="text" value="" class="form-control autocomplete-college" placeholder="College"/>
</div>
<div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
<input type="text" value="" class="form-control autocomplete-from-year" placeholder="year"/>
</div>
<div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
<button class="btn btn-success glyphicon glyphicon-plus" id="Education" onclick="addelement(this);">
</button>
</div>  
</div>
</div>
</div>
</div>
<!--Education End-->

<!--Experience Start-->
<div role="tabpanel" id="experience-wrapper" class="tab-pane col-md-12 col-lg-12 col-sm-12 col-xs-12 PT15">
<div class="panel panel-default">
<div class="panel-heading">Experience</div>    
<div class="panel-body" id="experience-list">
<?php if(isset($doctor_detail['Experience']) && is_array($doctor_detail['Experience']) && sizeof($doctor_detail['Experience']) > 0){  ?>
<?php foreach($doctor_detail['Experience'] as $key=>$val){ ?>
<div class="row form-group">
  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
	  <input type="text" value="<?=ucfirst($val['from_year'])?>" class="form-control" readonly/>
  </div>
  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
  	<input type="text" value="<?=ucfirst($val['to_year'])?>" class="form-control" readonly />
  </div>
  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
  	<input type="text" value="<?=ucfirst($val['description1'])?>" class="form-control" readonly />
  </div>
  <div class="col-lg-3 col-md-3 col-sm-2 col-xs-12">
  	<input type="text" value="<?=ucfirst($val['description2'])?>" class="form-control" readonly />  
  </div>
  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
  	<input type="text" value="<?=ucfirst($val['description3'])?>" class="form-control" readonly />
  </div>
  <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
	  <button class="btn btn-danger glyphicon glyphicon-minus" id="<?=$val['id']?>" onclick="removeelement(this)"></button>
  </div>
</div>
<?php }} ?>
</div>
</div>
<div class="panel panel-default">
<div class="panel-heading"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Experience</div>    
<div class="panel-body">
<div class="row">
  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
  <input type="text" value="" class="form-control autocomplete-from-year" placeholder="From Year"/>
  </div>
  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
  <input type="text" value="" class="form-control autocomplete-to-year" placeholder="To Year"/>
  </div>
  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
  <input type="text" value="" class="form-control autocomplete-role" placeholder="Role"/>
  </div>
  <div class="col-lg-3 col-md-3 col-sm-2 col-xs-12">
  <input type="text" value="" class="form-control autocomplete-hospital" placeholder="Hospital"/>
  </div>
  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
  <input type="text" value="" class="form-control autocomplete-city" placeholder="City"/>
  </div>
  <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
  <button class="btn btn-success glyphicon glyphicon-plus" id="Experience" onclick="addelement(this);">
  </button>
</div>  
</div>
</div>
</div>
</div>
<!--Experience End-->

</div>
<div class="form-horizontal tab-content" id="accreditations" style="display:none">
<ul class="nav nav-tabs" id="historytabs" role="tablist">
  <li role="presentation" class="active"><a href="#awardsandrecognitions-wrapper" role="tab" data-toggle="tab">Awards And Recognitions</a></li>
  <li role="presentation"><a href="#membership-wrapper" role="tab" data-toggle="tab">Membership</a></li>          
  <li role="presentation" ><a href="#registrations-wrapper" role="tab" data-toggle="tab">Registrations</a></li>
  <li role="presentation"><a href="#qualifications-wrapper" role="tab" data-toggle="tab">Qualifications</a></li>
  <li role="presentation"><a href="#paperspublished-wrapper" role="tab" data-toggle="tab">Papers Published</a></li>
  <li role="presentation"><a href="#summary-wrapper" role="tab" data-toggle="tab">Brief</a></li>
</ul>
<!--AwardsAndRecognitions Start-->
<div role="tabpanel" class="tab-pane active PT15" id="awardsandrecognitions-wrapper">
<div class="panel panel-default">
<div class="panel-heading">Awards And Recognitions</div>    
<div class="panel-body" id="awardsandrecognitions-list">
<?php if(isset($doctor_detail['AwardsAndRecognitions']) && is_array($doctor_detail['AwardsAndRecognitions']) && sizeof($doctor_detail['AwardsAndRecognitions']) > 0){  ?>
<?php foreach($doctor_detail['AwardsAndRecognitions'] as $key=>$val){ ?>
<div class="row form-group">
  <div class="col-sm-7">
	  <input type="text" value="<?=$val['description1']?>" class="form-control" readonly />
  </div>
  <div class="col-sm-3">
    <input type="text" value="<?=$val['from_year']?>"  class="form-control" readonly/>
  </div>
  <div class="col-sm-2">
	  <button class="btn btn-danger glyphicon glyphicon-minus" id="<?=$val['id']?>" onclick="removeelement(this)"></button>
  </div>
</div>
<?php }} ?>
</div>
</div>
<div class="panel panel-default">
<div class="panel-heading"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Awards And Recognitions</div>    
<div class="panel-body">
<div class="form-group">
  <div class="col-sm-7"><input type="text" value="" class="form-control autocomplete-awardsandrecognitions" placeholder="Awards And Recognitions"/></div>
  <div class="col-sm-3"><input type="text" value="" class="form-control autocomplete-from-year" placeholder="Year"/></div>
  <div class="col-sm-2"><button class="btn btn-success glyphicon glyphicon-plus" id="AwardsAndRecognitions" onclick="addelement(this);"></button>
</div>
</div>
</div>
</div>
</div>
<!--AwardsAndRecognitions End-->

<!--Membership Start-->
<div role="tabpanel" class="tab-pane PT15" id="membership-wrapper">
<div class="panel panel-default">
<div class="panel-heading">Membership</div>    
<div class="panel-body" id="membership-list">
<?php if(isset($doctor_detail['Membership']) && is_array($doctor_detail['Membership']) && sizeof($doctor_detail['Membership']) > 0){  ?>
<?php foreach($doctor_detail['Membership'] as $key=>$val){ ?>
<div class="row form-group">
<div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
  <input type="text" class="form-control" value="<?=ucfirst($val['description1'])?>" readonly />
</div>
<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
	<button class="btn btn-danger glyphicon glyphicon-minus" id="<?=$val['id']?>" onclick="removeelement(this)"></button>
</div>
</div>
<?php }} ?>
</div>
</div>
<div class="panel panel-default">
<div class="panel-heading"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Membership</div>    
<div class="panel-body">
<div class="form-group">
  <div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
  	<input type="text" value="" class="form-control autocomplete-membership" placeholder="Membership"/>
  </div>
  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
    <button class="btn btn-success glyphicon glyphicon-plus" id="Membership" onclick="addelement(this);"></button>
  </div>
</div>
</div>
</div>
</div>
<!--Membership End-->

<!--Registrations Start-->
<div role="tabpanel" class="tab-pane PT15" id="registrations-wrapper">
<div class="panel panel-default">
<div class="panel-heading">Registrations</div>    
<div class="panel-body" id="registrations-list">
<?php if(isset($doctor_detail['Registrations']) && is_array($doctor_detail['Registrations']) && sizeof($doctor_detail['Registrations']) > 0){  ?>
<?php foreach($doctor_detail['Registrations'] as $key=>$val){ ?>
<div class="row form-group">
  <div class="col-sm-4">
	  <input type="text" value="<?=$val['description1']?>" class="form-control" readonly />
  </div>
  <div class="col-sm-4">
    <input type="text" value="<?=$val['description2']?>"  class="form-control" readonly/>
  </div>
  <div class="col-sm-2">
    <input type="text" value="<?=$val['to_year']?>"  class="form-control" readonly/>
  </div>  
  <div class="col-sm-2">
	  <button class="btn btn-danger glyphicon glyphicon-minus" id="<?=$val['id']?>" onclick="removeelement(this)"></button>
  </div>
</div>
<?php }} ?>
</div>
</div>
<div class="panel panel-default">
<div class="panel-heading"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Registrations</div>
<div class="panel-body">
<div class="row form-group">
  <div class="col-sm-4"><input type="text" value="" class="form-control autocomplete-registration-no" placeholder="Registration Number"/></div>
  <div class="col-sm-4"><input type="text" value="" class="form-control autocomplete-registration-council" placeholder="Registration Council"/></div>
  <div class="col-sm-2"><input type="text" value="" class="form-control autocomplete-to-year" placeholder="Year"/></div>
  <div class="col-sm-2"><button class="btn btn-success glyphicon glyphicon-plus" id="Registrations" onclick="addelement(this);"></button>
</div>
</div>
</div>
</div>
</div>
<!--Registrations End-->

<!--Qualifications Start-->
<div role="tabpanel" class="tab-pane PT15" id="qualifications-wrapper">
<div class="panel panel-default">
<div class="panel-heading">Qualifications</div>    
<div class="panel-body" id="qualifications-list">
<?php if(isset($doctor_detail['Qualifications']) && is_array($doctor_detail['Qualifications']) && sizeof($doctor_detail['Qualifications']) > 0){  ?>
<?php foreach($doctor_detail['Qualifications'] as $key=>$val){ ?>
<div class="form-group">
<div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
  <input type="text" class="form-control" value="<?=ucfirst($val['description1'])?>" readonly />
</div>
<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
	<button class="btn btn-danger glyphicon glyphicon-minus" id="<?=$val['id']?>" onclick="removeelement(this)"></button>
</div>
</div>
<?php }} ?>
</div>
</div>
<div class="panel panel-default">
<div class="panel-heading"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Qualifications</div>
<div class="panel-body">
<div class="form-group">
  <div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
  <input type="text" value="" class="form-control autocomplete-qualification" placeholder="Qualification"/>
  </div>
  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
    <button class="btn btn-success glyphicon glyphicon-plus" id="Qualifications" onclick="addelement(this);"></button>
  </div>
</div>
</div>
</div>
</div>
<!--Qualifications End-->

<!--PapersPublished Start-->
<div role="tabpanel" class="tab-pane PT15" id="paperspublished-wrapper">
<div class="panel panel-default">
<div class="panel-heading">Papers Published</div>    
<div class="panel-body" id="paperspublished-list">
<?php if(isset($doctor_detail['PapersPublished']) && is_array($doctor_detail['PapersPublished']) && sizeof($doctor_detail['PapersPublished']) > 0){  ?>
<?php foreach($doctor_detail['PapersPublished'] as $key=>$val){ ?>
<div class="form-group">
<div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
  <input type="text" class="form-control" value="<?=ucfirst($val['description1'])?>" readonly />
</div>
<div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
	<button class="btn btn-danger glyphicon glyphicon-minus" id="<?=$val['id']?>" onclick="removeelement(this)"></button>
</div>
</div>
<?php }} ?>
</div>
</div>
<div class="panel panel-default">
<div class="panel-heading"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Add Papers Published</div>
<div class="panel-body">
<div class="form-group">
  <div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
  <input type="text" value="" class="form-control autocomplete-paperspublished" placeholder="PapersPublished"/>
  </div>
  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
    <button class="btn btn-success glyphicon glyphicon-plus" id="PapersPublished" onclick="addelement(this);"></button>
  </div>
</div>
</div>
</div>
</div>
<!--Summary End-->
<div role="tabpanel" class="tab-pane PT15" id="summary-wrapper">
<div class="panel panel-default">
<div class="panel-heading">Brief Summary About Your self</div>    
<div class="panel-body">
<div class="row form-group">
  <div class="col-lg-10 col-md-10 col-sm-10 col-xs-8">
    <textarea class="form-control" row="10"><?=$doctor_data['summary']?></textarea>
  </div>
  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4">
  <button class="btn btn-success glyphicon glyphicon-edit" id="doctor_summary" attr-id="<?=$doctor_id?>" onclick="addelement(this);"></button>
	</div>
</div>
</div>
</div>
</div>
<!--Summary End-->
</div>

</div> <!-- panel body -->
</div> <!-- panel  -->
</div> <!-- col sm-9 -->
</div> <!-- row -->
</div> <!-- container -->
<?php $this->load->view('login/common/footer'); ?>
<?php $this->load->view('login/common/bottom'); ?>
<script type="text/javascript">
var	year	=	<?=$year?>;
$(document).ready(function(){
	$(".autocomplete-service").autocomplete({
				source: function(request,response){
					$.ajax({
						url: BASE_URL + "api/masters/services/",
						dataType: "json",
						data: {
							query: request.term
						},
						success: function( data ) {
							response( data );
						}
					});
				},
				minLength: 0,
				select: function( event, ui ) {
					$(this).attr("value", ui.item.value)
				}
			}).focus(function() {$(this).autocomplete("search", $(this).val());});
	$(".autocomplete-specializations").autocomplete({
				source: function(request,response){
					$.ajax({
						url: BASE_URL + "api/masters/specializations/",
						dataType: "json",
						data: {
							query: request.term
						},
						success: function( data ) {
							response( data );
						}
					});
				},
				minLength: 0,
				select: function( event, ui ) {
					$(this).attr("value", ui.item.value)
				}
			}).focus(function() {$(this).autocomplete("search", $(this).val());});
	$(".autocomplete-qualification").autocomplete({
				source: function(request,response){
					$.ajax({
						url: BASE_URL + "api/masters/qualification/",
						dataType: "json",
						data: {
							query: request.term
						},
						success: function( data ) {
							response( data );
						}
					});
				},
				minLength: 0,
				select: function( event, ui ) {
					$(this).attr("value", ui.item.value)
				}
			}).focus(function() {$(this).autocomplete("search", $(this).val());});
	$(".autocomplete-college").autocomplete({
			source: function(request,response){
				$.ajax({
					url: BASE_URL + "api/masters/college/",
					dataType: "json",
					data: {
						query: request.term
					},
					success: function( data ) {
						response( data );
					}
				});
			},
			minLength: 0,
			select: function( event, ui ) {
				$(this).attr("value", ui.item.value)
			}
		}).focus(function() {$(this).autocomplete("search", $(this).val());});
	$( ".autocomplete-from-year" ).autocomplete({
		source: year,
		minLength: 0
	}).focus(function() {$(this).autocomplete("search", $(this).val());});
	$( ".autocomplete-to-year" ).autocomplete({
		source: year,
		minLength: 0
	}).focus(function() {$(this).autocomplete("search", $(this).val());});
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
		minLength: 0,
		select: function( event, ui ) {
			$(this).attr("value", ui.item.value)
		}
	}).focus(function() {$(this).autocomplete("search", $(this).val());});
	$(".autocomplete-membership").autocomplete({
		source: function(request,response){
			$.ajax({
				url: BASE_URL + "api/masters/membership/",
				dataType: "json",
				data: {
					query: request.term
				},
				success: function( data ) {
					response( data );
				}
			});
		},
		minLength: 0,
		select: function( event, ui ) {
			$(this).attr("value", ui.item.value)
		}
	}).focus(function() {$(this).autocomplete("search", $(this).val());});
	$(".autocomplete-registration-council").autocomplete({
		source: function(request,response){
			$.ajax({
				url: BASE_URL + "api/masters/councils/",
				dataType: "json",
				data: {
					query: request.term
				},
				success: function( data ) {
					response( data );
				}
			});
		},
		minLength: 0,
		select: function( event, ui ) {
			$(this).attr("value", ui.item.value)
		}
	}).focus(function() {$(this).autocomplete("search", $(this).val());});
});
function show_block(self,obj)
{
	$(".list-group a").removeClass("active");
	$(self).addClass("active");
	$(".form-horizontal").hide();
	$("#"+obj).show();
}
function removeelement(element)
{
	element	=	 $(element);
	$.ajax({
		url: '/api/doctor/delete_doctor_detail_byid',
		type: 'POST',
		data:{'id':element.attr('id')},
		cache: false,
		dataType: 'json',
		beforeSend: function() {
			element.removeClass("glyphicon-minus").addClass("glyphicon-refresh spinning");
		},		
		success: function(resp){
			if(resp.success)
			{
				element.parent().parent().remove();
			}
		},
		complete: function() {
			element.removeClass("glyphicon-refresh spinning").addClass("glyphicon-plus");
		}
	});		
}
function update_summary(element,doctor_id,summary)
{
	element	=	 $(element);
	$.ajax({
		url: '/api/doctor/update_doctor_summary_byid',
		type: 'POST',
		data:{'id':doctor_id,'summary':summary},
		cache: false,
		dataType: 'json',
		beforeSend: function() {
			element.removeClass("glyphicon-plus").addClass("glyphicon-refresh spinning");
		},		
		success: function(resp){
			if(resp.success)
			{
				// some code ..
			}
		},
		complete: function() {
			element.removeClass("glyphicon-refresh spinning").addClass("glyphicon-plus");
		}
	});		
}
function addrow(element,doctor_id,attribute,description1,description2,description3,from_year,to_year)
{
	//console.log(element.parent().parent());
	//return false;
	var insert_id = 0;
	if(doctor_id && attribute && description1)
	{
		$.ajax({
			url: '/api/doctor/add_doctor_detail_by_attribute',
			type: 'POST',
			data:{'doctor_id':doctor_id,'attribute':attribute,'description1':description1,
			'description2':description2,'description3':description3,'from_year':from_year,'to_year':to_year},
			cache: false,
			dataType: 'json',
			beforeSend: function() {
				element.removeClass("glyphicon-plus").addClass("glyphicon-refresh spinning");
			},		
			success: function(resp){
				if(resp.success)
				{
					insert_id=resp.success;
					switch(attribute)
					{
					case "Services":
						var html_services	=	'<div class="row form-group"><div class="col-lg-10 col-md-10 col-sm-10 col-xs-8"><input type="text" value="'+description1+'" class="form-control" readonly/></div><div class="col-lg-2 col-md-2 col-sm-2 col-xs-4"><button class="btn btn-danger glyphicon glyphicon-minus" id="'+insert_id+'" onclick="removeelement(this)"></button></div></div>';
						$("#services-list").append(html_services);
						element.parent().prev().find('input').val("");
					break;
					
					case "Specializations":
						var html_specializations	=	'<div class="row form-group"><div class="col-lg-10 col-md-10 col-sm-10 col-xs-8"><input type="text" value="'+description1+'" class="form-control" readonly/></div><div class="col-lg-2 col-md-2 col-sm-2 col-xs-4"><button class="btn btn-danger glyphicon glyphicon-minus" id="'+insert_id+'" onclick="removeelement(this)"></button></div></div>';
						$("#specializations-list").append(html_specializations);
						
						element.parent().prev().find('input').val("");
					break;
					
					case "Education":
						var html_education	=	'<div class="row form-group"><div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"><input type="text" value="'+description1+'" class="form-control" readonly /></div><div class="col-lg-5 col-md-5 col-sm-4 col-xs-12"><input type="text" value="'+description2+'" class="form-control" readonly/></div><div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"><input type="text" value="'+from_year+'" class="form-control" readonly/></div> <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12"><button class="btn btn-danger glyphicon glyphicon-minus" id="'+insert_id+'" onclick="removeelement(this)"></button></div></div>';
						$("#education-list").append(html_education);						

						element.parent().parent().find('input.autocomplete-qualification').val("");
						element.parent().parent().find('input.autocomplete-college').val("");
						element.parent().parent().find('input.autocomplete-from-year').val("");
					break;
					
					case "Experience":
						var html_experience	=	'<div class="form-group"><div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"><input type="text" value="'+from_year+'" class="form-control" readonly/></div><div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"><input type="text" value="'+to_year+'" class="form-control" readonly /></div><div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"><input type="text" value="'+description1+'" class="form-control" readonly /></div><div class="col-lg-3 col-md-3 col-sm-2 col-xs-12"><input type="text" value="'+description2+'" class="form-control" readonly /></div><div class="col-lg-2 col-md-2 col-sm-2 col-xs-12"><input type="text" value="'+description3+'" class="form-control" readonly /></div><div class="col-lg-1 col-md-1 col-sm-1 col-xs-12"><button class="btn btn-danger glyphicon glyphicon-minus" id="'+insert_id+'" onclick="removeelement(this)"></button></div></div>';
						$("#experience-list").append(html_experience);						

						element.parent().parent().find('input.autocomplete-from-year').val("");
						element.parent().parent().find('input.autocomplete-to-year').val("");
						element.parent().parent().find('input.autocomplete-role').val("");
						element.parent().parent().find('input.autocomplete-hospital').val("");
						element.parent().parent().find('input.autocomplete-city').val("");
					break;
					
					case "AwardsAndRecognitions":
						var html_awardsandrecognitions	=	'<div class="row form-group"><div class="col-sm-7"><input type="text" value="'+description1+'" class="form-control" readonly /></div><div class="col-sm-3"><input type="text" value="'+from_year+'"  class="form-control" readonly/></div><div class="col-sm-2"><button class="btn btn-danger glyphicon glyphicon-minus" id="'+insert_id+'" onclick="removeelement(this)"></button></div></div>';
						$("#awardsandrecognitions-list").append(html_awardsandrecognitions);						

						element.parent().parent().find('input.autocomplete-awardsandrecognitions').val("");
						element.parent().parent().find('input.autocomplete-from-year').val("");
					break;					
					
					case "Membership":
						var html_membership	=	'<div class="form-group"><div class="col-lg-10 col-md-10 col-sm-10 col-xs-8"><input type="text" value="'+description1+'" class="form-control" readonly/></div><div class="col-lg-2 col-md-2 col-sm-2 col-xs-4"><button class="btn btn-danger glyphicon glyphicon-minus" id="'+insert_id+'" onclick="removeelement(this)"></button></div></div>';
						$("#membership-list").append(html_membership);						
						element.parent().prev().find('input').val("");
					break;					
					
					case "Registrations":
						var html_registrations	=	'<div class="form-group"><div class="col-sm-4"><input type="text" value="'+description1+'" class="form-control" readonly /></div><div class="col-sm-4"><input type="text" value="'+description2+'"  class="form-control" readonly/></div><div class="col-sm-2"><input type="text" value="'+to_year+'"  class="form-control" readonly/></div><div class="col-sm-2"><button class="btn btn-danger glyphicon glyphicon-minus" id="'+insert_id+'" onclick="removeelement(this)"></button></div></div>';
						
						$("#registrations-list").append(html_registrations);						

						element.parent().parent().find('input.autocomplete-registration-no').val("");
						element.parent().parent().find('input.autocomplete-registration-council').val("");
						element.parent().parent().find('input.autocomplete-to-year').val("");
					break;										

					case "Qualifications":
						var html_qualifications	=	'<div class="form-group"><div class="col-lg-10 col-md-10 col-sm-10 col-xs-8"><input type="text" value="'+description1+'" class="form-control" readonly/></div><div class="col-lg-2 col-md-2 col-sm-2 col-xs-4"><button class="btn btn-danger glyphicon glyphicon-minus" id="'+insert_id+'" onclick="removeelement(this)"></button></div></div>';
						$("#qualifications-list").append(html_qualifications);						
						element.parent().prev().find('input').val("");
					break;
					case "PapersPublished":
						var html_paperspublished	=	'<div class="form-group"><div class="col-lg-10 col-md-10 col-sm-10 col-xs-8"><input type="text" value="'+description1+'" class="form-control" readonly/></div><div class="col-lg-2 col-md-2 col-sm-2 col-xs-4"><button class="btn btn-danger glyphicon glyphicon-minus" id="'+insert_id+'" onclick="removeelement(this)"></button></div></div>';
						$("#paperspublished-list").append(html_paperspublished);						
						element.parent().prev().find('input').val("");
					break;
					}
				}
				return false;
			},
		 complete: function() {
			 	/*if(insert_id){$("#"+insert_id).focus();}*/
				element.removeClass("glyphicon-refresh spinning").addClass("glyphicon-plus");
			}
		});		
	}
}	
function addelement(element)
{
	element	=	$(element)
	var doctor_id	=	'<?=$doctor_id?>';
	var attribute = element.attr('id');
	switch(attribute)
	{
		case "Services":
			var service_name	=	element.parent().prev().find('input').val();
			if(service_name)
			{
				addrow(element,doctor_id,attribute,service_name);
			}
		break;
		
		case "Specializations":
			var specialization_name	=	element.parent().prev().find('input').val();
			if(specialization_name)
			{
				addrow(element,doctor_id,attribute,specialization_name);
			}
		break;		

		case "Education":
			var qualification_name	=	element.parent().parent().find('input.autocomplete-qualification').val();
			var college_name				=	element.parent().parent().find('input.autocomplete-college').val();
			var from_year						=	element.parent().parent().find('input.autocomplete-from-year').val();
			if(qualification_name && college_name && from_year)
			{
				addrow(element,doctor_id,attribute,qualification_name,college_name,'',from_year);
			}
		break;				

		case "Experience":
			var from_year	=	element.parent().parent().find('input.autocomplete-from-year').val();
			var to_year		=	element.parent().parent().find('input.autocomplete-to-year').val();
			var role			=	element.parent().parent().find('input.autocomplete-role').val();
			var hospital	=	element.parent().parent().find('input.autocomplete-hospital').val();
			var city			=	element.parent().parent().find('input.autocomplete-city').val();
			if(role && hospital && city)
			{
				addrow(element,doctor_id,attribute,role,hospital,city,from_year,to_year);
			}
		break;				

		case "AwardsAndRecognitions":
			var awardsandrecognitions	=	element.parent().parent().find('input.autocomplete-awardsandrecognitions').val();
			var from_year	=	element.parent().parent().find('input.autocomplete-from-year').val();
			if(awardsandrecognitions && from_year)
			{
				addrow(element,doctor_id,attribute,awardsandrecognitions,'','',from_year);
			}
		break;				

		case "Membership":
			var membership_name	=	element.parent().prev().find('input').val();
			if(membership_name)
			{
				addrow(element,doctor_id,attribute,membership_name);
			}
		break;
		
		case "Registrations":
			var registrations_no			=	element.parent().parent().find('input.autocomplete-registration-no').val();
			var registration_council	=	element.parent().parent().find('input.autocomplete-registration-council').val();
			var to_year								=	element.parent().parent().find('input.autocomplete-to-year').val();
			
			if(registrations_no && registration_council && to_year)
			{
				addrow(element,doctor_id,attribute,registrations_no,registration_council,'','',to_year);
			}
		break;				

		case "Qualifications":
			var qualification_name	=	element.parent().prev().find('input').val();
			if(qualification_name)
			{
				addrow(element,doctor_id,attribute,qualification_name);
			}
		break;

		case "PapersPublished":
			var paperspublished_name	=	element.parent().prev().find('input').val();
			if(paperspublished_name)
			{
				addrow(element,doctor_id,attribute,paperspublished_name);
			}
		break;

		case "doctor_summary":
			var summary	=	element.parent().prev().find('textarea').val();
			if(summary)
			{
				console.log(summary);
				update_summary(element,doctor_id,summary);
			}
		break;

		
		default:
		break;
	}
};
</script>
</body>
</html>
