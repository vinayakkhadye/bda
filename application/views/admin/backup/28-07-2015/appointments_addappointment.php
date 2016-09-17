<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Add Appointment | BDA</title>
  <?php $this->load->view('admin/common/head'); ?>
</head>
<body>
	<?php $this->load->view('admin/common/header'); ?>
  <div class="container-fluid">
  <div class="panel panel-default">
  <div class="panel-heading">Add Appointments</div>
  <div class="panel-body">
	<div class="col-md-8 col-md-offset-2">
  <form id="add-appointment-form" onsubmit="return save_appointment()" data-toggle="validator">
    <div class="form-group ">
    <label class="control-label">Patient Name :</label>
    <input type="text" name="patient_name" value="<?=@ucfirst($all_details['patient_name'])?>" class="form-control" required/>
    </div>
    <div class="form-group ">
    <label class="control-label">Patient Email :</label>
    <input type="text" name="patient_email" value="<?=@$all_details['patient_email']?>" class="form-control" required/>
    </div>
    <div class="form-group ">
    <label class="control-label">Patient Gender :</label>
    <label class="checkbox-inline"><input type="radio" name="patient_gender" value="m" <?php if(@$all_details['patient_gender'] == 'm'){echo 'checked="checked"';} ?> required/> Male</label>
		<label class="checkbox-inline"><input type="radio" name="patient_gender" value="f" <?php if(@$all_details['patient_gender'] == 'f'){echo 'checked="checked"';} ?> required/> Female</label>
    </div>
    <div class="form-group ">
    <label class="control-label">Patient Number :</label>
    <input type="text" name="patient_contact_no" value="<?=@ucfirst($all_details['mobile_number'])?>" class="form-control" required/>
    </div>
    <div class="form-group form-inline ">
    <label class="control-label">Doctor Name :</label>
    <div id="doctor-name-td-to-copy">
    Enter Doctor ID : <input type="text" name="doctor_id" id="doctorid" value="<?=@$all_details['doctor_id']?>" class="form-control" />
    <input type="button" id="doctor-id-submit" value="Submit" class="btn btn-primary" />
    </div>
    <div id="doctor-name" style="display: none;"></div>
    </div>
    
    <div class="form-group ">
    <label class="control-label">Doctor Speciality :</label>
    <div id="doctor-speciality">
              <?php 
              if(isset($all_details['allspeciality']) && sizeof($all_details['allspeciality']) > 0)
              {
                foreach($all_details['allspeciality'] as $row)
                {
                  echo ucfirst($row['speciality_name']).'<br/>';
                }
              }
              if(isset($all_details['doctor_other_speciality']) && !empty($all_details['doctor_other_speciality']))
              {
                $otherspec = explode(',',$all_details['doctor_other_speciality']);
                foreach($otherspec as $row)
                {
                  echo ucfirst($row).'<br/>';
                }
              }
              ?>
            </div>
    </div>
    
    <div class="form-group ">
    <label class="control-label">Clinic Name :</label>
    <div id="clinic-name"><?=@ucfirst($all_details['clinic_name'])?></div>
    <div id="clinic-name-dropdown"></div>
    </div>
    
    <div class="form-group ">
    <label class="control-label">Clinic City :</label>
		<div id="clinic-city"><?=@ucfirst($all_details['city_name'])?></div>
    </div>
    
    <div class="form-group ">
    <label class="control-label">Clinic Address :</label>
		<div id="clinic-address"><?=@ucfirst($all_details['clinic_address'])?></div>
    </div>
    
    <div class="form-group ">
    <label class="control-label">Clinic Number :</label>
    <div id="clinic-number"><?=@$all_details['clinic_number']?></div>
    </div>
    
    <div class="form-group ">
    <label class="control-label">Reason for visit :</label>
    <input type="text" name="reason_for_visit" value="<?=@ucfirst($all_details['reason_for_visit'])?>" class="form-control" />
    </div>
    
    <div class="form-group form-inline">
    <label class="control-label">Appointment Date Time :</label>
    <input type="text" name="appt_date" id="scheduled_date" 
              value="<?php if(isset($all_details['scheduled_time']) && !empty($all_details['scheduled_time']))echo @date('m/d/Y', strtotime($all_details['scheduled_time']))?>" class="form-control" required />
		<input type="text" name="appt_time" id="scheduled_time" value="<?=@date('h:iA', strtotime($all_details['scheduled_time']))?>" class="form-control" required/>
    </div>
    
    <div class="form-group form-inline">
    <label class="control-label">Consultation Type :</label>
		<select name="consultation_type" class="form-control">
      <option value="1" <?php if(@$all_details['consultation_type'] == '1'){echo 'selected="selected"';} ?>>Normal</option>
      <option value="2" <?php if(@$all_details['consultation_type'] == '2'){echo 'selected="selected"';} ?>>Tele Consultation</option>
      <option value="3" <?php if(@$all_details['consultation_type'] == '3'){echo 'selected="selected"';} ?>>Online Consultation</option>
      <option value="4" <?php if(@$all_details['consultation_type'] == '4'){echo 'selected="selected"';} ?>>Express Appointment</option>
    </select>
    </div>
    
    <div class="form-group form-inline">
    <label class="control-label">Status :</label>
		<select name="status" class="form-control">
      <option value="1" <?php if(@$all_details['status'] == '1'){echo 'selected="selected"';} ?>>Approved</option>
      <option value="0" <?php if(@$all_details['status'] == '0'){echo 'selected="selected"';} ?>>Pending</option>
      <option value="-1" <?php if(@$all_details['status'] == '-1'){echo 'selected="selected"';} ?>>Delete</option>
    </select>
    </div>
    <div class="form-group">
      <input type="hidden" name="user_id" id="user_id" value="" />
      <input type="hidden" name="doctor_name" id="doctor_name" value="" />
      <input type="hidden" name="city_id" id="city_id" value="" />
      <input type="hidden" name="user_type" id="user_type" value="" />
      <input type="hidden" name="clinic_id" id="clinic_id" value="" />
      <input type="hidden" name="image" id="image" value="" />
      <input type="hidden" name="fb_id" id="fb_id" value="" />
      <input type="submit" value="Add Appointment" class="btn btn-primary" />
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
  <script type="text/javascript">
  	function save_appointment()
  	{
  		var appt_data	=	$("#add-appointment-form").serialize();		
  		$.ajax(
  		{
  		url: '/api/patient/save_appointment_admin',
  		type: "POST",
  		data:appt_data,
  		success: function(resp)
  		{
  			alert(resp.response.message);
  			if(resp.response.status==1)
  			{
  				window.location.href=window.location.href;
  			}
  		}
  		}
  		);
  		return false;
  	}

    $(document).ready(function()
    {
    $("#left_Panel").height($("#content_area").height());
    $("#scheduled_date").datepicker(
    {
    dateFormat: "mm/dd/yyyy",
  	autoclose: true,
		todayHighlight: true,
		orientation: "top left"
    });
    
    $("#scheduled_time").timepicker(
    {
  		template: false,
  		showInputs: false,
  		minuteStep: 5,
      defaultTime: '09:00AM'
    });
    
    $("#change-doc-btn").click(function()
    {
    $("#doctor-name-td").hide();
    $("#doctor-name-td-to-copy").show();
    });
    
    $("#doctor-id-submit").click(function()
    {
    var docid = $("#doctorid").val();
    //console.log(docid);
    $.ajax(
    {
    url: '/bdabdabda/appointments/get_doctor_details',
    type: "POST",
    data: 
    {
    'doctorid' : docid
    },
    success: function(resp)
    {
    //console.log(resp);
    $("#clinic-name").hide();
    $("#clinic-name-dropdown").html(resp);
    $("#clinic-name-dropdown").show();
    
    $("#clinicid").change(function()
    {
      var clinicid = $("#clinicid").val();
      //console.log(clinicid);
      $.ajax(
      {
        url: '/bdabdabda/appointments/get_clinic_details',
        type: "POST",
        //dataType: "json",
        data: 
        {
          'clinicid' : clinicid
        },
        success: function(resp)
        {
          //console.log(resp);
          var json = $.parseJSON(resp);
          
          $.each(json, function(index, element) 
          {
            //console.log(element);
            //console.log(index);
            //console.log(element.name);
            $("#clinic-city").html(element.city);
            $("#clinic-address").html(element.address);
            $("#clinic-number").html(element.contact_number);
            $("#clinic_id").val(element.id);
            $("#city_id").val(element.city_id);
            $("#left_Panel").height($("#content_area").height());
              });
        }
      });
    });
    }
    });
    $.ajax(
    {
    url: '/bdabdabda/appointments/get_doctor_name',
    type: "POST",
    data: 
    {
    'doctorid' : docid
    },
    success: function(resp)
    {
    //console.log(resp);
    $("#doctor-name").html(resp);
    $("#doctor-name").show();
  	$("#doctor_name").val(resp);
    }
    });
    $.ajax(
    {
    url: '/bdabdabda/appointments/get_doctor_speciality',
    type: "POST",
    data: 
    {
    'doctorid' : docid
    },
    success: function(resp)
    {
	    $("#doctor-speciality").html(resp);
    }
    });
    
    });
    });
  </script>
  <!-- PAGE SPECIFIC JS-->
</body>	
</html>
