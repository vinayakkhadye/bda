<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
	  <?php $this->load->view('admin/common/head'); ?>        
  </head>
  <body>
		<?php $this->load->view('admin/common/header');?>
    <div class="container-fluid">
    <div class="panel panel-default">
    <div class="panel-heading">Pending Appointments</div>
    <div class="panel-body">
      <form name="seach_doctors" action="/bdabdabda/appointments" class="form-inline"  >
         		<div class="form-group">
                <label class="control-label">Doctor ID :</label>
                <input name="id" type="text" placeholder="Doctors's ID" class="form-control" value="<?= @$id ?>"/>
						</div>                
            <div class="form-group">
                <label class="control-label">Appointment Status :</label>
                <select class="form-control" name="status">
                    <option value="">Select Status</option>
                    <option value="1" <?= (isset($status) && $status == 1) ? 'selected="selected"' : '' ?>>Scheduled</option>
                    <option value="0" <?= (isset($status) && $status == 0) ? 'selected="selected"' : '' ?>>Cancelled</option>
                </select>
            </div>
            <div class="form-group">
                <label>Appointment Confirmation :</label>
                <select class="form-control" name="confirmation">
                    <option value="">Select  Status</option>
                    <option value="1" <?= (isset($confirmation) && $confirmation == 1) ? 'selected="selected"' : '' ?>>Confirmed</option>
                    <option value="0" <?= (isset($confirmation) && $confirmation == 0) ? 'selected="selected"' : '' ?>>Pending</option>
                </select>
            </div>
            <div class="form-group">
                <input class="btn btn-primary" name="search" type="submit"  value="Search"/>
            </div>
          </form>
      <form name="edit_doctors" action="/bdabdabda/appointments" method="post" >
        <div class="table-overflow">
          <div class="form-group">
            <input type="hidden" value="<?= $cur_url ?>" name="url" />
            <div class="btn-group PB5">
              <button type="submit" name="approve" 		value="Confirm Appointment" class="btn btn-primary">Confirm Appointment</button>
              <button type="submit" name="disapprove" value="Cancel Appointment" 	class="btn btn-primary">Cancel Appointment</button>
              <button type="submit"	name="pending"  	value="Mark As Pending" 		class="btn btn-primary">Mark As Pending</button>
              <button type="submit" name="progress" 	value="In Progress" 				class="btn btn-primary">In Progress</button>
            </div>
            </div>
        	<table id="dataTables-example" class="table table-condensed table-bordered table-striped table-responsive">
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
              <th>Added on</th>
              <th>Appt. Mob Confirmed</th>
              <th><span class="glyphicon glyphicon-tasks"></span></th>
              </tr>
          </thead>
          <tbody>
          <?php if ($results) 
            {
              foreach ($results as $row) 
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
                  <?php echo date('d-m-Y', strtotime($row->date)) . ' ' . date('h:i:s a', strtotime($row->time)); ?>
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
                <td>
                  <?php echo date('d-m-Y h:i:s a', strtotime($row->added_on)); ?>
                </td>
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
                </td>
                </tr>
                <tr class="extra_field_row">
									<td colspan="13" class="form-inline">
                  <input class="revisited_date form-control" type="text" name="revisited_date" 
                  value="<?=($row->revisited_date)?@date('d-m-Y', strtotime($row->revisited_date)):''?>" 
                  data="<?php echo $row->id; ?>" placeholder="Date .." >
                  <input type="text" value="<?=($row->revisited_date)?@date('h:iA', strtotime($row->revisited_date)):''?>" name="revisited_time" 
                  class="revisited_time form-control input-small" placeholder="Time .." />
                  <input type="button" class="submit_rev_date btn btn-primary" name="submit_rev_date" value="Add Revisited Date"/>
                  
                  <textarea class="appt_notes form-control W50P H35P"  rows="1" ><?php echo $row->notes; ?></textarea>
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
        <ul class="pagination"><?php echo $this->pagination->create_links(); ?></ul>
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
            dateFormat: "dd-mm-yy",
            defaultDate: "-25y",
						autoclose:true,
            changeMonth: true,
            changeYear: true,
            yearRange: "1900:2014"
        });
    
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
    var rev_date = $(this).prev('.revisited_date').val();
    var rev_time = $(this).next('.revisited_time').val();
    var id_detls = $(this).prev('.revisited_date').attr('data')
    $.ajax({
        url: '/bdabdabda/appointments/submit_revisited_date',
        type: "POST",
        data: {
            'rev_date': rev_date,
            'rev_time': rev_time,
            'id_detls': id_detls
        },
        success: function(data)
        {
            alert("Revisited Date Added successfully");
        }
    });
    });
    
    //setTimeout(refresh_appointment(), 10);
    
    
    $(".revisited_date").datepicker(
        {
            dateFormat: "yy-mm-dd",
						autoclose:true,
            changeMonth: true,
            changeYear: true
        });
    
    $(".revisited_time").timepicker
    (
        {
					template: false,
					showInputs: false,
					minuteStep: 5
	
        });
    
    });
    //Refresh Newaly Inserted Appointments
    function refresh_appointment(refresh_date)
    {
    $.ajax({
    url:        '/bdabdabda/appointments/getNewPosts',
    dataType: "json",
    type:       'POST',
    data: {
    'refresh_date' : refresh_date
    },
    success: function(resp){
    console.log(resp);                    
    var html	=	 '<tr class="doc_details_row"><td class="check"><input type="checkbox" id="appointment_id_'+resp.id+'" name="appointment_id['+resp.id+']" class="rowcheck"></td><td class="">'+resp.doctor_name+'</td><td class="">'+resp.mobile_number+'</td><td class="">Mumbai</td><td class="">Test</td><td class="">4545</td><td class="">26-06-2015 05:30:00 am</td><td class="pstatus">Scheduled</td><td class="pstatus">Pending</td><td class="">12-06-2015 01:54:06 pm</td><td class=""></td><td class=""><select data="86" id="ver_no" class="verified_no" name="verified_no"><option>Select</option><option value="1">Yes</option><option selected="" value="0">No</option></select></td><td class=""><input type="text" style="width: 100px;" class="revisited_date hasDatepicker" data="86" value="01-01-1970" name="revisited_date" id="dp1434098356626"><input type="button" value="Add" name="submit_rev_date" class="submit_rev_date"><input type="text" style="width: 100px;" class="revisited_time is-timeEntry" name="revisited_time" value="05:30AM"></td><input type="hidden" class="confrm_date" name="confrm_date" data="2015-06-12 14:09:17"><td><a href="/bdabdabda/appointments/view_appointment/86"><span title="view appoinmtment" class="glyphicon glyphicon-th"></span></a></td></tr><tr class="extra_field_row"><td align="center" colspan="14"><textarea rows="1" class="appt_notes form-control" style="float:left"></textarea>   <input type="button" value="Submit Notes" class="btn btn-default add_extra " name="edit_note"> <input type="hidden" class="id_detls" name="app_id" value="86" data="86"></td></tr>';
    $("#dataTables-example tbody").prepend(html);
    }           
    });
              
    }
    var date = new Date();
    var getmonth = date.getMonth()+ 1;
    var getminute = date.getMinutes();
    var getseconds = date.getSeconds();
    var getdate = date.getDate();
    var gethours = date.getHours();
    
    var month = getmonth < 10 ? '0' + getmonth : '' + getmonth ;
    var minutes = getminute < 10 ? '0' + getminute : '' + getminute ;
    var seconds = getseconds < 10 ? '0' + getseconds : '' + getseconds ;
    var dateday = getdate < 10 ? '0' + getdate : '' + getdate ;
    var hours = gethours < 10 ? '0' + gethours : '' + gethours ;
    
    var refresh_date =  date.getFullYear() + "-" + month  + "-" + dateday +  " " + hours + ":" + minutes + ":" + seconds;
    
    var myVar=setInterval(function () {refresh_appointment('2015-06-12 01:10:15')}, 5000);
    </script>
    <!-- PAGE SPECIFIC JS-->
  </body>
</html>
