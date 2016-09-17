<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Edit Detail Doctor Profile | BDA</title>
	<?php $this->load->view('admin/common/head'); ?>
</head>
<body>
	<?php $this->load->view('admin/common/header'); ?>
  <div class="container-fluid">
  <div class="panel panel-default">
  <div class="panel-heading">Doctor Extra Profile Details</div>
  <div class="panel-body"> 
  <div class="col-sm-12">
  <form action="/bdabdabda/manage_doctors/post_doctor_extra_details/<?=$all_details['doctor_id']?>" method="POST" role="form" class="form-horizontal">
    <!--Services Start-->
    <div class="form-group">
      <div class="col-sm-10">
	      <label class="control-label"><span class="red">*</span>Services offered : </label>
      </div>
    </div>	
    <div class="InputsWrapper" id="services">
    <?php if(is_array($doctor_extra_details)){foreach($doctor_extra_details as $row){  ?>
    <?php if(isset($row['attribute']) && $row['attribute'] == 'Services'){ ?>
    		<div class="form-group">
        <div class="col-sm-10">
	      <input type="text" name="services[]" value="<?=ucfirst($row['description1'])?>" class="form-control" placeholder="Services" />
        </div>
        <div class="col-sm-2">
        <a href="javascript:void(0);" class="removeclass btn btn-danger" id="services">Remove</a>
        </div>
        </div>
    <?php }}} ?>
    </div>
    <div class="form-group AddMoreFileId">
      <div class="col-sm-2">
	      <a href="javascript:void(0);" class="AddMoreFileBox  btn btn-primary" id="services">Add More</a>
      </div>
      <div class="col-sm-2">
  	    <a href="javascript:void(0);" class="AddMoreFileBox  btn btn-primary" id="services_other">Add Other</a>
      </div>
    </div>
    <!--Services End-->
		<hr />
    <!--Education Start-->
    <div class="form-group">
      <div class="col-sm-10">
	      <label class="control-label"><span class="red">*</span>Education offered : </label>
      </div>
    </div>	
    <div class="InputsWrapper" id="education">
    <?php if(is_array($doctor_extra_details)){foreach($doctor_extra_details as $row){  ?>
    <?php if(isset($row['attribute']) && $row['attribute'] == 'Education'){ ?>
    		<div class="form-group">
        <div class="col-sm-3">
        <input type="text" name="education_qualification[]" value="<?=ucfirst($row['description1'])?>" class="form-control" placeholder="Qualification"/>
        </div>
        <div class="col-sm-4">
        <input type="text" name="education_college[]" value="<?=ucfirst($row['description2'])?>" class="form-control" placeholder="College"/>
        </div>
        <div class="col-sm-3">
        <input type="text" name="education_from_year[]" value="<?=ucfirst($row['from_year'])?>" class="form-control" placeholder="From Year"/>
        </div>
        <div class="col-sm-2">
        <a href="javascript:void(0);" class="removeclass btn btn-danger" id="education">Remove</a>
        </div>
        </div>
    <?php }}} ?>
    </div>
    <div class="form-group AddMoreFileId">
      <div class="col-sm-2">
	      <a href="javascript:void(0);" class="AddMoreFileBox  btn btn-primary" id="education">Add More</a>
      </div>
      <div class="col-sm-2">
  	    <a href="javascript:void(0);" class="AddMoreFileBox  btn btn-primary" id="education_other">Add Other</a>
      </div>
    </div>
    <!--Education End-->
		<hr />
    <!--Experience Start-->
    <div class="form-group">
      <div class="col-sm-10">
	      <label class="control-label"><span class="red">*</span>Experience offered : </label>
      </div>
    </div>	
    <div class="InputsWrapper" id="experience">
    <?php if(is_array($doctor_extra_details)){foreach($doctor_extra_details as $row){  ?>
    <?php if(isset($row['attribute']) && $row['attribute'] == 'Experience'){ ?>
    		<div class="form-group">
          <div class="col-sm-1">
          <input type="text" name="experience_from_year[]" value="<?=ucfirst($row['from_year'])?>" class="form-control" placeholder="From Year"/>
          </div>
          <div class="col-sm-1">to</div> 
          <div class="col-sm-1">
          <input type="text" name="experience_to_year[]" value="<?=ucfirst($row['to_year'])?>" class="form-control" placeholder="To Year" />
          </div>
          <div class="col-sm-2">
          <input type="text" name="experience_role[]" value="<?=ucfirst($row['description1'])?>" class="form-control" placeholder="Role" />
          </div>
          <div class="col-sm-2">
          <input type="text" name="experience_hospital[]" value="<?=ucfirst($row['description2'])?>" class="form-control" placeholder="Hospital"/>  
          </div>
          <div class="col-sm-1">at</div>
          <div class="col-sm-2">
          <input type="text" name="experience_city[]" value="<?=ucfirst($row['description3'])?>" class="form-control" placeholder="City" />
          </div>
          <div class="col-sm-1">
          <a href="javascript:void(0);" class="removeclass btn btn-danger" id="experience">Remove</a>
          </div>
        </div>
    <?php }}} ?>
    </div>
    <div class="form-group AddMoreFileId">
      <div class="col-sm-2">
	      <a href="javascript:void(0);" class="AddMoreFileBox  btn btn-primary" id="experience">Add More</a>
      </div>
      <div class="col-sm-2">
  	    <a href="javascript:void(0);" class="AddMoreFileBox  btn btn-primary" id="experience_other">Add Other</a>
      </div>
    </div>
    <!--Experience End-->
		<hr />
	 	<!--Awards & Recognitions Start-->
    <div class="form-group">
    <div class="col-sm-10">
      <label class="control-label"><span class="red">*</span>Awards & Recognitions : </label>
    </div>
    </div>	
    <div class="InputsWrapper" id="awards">
    <?php if(is_array($doctor_extra_details)){foreach($doctor_extra_details as $row){  ?>
    <?php if(isset($row['attribute']) && $row['attribute'] == 'AwardsAndRecognitions'){ ?>
      <div class="form-group">
        <div class="col-sm-6">
          <input type="text" name="awardsandrecognitions_award[]" value="<?=ucfirst($row['description1'])?>" class="form-control"/>
        </div>
        <div class="col-sm-4">
          <input type="text" name="awardsandrecognitions_from_year[]" value="<?=ucfirst($row['from_year'])?>" class="form-control"/>
        </div>
        <div class="col-sm-2">
          <a href="javascript:void(0);" class="removeclass btn btn-danger" id="awards">Remove</a>
        </div>
      </div>
    <?php }}} ?>
    </div>
    <div class="form-group AddMoreFileId">
    <div class="col-sm-2">
      <a href="javascript:void(0);" class="AddMoreFileBox  btn btn-primary" id="awards">Add More</a>
    </div>
    <div class="col-sm-2">
      <a href="javascript:void(0);" class="AddMoreFileBox  btn btn-primary" id="awards_other">Add Other</a>
    </div>
    </div>
  	<!--Awards & Recognitions End-->        
    <hr />
		
    <!--Membership Start-->
    <div class="form-group">
    <div class="col-sm-10">
      <label class="control-label"><span class="red">*</span>	Memberships : </label>
    </div>
    </div>	
    <div class="InputsWrapper" id="membership">
    <?php if(is_array($doctor_extra_details)){foreach($doctor_extra_details as $row){  ?>
    <?php if(isset($row['attribute']) && $row['attribute'] == 'Membership'){ ?>
      <div class="form-group">
      	<div class="col-sm-10">
        <input type="text" name="membership[]" value="<?=ucfirst($row['description1'])?>" class="form-control"/>
        </div>
        <div class="col-sm-2">
        <a href="javascript:void(0);" class="removeclass btn btn-danger" id="membership">Remove</a>
        </div>
      </div>
    <?php }}} ?>
    </div>
    <div class="form-group AddMoreFileId">
    <div class="col-sm-2">
      <a href="javascript:void(0);" class="AddMoreFileBox  btn btn-primary" id="membership">Add More</a>
    </div>
    <div class="col-sm-2">
      <a href="javascript:void(0);" class="AddMoreFileBox  btn btn-primary" id="membership_other">Add Other</a>
    </div>
    </div>
  	<!--Membership End-->  
    <hr />    
    <!--Specializations Start-->
    <div class="form-group">
    <div class="col-sm-10">
      <label class="control-label"><span class="red">*</span>	Specializations : </label>
    </div>
    </div>	
    <div class="InputsWrapper" id="specializations">
    <?php if(is_array($doctor_extra_details)){foreach($doctor_extra_details as $row){  ?>
    <?php if(isset($row['attribute']) && $row['attribute'] == 'Specializations'){ ?>
      <div class="form-group">
      	<div class="col-sm-10">
        <input type="text" name="specializations[]" value="<?=ucfirst($row['description1'])?>" class="form-control"/>
        </div>
        <div class="col-sm-2">
        <a href="javascript:void(0);" class="removeclass btn btn-danger" id="specializations">Remove</a>
        </div>
      </div>
    <?php }}} ?>
    </div>
    <div class="form-group AddMoreFileId">
    <div class="col-sm-2">
      <a href="javascript:void(0);" class="AddMoreFileBox  btn btn-primary" id="specializations">Add More</a>
    </div>
    <div class="col-sm-2">
      <a href="javascript:void(0);" class="AddMoreFileBox  btn btn-primary" id="specializations_other">Add Other</a>
    </div>
    </div>
  	<!--Specializations End-->  
    <hr />        
	 <!--Registrations Start-->
    <div class="form-group">
    <div class="col-sm-10">
      <label class="control-label"><span class="red">*</span>	Registrations : </label>
    </div>
    </div>	
    <div class="InputsWrapper" id="registrations">
    <?php if(is_array($doctor_extra_details)){foreach($doctor_extra_details as $row){  ?>
    <?php if(isset($row['attribute']) && $row['attribute'] == 'Registrations'){ ?>
      <div class="form-group">
	      <div class="col-sm-3">
        <input type="text" name="registrations_no[]" value="<?=ucfirst($row['description1'])?>" class="form-control"/>
        </div>
        <div class="col-sm-4">
        <input type="text" name="registrations_council[]" value="<?=ucfirst($row['description2'])?>" class="form-control"/>
        </div>
        <div class="col-sm-3">
        <input type="text" name="registrations_year[]" value="<?=ucfirst($row['from_year'])?>" class="form-control"/>
        </div>
        <div class="col-sm-2">
        <a href="javascript:void(0);" class="removeclass btn btn-danger" id="registrations">Remove</a>
        </div>
      </div>
    <?php }}} ?>
    </div>
    <div class="form-group AddMoreFileId">
    <div class="col-sm-2">
      <a href="javascript:void(0);" class="AddMoreFileBox  btn btn-primary" id="registrations">Add More</a>
    </div>
    <div class="col-sm-2">
      <a href="javascript:void(0);" class="AddMoreFileBox  btn btn-primary" id="registrations_other">Add Other</a>
    </div>
    </div>
  	<!--Registrations End-->      
    <hr />
		<!--Additional Qualifications Start-->
    <div class="form-group">
    <div class="col-sm-10">
      <label class="control-label"><span class="red">*</span>	Additional Qualifications : </label>
    </div>
    </div>	
    <div class="InputsWrapper" id="qualifications">
    <?php if(is_array($doctor_extra_details)){foreach($doctor_extra_details as $row){  ?>
    <?php if(isset($row['attribute']) && $row['attribute'] == 'Qualifications'){ ?>
      <div class="form-group">
	      <div class="col-sm-10">
        <input type="text" name="qualifications[]" value="<?=ucfirst($row['description1'])?>" class="form-control" placeholder="Qualification" />
        </div>
        <div class="col-sm-2">
        <a href="javascript:void(0);" class="removeclass btn btn-danger" id="qualifications">Remove</a>
        </div>
      </div>
    <?php }}} ?>
    </div>
    <div class="form-group AddMoreFileId">
    <div class="col-sm-2">
      <a href="javascript:void(0);" class="AddMoreFileBox btn btn-primary" id="qualifications_other">Add Other</a><br><br>
    </div>
    </div>
  	<!--Additional Qualifications End-->          
    <hr />
		<!--Papers published Start-->
    <div class="form-group">
    <div class="col-sm-10">
      <label class="control-label"><span class="red">*</span>	Papers Published : </label>
    </div>
    </div>	
    <div class="InputsWrapper" id="paperspublished">
    <?php if(is_array($doctor_extra_details)){foreach($doctor_extra_details as $row){  ?>
    <?php if(isset($row['attribute']) && $row['attribute'] == 'PapersPublished'){ ?>
      <div class="form-group">
	      <div class="col-sm-10">
        <input type="text" name="paperspublished[]" value="<?=ucfirst($row['description1'])?>" class="form-control" placeholder="Papers Published" />
        </div>
        <div class="col-sm-2">
        <a href="javascript:void(0);" class="removeclass btn btn-danger" id="paperspublished">Remove</a>
        </div>
      </div>
    <?php }}} ?>
    </div>
    <div class="form-group AddMoreFileId">
    <div class="col-sm-2">
      <a href="javascript:void(0);" class="AddMoreFileBox btn btn-primary" id="paperspublished_other">Add Other</a><br><br>
    </div>
    </div>
  	<!--Papers published End-->      
		<hr />
    <!--Short Brief about Practice-->      
    <div class="form-group">
    <div class="col-sm-10">
    <label class="control-label"><span class="red">*</span>	Short Brief about Practice : </label>
    </div>
    </div>	
    <div class="form-group">
      <div class="col-sm-12">
      <textarea name="doctor_summary" class="form-control H200P"><?=@$all_details['summary']?></textarea>
      </div>
    </div>
		<hr />
		<!--Pateint Reviews Start-->
    <div class="form-group">
    <div class="col-sm-10">
      <label class="control-label"><span class="red">*</span>	Pateint Reviews : </label>
    </div>
    </div>	
    <div class="InputsWrapper" id="patient">
		<?php if((is_array($patient_numbers) && sizeof($patient_numbers) > 0)){
    foreach($patient_numbers as $row){
    ?>
      <div class="form-group">
      	<div class="col-sm-5">
        <input type="text" name="patient_name[]" value="<?=$row['patient_name']?>" class="form-control" placeholder="Patient Name" />
        </div>
        <div class="col-sm-5">
        <input type="text" name="patient_number[]" value="<?=$row['patient_number']?>" maxlength="10" class="form-control" placeholder="Patient Number" />
        </div>
        <div class="col-sm-2">
        <a href="javascript:void(0);" class="removeclass btn btn-danger" id="patient">Remove</a>
        </div>
       </div>
    <?php }} ?>
    </div>
    <div class="form-group AddMoreFileId">
    <div class="col-sm-2">
      <a href="javascript:void(0);" class="AddMoreFileBox btn btn-primary" id="patient_other">Add Other</a><br><br>
    </div>
    </div>
  	<!--Pateint Reviews End-->      
		<div class="form-group">
	    <div class="col-sm-12">
	    <input type="submit" name="submit" value="Save Changes" id="submit" class="btn btn-primary" />
      </div>
    </div>    
  </form>
  </div>
  </div>
  <div class="panel-footer">
  <?php $this->load->view('admin/common/footer'); ?>
  </div>
  </div>
  </div>
  <div class="hide">
  <div id="experience_more_to_copy">
  	<div class="form-group">
  	<div class="col-sm-1">
    <select name="experience_from_year[]"  class="form-control">
    <option value="">Yr</option>
    <?php foreach($from_year as $val){
    ?>
    <option value="<?=$val?>"><?=$val?></option>
    <?php } ?>
    </select>
    </div>
    <div class="col-sm-1">to</div>
    <div class="col-sm-1">
    <select name="experience_to_year[]"  class="form-control">
    <option value="">Yr</option>
    <?php foreach($to_year as $val){?>
    <option value="<?=$val?>"><?=$val?></option>
    <?php } ?>
    </select>
    </div>
    <div class="col-sm-2">
    <input name="experience_role[]" type="text" class="form-control" placeholder="Role"/>
    </div>
    <div class="col-sm-2">
    <input name="experience_hospital[]" type="text" class="form-control" placeholder="Hospital / Clinic" />
    </div>
    <div class="col-sm-1">at</div>
    <div class="col-sm-2">
    <select name="experience_city[]" class="form-control">
    <option value="">City</option>
    <?php foreach($city as $key=>$val){?>
    <option value="<?=mysql_real_escape_string($val['name'])?>"><?=mysql_real_escape_string($val['name'])?></option>
    <?php } ?>
    </select>
    </div>
    <div class="col-sm-1">
    <a href="javascript:void(0);" class="removeclass btn btn-danger" id="experience">Remove</a>
    </div>
    </div>
  </div>
  <div id="awards_more_to_copy">
  <div class="form-group">
  <div class="col-sm-6">
  <input name="awardsandrecognitions_award[]" value="" type="text" class="form-control" placeholder="Award"/>
  </div>
  <div class="col-sm-4">
  <select name="awardsandrecognitions_from_year[]" class="form-control">
  <option value="">Year</option>
  <?php foreach($from_year as $val){?>
  <option value="<?=mysql_real_escape_string($val)?>"><?=mysql_real_escape_string($val)?></option>
  <?php } ?>
  </select>
  </div>
  <div class="col-sm-2">
  <a href="javascript:void(0);" class="removeclass btn btn-danger" id="awards">Remove</a>
  </div>
  </div>
  </div>
  <div id="awards_other_more_to_copy">
    <div class="form-group">
    <div class="col-sm-6">
    <input type="text" value="" name="awardsandrecognitions_award[]" class="form-control" placeholder="Award">
    </div>
    <div class="col-sm-4">
    <input type="text" value="" name="awardsandrecognitions_from_year[]" class="form-control" placeholder="Year">
    </div>
    <div class="col-sm-2">
    <a id="awards" class="removeclass btn btn-danger" href="javascript:void(0);">Remove</a><br>
    </div>
    </div>
  </div>
  <div id="membership_more_to_copy">
  <div class="form-group">
    <div class="col-sm-10">
    <select name="membership[]" class="form-control">
    <option value="">Select membership</option>
    <?php foreach($membership as $key=>$val){?>
    <option value="<?=mysql_real_escape_string($val['name'])?>"><?=mysql_real_escape_string($val['name'])?></option>
    <?php } ?>
    </select>
    </div>
    <div class="col-sm-2">
    <a href="javascript:void(0);" class="removeclass btn btn-danger" id="membership">Remove</a>
    </div>
  </div>
  </div>
  <div id="membership_other_more_to_copy">
  <div class="form-group">
    <div class="col-sm-10">
    <input type="text" name="membership[]" value="" class="form-control" placeholder="Membership"/>
    </div>
    <div class="col-sm-2">
    <a href="javascript:void(0);" class="removeclass btn btn-danger" id="membership">Remove</a>
    </div>
  </div>
  </div>
	
  <div id="specializations_more_to_copy">
  <div class="form-group">
    <div class="col-sm-10">
    <select name="specializations[]" class="form-control">
    <option value="">Select Specializations</option>
    <?php foreach($specializations as $key=>$val){?>
    <option value="<?=mysql_real_escape_string($val['name'])?>"><?=mysql_real_escape_string($val['name'])?></option>
    <?php } ?>
    </select>
    </div>
    <div class="col-sm-2">
    <a href="javascript:void(0);" class="removeclass btn btn-danger" id="specializations">Remove</a>
    </div>
  </div>
  </div>
  <div id="specializations_other_more_to_copy">
  <div class="form-group">
    <div class="col-sm-10">
    <input type="text" name="specializations[]" value="" class="form-control" placeholder="Specializations"/>
    </div>
    <div class="col-sm-2">
    <a href="javascript:void(0);" class="removeclass btn btn-danger" id="specializations">Remove</a>
    </div>
  </div>
  </div>

  <div id="registrations_more_to_copy">
  <div class="form-group">
  	<div class="col-sm-3">
    <input name="registrations_no[]" type="text" placeholder="Reg No" class="form-control" />
    </div>
    <div class="col-sm-4">
    <select name="registrations_council[]" class="form-control">
    <option value="">Registration Council</option>
    <?php foreach($council as $key=>$val){?>
    <option value="<?=$val['name']?>"><?=$val['name']?></option>
    <?php } ?>
    </select>
    </div>
    <div class="col-sm-3">
    <select name="registrations_year[]" class="form-control">
    <option value="">Year</option>
    <?php foreach($from_year as $val){?>
    <option value="<?=$val?>"><?=$val?></option>
    <?php } ?>
    </select>
    </div>
    <div class="col-sm-2">
    <a href="javascript:void(0);" class="removeclass btn btn-danger" id="registrations">Remove</a>
    </div>
  </div>
  </div>
  <div id="registrations_other_more_to_copy">
  <div class="form-group">
  <div class="col-sm-3"><input type="text" value="" name="registrations_no[]" placeholder="Reg No" class="form-control"></div>
  <div class="col-sm-4"><input type="text" value="" name="registrations_council[]" class="form-control" placeholder="Registrations Council"></div>
  <div class="col-sm-3"><input type="text" value="" name="registrations_year[]" class="form-control" placeholder="Year"></div>
  <div class="col-sm-2"><a id="registrations" class="removeclass btn btn-danger" href="javascript:void(0);">Remove</a></div>
  <br>
  </div>
  </div>
  <div id="qualifications_other_more_to_copy">
  <div class="form-group">
  <div class="col-sm-10">
  <input type="text" value="" name="qualifications[]" class="form-control" placeholder="Qualification">
  </div>
  <div class="col-sm-2">
  <a id="qualifications" class="removeclass btn btn-danger" href="javascript:void(0);">Remove</a>
  </div>
  </div>
  </div>
  <div id="paperspublished_other_more_to_copy">
  <div class="form-group">
    <div class="col-sm-10">
    <input type="text" value="" name="paperspublished[]" class="form-control" placeholder="Papers Published">
    </div>
    <div class="col-sm-2">
    <a id="paperspublished" class="removeclass btn btn-danger" href="javascript:void(0);">Remove</a>
    </div>
  <br>
  </div>
  </div>
  <div id="patient_other_more_to_copy">
  <div class="form-group">
  <div class="col-sm-5">
  <input type="text" name="patient_name[]" value="<?=$val['patient_name']?>" class="form-control" placeholder="Patient Name"/>
  </div>
  <div class="col-sm-5">
  <input type="text" name="patient_number[]" value="<?=$val['patient_number']?>" maxlength="10" class="form-control" placeholder="Patient Number"/>
  </div>
  <div class="col-sm-2">
  <a href="javascript:void(0);" class="removeclass btn btn-danger" id="patient">Remove</a>
  </div>
  </div>
  </div>
  </div>
  <?php $this->load->view('admin/common/bottom'); ?>
	<script type="text/javascript">
  $(document).ready(function()
  {
		$.fn.addelement = function(element)
		{
		//console.log(this);
		var id = this.attr('id');
		if(id == 'services_other')
		{
		$(".InputsWrapper#services").last().append('<div class="form-group"><div class="col-sm-10"><input type="text" name="services[]" value="" class="form-control" placeholder="Services" /></div><div class="col-sm-2"><a href="javascript:void(0);" class="removeclass btn btn-danger" id="services">Remove</a></div></div>');
		}
		else if(id == 'services')
		{
		$(".InputsWrapper#services").last().append("<div class=\"form-group\"><div class=\"col-sm-10\"><select name=\"services[]\" class=\"form-control\" ><option value=\"\">Select Service</option><?php foreach($services as $key=>$val) { ?> <option value=\"<?=mysql_real_escape_string($val['name'])?>\"><?=mysql_real_escape_string($val['name'])?></option><?php }; ?></select></div><div class=\"col-sm-2\"><a href=\"javascript:void(0);\" class=\"removeclass btn btn-danger\" id=\"services\">Remove</a></div></div>");
		}
		else if(id == 'education')
		{
		$(".InputsWrapper#education").last().append("<div class=\"form-group\"><div class=\"col-sm-3\"><select name=\"education_qualification[]\" class=\"form-control\"><option value=\"\">Degree</option><?php foreach($qualification as $key=>$val){ ?><option value=\"<?=mysql_real_escape_string($val['name'])?>\"><?=mysql_real_escape_string($val['name'])?></option><?php } ?></select></div><div class=\"col-sm-4\"><select name=\"education_college[]\" class=\"form-control\"><option value=\"\">College Name</option><?php foreach($college as $key=>$val){ ?><option value=\"<?=mysql_real_escape_string($val['name'])?>\"><?=mysql_real_escape_string($val['name'])?></option><?php } ?></select></div><div class=\"col-sm-3\"><select name=\"education_from_year[]\" class=\"form-control\"><option value=\"\">Year</option><?php foreach($from_year as $val){?><option value=\"<?=$val?>\"><?=$val?></option><?php } ?></select></div><div class=\"col-sm-2\"><a href=\"javascript:void(0);\" class=\"removeclass btn btn-danger\" id=\"education\">Remove</a></div></div>");
		}
		else if(id == 'education_other')
		{
		$(".InputsWrapper#education").last().append("<div class=\"form-group\"><div class=\"col-sm-3\"><input type=\"text\" value=\"\" name=\"education_qualification[]\" class=\"form-control\" placeholder=\"Qualification\"></div><div class=\"col-sm-4\"><input type=\"text\" value=\"\" name=\"education_college[]\" class=\"form-control\" placeholder=\"College\"></div><div class=\"col-sm-3\"><input type=\"text\" value=\"\" name=\"education_from_year[]\" class=\"form-control\" placeholder=\"From Year\"></div><div class=\"col-sm-2\"><a id=\"education\" class=\"removeclass btn btn-danger\" href=\"javascript:void(0);\">Remove</a></div></div>");
		}
		else if(id == 'experience')
		{
		$(".InputsWrapper#experience").last().append($("#experience_more_to_copy").html());
		}
		else if(id == 'experience_other')
		{
		$(".InputsWrapper#experience").last().append('<div class="form-group"><div class="col-sm-1"><input type="text" value="" name="experience_from_year[]" class="form-control" placeholder="From Year"></div><div class="col-sm-1">to</div><div class="col-sm-1"><input type="text" value="" name="experience_to_year[]" class="form-control" placeholder="To Year"></div><div class="col-sm-2"><input type="text" value="" name="experience_role[]" class="form-control" placeholder="Role"></div><div class="col-sm-2"><input type="text" value="" name="experience_hospital[]" class="form-control" placeholder="Hospital"></div><div class="col-sm-1">at</div><div class="col-sm-2"><input type="text" value="" name="experience_city[]" class="form-control" placeholder="City"></div><div class="col-sm-1"><a id="experience" class="removeclass btn btn-danger" href="javascript:void(0);">Remove</a></div></div>');
		}
		else if(id == 'awards')
		{
		$(".InputsWrapper#awards").last().append($("#awards_more_to_copy").html());
		}
		else if(id == 'awards_other')
		{
		$(".InputsWrapper#awards").last().append($("#awards_other_more_to_copy").html());
		}
		else if(id == 'membership')
		{
		$(".InputsWrapper#membership").last().append($("#membership_more_to_copy").html());
		}
		else if(id == 'specializations')
		{
		$(".InputsWrapper#specializations").last().append($("#specializations_more_to_copy").html());
		}
		else if(id == 'specializations_other')
		{
		$(".InputsWrapper#specializations").last().append($("#specializations_other_more_to_copy").html());
		}
		else if(id == 'membership_other')
		{
		$(".InputsWrapper#membership").last().append($("#membership_other_more_to_copy").html());
		}
		else if(id == 'registrations')
		{
		$(".InputsWrapper#registrations").last().append($("#registrations_more_to_copy").html());
		}
		else if(id == 'registrations_other')
		{
		$(".InputsWrapper#registrations").last().append($("#registrations_other_more_to_copy").html());
		}
		else if(id == 'qualifications_other')
		{
		$(".InputsWrapper#qualifications").last().append($("#qualifications_other_more_to_copy").html());
		}
		else if(id == 'paperspublished_other')
		{
		$(".InputsWrapper#paperspublished").last().append($("#paperspublished_other_more_to_copy").html());
		}
		
		else if(id == 'patient_other')
		{
		$(".InputsWrapper#patient").last().append($("#patient_other_more_to_copy").html());
		}
		// Attaching the click event on newly created removeclass element
		$(".removeclass").click(function()
		{
			//console.log(this);
			$(this).removeelement(this.id);
		});
		$("#left_Panel").height($("#content_area").height());
		};
		
		$.fn.removeelement = function(element)
		{
		this.parent('div').parent('div').remove();
		};
		
		$(".AddMoreFileBox").click(function()
		{
		$(this).addelement();
		});
		
		$(".removeclass").on("click",function()
		{
			//console.log(this);
		$(this).removeelement(this.id);
		s});
  });
  </script>
</body>	
</html>
