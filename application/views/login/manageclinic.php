<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php $this->load->view('login/common/head'); ?>
</head>
<body>
<?php $this->load->view('login/common/doctor_header'); ?>
<div class="container H550">
<div class="row">
<div class="col-lg-offset-1 col-md-offset-1 col-lg-10 col-md-10">      
<div class="panel panel-default">  
<div class="panel-heading">Your Clinics</div>
<div class="panel-body">
<div class="row">
<?php if(sizeof($clinics) >=1){ ?>
<?php foreach($clinics as $row){ ?>
<div class="col-sm-12 col-xs-12 col-lg-6 col-md-6">
<div class="panel panel-primary">
<div class="panel-heading">
<div class="text-center"><?php echo $row->name; ?></div>
</div>
<div class="panel-body">
<p><span class="glyphicon glyphicon-phone-alt" aria-hidden="true">&nbsp;</span><?php echo $row->contact_number; ?></p>
<p><span class="glyphicon glyphicon-map-marker" aria-hidden="true">&nbsp;</span><?php echo $this->doctor_model->get_city_name($row->city_id).', '.$this->doctor_model->get_locality_name($row->location_id, $row->other_location); ?></p>
</div>
<div class="panel-footer">
  <span class="text-left"><a class="btn btn-default" href="/doctor/editclinic/<?php echo $row->id; ?>">Edit</a></span>
  <span class="text-right"><a href="javascript:;" class="btn btn-danger delete-clinic-btn" id="clinic<?php echo $row->id; ?>">Delete</a></span>
</div>
</div>
</div>
<?php }?>
<?php }?>
<div class="col-sm-12 col-xs-12 col-lg-6 col-md-6">
<div class="panel panel-default" style="height:188px;">
<div class="panel-heading">
<div class="text-center">Add a Clinic</div>
</div>
<div class="panel-body text-center">
    <p style="margin-top:30px;"><a class="btn btn-success" href="/doctor/addclinic">Add</a></p>
</div>

</div>
</div>

</div>
</div>
</div>
</div>    
</div>    
</div>
</body>
<?php $this->load->view('login/common/footer'); ?>
<?php $this->load->view('login/common/bottom'); ?>
<script type="text/javascript">
$(document).ready(function()
{
$(".delete-clinic-btn").click(function()
{
	var a = confirm('Are you sure you want to delete this clinic/hospital?');
	if(a == true)
	{
		var clinic = this.id;
		var clinicid = clinic.substr(6);
		$.ajax({
			url : '/doctor/deleteclinic/'+clinicid,
			success: function(resp)
			{
			$(location).attr('href','/doctor/manageclinic');
			}
		});
	}
});
});
</script>
</html>
