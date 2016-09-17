<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Edit Details | BDA</title>
<?php $this->load->view('admin/common/head'); ?>
</head>
<body>
<?php $this->load->view('admin/common/header'); ?>
<div class="container-fluid">
<div class="panel panel-default">
<div class="panel-heading">Edit Details</div>
<div class="panel-body">
<form  method="POST" data-toggle="validator">
  <input type="hidden" name="dr_name" id="dr-name-input" value="<?=$all_details['doctor_name'] ?>" />
  <input type="hidden" name="clinic_name" id="clinic-name-input" value="<?=$all_details['clinic_name'] ?>" />
  <input type="hidden" name="clinic_address" id="clinic-address-input" value="<?php  echo $all_details['clinic_address'] ?>" />
  <input type="hidden" name="clinic_contact" id="clinic-contact-input" value="<?php  echo $all_details['clinic_number'] ?>" />
  <div class="col-md-8 col-md-offset-2">
  <table class="table table-striped table-condensed table-bordered table-responsive" >
    <tr>
      <td>Patient Name</td>
      <td><input type="text" name="patient_name" value="<?=@ucfirst($all_details['patient_name'])?>" class="form-control" required /></td>
    </tr>
    <tr>
      <td>Patient Email</td>
      <td><input type="text" name="patient_email" value="<?=@$all_details['patient_email']?>" class="form-control" required /></td>
    </tr>
    <tr>
      <td>Patient Gender</td>
      <td>
	      <label class="checkbox-inline"><input type="radio" name="patient_gender" value="m" <?php if(@$all_details['patient_gender'] == 'm'){echo 'checked="checked"';} ?> required /> Male</label>
        <label class="checkbox-inline"><input type="radio" name="patient_gender" value="f" <?php if(@$all_details['patient_gender'] == 'f'){echo 'checked="checked"';} ?> required /> Female</label>
      </td>
    </tr>
    <tr>
      <td>Patient Number</td>
      <td><input type="text" name="mobile_number" value="<?=@ucfirst($all_details['mobile_number'])?>" required /></td>
    </tr>
    <tr>
      <td>Doctor Name</td>
      <td class="form-inline">
      <div id="doctor-name-td">
				<?=@ucfirst($all_details['doctor_name'])?>
        <input type="button" id="change-doc-btn" value="Change Doctor" class="btn btn-primary" />
      </div>
      <div id="doctor-name-td-to-copy" style="display: none;">
        <div>
          Enter Doctor ID : <input type="text" name="doctorid" id="doctorid" value="<?=@$all_details['doctor_id']?>" class="form-control" />
          <input type="button" id="doctor-id-submit" value="Submit" class="btn btn-primary" />
        </div>
        <div id="doctor-name" style="display: none;"></div>
      </div>
      </td>
    </tr>
    <tr>
      <td>Doctor Speciality</td>
      <td>
      	<div id="doctor-speciality">
        <?php 
        $strSpeciality	=	'';
        if(isset($all_details['allspeciality']) && sizeof($all_details['allspeciality']) > 0)
        {
          foreach($all_details['allspeciality'] as $row)
          {
            $strSpeciality	.=	ucfirst($row['speciality_name']).'<br/>';
          }
        }
        if(isset($all_details['doctor_other_speciality']) && !empty($all_details['doctor_other_speciality']))
        {
          $otherspec = explode(',',$all_details['doctor_other_speciality']);
          foreach($otherspec as $row)
          {
            $strSpeciality	.=	ucfirst($row).'<br/>';
          }
        }
        echo $strSpeciality;
        ?>
        <input type="hidden" value="<?php  echo rtrim(str_replace("<br/>",",",$strSpeciality),",") ?>" />
        </div>
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
      <td id="clinic-address"><?=@ucfirst($all_details['clinic_address'])?>
      </td>
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
        <input type="text" name="scheduled_date" id="scheduled_date" value="<?=@date('d-m-Y', strtotime($all_details['scheduled_time']))?>" 
        class="form-control" />
        <input type="text" name="scheduled_time" id="scheduled_time" value="<?=@date('h:iA', strtotime($all_details['scheduled_time']))?>" class="form-control input-small" />
        <input type="hidden" name="org_scheduled_time" value="<?=$all_details['scheduled_time']?>" />
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
          <option value="1" <?php if(@$all_details['status'] == '1'){echo 'selected="selected"';} ?>>Scheduled</option>
          <option value="0" <?php if(@$all_details['status'] == '0'){echo 'selected="selected"';} ?>>Cancelled</option>
        </select>
      </td>
    </tr>
    <tr>
      <td>Confirmation</td>
      <td>
        <select name="confirmation" class="form-control">
          <option value="1" <?php if(@$all_details['confirmation'] == '1'){echo 'selected="selected"';} ?>>Confirmed</option>
          <option value="0" <?php if(@$all_details['confirmation'] == '0'){echo 'selected="selected"';} ?>>Pending</option>
        </select>
      </td> 
    </tr>
    <tr>
      <td>Appointment Booked On</td>
      <td><?=@date('d-m-Y h:i:s a', strtotime($all_details['added_on']))?></td>
    </tr>
    <tr>
      <td>Appointment Updated On</td>
      <td><?php 
      if(isset($all_details['updated_on']) && !empty($all_details['updated_on']))
      echo @date('d-m-Y h:i:s a', strtotime($all_details['updated_on']))
      ?></td>
    </tr>
    <tr>
      <td colspan="2" align="center">
        <input type="submit" name="submit" value="Save Changes" class="btn btn-primary" />
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
<script type="text/javascript">
$(document).ready(function()
{
  $("#scheduled_date").datepicker(
  {
		autoclose: true,
    dateFormat: "dd-mm-yy",
    changeMonth: true,
    changeYear: true
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

        $("#clinic-city").html('');
        $("#clinic-address").html('');
        $("#clinic-number").html('');
        
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

                $("#clinic-name-input").attr("value",element.name);
                $("#clinic-address-input").attr("value",element.address);
                $("#clinic-contact-input").attr("value",element.contact_number);
                
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
        console.log(resp);
        $("#dr-name-input").attr("value",resp);
        $("#doctor-name-td").html(resp);
        $("#doctor-name").show();
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
      }
    });
    
  });
});
</script>
</body>	
</html>
