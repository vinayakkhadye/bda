<!DOCTYPE html>
<html lang="en">
<head>
  <title>Packages Edit| BDA</title>
	<?php $this->load->view('admin/common/head'); ?> 
</head>
<body>
<?php $this->load->view('admin/common/header'); ?>
<div class="container-fluid">
<div class="panel panel-default">
<div class="panel-heading">Edit Package</div>
<div class="panel-body">
<?php #print_r($user_package_details);exit; ?>
<form method="POST" name="seach_doctors" data-toggle="validator">
	<div class="col-md-4 col-md-offset-4">
  <div class="form-group">
    <label class="control-label">Package Type :</label>
    <select name="packageid" class="form-control" required>
			<?php foreach($packages_list as $row): ?>
      <option value="<?=$row->id?>" <?php if($user_package_details->package_id == $row->id) echo "selected='selected'"; ?> ><?=$row->name?></option>
      <?php endforeach; ?>
    </select> 
  </div>
  <div class="form-group">
    <label class="control-label">Start Date :</label>
    <input name="start_date" type="text" class="form-control" placeholder="Package Start Date"  value="<?=@date('Y-m-d', strtotime(@$user_package_details->start_date))?>" id="start_date" required/>
  </div>
  <div class="form-group">
    <label class="control-label">End Date :</label>
    <input name="end_date" type="text" class="form-control" placeholder="Package End Date" value="<?=@date('Y-m-d', strtotime(@$user_package_details->end_date))?>" id="end_date" required/>
  </div>
  <div class="form-group">
    <label class="control-label">Amount Paid :</label>
    <input name="amount" type="number" class="form-control" placeholder="Package Amount" value="<?=@$user_package_details->amount_paid?>" required />
  </div> 
  <div class="form-group">
		<label class="control-label">Status :</label>
		<select name="status" class="form-control" >
		<option value="1" <?php if($user_package_details->current_status == '1') echo "selected='selected'"; ?> >Approved</option>
		<option value="0" <?php if($user_package_details->current_status == '0') echo "selected='selected'"; ?> >Pending</option>
		<option value="-1" <?php if($user_package_details->current_status == '-1') echo "selected='selected'"; ?> >Disapproved</option>
        </select> 
  </div>
	<div class="form-group">
   <input type="submit" name="submit" id="new_record_submit"  value="Edit Package" class="btn btn-primary" />
   </div>
   </div>
</form> 
</div>
<div class="panel-footer">
<?php $this->load->view('admin/common/footer'); ?>
</div>
</div>
</div>
<?php $this->load->view('admin/common/bottom'); ?>
<script src="<?php echo JS_URL; ?>admin/bootstrap-datepicker.js"></script>
<!--PAGE SPECIFIC SCRIPT-->
<script type="text/javascript">
$(document).ready(function() {
	$('#start_date').datepicker({
			format: "yyyy-mm-dd",
			autoclose: true,
			 todayHighlight: true,
			orientation: "top left"
	});
	$('#end_date').datepicker({
			format: "yyyy-mm-dd",
			autoclose: true,
			 todayHighlight: true,
		   orientation: "top left"
	});
});
</script>
<!--PAGE SPECIFIC SCRIPT-->
</body>
</html>
