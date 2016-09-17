<!DOCTYPE html>
<html lang="en">
<head>
  <title>Packages view | BDA</title>
	<?php $this->load->view('admin/common/head'); ?>
</head>
<body>
<?php $this->load->view('admin/common/header'); ?>
<div class="container-fluid">
<div class="panel panel-default">
<div class="panel-heading">Packages</div>
<div class="panel-body">
<form class="form-inline" name="seach_doctors" action="/bdabdabda/packages">
  <div class="form-group">
    <label class="control-label">Doctor ID :</label>
    <input type="text" value="<?=@$doctor_id?>" class="form-control" placeholder="Doctors's ID" name="doctor_id">
  </div>
  <div class="form-group">
    <label class="control-label">Doctor Name :</label>
	  <input name="doctor_name" type="text" class="form-control" placeholder="Doctors's name" value="<?=@$doctor_name?>" />
  </div>
  <div class="form-group">
    <label class="control-label">Status : </label>
		<select name="status" class="form-control" >
		<option value="">Select Status</option>
		<option value="1" <?=(isset($status) && $status == 1)?'selected="selected"':''?>>Approved</option>
		<option value="0" <?=(isset($status) && $status == 0)?'selected="selected"':''?>>Pending</option>
		<option value="-1" <?=(isset($status) && $status==-1)?'selected="selected"':''?>>Disapproved</option>
		</select> 
  </div> 
  <div class="form-group">
   <input type="submit" name="submit" id="new_record_submit"  value="Search" class="btn btn-primary" />
   </div>
</form>
<hr /> 
<form name="edit_records" id="edit_records" method="post" class="" >
<div class="table-responsive">
<table class="table table-striped table-condensed table-bordered" >
<tr>
<th><span class="glyphicon glyphicon-check"></span></th>
<th>Doctor Name</th>
<th>Package Name</th>
<th>Package Status</th>
<th>Start date</th>
<th>End Date</th>
<th>Action</th>
<th><span class="glyphicon glyphicon-edit"></span></th>
</tr>

<?php
if($results)
{
foreach($results as $row)
{
  ?> 
<tr>
<td>
  <input type="checkbox" class="rowcheck" name="reviews_id[<?php echo $row->id; ?>]" id="reviews_id_<?php echo $row->id; ?>" />
</td>
<td><?php echo ucfirst($row->doctor_name); ?></td>
<td><?php echo ucfirst($row->package_name); ?></td>
<td>
  <?php if($row->status==1){ echo "Approved";}else if($row->status==0){ echo "Pending";}else if($row->status==-1){ echo "Disapproved";}?>
</td>
<td>
  <?php echo date('d-m-Y', strtotime($row->start_date)); ?>
</td>
<td>
  <?php echo date('d-m-Y', strtotime($row->end_date)); ?>
</td>
<td>
<a href="/bdabdabda/packages/add_package/<?php echo $row->user_id; ?>" style="text-decoration: none;"><input type="button" value="Add a Package" id="<?php echo $row->user_id; ?>" class="add-package-btn btn btn-default"  /></a>
</td> 
<td>
<a href="/bdabdabda/packages/edit_package_details/<?php echo $row->id; ?>" title="Edit"><span class="glyphicon glyphicon-edit"></span></a>
</td>							
</tr>
<?php
}
}
else
{
?>
<tr>
<td colspan="7" align="center">No Doctors Available </td>
</tr>
<?php } ?>
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


<script>
		$(document).ready(function()
			{
				$("#chackAll").change(function()
					{
						if(this.checked)
						{
							$('.rowcheck').prop('checked', true);
						}else
						{
							$('.rowcheck').prop('checked', false);
						}
					});
				// $("#date").datepicker(
				// 	{
				// 		dateFormat: "dd-mm-yy",
				// 		defaultDate: "-25y",
				// 		changeMonth: true,
				// 		changeYear: true,
				// 		yearRange: "1900:2014"
				// 	});
				// $("#left_Panel").height($("#content_area").height());
			 });

	</script>
<!--PAGE SPECIFIC SCRIPT-->
</body>
</html>
