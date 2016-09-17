<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <?php $this->load->view('login/common/head'); ?>
</head>
<body>
<?php $this->load->view('login/common/patient_header'); ?>
<div class="container H550">
<div class="row">
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">            
<div class="panel panel-default">    
<div class="panel-body">
 <div class="row"> 
 <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-danger">
    <div class="panel-heading" role="tab" id="headingTwo">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          Past Appointments
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
      <div class="panel-body">
      <div class="row">
      	<div class="col-lg-offset-5 col-lg-7 col-md-12 col-sm-12 col-xs-12">
      	<span class="glyphicon glyphicon-minus spinning"></span>
        </div>
      </div>
      </div>
    </div>
  </div>
  <div class="panel panel-success">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
          Upcoming Appointments
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body">
      <div class="row">
      	<div class="col-lg-offset-5 col-lg-7 col-md-12 col-sm-12 col-xs-12">
      	<span class="glyphicon glyphicon-minus spinning"></span>
        </div>
      </div>
      </div>
    </div>
  </div>
  
</div> 
 
 
 </div>
 </div>     
</div>
</div>    
</div>
</div>    
</div>
<?php $this->load->view('login/common/footer'); ?>
<?php $this->load->view('login/common/bottom'); ?>
<!-- PAGE SPECIFIC JS-->
<script type="text/javascript">
function get_appointments(type,page_id)
{
	if(type)
	{
		var apt_data	=	{};
		apt_data['type']	=	type;
		apt_data['patient_id']	=	<?=$userid?>;
		if(page_id)
		{
			apt_data['page']	=	page_id;
		}
		$.ajax({
			type:'POST',
			url:BASE_URL+"api/patient/get_appointment",
			data:apt_data,
			dataType:'json',
			success:function(data)
			{
				if(data.status==1)
				{
				var html	=	'';
				html	+=	'<div class="row">';
				html	+=	'<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">Doctor Name</div>';
				html	+=	'<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">Appointment Date</div>';
				html	+=	'<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">Appointment Time</div>';
				html	+=	'<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">Clniic Name</div>';
				html	+=	'<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">Clniic Location</div>';
				html	+=	'<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">Clniic Addreess</div>';
				html	+=	'</div>';
				for(i in data.appointments)
				{
					html	+=	'<div class="row">';
					html	+=	'<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">'+data.appointments[i]['doctor_name']+'</div>';
					html	+=	'<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">'+data.appointments[i]['date']+'</div>';
					html	+=	'<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">'+data.appointments[i]['start']+'</div>';
					html	+=	'<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">'+data.appointments[i]['clinic_name']+'</div>';
					html	+=	'<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">'+data.appointments[i]['city_name']+'</div>';
					html	+=	'<div class="col-lg-2 col-md-2 col-sm-6 col-xs-12">'+data.appointments[i]['reason_for_visit']+'</div>';
					html	+=	'</div>';
				}
					
				if(type=='upcoming')
				{
					$("#collapseOne .panel-body").html(html);
				}
				else if(type=='past')
				{
					$("#collapseTwo .panel-body").html(html);
				}

				}
				else if(data.status==0)
				{
					if(type=='upcoming')
					{
						$("#collapseOne .panel-body").html('<div class="row"><div class="col-lg-offset-5 col-lg-7 col-md-12 col-sm-12 col-xs-12">'+data.message+'</div></div>');
					}
					else if(type=='past')
					{
						$("#collapseTwo .panel-body").html('<div class="row"><div class="col-lg-offset-5 col-lg-7 col-md-12 col-sm-12 col-xs-12">'+data.message+'</div></div>');
					}
				}
			}
		});
	}
}
$(function(){
	get_appointments('upcoming');
	get_appointments('past');
});

</script>

<!-- PAGE SPECIFIC JS-->	
</body>
</html>

