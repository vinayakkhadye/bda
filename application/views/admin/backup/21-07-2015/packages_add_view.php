<!DOCTYPE html>
<html lang="en">
<head>
  <title>Packages view| BDA</title>
	<?php $this->load->view('admin/common/head'); ?> 
</head>
<body>
<?php $this->load->view('admin/common/header'); ?>
<div class="container-fluid">
<div class="panel panel-default">
<div class="panel-heading">Add Packages</div>
<div class="panel-body">
<form  method="POST" name="seach_doctors" data-toggle="validator" >
	<div class="col-md-4 col-md-offset-4">
  <div class="form-group">
    <label class="control-label">Package Type :</label>
    <select name="status" class="form-control" required >
      <?php foreach($package as $row): ?>
        <option value="<?=$row->id?>"><?=$row->name?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="form-group">
    <label class="control-label">Start Date :</label>
	  <input type="text" class="form-control" id="start_date" name="start_date" placeholder="Package Start Date" required>
    </div>
  <div class="form-group">
    <label class="control-label">End Date :</label>
    <input type="text" class="form-control" id="end_date" name="end_date" placeholder="Package End Date" required>
  </div> 
  <div class="form-group">
  <input type="submit" name="submit" id="new_record_submit"  value="Add Package" class="btn btn-primary" />
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
