<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title>Appointment Reports | BDA</title>
  <?php $this->load->view('admin/common/head'); ?>
</head>
<body>
  <?php $this->load->view('admin/common/header'); ?> 
  <div class="container-fluid">
  <div class="panel panel-default">
  <div class="panel-heading">
  Search Report
  </div>
  <div class="panel-body">
		<form role="form" method="POST" class="form-inline" >
      <div class="form-group">
        <label class="control-label">Select City : </label>
        <select id="city" class="form-control" name="city"> 
        <option value="all">All</option>
        <?php
        foreach ($city as $row) { 
        ?> 
        <option value="<?php echo $row->name; ?>"> 
        <?php
        echo $row->name; 
        ?>
        </option>
        <?php } ?> 
        </select>
      </div>
      <div class="form-group">
      <label class="control-label">Select Speciality : </label>
      <select id="speciality" class="form-control" name="speciality">
      <option value="all">All</option>
      <?php
      foreach ($speciality as $key) {
      
      ?>
      <option value="<?php echo $key->id; ?>">
      <?php echo $key->name; ?></option>
      
      <?php } ?>
      </select>
      </div>
      <div class="form-group">
      <label class="control-label">Select Status : </label>
      <select id="status" class="form-control" name="status">
      <option value="both">Both</option>
      <option value="1">Scheduled</option>
      <option value="0">Cancelled</option> 
      </select>
      </div>
      <div class="form-group">
      <label class="control-label">Booked From :</label>
      <select id="from_app" class="form-control" name="from">
      <option value="all">All</option>
      <option value="0">Website</option>
      <option value="1">Patient App</option>
      <option value="2">Doctor App</option>
      </select>
      </div>
      
      <div class="form-group">
			<label class="control-label">From :</label>
      <input id="date_from" type="text" name="date_from" class="scheduled_date form-control" value=" "   /> 
      <label class="control-label">To :</label>
      <input id="date_to" type="text" name="date_to" class="scheduled_date form-control" value=" " />
      </div>
			<div class="form-group">
        <label class="control-label">Group By :</label>
        <div class="checkbox"><label><input type="checkbox" value="appointment.date">&nbsp; Date &nbsp;</label></div>
        <div class="checkbox"><label><input type="checkbox" value="city.name">&nbsp; City &nbsp;</label></div>
        <div class="checkbox"><label><input type="checkbox" value="doctor.speciality">&nbsp; Speciality &nbsp;</label></div>
        <div class="checkbox"><label><input type="checkbox" value="appointment.status">&nbsp; Status &nbsp;</label></div>
        <div class="checkbox"><label><input type="checkbox" value="appointment.from_app">&nbsp; From &nbsp;</label></div>
			</div> 
      <div class="form-group"> 
      <a class="btn btn-primary" onclick="return getcount(this)"> Search </a> 
      </div>
		</form>
  <div class="form-group">
    <label id="output" class="control-label">Total Appointment: </label> 
    <table id="dataTables-example" class="table table-striped table-bordered table-hover">
    <thead>
      <th>Date</th>
      <th>City</th>
      <th>Speciality</th>
      <th>Status</th>
      <th>From_App</th> 
      <th>Appointment</th>   
    </thead>
    <tbody></tbody>
    </table> 
    </div>   
  </div>
  <div class="panel-footer">
	<?php $this->load->view('admin/common/footer'); ?>
  </div>
  </div>
	</div>  
  
</body>
<?php $this->load->view('admin/common/bottom'); ?>
<!-- PAGE SPECIFIC JS-->
<script type="text/javascript">
$(document).ready(function() { 
$('.scheduled_date').datepicker({
		format: "yyyy-mm-dd",
		autoclose: true,
		todayHighlight: true,
		orientation: "top left"
});
});

function getcount(search_btn)
{
	var search_txt	=	' Search ';
	var loader	=	'<span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Loading...';
	$(search_btn).html(loader);
	var checkbox_value = "";
	$(":checkbox").each(function () {
		var ischecked = $(this).is(":checked");
		if (ischecked) {
			checkbox_value += $(this).val() + ",";
		}
	});
	var obj =	{};
	obj['city']  =$("#city").val();
	obj['speciality'] =$("#speciality").val();
	obj['status'] =$("#status").val();
	obj['from'] =$("#from_app").val(); 
	obj['date_from'] =$("#date_from").val();
	obj['date_to'] =$("#date_to").val();
	obj['group_by'] = checkbox_value;
	$.ajax(     
	{
	url:    '/bdabdabda/setting/appointment_final_report',
	type:   'POST',
	cache:  false,
	dataType: 'json',
	data:      obj,
	success: function(resp)
	{
		var html2="";
		var dates  ;
		var city  ;
		var speciality ;
		var status  ;
		var from_app  ;
		var total_appointment  ; 
		var obj_val ={};
		for(var i=0; i < resp.length; i++)
		{       
			dates = resp[i]['date'];
			city = resp[i]['name'];
			speciality = resp[i]['speciality'];
			status = resp[i]['status'];
			from_app = resp[i]['from_app'];
			total_appointment = resp[i]['total_appointment'];
			
			if( status == 1 )
			{
			status = "Scheduled";
			}
			else
			{
			status = "Cancelled";
			}
			
			if(  from_app == 0 )
			{
			from_app = "Website";
			}
			else if( from_app == 1 )
			{
			from_app = "patient App";
			}
			else
			{
			from_app = "Doctor App";
			}
			html2  = html2 + "<tr><td>"+dates+"</td><td>"+city+"</td><td>"+speciality+"</td><td>"+status+"</td><td>"+from_app+"</td><td>"+total_appointment+"</td></tr>"; 
		}
		$('#dataTables-example tbody').html(html2);
	},
	complete:function(resp)
	{
		$(search_btn).html(search_txt);
	}
	}
	)
}

</script>
<!-- PAGE SPECIFIC JS-->
</html>
