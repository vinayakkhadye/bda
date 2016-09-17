<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Pending Appointments | BDA</title>
<?php $this->load->view('admin/common/head'); ?>
</head>
<body>
<?php $this->load->view('admin/common/header'); ?>
<div class="container-fluid">
<div class="panel panel-default">
<div class="panel-heading">Pending Appointments</div>
<div class="panel-body">
<form name="seach_doctors" action="/bdabdabda/appointments/pending_appointment" class="form-inline"  >
<div class="form-group">
  <label class="control-label">Doctor ID :</label>
  <input name="doctor_id" type="text" placeholder="Doctors's ID" class="form-control" value="<?= @$_GET['doctor_id'] ?>"/>
</div>
<div class="form-group">
  <label class="control-label">Doctor Name :</label>
  <input name="doctor_name" type="text" placeholder="Doctor Name" class="form-control" value="<?=@$_GET['doctor_name'] ?>"/>
</div>
<div class="form-group">
  <label class="control-label">Patient Name :</label>
  <input name="patient_name" type="text" placeholder="Patient Name" class="form-control" value="<?= @$_GET['patient_name'] ?>"/>
</div>                
<div class="form-group">
  <label>Sort By :</label>
  <select class="form-control" name="order">
      <option value="">Select</option>
      <option value="appointment.scheduled_time desc" <?= (isset($_GET['order']) && !empty($_GET['order']) && $_GET['order']=="appointment.scheduled_time desc" ) ? 'selected="selected"' : '' ?> >
      Appointment Date
      </option>
      <option value="appointment.id desc" <?= (isset($_GET['order']) && !empty($_GET['order']) && $_GET['order']=="appointment.id desc" ) ? 'selected="selected"' : '' ?>>Appointment Id</option>
  </select>
</div>
<div class="form-group">
  <input class="btn btn-primary" name="search" type="submit"  value="Search"/>
