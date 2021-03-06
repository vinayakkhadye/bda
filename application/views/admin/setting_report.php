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
  <div class="panel-heading">Search Report</div>
  <div class="panel-body">
		<form role="form" method="POST" class="form-inline"  action="download_csv">
      <div class="form-group">
        <label class="control-label">Select City : </label>
        <select id="city" class="form-control" name="city"> 
        <option value="all">All</option>
        <?php
        foreach ($city as $row) { 
        ?> 
        <option value="<?php echo $row->id; ?>"> 
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
      <input type="text" id="time_from" value="<?='00:01:AM'?>" name="time_from" class="revisited_time form-control input-small" placeholder="Time .." /> 
      <label class="control-label">To :</label>
      <input id="date_to" type="text" name="date_to" class="scheduled_date form-control" value=" " />
      <input type="text" id="time_to" value="<?='23:59:PM'?>" name="time_to" class="revisited_time form-control input-small" placeholder="Time .." /> 
      </div>
			<div class="form-group">
        <label class="control-label">Group By :</label>
			
        <div class="checkbox"><label><input type="checkbox" value="DATE(appointment.added_on)">&nbsp; Date &nbsp;</label></div>
        <div class="checkbox"><label><input type="checkbox" value="city.name">&nbsp; City &nbsp;</label></div>
        <div class="checkbox"><label><input type="checkbox" value="doctor.speciality">&nbsp; Speciality &nbsp;</label></div>
        <div class="checkbox"><label><input type="checkbox" value="appointment.status">&nbsp; Status &nbsp;</label></div>
        <div class="checkbox"><label><input type="checkbox" value="appointment.from_app">&nbsp; From &nbsp;</label></div>
			</div> 

	<!--<div class="form-group"> 
    <input id="doctor_name" type="text" class="form-control" placeholder="Search doctor..." name="doctor_name" value=""/>
	</div>-->
      <div class="form-group"> 
      <a class="btn btn-primary" onclick="return getcount(this)"> Search </a> 
      <input type="submit" Value="Export" name="export" class="btn btn-primary"> 
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
<!--<script src="<?php echo JS_URL; ?>admin/typeahead.min.js"></script>-->
<!-- PAGE SPECIFIC JS-->
<script type="text/javascript">
$(document).ready(function() { 

/*$("#doctor_name").typeahead({
		name : 'dcotor_name',
		remote: {
				url : '/bdabdabda/setting/get_dr_list?query=%QUERY'
		}
});*/
			
$('.scheduled_date').datepicker({
		format: "yyyy-mm-dd",
		autoclose: true,
		todayHighlight: true,
		orientation: "top left"
});
    $(".revisited_date").datepicker(
        {
            dateFormat: "yyyy-mm-dd",
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
	obj['time_from'] =$("#time_from").val();
	obj['date_to'] =$("#date_to").val();
	obj['time_to'] =$("#time_to").val();
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
		var jsDate
		for(var i=0; i < resp.length; i++)
		{       
			if(obj['group_by'].indexOf('added_on') > -1)
			{
			// jsDate = new Date(resp[i]['added_on']*1000); 
			// $date = date('d-m-Y', resp[i]['added_on']);
			dates = resp[i]['added_on'];
		    }
		    else
		    {
		    	dates = "-";
		    }

		    // dates = resp[i]['added_on'];

		    if(obj['group_by'].indexOf('name') > -1)
			{
			city = resp[i]['name'];
			 }
		    else
		    {
		    	city = "-";
		    }

		    if(obj['group_by'].indexOf('speciality') > -1)
			{		    
			speciality = resp[i]['speciality'];
			}
		    else
		    {
		    	speciality = "-";
		    }

		    if(obj['group_by'].indexOf('status') > -1)
			{
			status = resp[i]['status'];

				if( status == 0 )
				{
				status = "Cancelled";
				}
				else if( status == 1 )
				{
				status = "Scheduled";
				}
				else
				{
				status = "-";
				}

			}
		    else
		    {
		    	status = "-";
		    }

		    if(obj['group_by'].indexOf('from_app') > -1)
			{
			from_app = resp[i]['from_app'];

				if(  from_app == 0 )
				{
				from_app = "Website";
				}
				else if( from_app == 1 )
				{
				from_app = "Patient App";
				}
				else if( status == 2 )
				{
				from_app = "Doctor App";
				}
				else
				{
				status = "-";
				}
			
			}
		    else
		    {
		    	from_app = "-";
		    }
 
			total_appointment = resp[i]['total_appointment'];
			  
			 // var da = resp[i]['status'];

			html2  = html2 + "<tr><td>"+dates+"</td><td>"+city+"</td><td>"+speciality+"</td><td>"+status+"</td><td>"+from_app+"</td><td>"+total_appointment+"</td></tr>"; 
		}

		  
		 
		// if (obj['group_by'].indexOf('from_app') > -1) 
		// {
		// 		  var da ="yes";
		//  }
		//  else{
		//  	var da = "No";

		//  }
		// $('#dataTables-example tbody').html(status);
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
