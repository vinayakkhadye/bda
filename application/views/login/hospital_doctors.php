<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <?php $this->load->view('login/common/head'); ?>
</head>
<body>
<?php $this->load->view('login/common/hospital_header'); ?>
<div class="container H550">
<div class="row">
<div class="col-lg-offset-1 col-md-offset-1 col-lg-10 col-md-10">      
<div class="panel panel-default">  
<div class="panel-heading">Your Doctors</div>
<div class="panel-body">

<?php if(is_array($doctor_data) && sizeof($doctor_data) >=1){ ?>
	<?php foreach($doctor_data as $row){
	$specialityStr = '';
	if (!empty($row['speciality']))
	{
		$row['speciality'] = explode(',', $row['speciality']);
		foreach ($row['speciality'] as $spKey => $spVal)
		{
				$specialityStr .= $speciality_data[$spVal]['name'] . ", ";
		}
		$specialityStr = trim($specialityStr, ", ");
	}?>
  <div class="col-sm-12 col-xs-12 col-lg-6 col-md-6">
  <div class="panel panel-primary">
  <div class="panel-heading">
  <div class="text-center">Dr. <?php echo $row['name']; ?></div>
  </div>
  <div class="panel-body MH120">
  <p><span class="glyphicon glyphicon-phone-alt" aria-hidden="true">&nbsp;</span><?php echo $row['contact_number']; ?></p>
  <?php if($specialityStr){ ?>
  <p><span class="glyphicon glyphicon-education" aria-hidden="true">&nbsp;</span><?=$specialityStr  ?> </p>
  <?php }?>
  <?php if($row['disptimings']){ 
		foreach($row['disptimings'] as $t_key=>$t_val){?>
	<p><span class="glyphicon glyphicon-list" aria-hidden="true">&nbsp;</span><span><?php echo $t_val['label']?> : </span><span><?php echo $t_val['value'] ?></span></p>
  <?php }} ?>
  
  </div>
  <div class="panel-footer">
    <span class="text-left"><a class="btn btn-default" href="/hospital/editdoctor/<?php echo $row['id']; ?>">Edit</a></span>
    <span class="text-right"><a onclick="delete_doctor(<?php echo $row['user_id']; ?>,this);" href="javascript:;" class="btn btn-danger">Delete</a></span>
  </div>
  </div>
  </div>
	<?php }?>
<?php }?>
<div class="col-sm-12 col-xs-12 col-lg-6 col-md-6">
<div class="panel panel-default">
<div class="panel-heading">
<div class="text-center">Add a Doctor</div>
</div>
<div class="panel-body text-center H175">
    <p style="margin-top:30px;"><a class="btn btn-success" href="/hospital/adddoctor">Add</a></p>
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
<!--PAGE SPECIFIC  JS-->
<script type="text/javascript">
function delete_doctor(user_id,obj)
{
	var a = confirm('Are you sure you want to delete this clinic/hospital?');
	if(a == true)
	{
		$.ajax({
			method:'POST',
			data:{'user_id':user_id,'type':2},
			url : '/api/user/delete/',
			success: function(resp)
			{
				$(obj).closest('.col-sm-12').remove();
			}
		});
	}
}
</script>
<!--PAGE SPECIFIC  JS-->
</body>
</html>