</div>
</form>
<form name="edit_doctors" action="/bdabdabda/appointments" method="post" role="from" >
<div class="form-group">
<input type="hidden" value="<?= $cur_url ?>" name="url" />
<div class="btn-group PB5">
<button type="submit" name="approve" value="Confirm Appointment" class="btn btn-primary">Confirm Appointment</button>
<button type="submit" name="disapprove" value="Cancel Appointment" class="btn btn-primary">Cancel Appointment</button>
<button type="submit" name="progress" value="In Progress" class="btn btn-primary">In Progress</button>
</div>
</div>
<div class="table-responsive">
<table id="dataTables-example" class="table table-condensed table-bordered table-striped">
<thead>
<tr>
<th><input type="checkbox" id="chackAll"></th>
<th>Doctor Name</th>
<th>Doctor No.</th>    
<th>City</th>
<th>Patient Name</th>
<th>Patient No.</th>
<th >Appointment Date</th>
<th>Status</th>
<th>Confirmation</th>
<!--<th>Added on</th>-->
<th>Verified</th>
<th><span class="glyphicon glyphicon-tasks"></span></th>
</tr>
</thead>
<tbody>
<?php if ($new_apponts) 
{
foreach ($new_apponts as $row) 
{?>
  <tr class="doc_details_row">
  <td class="check">
  <input type="checkbox" class="rowcheck" name="appointment_id[<?php echo $row->id; ?>]" id="appointment_id_<?php echo $row->id; ?>" />
  </td>
  <td>
    <a href="/bdabdabda/manage_doctors/viewprofile/<?php echo $row->doctor_id; ?>"><?php echo ucfirst($row->doctor_name);?></a>
  
  </td>
  <td>
  <?php 
  if(!empty($row->clinic_contact_number))
  {
    echo $row->clinic_contact_number;
  }
  else
  {
   echo $row->doc_contact_number;
  }
  ?>
  </td>
  <td>
    <?php echo ucfirst($row->city_name); ?>
  </td>
  <td>
    <?php echo ucfirst($row->patient_name); ?>
  </td>
  <td>
    <?php echo ucfirst($row->mobile_number); ?>
  </td>
  <td>
    <?php echo date('d-m-Y', strtotime($row->date)) . ' ' . date('h:i a', strtotime($row->time)); ?>
  </td>
  <td>
  <?php
  if ($row->status == 1)
  {
    echo 'Scheduled';
  }
  else if ($row->status == 0)
  {
    echo 'Cancelled';
  }
  ?>
  </td>
  <td>
  <?php
  if ($row->confirmation == 1)
  {
    echo 'Confirmed';
  }else if($row->confirmation == 0)
  {
    echo 'Pending';
  }else if($row->confirmation == 2)
  {
    echo 'In Progress';
  }
  ?>
  </td>
  <!--td>
    <?php #echo date('d-m-Y h:i:s a', strtotime($row->added_on)); ?>
  </td-->
  <td>
    <label>
      <?php 
      if($row->is_verified == 1)
      { echo "Yes"; 
      } 
      else
      {
      echo "No"; 
      }
      ?>
    </label> 
  </td>
  <td>
    <a href="/bdabdabda/appointments/view_appointment/<?php echo $row->id; ?>">
      <span class="glyphicon glyphicon-edit" title="view appointment"></span>
    </a>
    <a href="javascript:;" onclick="show(<?php echo $row->id; ?>)">
    <span class="glyphicon glyphicon-menu-down" title="view Sub Part"></span>
    </a>
  </td>
  </tr>
  <tr class="extra_field_row" id="<?php echo $row->id; ?>" style="display : none">
    <td colspan="13" class="form-inline">
    <input class="revisited_date form-control" type="text" name="revisited_date" 
    value="<?=($row->revisited_date)?@date('d-m-Y', strtotime($row->revisited_date)):''?>" 
    data="<?php echo $row->id; ?>" placeholder="Date .." >
    <input type="text" value="<?=($row->revisited_date)?@date('h:iA', strtotime($row->revisited_date)):'00:01:AM'?>" name="revisited_time" 
    class="revisited_time form-control input-small" placeholder="Time .." />
    <input type="button" class="submit_rev_date btn btn-primary" name="submit_rev_date" value="Add Revisited Date"/>
    
    <textarea class="appt_notes form-control W40P H35P"  rows="1" ><?php echo $row->notes; ?></textarea>
    <input type="button" name="edit_note" class="btn btn-primary add_extra" value="Add Notes" />
    <input type="hidden" data="<?php echo $row->id; ?>" value="<?php echo $row->id; ?>" name="app_id" class="id_detls"/>
    </td>
  </tr>
<?php }
}else{?>
<tr>
  <td colspan="13" align="center">
      No Appointments Found
  </td>
</tr>
<?php }?>
</tbody>
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

  function show(target){

      var div = document.getElementById(target) ;
 
        if (div.style.display !== "none") 
        { 
        div.style.display = "none";
        }
        else
        {
        div.style.display = "";
        }
}


