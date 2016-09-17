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
  <form id="add-appointment-form" onsubmit="return save_appointment()" data-toggle="validator">
  <div class="col-md-8 col-md-offset-2">
	  <table class="table table-striped table-condensed table-bordered table-responsive">
          <tr>
            <td>Patient Name</td>
            <td><input type="text" name="patient_name" value="<?=@ucfirst($all_details['patient_name'])?>" class="form-control" required/></td>
          </tr>
          <tr>
            <td>Patient Email</td>
            <td><input type="text" name="patient_email" value="<?=@$all_details['patient_email']?>" class="form-control" required/></td>
          </tr>
          <tr>
            <td>Patient Gender</td>
            <td>
            <label class="checkbox-inline"><input type="radio" name="patient_gender" value="m" <?php if(@$all_details['patient_gender'] == 'm'){echo 'checked="checked"';} ?> required/> Male</label>
            <label class="checkbox-inline"><input type="radio" name="patient_gender" value="f" <?php if(@$all_details['patient_gender'] == 'f'){echo 'checked="checked"';} ?> required/> Female</label>
            </td>
          </tr>
          <tr>
            <td>Patient Number</td>
            <td><input type="text" name="patient_contact_no" value="<?=@ucfirst($all_details['mobile_number'])?>" class="form-control" required/></td>
          </tr>
          <tr>
            <td>Doctor Name</td>
            <td>
              <div id="doctor-name-td-to-copy">
                Enter Doctor ID : <input type="text" name="doctor_id" id="doctorid" value="<?=@$all_details['doctor_id']?>" class="form-control" />
                <input type="button" id="doctor-id-submit" value="Submit" class="btn btn-primary" />
              </div>
              <div id="doctor-name" style="display: none;"></div>
            </td>
          </tr>
          <tr>
            <td>Doctor Speciality</td>
            <td id="doctor-speciality">
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
            </td>
          </tr>
          <tr>
            <td>Clinic Name</td>
            <td id="clinic-name"><?=@ucfirst($all_details['clinic_name'])?></td>
            <td id="clinic-name-dropdown" style="display: none;"></td>
          </tr>
          <tr>
            <td>Clinic City</td>
            <td id="clinic-city"><?=@ucfirst($all_details['city_name'])?></td>
          </tr>
          <tr>
            <td>Clinic Address</td>
            <td id="clinic-address"><?=@ucfirst($all_details['clinic_address'])?></td>
          </tr>
          <tr>
            <td>Clinic Number</td>
            <td id="clinic-number"><?=@$all_details['clinic_number']?></td>
          </tr>
          <tr>
            <td>Reason for visit</td>
            <td><input type="text" name="reason_for_visit" value="<?=@ucfirst($all_details['reason_for_visit'])?>" class="form-control" /></td>
          </tr>
          <tr>
            <td>Appointment Date Time</td>
            <td>
              <input type="text" name="appt_date" id="scheduled_date" 
              value="<?php if(isset($all_details['scheduled_time']) && !empty($all_details['scheduled_time']))echo @date('d-m-Y', strtotime($all_details['scheduled_time']))?>" class="form-control" required />
              <input type="text" name="appt_time" id="scheduled_time" value="<?=@date('h:iA', strtotime($all_details['scheduled_time']))?>" class="form-control" required/>
            </td>
          </tr>
          <tr>
            <td>Consultation Type</td>
            <td>
              <select name="consultation_type" class="form-control">
                <option value="1" <?php if(@$all_details['consultation_type'] == '1'){echo 'selected="selected"';} ?>>Normal</option>
                <option value="2" <?php if(@$all_details['consultation_type'] == '2'){echo 'selected="selected"';} ?>>Tele Consultation</option>
                <option value="3" <?php if(@$all_details['consultation_type'] == '3'){echo 'selected="selected"';} ?>>Online Consultation</option>
                <option value="4" <?php if(@$all_details['consultation_type'] == '4'){echo 'selected="selected"';} ?>>Express Appointment</option>
              </select>
            </td>
          </tr>
          <tr>
            <td>Status</td>
            <td>
              <select name="status" class="form-control">
                <option value="1" <?php if(@$all_details['status'] == '1'){echo 'selected="selected"';} ?>>Approved</option>
                <option value="0" <?php if(@$all_details['status'] == '0'){echo 'selected="selected"';} ?>>Pending</option>
                <option value="-1" <?php if(@$all_details['status'] == '-1'){echo 'selected="selected"';} ?>>Delete</option>
              </select>
            </td>
          </tr>
          <tr>
            <td colspan="2" align="center">
              <input type="hidden" name="user_id" id="user_id" value="" />
              <input type="hidden" name="doctor_name" id="doctor_name" value="" />
              <input type="hidden" name="city_id" id="city_id" value="" />
              <input type="hidden" name="user_type" id="user_type" value="" />
              <input type="hidden" name="clinic_id" id="clinic_id" value="" />
              <input type="hidden" name="image" id="image" value="" />
              <input type="hidden" name="fb_id" id="fb_id" value="" />
              <input type="submit" value="Add Appointment" class="btn btn-primary" />
            </td>
          </tr>
    </table>
  </div>
  </form>
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
    dateFormat: "dd-mm-yy",
  	autoclose: true,
    changeMonth: true,
    changeYear: true,
    yearRange: "2015:2020"
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
    //console.log(resp);
    $("#doctor-speciality").html(resp);
    $("#left_Panel").height($("#content_area").height());
    }
    });
    
    });
    });
  </script>
  <!-- PAGE SPECIFIC JS-->
</body>	
</html>
