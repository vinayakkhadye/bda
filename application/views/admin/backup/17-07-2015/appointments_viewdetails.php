<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>View Appointments | BDA</title>
<?php $this->load->view('admin/common/head'); ?>
</head>
<body>
<?php $this->load->view('admin/common/header'); ?>
<div class="container-fluid">
<div class="panel panel-default">
<div class="panel-heading">
  View Appointments Details
    <a class="btn btn-primary FR" href="/bdabdabda/appointments/editappointment/<?=$all_details['id']?>">Edit Appointment Details</a> 
    <div class="CL"></div>
</div>
<div class="panel-body">
<div class="col-md-8 col-md-offset-2">
   <table class="table table-striped table-condensed table-bordered table-responsive">
      <tr>
        <td>Patient Name</td>
        <td><?=@ucfirst($all_details['patient_name'])?></td>
      </tr>
      <tr>
        <td>Patient Email</td>
        <td><?=@$all_details['patient_email']?></td>
      </tr>
      <tr>
        <td>Patient Gender</td>
        <td>
          <?php 
            if(@strtolower(@$all_details['patient_gender']) == 'm')
            {
              echo 'Male';
            }
            elseif(@strtolower(@$all_details['patient_gender']) == 'f')
            {
              echo 'Female';
            }
          ?>
        </td>
      </tr>
      <tr>
        <td>Patient Number</td>
        <td><?=@$all_details['mobile_number']?></td>
      </tr>
      <tr>
        <td>Doctor Name</td>
        <td><?=@ucfirst($all_details['doctor_name'])?></td>
      </tr>
      <tr>
        <td>Doctor Speciality</td>
        <td>
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
        <td><?=@ucfirst($all_details['clinic_name'])?></td>
      </tr>
      <tr>
        <td>Clinic City</td>
        <td><?=@ucfirst($all_details['city_name'])?></td>
      </tr>
      <tr>
        <td>Clinic Address</td>
        <td><?=@ucfirst($all_details['clinic_address'])?></td>
      </tr>
      <tr>
        <td>Clinic Number</td>
        <td><?=@$all_details['clinic_number']?></td>
      </tr>
      <tr>
        <td>Reason for visit</td>
        <td><?=@ucfirst($all_details['reason_for_visit'])?></td>
      </tr>
      <tr>
        <td>Appointment Date Time</td>
        <td><?=@date('d-m-Y h:i:s a', strtotime($all_details['scheduled_time']))?></td>
      </tr>
      <tr>
        <td>Consultation Type</td>
        <td>
          <?php 
            if(@$all_details['consultation_type'] == '1')
            {
              echo 'Normal';
            }
            elseif(@$all_details['consultation_type'] == '2')
            {
              echo 'Tele Consultation';
            }
            elseif(@$all_details['consultation_type'] == '3')
            {
              echo 'Online Consultation';
            }
            elseif(@$all_details['consultation_type'] == '4')
            {
              echo 'Express Appointment';
            }
          ?>
        </td>
      </tr>
      <tr>
        <td>Status</td>
        <td>
          <?php 
            if(@$all_details['status'] == '1')
            {
              echo 'Scheduled';
            }
            elseif(@$all_details['status'] == '0')
            {
              echo 'Cancelled';
            }
            /*elseif(@$all_details['status'] == '-1')
            {
              echo 'Deleted';
            }*/
          ?>	
        </td>
      </tr>
      <tr>
        <td>Cofirmation</td>
        <td>
          <?php 
            if(@$all_details['confirmation'] == '1')
            {
              echo 'Confirmed';
            }
            elseif(@$all_details['confirmation'] == '0')
            {
              echo 'Pending';
            }
            /*elseif(@$all_details['status'] == '-1')
            {
              echo 'Deleted';
            }*/
          ?>	
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
        <td>Appointment Notes</td>
        <td><?php 
        
        echo $all_details['notes'];
        ?></td>
      </tr>
      
    </table>
</div>
</div>
<div class="panel-footer">
<?php $this->load->view('admin/common/footer'); ?>
</div>
</div>
</div>

<?php $this->load->view('admin/common/footer'); ?>
<?php $this->load->view('admin/common/bottom'); ?>
</body>	
</html>