$(document).ready(function ()
{
$("#chackAll").change(function ()
{
if (this.checked)
{
$('.rowcheck').prop('checked', true);
} else
{
$('.rowcheck').prop('checked', false);
}
});
$("#date").datepicker(
{
format: "yyyy-mm-dd",
autoclose: true,
todayHighlight: true,
orientation: "top left",
});
$("#left_Panel").height($("#content_area").height());

//notes insertion
$('.add_extra').click(function () {
var appt_notes = $(this).prev('.appt_notes').val();
var id_detls = $(this).next('.id_detls').attr('data');
$.ajax({
url: '/bdabdabda/appointments/save_notes',
type: "POST",
data: {
'appt_notes': appt_notes,
'id_detls': id_detls
},
success: function(data)
{
alert("Notes added successfully");
}
});
});

//Ajax For No verified or not

$('.verified_no').change(function () {
var verify_status = $(this).val();
var appt_id = $(this).attr('data');
$.ajax({
url: '/bdabdabda/appointments/update_is_no_verified',
type: "POST",
data: {
'verify_status': verify_status,
'appt_id': appt_id
},
success: function(data)
{
alert("Number Status Changed");
}
});
});

// Revisited date submit
$('.submit_rev_date').click(function () {
var rev_date = $(this).prev().prev().val();
var id_detls = $(this).prev().prev().attr('data')
var rev_time = $(this).prev('.revisited_time').val();
$.ajax({
url: '/bdabdabda/appointments/submit_revisited_date',
type: "POST",
data: {
'rev_date': rev_date,
'rev_time': rev_time,
'id_detls': id_detls
},
success: function(resp)
{
alert("Revisited Date Added successfully");

}
});
});
$(".revisited_date").datepicker(
{
autoclose:true,
dateFormat: "yyyy-mm-dd",
changeMonth: true,
changeYear: true
});

$('.revisited_time').timepicker({
template: false,
showInputs: false,
minuteStep: 5
});
/*    $(".revisited_time").timeEntry(
{
spinnerImage: '',
timeSteps: [1, 5, 0],
defaultTime: '09:00AM'
});
*/    
});
var latest_appt_id  = 0;
var myVar = '';
//Refresh Newaly Inserted Appointments
function get_latest_apptid()
{

$.ajax({
url:        '/bdabdabda/appointments/get_latest_appointment',
dataType: "json",
type:       'POST',
success: function(resp){
        console.log(resp);
latest_appt_id  = resp.id;//resp;
//myVar = setInterval(function () {refresh_appointment(latest_appt_id)}, 5000);
        myVar=setInterval(function () {refresh_appointment(latest_appt_id)}, 100000);//0
}           
});
}
get_latest_apptid();
function refresh_appointment(id)
{
console.log(id);


$.ajax({
    url:        '/bdabdabda/appointments/getNewPosts',
    dataType: "json",
    type:       'POST',
    data: {
    'id' : id
    },
    success: function(resp){
        var tmp_appt_id =   0;
        var is_verified = ''; 
       if(resp)
       {
         var html = '';
        for(i in resp)
        {
            console.log(resp[i]);
            var dr_number;
             if(resp[i].clinic_contact_number)
                { 
                   dr_number = resp[i].clinic_contact_number; 
                }
             else{
                   dr_number = resp[i].doc_contact_number;
                 }
             if(resp[i].is_verified==1)
                { 
                   is_verified = 'yes'; 
                }
             else{
                   is_verified = 'no'; 
                 }

            html = '<tr class="doc_details_row bgred" ><td class="check"><input type="checkbox" id="appointment_id_'+resp[i].id+'" name="appointment_id['+resp[i].id+']" class="rowcheck"></td><td class="">'+resp[i].doctor_name+'</td><td class="">'+dr_number+'</td><td class="">'+resp[i].city_name+'</td><td class="">'+resp[i].patient_name+'</td><td class="">'+resp[i].mobile_number+'</td><td class="">'+resp[i].scheduled_time+'</td><td>'+resp[i].status+'</td><td>'+resp[i].confirmation+'</td> <td class=""><label>'+is_verified+'</label> </td><td><a href="/bdabdabda/appointments/view_appointment/'+resp[i].id+'"><span title="view appointment" class="glyphicon glyphicon-edit"></span></a><a "javascript:;" onclick="show('+resp[i].id+')" ><span title="view Sub Part" class="glyphicon glyphicon-menu-down"></span></a></td></tr>';
            
            html += '<tr class="extra_field_row" id="'+resp[i].id+'" style="display : none" ><td class="form-inline" colspan="13"><input type="text" placeholder="Date .." data="'+resp[i].id+'" value="" name="revisited_date" class="revisited_date form-control"><input type="text" placeholder="Time .." class="revisited_time form-control input-small" name="revisited_time" value=""><input type="button" value="Add Revisited Date" name="submit_rev_date" class="submit_rev_date btn btn-primary"><textarea rows="1" class="appt_notes form-control W50P H35P"></textarea><input type="button" value="Add Notes" class="btn btn-primary add_extra" name="edit_note"><input type="hidden" class="id_detls" name="app_id" value="'+resp[i].id+'" data="'+resp[i].id+'"></td></tr>';

            $("#dataTables-example tbody").prepend(html);
							$(".revisited_date").datepicker(
							{
							autoclose:true,
							dateFormat: "yyyy-mm-dd",
							changeMonth: true,
							changeYear: true
							});						
							$('.revisited_time').timepicker({
							template: false,
							showInputs: false,
							minuteStep: 5
							});

            if(!tmp_appt_id)
            {
            tmp_appt_id =   resp[i].id;
            }
        }

        latest_appt_id  =   tmp_appt_id;
    }
    }           
    });

                            
}
</script>
<!-- PAGE SPECIFIC JS-->
</body>
</html>